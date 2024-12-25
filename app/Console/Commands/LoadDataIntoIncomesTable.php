<?php

namespace App\Console\Commands;

use App\Http\Controllers\IncomeController;
use Illuminate\Console\Command;

class LoadDataIntoIncomesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-incomes-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление данные в таблицу incomes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        IncomeController::writeInDb($token);
    }
}
