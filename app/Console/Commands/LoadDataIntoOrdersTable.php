<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderController;
use App\Models\Account_api_service;
use App\Models\Order;
use Illuminate\Console\Command;

class LoadDataIntoOrdersTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data-into-orders-table {token}';

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

        Order::query()->where('account_id', $accountId)->delete();

        OrderController::writeInDb($token);
    }
}
