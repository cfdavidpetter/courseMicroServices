<?php

namespace App\Observers;

use App\Payment;

class PaymentObserver
{
    /**
     * Handle the payment "created" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        $payment->order->adjustTotal();
        $payment->order->adjustBalance();
    }

    /**
     * Handle the payment "updated" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        $payment->order->adjustTotal();
        $payment->order->adjustBalance();
    }

    /**
     * Handle the payment "deleted" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        $payment->order->adjustTotal();
        $payment->order->adjustBalance();
    }
}
