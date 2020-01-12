<?php

namespace App\Services;

use App\Services\Kafka\Kafka;

/**
 * Class Kafka
 *
 * @package namespace App\Services;
 */
class ProductKafka extends Kafka
{
    public function sendKafka($product, $parameters)
    {
        $Message = [
            'data' => $product,
            'parameters' => $parameters
        ];

        $this->producer($Message, 'products');
    }
}