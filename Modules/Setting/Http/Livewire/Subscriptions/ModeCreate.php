<?php

namespace Modules\Setting\Http\Livewire\Subscriptions;

use App\Models\TypeSubscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModeCreate extends Component
{
    public $name;
    public $detail_one;
    public $detail_two;
    public $detail_three;
    public $detail_four;
    public $detail_five;
    public $detail_six;
    public $detail_seven;
    public $detail_eight;
    public $price;
    public $dollar_price;
    public $ai_oportunities;
    public $allowed_thesis;
    public $until_subscription;

    public function render()
    {
        return view('setting::livewire.subscriptions.mode-create');
    }

    protected $rules = [
        'name' => 'required|min:3|unique:roles,name',
        'detail_one' => 'required|min:3|max:255',
        'detail_two' => 'required|min:3|max:255',
        'detail_three' => 'required|min:3|max:255',
        'detail_four' => 'required|min:3|max:255',
        // 'detail_five' => 'required|min:3|max:255',
        // 'detail_six' => 'required|min:3|max:255',
        // 'detail_seven' => 'required|min:3|max:255',
        // 'detail_eight' => 'required|min:3|max:255',
        'price' => 'required',
        'dollar_price' => 'required',
        'ai_oportunities' => 'required',
        'allowed_thesis' => 'required',
        'until_subscription' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        TypeSubscription::create([
            'name'              => $this->name,
            'detail_one'        => $this->detail_one,
            'detail_two'        => $this->detail_two,
            'detail_three'      => $this->detail_three,
            'detail_four'       => $this->detail_four,
            'detail_five'       => $this->detail_five,
            'detail_six'        => $this->detail_six,
            'detail_seven'      => $this->detail_seven,
            'detail_eight'      => $this->detail_eight,
            'price'             => $this->price,
            'dollar_price'      => $this->dollar_price,
            'ai_oportunities'   => $this->ai_oportunities,
            'allowed_thesis'    => $this->allowed_thesis,
            'until_subscription' => $this->until_subscription,
            'created_user_id'   => Auth::id(),
            'updated_user_id'   => null,
        ]);

        $this->clearForm();

        $this->dispatchBrowserEvent('set-subscription-modes-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }

    public function clearForm()
    {
        $this->name = null;
        $this->detail_one = null;
        $this->detail_two = null;
        $this->detail_three = null;
        $this->detail_four = null;
        $this->detail_five = null;
        $this->detail_six = null;
        $this->detail_seven = null;
        $this->detail_eight = null;
        $this->price = null;
        $this->dollar_price  = null;
        $this->ai_oportunities  = null;
        $this->allowed_thesis  = null;
        $this->until_subscription  = null;
    }
}
