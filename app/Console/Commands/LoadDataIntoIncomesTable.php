<?php

namespace App\Console\Commands;

use App\Http\Controllers\IncomeController;
use App\Http\RateLimiter;
use App\Models\Account_api_service;
use App\Models\Income;
use Illuminate\Console\Command;

class LoadDataIntoIncomesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-incomes-table {token}';

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
        $token = $this->argument('token');
        //$token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';

        //Проверяем, привязан ли аккаунт к токену
        $accountId = Account_api_service::query()
            ->where('token_access', '=', $token)
            ->value('account_id');
        if (!$accountId) {
            echo 'Аккаунт не существует';
            return;
        }

        Income::query()->where('account_id', $accountId)->delete();

        IncomeController::writeInDb($token);
    }
}

