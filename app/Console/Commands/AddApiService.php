<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
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
    protected $description = 'Добавление API-сервиса';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nameApiService = $this->argument('nameApiService');
        $urlApiService = $this->argument('urlApiService');

        //Проверка, что api-сервиса с таким названием или url не существует
        $apiService =  Api_service::query()
            ->where('name', '=', $nameApiService)
            ->orWhere('url', '=', $urlApiService)
            ->exists();
        if ($apiService) {
            Controller::debugInfo("Api-сервис с таким названием или URL уже существует");
            return;
        }

        //Добавляем новый api-сервис
        $newApiService = Api_service::query()->create([
            'name' => $nameApiService,
            'url' => $urlApiService,
        ]);

        if ($newApiService) {
            Controller::debugInfo("API-сервис $nameApiService успешно добавлен");
        }
    }
}
