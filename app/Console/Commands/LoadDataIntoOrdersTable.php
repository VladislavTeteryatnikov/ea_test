<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderController;
use Illuminate\Console\Command;

class LoadDataIntoOrdersTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-orders-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление данных в таблицу orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        OrderController::writeInDb($token);
    }
}
