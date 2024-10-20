<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Homepage\Entities\HomeHistories;
use Modules\Homepage\Entities\HomeHistoriesDetails;

class HistoryCreate extends Component
{
    use WithFileUploads;

    public $image_path;

    public $title;
    public $author;
    public $thesis_title;
    public $career;
    public $year;
    public $month;
    public $university;
    public $details;

    public function render()
    {
        return view('homepage::livewire.home.history-create');
    }

    public function save(){
        $this->validate([
            'year' => 'numeric|min:2010',
        ]);
        $history = new HomeHistories();
        $history->title = $this->title;
        $history->author = $this->author;
        $history->thesis_title = $this->thesis_title;
        $history->career = $this->career;
        $history->year = $this->year;
        $history->month = $this->month;
        $history->university = $this->university;
        $history->image_path = 'storage/'.substr($this->image_path->store('public/uploads/homepage/histories'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        $history->save();

        $detail= explode(',', $this->details);


        foreach ($detail as $value) {
            $detail = new HomeHistoriesDetails();
            $detail->history_id = $history->id;
            $detail->detail = trim($value);
            $detail->save();
        }
/*
        $history_details = new HomeHistoriesDetails();
        $history_details->history_id = $history->id;
        $history_details->image_path = $this->image_path;
        $history_details->save();
*/
        session()->flash('success', 'Historia creada correctamente');
        return redirect()->route('homepage_histories');
    }

    public function updatedPhoto(){
        $this->validate([
            'image_path' => 'image|max:10240',
        ]);
    }

    protected $rules = [
        'image_path' => 'required',
        'title' => 'required',
        'author' => 'required',
        'thesis_title' => 'required',
        'career' => 'required',
        'year' => 'required',
        'month' => 'required',
        'university' => 'required',
        'details' => 'required'
    ];

}
