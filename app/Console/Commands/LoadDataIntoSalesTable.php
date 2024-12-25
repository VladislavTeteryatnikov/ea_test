<?php

namespace App\Console\Commands;

use App\Http\Controllers\SaleController;
use Illuminate\Console\Command;

class LoadDataIntoSalesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-sales-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление данных в таблицу sales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        SaleController::writeInDb($token);
    }
}
