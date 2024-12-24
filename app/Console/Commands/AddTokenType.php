<?php

namespace App\Console\Commands;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tokenType = $this->argument('tokenType');
        $token =  Token::query()->where('type', '=', $tokenType)->exists();
        if ($token) {
            echo "Token type $tokenType уже существует";
            return;
        }
        $newToken = Token::query()->create([
            'type' => $tokenType,
        ]);

        if ($newToken) {
            echo "Тип токена $tokenType успешно добавлен";
        }
    }
}
