<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CustomerKafka;

class CustomerConsumer extends Command
{
    protected $CustomerKafka;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumer customers on kafka';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CustomerKafka $CustomerKafka)
    {
        parent::__construct();

        $this->CustomerKafka = $CustomerKafka;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Customer Consumer Initiate \n";
        $this->CustomerKafka->receiveKafka();
    }
}
