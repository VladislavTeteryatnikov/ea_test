<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Company;
use Illuminate\Console\Command;

class AddAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-account {nameAccount} {idCompany}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление аккаунта для компании';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companyId = $this->argument('idCompany');
        $accountName = $this->argument('nameAccount');

        //Проверка, что такая компания существует
        $company =  Company::query()->find($companyId);
        if (!$company) {
            echo "Компании с id = $companyId не существует";
            return;
        }

        //Добавляем аккаунт
        $account = Account::query()->create([
            'name' => $accountName,
            'company_id' => $companyId,
        ]);
        if ($account) {
            echo "Аккаунт $accountName успешно добавлен для комании $company->name";
        }
    }
}
