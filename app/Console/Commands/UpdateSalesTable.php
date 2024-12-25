<?php

namespace App\Console\Commands;

use App\Http\Controllers\SaleController;
use App\Models\Account_api_service;
use App\Models\Sale;
use Illuminate\Console\Command;

class UpdateSalesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-sales-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление данных в таблице Sales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        //Обновляем данные только для тех аккаунтов, которые уже присутствуют в таблице Incomes
        $accountsId = Sale::query()->pluck('account_id')->unique();
        foreach ($accountsId as $accountId) {
            $token = Account_api_service::query()
                ->where('account_id', $accountId)
                ->value('token_access');
            SaleController::updateSalesTable($token);
        }
    }
}
