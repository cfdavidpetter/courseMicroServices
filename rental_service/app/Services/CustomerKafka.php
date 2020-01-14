<?php

namespace App\Services;

use App\Services\Kafka\Kafka;
use App\Customer;

/**
 * Class Kafka
 *
 * @package namespace App\Services;
 */
class CustomerKafka extends Kafka
{
    public function receiveKafka()
    {
        $this->consumer('customers');
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
        Customer::create($data);
        echo "Created Customer\n";
    }

    protected function update($data)
    {
        $Customer = Customer::find($data['id']);
        if ($Customer) {
            $Customer->fill($data);
            $Customer->save();
            echo "Updated Customer\n";
        } else {
            $this->create($data);
        }
    }

    protected function delete($data)
    {
        Customer::destroy($data['id']);
        echo "Deleted Customer\n";
    }
}