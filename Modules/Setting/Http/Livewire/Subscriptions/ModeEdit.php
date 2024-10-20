<?php

namespace Modules\Setting\Http\Livewire\Subscriptions;

use App\Models\TypeSubscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModeEdit extends Component
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

    public $sub;

    public function mount($subId)
    {
        $this->sub = TypeSubscription::find($subId);

        $this->name             = $this->sub->name;
        $this->detail_one       = $this->sub->detail_one;
        $this->detail_two       = $this->sub->detail_two;
        $this->detail_three     = $this->sub->detail_three;
        $this->detail_four      = $this->sub->detail_four;
        $this->detail_five      = $this->sub->detail_five;
        $this->detail_six       = $this->sub->detail_six;
        $this->detail_seven     = $this->sub->detail_seven;
        $this->detail_eight     = $this->sub->detail_eight;
        $this->price            = $this->sub->price;
        $this->dollar_price     = $this->sub->dollar_price;
        $this->ai_oportunities  = $this->sub->ai_oportunities;
        $this->allowed_thesis   = $this->sub->allowed_thesis;
        $this->until_subscription = $this->sub->until_subscription;
    }

    public function render()
    {
        return view('setting::livewire.subscriptions.mode-edit');
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

        $this->sub->update([
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
            'updated_user_id'   => Auth::id(),
        ]);

        $this->dispatchBrowserEvent('set-subscription-modes-update', ['tit' => 'Enhorabuena', 'msg' => 'Se Actualizó correctamente']);
    }
}
