<?php

namespace App\Observers;

use App\Order;
use App\Services\OrderKafka;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    protected $OrderKafka;

    function __construct(OrderKafka $OrderKafka) {
        $this->OrderKafka = $OrderKafka;
    }

    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        Log::info('OrderObserver -> created');
        $order->adjustTotal();
        $this->OrderKafka
            ->sendKafka(Order::with('items')->findOrFail($order->id), ['type' => 'create']);
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        Log::info('OrderObserver -> updated');
        $order->adjustTotal();
        $order->adjustBalance();
        $this->OrderKafka
            ->sendKafka(Order::with('items')->findOrFail($order->id), ['type' => 'update']);
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        Log::info('OrderObserver -> deleted');
        $this->OrderKafka->sendKafka($order, ['type' => 'delete']);
    }
}
