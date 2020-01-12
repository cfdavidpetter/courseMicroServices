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
    public function receiveKafka()
    {
        $this->consumer('products');
        while (true) {
            $message = $this->receiveMessage->consume(120*1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    var_dump($message);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
                    break;
            }
        }
    }
}