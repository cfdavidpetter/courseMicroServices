<?php

namespace App\Observers;

use App\Product;
use App\Services\ProductKafka;
use Illuminate\Support\Facades\Log;


class ProductObserver
{
    protected $ProductKafka;

    function __construct(ProductKafka $ProductKafka) {
        $this->ProductKafka = $ProductKafka;
    }

    /**
     * Handle the product "created" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        Log::info('ProductObserver -> created');
        $this->ProductKafka->sendKafka($product, ['type' => 'create']);
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        Log::info('ProductObserver -> updated');
        $this->ProductKafka->sendKafka($product, ['type' => 'update']);
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        Log::info('ProductObserver -> deleted');
        $this->ProductKafka->sendKafka($product, ['type' => 'delete']);
    }
}
