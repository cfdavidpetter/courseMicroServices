<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductKafka;

class ProductsConsumer extends Command
{
    protected $ProductKafka;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumer products on kafka';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductKafka $ProductKafka)
    {
        parent::__construct();

        $this->ProductKafka = $ProductKafka;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Product Consumer Initiate \n";
        $this->ProductKafka->receiveKafka();
    }
}
