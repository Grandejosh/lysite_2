<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Person;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisStudent;
use Livewire\WithPagination;

class ThesisAllowed extends Component
{
    use WithPagination;
    public $search;    

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view(
            'investigation::livewire.thesis.thesis-allowed',
            [
                'people' => $this->getPeople()
            ]
        );
    }

    public function getPeople()
    {
        $people = Person::where('full_name', 'like', '%' . $this->search . '%')
            ->orWhere('number', 'like', '%' . $this->search . '%')
            ->paginate(10);

        foreach ($people as $person) {
            $person->created_thesis = InveThesisStudent::where('person_id', $person->id)
                ->count();
        }
        return $people;
    }

    public function changeAllowedThesis($id, $valor)
    { //id = person_id, valor = allowed
        $person = Person::where('id', $id)->first();
        $person->allowed_thesis = $valor;
        $person->save();
    }

    public function changeAllowedParaphrase($id, $valor)
    { //id = person_id, valor = allowed
        $person = Person::where('id', $id)->first();
        $person->paraphrase_allowed = $valor;
        $person->save();
    }
}
