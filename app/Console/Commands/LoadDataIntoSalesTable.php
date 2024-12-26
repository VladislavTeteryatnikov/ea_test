<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SaleController;
use App\Models\Account_api_service;
use App\Models\Income;
use App\Models\Sale;
use Illuminate\Console\Command;

class LoadDataIntoSalesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-sales-table {token}';

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
        $token = $this->argument('token');
        //$token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';

        //Проверяем, привязан ли аккаунт к токену
        $accountId = Account_api_service::query()
            ->where('token_access', '=', $token)
            ->value('account_id');
        if (!$accountId) {
            Controller::debugInfo('Аккаунт не существует');
            return;
        }

        //Удаляем все данные из таблицы для этого аккаунта и загружаем заново
        Sale::query()->where('account_id', $accountId)->delete();
        SaleController::writeInDb($token);
    }
}
