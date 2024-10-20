<?php

namespace Modules\Academic\Http\Livewire\Students;

use Exception;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class Openaiview extends Component
{
    public $frase_text;
    public $result_text="aquí va el resultado";
    public $query_tokens=0;
    public $result_tokens=0;
    public $consumed_tokens=0;
    public $parafrasear=false;
    public $modelo="gpt-3.5-turbo-instruct";
    public $temperature=50;

    public function render()
    {
        return view('academic::livewire.students.openaiview');
    }

    public function save()
    {
        $max_tokens=1500;
        if($this->modelo=="gpt-3.5-turbo-instruct")$max_tokens=3300;

        $this->result_text="espera el resultado...";
        if($this->parafrasear){
            $consulta= "parafrasea lo contenido entre los corchetes: [".$this->frase_text."]";
        }else{
            $consulta= $this->frase_text;
        }
        try{
            $result = OpenAI::completions()->create([
                'model' => $this->modelo,
                'prompt' => $consulta,
                'max_tokens' => $max_tokens,
                'temperature' => $this->temperature/100
            ]);
            $this->result_text = $result['choices'][0]['text'];
            $this->query_tokens = $result['usage']['prompt_tokens'];
            $this->result_tokens = $result['usage']['completion_tokens'];
            $this->consumed_tokens = $result['usage']['total_tokens'];
        }catch(Exception $e){
            $this->result_text=$e->getMessage();
        }

    }
}
