<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IncomeController;
use App\Models\Account_api_service;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateIncomesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-incomes-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление данных в таблице Incomes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Обновляем данные только для тех аккаунтов, которые уже присутствуют в таблице Incomes
        $accountsId = Income::query()->pluck('account_id')->unique();
        foreach ($accountsId as $accountId) {
            $token = Account_api_service::query()
                ->where('account_id', $accountId)
                ->value('token_access');
            IncomeController::updateIncomesTable($token);
        }
    }
}
