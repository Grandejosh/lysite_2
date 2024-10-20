<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Person;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class ThesisHelpCreateTitles extends Component
{
    public $resultado;
    public $keywords;
    public $paraphrase_left;
    public $career;
    public $type_thesis;
    public $procesando = false;

    public function render()
    {
        return view('investigation::livewire.thesis.thesis-help-create-titles');
    }

    public function helpwithtitle()
    {
        //dd($this->keywords);

        $this->validate([
            'keywords' => 'required|max:255',
            'career' => 'required|max:255',
            'type_thesis' => 'required|max:255',
        ]);

        if (strlen($this->keywords) > 4) {
            $this->resultado = "espera un momento...";
            $this->procesando = true;
            $permisos = Person::where('user_id', Auth::user()->id)->first();
            $p_allowed = $permisos->paraphrase_allowed;
            $p_used = $permisos->paraphrase_used;

            if ($p_allowed > $p_used) {
                //$max_tokens = 1500;
                $max_tokens = 3400;
                $temperature = 0.7;

                $result_text = "hubo un problema, intenta mas tarde";

                $consulta = "recomiendame 10 títulos para una tesis " . $this->type_thesis . ", para la carrera de" . $this->career . "sobre los siguientes temas: " . $this->keywords;

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
                } catch (Exception $e) {
                    $result_text = $e->getMessage();
                }
                $this->procesando = false;
                $this->resultado = $result_text;
            } else {
                $this->procesando = false;
                $this->resultado = "Lo siento, pero parece que has superado tu límite de consultas. Para continuar utilizando este servicio, por favor comunícate con los administradores para solicitar un aumento en tu límite. Estamos aquí para ayudarte y queremos asegurarnos de que tengas la mejor experiencia posible. ¡Gracias por usar nuestro servicio!";
            }
        } else {
            $this->procesando = false;
            $this->resultado = Auth::user()->name . " aprovecha este servicio escribiendo palabras claves, esta consulta no será tomada en cuenta";
        }
    }
}
