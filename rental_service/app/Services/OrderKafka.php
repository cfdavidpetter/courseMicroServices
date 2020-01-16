<?php

namespace App\Services;

use App\Services\Kafka\Kafka;

/**
 * Class Kafka
 *
 * @package namespace App\Services;
 */
class OrderKafka extends Kafka
{
    public function sendKafka($order, $parameters)
    {
        $Message = [
            'data' => $order,
            'parameters' => $parameters
        ];

        $this->producer($Message, 'orders');
    }
}