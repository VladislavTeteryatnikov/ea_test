<?php

namespace App\Console\Commands;

use App\Models\Api_service;
use Illuminate\Console\Command;

class AddApiService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-api-service {nameApiService} {urlApiService}';

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
        $nameApiService = $this->argument('nameApiService');
        $urlApiService = $this->argument('urlApiService');
        $apiService =  Api_service::query()
            ->where('name', '=', $nameApiService)
            ->orWhere('url', '=', $urlApiService)
            ->exists();
        if ($apiService) {
            echo "Api сервис с таким названием или URL уже существует";
            return;
        }
        $newApiService = Api_service::query()->create([
            'name' => $nameApiService,
            'url' => $urlApiService,
        ]);

        if ($newApiService) {
            echo "API-сервис $nameApiService успешно добавлен";
        }
    }
}
