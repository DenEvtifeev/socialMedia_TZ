<?php

namespace App\Console\Commands;

use App\Services\DummyService;
use Illuminate\Console\Command;

class GetProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-data {--endpoint=} {--filter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить продукты по категориям';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endpoint = $this->option('endpoint');
        $filter = $this->option('filter');
        new DummyService($endpoint, $filter)->getProductData();
    }
}
