<?php

namespace App\Console\Commands;

use App\Http\Controllers\StockController;
use Illuminate\Console\Command;

class UpdateStocksTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stocks-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        StockController::updateStocksTable($token);
    }
}
