<?php

namespace App\Observers;

use App\OrderItem;

class OrderItemObserver
{
    /**
     * Handle the order item "created" event.
     *
     * @param  \App\OrderItem  $orderItem
     * @return void
     */
    public function created(OrderItem $orderItem)
    {
        $orderItem->order->adjustTotal();
        $orderItem->order->adjustBalance();
    }

    /**
     * Handle the order item "updated" event.
     *
     * @param  \App\OrderItem  $orderItem
     * @return void
     */
    public function updated(OrderItem $orderItem)
    {
        $orderItem->order->adjustTotal();
        $orderItem->order->adjustBalance();
    }

    /**
     * Handle the order item "deleted" event.
     *
     * @param  \App\OrderItem  $orderItem
     * @return void
     */
    public function deleted(OrderItem $orderItem)
    {
        $orderItem->order->adjustTotal();
        $orderItem->order->adjustBalance();
    }
}
