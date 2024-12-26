<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Console\Command;

class AddTokenType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-token-type {tokenType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление типа токена (bearer, api-key и тд)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tokenType = $this->argument('tokenType');
        //Тип токена должен быть уникальным
        $token =  Token::query()->where('type', '=', $tokenType)->exists();
        if ($token) {
            Controller::debugInfo("Token type $tokenType уже существует");
            return;
        }

        //Добавляем тип токена
        $newToken = Token::query()->create([
            'type' => $tokenType,
        ]);

        if ($newToken) {
            Controller::debugInfo("Тип токена $tokenType успешно добавлен");
        }
    }
}
