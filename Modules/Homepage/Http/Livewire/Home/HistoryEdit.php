<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Homepage\Entities\HomeHistories;
use Modules\Homepage\Entities\HomeHistoriesDetails;
use Illuminate\Support\Facades\Storage;

class HistoryEdit extends Component
{
    use WithFileUploads;


    public $history;
    public $histories_details;

    public $image_path_last;
    public $image_path;
    public $title;
    public $author;
    public $thesis_title;
    public $career;
    public $year;
    public $month;
    public $university;
    public $details;
    public $details_old;

    public function mount($id)
    {
        $this->history = HomeHistories::find($id);
        $this->histories_details = HomeHistoriesDetails::where('history_id', $id)->get();
        $this->title = $this->history->title;
        $this->author = $this->history->author;
        $this->thesis_title = $this->history->thesis_title;
        $this->career = $this->history->career;
        $this->year = $this->history->year;
        $this->month = $this->history->month;
        $this->university = $this->history->university;
        foreach ($this->histories_details as $detail) {
            $this->details .= $detail->detail . ', ';
        }
        $this->details = substr($this->details, 0, -2);
        $this->details_old = $this->details;
        $this->image_path = $this->history->image_path;
        $this->image_path_last = $this->history->image_path;
    }

    public function render()
    {
        return view('homepage::livewire.home.history-edit');
    }

    public function save()
    {
        if ($this->image_path_last != $this->image_path) {
            $image_path = HomeHistories::find($this->history->id)->image_path;
            Storage::disk('public')->delete(substr($image_path, 8));
            $this->image_path = 'storage/' . substr($this->image_path->store('public/uploads/homepage/histories'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        }
        $this->history->title = $this->title;
        $this->history->author = $this->author;
        $this->history->thesis_title = $this->thesis_title;
        $this->history->career = $this->career;
        $this->history->year = $this->year;
        $this->history->month = $this->month;
        $this->history->university = $this->university;
        $this->history->image_path = $this->image_path;
        $this->history->update();

        if ($this->details_old != $this->details) {
            $detail = explode(',', $this->details);
            $old_details = HomeHistoriesDetails::where('history_id', $this->history->id)->get();
            $old_details->each(function ($detail) {
                $detail->delete();
            });

            foreach ($detail as $value) {
                $detail = new HomeHistoriesDetails();
                $detail->history_id = $this->history->id;
                $detail->detail = trim($value);
                $detail->save();
            }
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

    public function updatedPhoto()
    {
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
