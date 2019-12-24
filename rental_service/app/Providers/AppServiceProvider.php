<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\{ OrderObserver, OrderItemObserver, PaymentObserver };
use App\{ Order, OrderItem, Payment };

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
