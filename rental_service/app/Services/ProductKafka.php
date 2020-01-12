<?php

namespace App\Services;

use App\Services\Kafka\Kafka;
use App\Product;

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
                    $data = json_decode($message->payload, true);

                    switch ($data['parameters']['type']) {
                        case 'create':
                            $this->create($data['data']);
                            break;

                        case 'update':
                            $this->update($data['data']);
                            break;

                        case 'delete':
                            $this->delete($data['data']);
                            break;
                        
                        default:
                            echo "invalid type\n";
                            break;
                    }

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

    protected function create($data)
    {
        Product::create($data);
        echo "Created Product\n";
    }

    protected function update($data)
    {
        $Product = Product::find($data['id']);
        if ($Product) {
            $Product->fill($data);
            $Product->save();
            echo "Updated Product\n";
        } else {
            $this->create($data);
        }
    }

    protected function delete($data)
    {
        Product::destroy($data['id']);
        echo "Deleted Product\n";
    }
}