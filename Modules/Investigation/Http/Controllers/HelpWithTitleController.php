<?php

namespace Modules\Investigation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenAI\Laravel\Facades\OpenAI;

class HelpWithTitleController extends Controller
{
    public function helpwithtitle(Request $request)
    { 
        $consulta = $request->get('consulta');
        $thesisType = $request->get('thesisType'); //descriptiva, experimental, etc.
        $school = $request->get('school'); //escuela: ingenieria de sistemas, enfermería, medicina, etc
        if (strlen($consulta) > 4) {
            $resultado = "espera un momento...";
            $permisos = Person::where('user_id', Auth::user()->id)->first();
            $p_allowed = $permisos->paraphrase_allowed;
            $p_used = $permisos->paraphrase_used;

            if ($p_allowed > $p_used) {
                
                $max_tokens = 3400;
                $temperature = 1;

                $result_text = "hubo un problema, intenta mas tarde";

                $consulta = "recomiendame 10 títulos para una tesis ".$thesisType.", para la carrera de". $school ."con los siguientes temas: ". $consulta . " y cada título con sus respectivas palabras Claves";

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
            return $resultado;
        } else {
            return $resultado = Auth::user()->name . " aprovecha este servicio escribiendo palabras claves, esta consulta no será tomada en cuenta";
        }
    }
}
