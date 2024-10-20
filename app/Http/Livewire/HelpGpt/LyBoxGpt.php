<?php

namespace App\Http\Livewire\HelpGpt;

use App\Models\HistoryGpt;
use App\Models\HistoryGptItem;
use App\Models\Person;
use Modules\Investigation\Entities\AssistantGtpFilesId;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Request as GRequest;
use Livewire\WithFileUploads;
use Modules\Investigation\Entities\AssistantGptFilesId;

class LyBoxGpt extends Component
{
    use WithFileUploads;

    public $typeAction = 1;
    public $history = [];
    public $historyItems = [];
    public $consulta = null;
    public $file_document = null;
    public $file_id = null;
    public $fileName;
    public $path; // ruta completa para eliminar el archivo del servidor
    public $resultado = null;
    public $paraphrase_left;
    public $paraphrase_used;
    public $paraphrase_allowed;
    public $normativa = "apa";
    public $prompt = 0;
    /*  Asistente de Chat GPT  */
    public $thread_id = null;
    public $run_id = null;
    public $assistant_id = null;
    public $message = null;
    public $disableButton2 = false;
    public $n1 = true;
    public $n2 = false;
    public $n3 = false;
    public $n4 = false;
    public $n5 = false;

    public $forget_context = false;
    public $vector_id = null;

    public function verifyDeviceTokenUser()
    {
        $user = Auth::user();

        $deviceToken = $_COOKIE['device_token'];

        if ($user && $user->device_token && $user->device_token !== $deviceToken) {
            $response = redirect()->route('logout')->with('error', 'Se ha iniciado sesión desde otro dispositivo.');

            //esta parte de abajo no es necesario creo.... 10 de julio 2024
            // // Eliminar la cookie 'device_token'
            // $response->withCookie(cookie()->forget('device_token'));

            return $response;
        } else {
            return true;
        }
    }

    public function mount()
    {
        $permisos = Person::where('user_id', Auth::user()->id)->first();
        $this->paraphrase_used = $permisos->paraphrase_used;
        $this->paraphrase_left = $permisos->paraphrase_allowed - $permisos->paraphrase_used;
        $this->paraphrase_allowed = $permisos->paraphrase_allowed;
    }

    public function render()
    {
        $this->getHistory($this->typeAction);
        return view('livewire.help-gpt.ly-box-gpt');
    }

    public function setBtnActive($num)
    {
        $this->activator($num);
        $this->typeAction = $num;
        $this->resultado = null;
        $this->consulta = null;
        $this->getHistory($num);
    }

    private function activator($num)
    {
        switch ($num) {
            case 1:
                $this->n1 = 1;
                $this->n2 = 0;
                $this->n3 = 0;
                $this->n4 = 0;
                $this->n5 = 0;
                break;
            case 2:
                $this->n1 = 0;
                $this->n2 = 1;
                $this->n3 = 0;
                $this->n4 = 0;
                $this->n5 = 0;
                break;
            case 3:
                $this->n1 = 0;
                $this->n2 = 0;
                $this->n3 = 1;
                $this->n4 = 0;
                $this->n5 = 0;
                break;
            case 4:
                $this->n1 = 0;
                $this->n2 = 0;
                $this->n3 = 0;
                $this->n4 = 1;
                $this->n5 = 0;
                break;
            case 5:
                $this->n1 = 0;
                $this->n2 = 0;
                $this->n3 = 0;
                $this->n4 = 0;
                $this->n5 = 1;
                break;

            default:
                # code...
                break;
        }
    }

    public function getHistory($num)
    {
        $this->history = HistoryGpt::with('user')->where('user_id', Auth::id())
            ->where('type_action', $num)
            ->first();

        if ($this->history) {
            $this->historyItems = HistoryGptItem::where('history_id', $this->history->id)->orderBy('created_at', 'desc')->take(70)->get()->reverse();
        }

        if ($this->typeAction == 4) {
            $this->dispatchBrowserEvent('scroll-messages-updated', ['success' => true]);
        }
    }

    public function formatDateBox($date)
    {

        $fechaCreacion = $date;

        // Obtén la fecha actual
        $fechaActual = Carbon::now();

        // Verifica si el año de la fecha de creación es diferente al año actual
        if ($fechaCreacion->year != $fechaActual->year) {
            // Si el año es diferente, muestra el año también en el formato
            $formattedDate = $fechaCreacion->format('h:i A | F j, Y');
        } else {
            // Si el año es igual, omite el año en el formato
            $formattedDate = $fechaCreacion->format('h:i A | F j');
        }

        // Imprime la fecha formateada
        return $formattedDate;
    }


    public function saveMessageUser()
    {
        $history = HistoryGpt::firstOrCreate(
            [
                'type_action' => $this->typeAction,
                'user_id'   => Auth::id()
            ]
        );

        HistoryGptItem::create([
            'history_id' => $history->id,
            'my_user' => true,
            'file_original_name' => null,
            'content' => htmlentities($this->message, ENT_QUOTES, "UTF-8")
        ]);

        $resultado = null;
        $messages = null;
        if ($this->typeAction == 1) {
            $resultado = $this->paraphrasing();
        } elseif ($this->typeAction == 2) {
            $resultado = $this->recommendations();
        } elseif ($this->typeAction == 3) {
            $resultado = $this->grammarCorrection();
        } elseif ($this->typeAction == 4) {
            $this->fileName = null;

            if ($this->file_document) {
                //Agregar texto al mensaje cuando se envia nulo en mensaje
                $this->forget_context = true;
                if ($this->message == "" || $this->message == null) {
                    $this->message = "voy a hacerte algunas preguntas sobre el documento que tienes.";
                }
                $basePath = base_path();
                $asistentePath = $basePath . '/asistente_lyon';

                if (!is_dir($asistentePath)) {
                    mkdir($asistentePath);
                }

                $extension = pathinfo($this->file_document->getClientOriginalName(), PATHINFO_EXTENSION);

                $this->fileName = $this->randomName() . '.' . $extension;

                $this->path = $this->file_document->storeAs('asistente_lyon', $this->fileName);
            }


            $messages = $this->getThreadId($this->message);  //crear u obtener el thread_id devuelve lista de mensajes
            $break = false;
            try {
                if (!isset($messages[0])) {
                    while ($messages['status'] == "Pending" && $break == false) {
                        $messages = $this->getPendingRun($messages);
                        if ($messages['status'] == "failed") $break = true;
                    }
                }
            } catch (\Throwable $th) {
            }
            //dd($this->message);
            if ($messages != false && $break == false) {

                try {
                    $resultado = $messages[0][0]['text']['value'];   //la respuesta final
                } catch (\Throwable $th) {
                    $resultado = "El servidor está ocupado intenta de nuevo por favor, o quizá ya no tienes mas oportunidades de usar esta herramienta.";   //la respuesta final
                }

                ///eliminar archivo subido

                $ifile_path = storage_path('app/' . $this->path);
                //dd($ifile_path);
                if (file_exists($ifile_path)) {
                    @unlink($ifile_path);
                }
            } else {
                $resultado = "Hubo un error vuelve a intentarlo";
            }
            ////bajar el scroll!!!!
            $this->dispatchBrowserEvent('scroll-messages-updated', ['success' => true]);
        } elseif ($this->typeAction == 5) {
            $resultado = $this->references();
        }

        HistoryGptItem::create([
            'history_id' => $history->id,
            'my_user' => false,
            'file_original_name' => null,
            'content' => $resultado
        ]);
        //$this->saveFileID_deleteFile($file_id, $filename, $path);

        if ($this->typeAction == 4) {
            $this->consulta = null; // para que no borre la consulta salvo en el chat
        }
        $this->file_document = null;
        $this->fileName = null;
        $this->message = null;
        $this->path = null;
    }


    public function paraphrasing()
    {
        $resultado = null;

        if (strlen($this->consulta) > 10) {
            $this->resultado = "espera un momento...";
            $permisos = Person::where('user_id', Auth::user()->id)->first();
            $p_allowed = $permisos->paraphrase_allowed;
            $p_used = $permisos->paraphrase_used;

            if ($p_allowed > $p_used) {
                $max_tokens = 3500;
                $temperature = 0.7;
                $consulta = null;
                $result_text = "hubo un problema, intenta mas tarde";

                switch ($this->prompt) {

                    case  0:
                        $consulta = "Parafraséame este texto en español como si fueras un experto en investigación: ";
                        break;
                    case  1:
                        $consulta = "Parafraséame este texto en español con el objetivo de reducir el mayor grado de similitud: ";
                        break;
                    case  2:
                        $consulta = "Parafraséame este texto en español logrando humanizarlo por completo, asimismo, reduciendo el mayor grado de similitud posible: ";
                        break;
                }

                $consulta = $consulta . "{" . $this->consulta . "}";

                try {
                    $result = OpenAI::completions()->create([
                        'model' => 'gpt-3.5-turbo-instruct',
                        'prompt' => $consulta,
                        'max_tokens' => $max_tokens,
                        'temperature' => $temperature,
                    ]);
                    $result_text = $result['choices'][0]['text'];
                    $query_tokens = $result['usage']['prompt_tokens'];
                    $result_tokens = $result['usage']['completion_tokens'];
                    $consumed_tokens = $result['usage']['total_tokens'];
                    $permisos->paraphrase_used = $p_used + 1;
                    $permisos->save();
                    $this->paraphrase_left--;
                    $this->paraphrase_used++;
                } catch (Exception $e) {
                    $result_text = $e->getMessage();
                }
                $resultado = $result_text;
            } else {
                $resultado = "Lo siento, pero parece que has superado tu límite de parafraseo. Para continuar utilizando este servicio, por favor comunícate con los administradores para solicitar un aumento en tu límite. Estamos aquí para ayudarte y queremos asegurarnos de que tengas la mejor experiencia posible. ¡Gracias por usar nuestro servicio!";
            }
        } else {
            $resultado = Auth::user()->name . " aprovecha este servicio escribiendo párrafos mas extensos que el que acabas de escribir, esta consulta no será tomada en cuenta";
        }
        $this->resultado = $resultado;
        return $resultado;
    }

    public function recommendations()
    {
        $consulta = $this->consulta;
        $resultado = "espera un momento...";

        if (strlen($consulta) > 6) {
            $permisos = Person::where('user_id', Auth::user()->id)->first();
            $p_allowed = $permisos->paraphrase_allowed;
            $p_used = $permisos->paraphrase_used;

            if ($p_allowed > $p_used) {

                $max_tokens = 3400;
                $temperature = 0.7;

                $result_text = "hubo un problema, intenta mas tarde";

                $consulta = "Dame un listado de títulos de artículos científicos sobre: {" . $consulta . "} presenta esta lista en idioma inglés, luego presenta la misma lista traducida al español y finalmente presenta la misma lista traducida al portugués. por favor recuerda presentar las listas dentro de etiquetas HTML ol y agrega un título acorde a la respuesta entre etiquetas h3 de html";

                try {
                    $result = OpenAI::completions()->create([
                        'model' => 'gpt-3.5-turbo-instruct',
                        'prompt' => $consulta,
                        'max_tokens' => $max_tokens,
                        'temperature' => $temperature,
                    ]);
                    $result_text = $result['choices'][0]['text'];
                    $query_tokens = $result['usage']['prompt_tokens'];
                    $result_tokens = $result['usage']['completion_tokens'];
                    $consumed_tokens = $result['usage']['total_tokens'];
                    $permisos->paraphrase_used = $p_used + 1;
                    $permisos->save();
                } catch (Exception $e) {
                    $result_text = $e->getMessage();
                }
                $resultado = $result_text;
            } else {
                $resultado = "Lo siento, pero parece que has superado tu límite de consultas. Para continuar utilizando este servicio, por favor comunícate con los administradores para solicitar un aumento en tu límite. Estamos aquí para ayudarte y queremos asegurarnos de que tengas la mejor experiencia posible. ¡Gracias por usar nuestro servicio!";
            }
        } else {
            $resultado = Auth::user()->name . " aprovecha este servicio escribiendo párrafos mas extensos que el que acabas de escribir, esta consulta no será tomada en cuenta";
        }

        $this->resultado = $resultado;
        return $resultado;
    }

    public function grammarCorrection()
    {
        $consulta = $this->consulta;
        $resultado = "espera un momento...";
        if (strlen($consulta) > 6) {

            $permisos = Person::where('user_id', Auth::user()->id)->first();
            $p_allowed = $permisos->paraphrase_allowed;
            $p_used = $permisos->paraphrase_used;

            if ($p_allowed > $p_used) {

                $max_tokens = 3400;
                $temperature = 0.7;

                $result_text = "hubo un problema, intenta mas tarde";

                $consulta = "Corrígeme este texto en español para una mejor comprensión como si fueras un experto en literatura: {" . $consulta . "}";

                try {
                    $result = OpenAI::completions()->create([
                        'model' => 'gpt-3.5-turbo-instruct',
                        'prompt' => $consulta,
                        'max_tokens' => $max_tokens,
                        'temperature' => $temperature,
                    ]);
                    $result_text = $result['choices'][0]['text'];
                    $query_tokens = $result['usage']['prompt_tokens'];
                    $result_tokens = $result['usage']['completion_tokens'];
                    $consumed_tokens = $result['usage']['total_tokens'];
                    $permisos->paraphrase_used = $p_used + 1;
                    $permisos->save();
                } catch (Exception $e) {
                    $result_text = $e->getMessage();
                }
                $resultado = $result_text;
            } else {
                $resultado = "Lo siento, pero parece que has superado tu límite de consultas. Para continuar utilizando este servicio, por favor comunícate con los administradores para solicitar un aumento en tu límite. Estamos aquí para ayudarte y queremos asegurarnos de que tengas la mejor experiencia posible. ¡Gracias por usar nuestro servicio!";
            }
        } else {
            $resultado = Auth::user()->name . " aprovecha este servicio escribiendo párrafos mas extensos que el que acabas de escribir, esta consulta no será tomada en cuenta";
        }
        $this->resultado = $resultado;
        return $resultado;
    }

    public function references()
    {
        if ($this->consulta == null || $this->consulta == "") {
            $this->resultado = "Ingresa la consulta";
            return "Ingresa la consulta";
        } else {
            $references = new MendeleyReferences();

            $resultado = $references->citar($this->consulta, $this->normativa);

            $this->resultado = $resultado;
            return $resultado;
        }
    }
    /*  Asistente de chat GPT  */

    public function getThreadId($msg)
    {  //crea el thread y obtiene el ID, si ya existe no la crea y luego consulta respuesta

        if ($this->verifyDeviceTokenUser()) {
        if (true) { // la linea anterior debe ir por ahora la quité 10 de julio 2024
            if ($this->paraphrase_left >= 1) {
                try {
                    $pasaje = false;
                    if ($this->thread_id == null || $this->forget_context) {
                        $this->forget_context = false;
                        $pasaje = true; //para restar el consumo de oportunidades de IA si es true no se cobra
                        $client = new Client();
                        $promise = $client->getAsync('http://localhost:' . env('AI_ASSISTANT_PORT') . '/create_thread');
                        $response = $promise->wait();
                        $data = json_decode($response->getBody(), true);
                        $this->thread_id = $data['thread_id'];
                        $this->assistant_id = $data['assistant_id'];
                    }
                    $permisos = Person::where('user_id', Auth::user()->id)->first();
                    $permisos->paraphrase_used++;
                    $permisos->save();
                    if ($pasaje == false) {
                        $this->paraphrase_used++;
                        $this->paraphrase_allowed--;
                    }

                    return $this->sendGetConsulta($msg); //aqui ejecuta run y consulta respuesta el thread_id es variable global
                } catch (\Throwable $th) {
                    return null;
                }
            } else {
                return $val[0] = "Parece que se agotaron tus oportunidades para usar esta herramienta";
            }
        }
    }
    }

    public function sendGetConsulta($msg)   //consulta respuesta y verificar si existe archivo q pasar file
    {
        // Creando run y haciendo consulta para obtener respuesta de la IA
        $response = Http::post('http://localhost:' . env('AI_ASSISTANT_PORT') . '/create_run', [
            'user_message' => $msg,
            'user_name' => Auth::user()->name,
            'thread_id' => $this->thread_id,
            'assistant_id' => $this->assistant_id,
            'file' => $this->fileName,
            'file_ids' => $this->file_id, // de ser necesario enviar array
            'vector_id' => $this->vector_id,
        ]);

        $data = $response->json();
        try {
            $tempura = end($data);
            $tempura = $tempura["file_id"]; //aqui obtengo el file_id
            $vector_id = $tempura["vectorStore_id"]; //aqui obtengo el vector_id

            if ($tempura != 'Pending' && $tempura != null && strlen($tempura) > 12) {
                $this->file_id = $tempura;
                $data[0][0]['text']['value'] = "Has enviado un documento, has una consulta para poder ayudarte.";
            }
        } catch (\Throwable $th) {
        }
        return $data;
        // dd($this->thread_id, $response);
    }

    public function getPendingRun($messages)
    {   //consulta de respuesta cuando la espera es larga
        // consultamos si el run ya tiene respuesta y si es así entregue el mensaje o avise que no
        $response = Http::post('http://localhost:' . env('AI_ASSISTANT_PORT') . '/get_run_pending', [
            'thread_id' => $messages['thread_id'],
            'run_id' => $messages['run_id'],
        ]);

        $data = $response->json();
        return $data;
        // dd($this->thread_id, $response);
    }

    public function randomName()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 6;
        $codigo = '';

        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $codigo;
    }
    protected function saveFileID_deleteFile($file_id, $filename, $path)
    {
        AssistantGptFilesId::create([
            'id' => $file_id, // Aquí debes proporcionar el id q te da openai
            'filename' => $filename // Aquí debes proporcionar el nombre del archivo y su extenshon
        ]);
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function r_prompts($prompt)
    {

        switch ($prompt) {
            case 1:
                $this->message = "Objetivos del documento de investigación";
                break;
            case 2:
                $this->message = "Estructura de los antecedentes";
                break;
            case 3:
                $this->message = "Problemática de la investigación";
                break;
            case 4:
                $this->message = "Teorías empleadas en la investigación";
                break;
            case 5:
                $this->message = "Definición de las variables";
                break;
            case 6:
                $this->message = "Aportes del estudio";
                break;
            case 7:
                $this->message = "Resultados del estudio";
                break;
            case 8:
                $this->message = "Recomendación principal";
                break;
            case 9:
                $this->message = "Propuesta de mejora";
                break;
            case 10:
                $this->message = "Resumen general del estudio";
                break;
            case 20:
                $this->message = "Eliminar Contexto.";
                break;
            default:
                # code...
                break;
        }
        $history = HistoryGpt::firstOrCreate(
            [
                'type_action' => 4, // 4 es el uso del asistente
                'user_id'   => Auth::id()
            ]
        );
        // se graba el mensaje corto del prompt en el registro para ver en los mensajes pero mas abajo se manda un mensaje mas largo a la IA de GPT
        HistoryGptItem::create([
            'history_id' => $history->id,
            'my_user' => true,
            'file_original_name' => null,
            'content' => $this->message
        ]);

        $resultado = null;
        $messages = null;

        $this->fileName = null;
        if ($this->file_document) {
            $basePath = base_path();
            $asistentePath = $basePath . '/asistente_lyon';

            if (!is_dir($asistentePath)) {
                mkdir($asistentePath);
            }

            $extension = pathinfo($this->file_document->getClientOriginalName(), PATHINFO_EXTENSION);

            $this->fileName = $this->randomName() . '.' . $extension;

            $this->path = $this->file_document->storeAs('asistente_lyon', $this->fileName);
        }
        //$this->file_id
        $sufijo = "responde usando código HTML y las listas en etiquetas <ul></ul>, <ol></ol> e <il></il> según sea necesario pero no crees las etiquetas '<HTML>', '<body>', '<head>' ni  '<tittle>' si puedes utiliza clases boostrap 4 en las propiedades class";
        switch ($prompt) {
            case 1:
                $this->message = "del archivo que tienes Enlístame los objetivos generales y específicos de la investigación, si no lo dice explicitamente deducelo y dímelo. " . $sufijo;
                break;
            case 2:
                $this->message = "del archivo que tienes redáctame en un párrafo de 12 líneas el resumen de toda la investigación, manteniendo esta estructura: 1) Apellido y nombre de autor, 2) Año, 3) Título de la investigación, 4) Metodología, 5) Muestra y instrumentos de recolección, 6) Resultados, y 7) Conclusión general. " . $sufijo;
                break;
            case 3:
                $this->message = "del archivo que tienes Redáctame a profundidad la problemática de la investigación, si no lo dice explicitamente deducelo y dimelo. " . $sufijo;
                break;
            case 4:
                $this->message = "del archivo que tienes Redáctame las teorías de cada variable que se utilizaron en el apartado de marco teórico y/o revisión  de la literatura de esta investigación, y agregar a cada teoría su cita de autor, deducelo del documento si no está explicito " . $sufijo;
                break;
            case 5:
                $this->message = "del archivo que tienes Redáctame las definiciones más representativas de las variables de la investigación, y agrega su cita de autor a cada definición. si no lo dice explicitamente definelo del contenido. " . $sufijo;
                break;
            case 6:
                $this->message = "del archivo que tienes Cuál es el aporte principal de esta investigación, y quiénes serían los beneficiarios directos " . $sufijo;
                break;
            case 7:
                $this->message = "del archivo que tienes Indícame los resultados de acuerdo a cada objetivo de la investigación. revisa todo el documento y dedúcelo si no es explícito. " . $sufijo;
                break;
            case 8:
                $this->message = "del archivo que tienes Redáctame la recomendación principal del documento, averigua en todo el documento antes de responder, no tiene que estár explicito en el documento " . $sufijo;
                break;
            case 9:
                $this->message = "del archivo que tienes Créame una propuesta de mejora en base a las recomendaciones de la investigación de este documento " . $sufijo;
                break;
            case 10:
                $this->message = "del archivo que tienes Resume lo más que puedas este documento de acuerdo a lo que consideres como elemental de una investigación, aunque el documento no sea una investigación resumelo. " . $sufijo;
                break;
            case 20:
                $this->message = "Olvida todo el contexto de esta conversación, has borrón y cuenta nueva como si no supieras nada de lo que hablamos salvo mi nombre si ya te lo dije " . $sufijo;
                $this->forget_context = true;
                break;
            default:
                # code...
                break;
        }

        $messages = $this->getThreadId($this->message);  //crear u obtener el thread_id devuelve lista de mensajes
        $break = false;
        try {
            if (!isset($messages[0])) {
                while ($messages['status'] == "Pending" && $break == false) {
                    $messages = $this->getPendingRun($messages);
                    if ($messages['status'] == "failed") $break = true;
                }
            }
        } catch (\Throwable $th) {
        }
        try {
            if ($messages != false && $break == false) {
                $resultado = $messages[0][0]['text']['value'];   //la respuesta final

                ///eliminar archivo subido

                $ifile_path = storage_path('app/' . $this->path);
                //dd($ifile_path);
                if (file_exists($ifile_path)) {
                    @unlink($ifile_path);
                }
            } else {
                $resultado = "Hubo un error vuelve a intentarlo";
            }
        } catch (\Throwable $th) {
            $resultado = "Hubo un error vuelve a intentarlo";
        }
        ////bajar el scroll!!!!
        $this->dispatchBrowserEvent('scroll-messages-updated', ['success' => true]);

        HistoryGptItem::create([
            'history_id' => $history->id,
            'my_user' => false,
            'file_original_name' => null,
            'content' => $resultado
        ]);
        //$this->saveFileID_deleteFile($file_id, $filename, $path);


        $this->consulta = null;
        $this->file_document = null;
        $this->fileName = null;
        $this->message = null;
        $this->path = null;
    }

    public function updatedFileDocument($value)
    {
        $this->getFileData();
    }

    public function getFileData()
    {
        $this->dispatchBrowserEvent('document-updated-gpt', ['success' => true]);
    }
}
