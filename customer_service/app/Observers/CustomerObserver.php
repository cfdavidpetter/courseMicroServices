<?php

namespace App\Observers;

use App\Customer;
use App\Services\CustomerKafka;
use Illuminate\Support\Facades\Log;

class CustomerObserver
{
    protected $CustomerKafka;

    function __construct(CustomerKafka $CustomerKafka) {
        $this->CustomerKafka = $CustomerKafka;
    }

    /**
     * Handle the customer "created" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        Log::info('CustomerObserver -> created');
        $this->CustomerKafka->sendKafka($Customer, ['type' => 'create']);
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        Log::info('CustomerObserver -> updated');
        $this->CustomerKafka->sendKafka($Customer, ['type' => 'update']);
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        Log::info('CustomerObserver -> deleted');
        $this->CustomerKafka->sendKafka($Customer, ['type' => 'delete']);
    }
}
