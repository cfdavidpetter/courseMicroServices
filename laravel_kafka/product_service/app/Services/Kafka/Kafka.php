<?php

namespace App\Services\Kafka;

/**
 * Class Kafka
 *
 * @package namespace App\Services;
 */
class Kafka
{
    protected $conf;
    protected $receiveMessage;

    function __construct() {
        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('auto.offset.reset', 'latest');
        $conf->set('enable.auto.commit', 'true');
        $conf->set('offset.store.method', 'broker');

        $this->conf = $conf;
    }

    public function producer($message, $nameTopic)
    {
        $this->conf->set('group.id', 'product' . $nameTopic . '-group');

        $producer = new \RdKafka\Producer($this->conf);
        $topic = $producer->newTopic($nameTopic);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($message));
        $producer->poll(0);

        $result = $producer->flush(10000);

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new \RuntimeException('Was unable to flush, messages might be lost!');
        }
    }

    public function consumer($nameTopic)
    {
        $this->conf->set('group.id', 'product' . $nameTopic . '-group');

        $consumer = new \RdKafka\KafkaConsumer($this->conf);
        $consumer->subscribe([$nameTopic]);
        $this->receiveMessage = $consumer;

        echo "Waiting for partition assignment... \n";
    }
}