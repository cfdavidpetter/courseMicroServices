<?php

namespace App\Services;

use App\Services\Kafka\Kafka;
use App\Order;
use App\OrderItem;
use Illuminate\Support\Facades\DB;

/**
 * Class Kafka
 *
 * @package namespace App\Services;
 */
class OrderKafka extends Kafka
{
    public function receiveKafka()
    {
        $this->consumer('orders');
        while (true) {
            $message = $this->receiveMessage->consume(120*1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $data = json_decode($message->payload, true);

                    try {
                        DB::beginTransaction();
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
                        DB::commit();
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        print_r($th->getMessage());
                        die();
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
        $Order = Order::create($data);
        foreach ($data['items'] as $Item) {
            OrderItem::create($Item);
        }
        echo "Created Order\n";
    }

    protected function update($data)
    {
        $Order = Order::find($data['id']);
        if ($Order) {
            $Order->fill($data);
            $Order->save();

            //Itens
            $Order->items()->delete();
            foreach ($data['items'] as $Item) {
                OrderItem::create($Item);
            }

            echo "Updated Order\n";
        } else {
            $this->create($data);
        }
    }

    protected function delete($data)
    {
        Order::destroy($data['id']);
        echo "Deleted Order\n";
    }
}