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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        IncomeController::updateIncomesTable($token);
    }
}
