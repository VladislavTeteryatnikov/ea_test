<?php

namespace App\Console\Commands;

use App\Models\Company;
use Illuminate\Console\Command;

class AddCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-company {nameCompany}';

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
        $nameCompany = $this->argument('nameCompany');
        $company = Company::query()->create([
            'name' => $nameCompany,
        ]);

        if ($company) {
            echo "Компания $nameCompany успешно добавлена";
        }
    }
}
