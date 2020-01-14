<?php

namespace App\Services;

use App\Services\Kafka\Kafka;

/**
 * Class Kafka
 *
 * @package namespace App\Services;
 */
class CustomerKafka extends Kafka
{
    public function sendKafka($customer, $parameters)
    {
        $Message = [
            'data' => $customer,
            'parameters' => $parameters
        ];

        $this->producer($Message, 'customers');
    }
}