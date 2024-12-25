<?php

namespace App\Console\Commands;

use App\Http\Controllers\SaleController;
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        SaleController::updateSalesTable($token);
    }
}
