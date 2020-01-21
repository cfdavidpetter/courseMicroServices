<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OrderKafka;

class OrdersConsumer extends Command
{
    protected $OrderKafka;
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
    public function __construct(OrderKafka $OrderKafka)
    {
        parent::__construct();

        $this->OrderKafka = $OrderKafka;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Order Consumer Initiate \n";
        $this->OrderKafka->receiveKafka();
    }
}
