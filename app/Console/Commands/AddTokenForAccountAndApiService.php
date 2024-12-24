<?php

namespace App\Console\Commands;

use App\Models\Account_api_service;
use Illuminate\Console\Command;

class AddTokenForAccountAndApiService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-token-for-account-and-api-service {accountId} {apiServiceId} {tokenId} {token}';

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
        $accountId = $this->argument('accountId');
        $apiServiceId = $this->argument('apiServiceId');
        $tokenId = $this->argument('tokenId');
        $token = $this->argument('token');
        $tokenItem = Account_api_service::query()->create([
            'account_id' => $accountId,
            'api_service_id' => $apiServiceId,
            'token_id' => $tokenId,
            'token_access' => $token,
        ]);

        if ($tokenItem) {
            echo "Токен $tokenItem успешно добавлен для аккаунта с id = $accountId и API-сервиса с id=$apiServiceId. Тип токена имеет id=$tokenId";
        }
    }
}
