<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OrdersConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumer orders on kafka';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Order Consumer Initiate \n";

        $conf = new \RdKafka\Conf();
        $conf->set('group.id', 'orders-group');
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('auto.offset.reset', 'latest');
        $conf->set('enable.auto.commit', 'true');
        $conf->set('offset.store.method', 'broker');

        $consumer = new \RdKafka\KafkaConsumer($conf);
        $consumer->subscribe(['orders']);

        echo "Waiting for partition assignment... \n";

        while (true) {
            $message = $consumer->consume(120*1000);
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
