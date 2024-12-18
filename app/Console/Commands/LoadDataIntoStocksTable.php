<?php

namespace App\Console\Commands;

use App\Http\Controllers\StockController;
use Illuminate\Console\Command;

class LoadDataIntoStocksTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-stocks-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление данных в таблицу stocks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        StockController::writeInDb();
    }
}
