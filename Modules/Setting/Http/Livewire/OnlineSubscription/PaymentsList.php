<?php

namespace Modules\Setting\Http\Livewire\OnlineSubscription;

use App\Models\UserSubscription;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentsList extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        //dd($this->getData());
        return view('setting::livewire.online-subscription.payments-list', [
            'subscriptions' => $this->getData()
        ]);
    }

    public function getData()
    {
        return UserSubscription::join('people', 'user_subscriptions.user_id', 'people.user_id')
            ->join('type_subscriptions', 'subscription_id', 'type_subscriptions.id')
            ->select(
                'people.number',
                'people.full_name',
                'people.mobile_phone',
                'people.email',
                'user_subscriptions.date_start',
                'user_subscriptions.date_end',
                'user_subscriptions.payment_response',
                'user_subscriptions.status_response',
                'user_subscriptions.payment_server',
                'type_subscriptions.name AS type_subscription_name'
            )
            ->where('payment_online', true)
            ->paginate(20);
    }
}
