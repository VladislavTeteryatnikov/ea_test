<?php

namespace App\Console\Commands;

use App\Http\Controllers\StockController;
use App\Models\Account_api_service;
use App\Models\Stock;
use Illuminate\Console\Command;

class LoadDataIntoStocksTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-stocks-table {token}';

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

        //Удаляем все данные из таблицы для этого аккаунта и загружаем заново
        Stock::query()->where('account_id', $accountId)->delete();
        StockController::writeInDb($token);
    }
}
