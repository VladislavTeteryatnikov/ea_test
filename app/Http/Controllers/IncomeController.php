<?php

namespace App\Http\Controllers;

use App\Http\RateLimiter;
use App\Models\Account_api_service;
use App\Models\Income;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;

class IncomeController extends Controller
{
    /**
     * Запись данных в таблицу incomes
     */
    public static function writeInDb(string $token)
    {
        $url = 'http://89.108.115.241:6969/api/incomes';
        $dateFrom = '2000-12-17';
        $dateTo = '2024-12-17';

        //Проверка существования аккаунта с таким токеном
        $accountId = Account_api_service::query()
            ->where('token_access', '=', $token)
            ->value('account_id');
        if (!$accountId) {
            self::debugInfo('Аккаунт не существует');
            return;
        };

        $keyForLinks = 'links';
        $lastLink = self::getLastLink($url, $dateFrom, $dateTo, $token, $keyForLinks);

        for ($page = 1; $page <= (int)$lastLink; $page++) {
            $keyForData = 'data';
            $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData, $page);

        foreach ($allData as $data) {
            $income = Income::query()->create([
                'account_id' => $accountId,
                'income_id' => $data['income_id'],
                'number' => $data['number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'quantity' => $data['quantity'],
                'total_price' => $data['total_price'],
                'date_close' => $data['date_close'],
                'warehouse_name' => $data['warehouse_name'],
                'nm_id' => $data['nm_id'],
                ]);
            }
        }
        self::debugInfo('Данные успешно добавлены в БД');
    }

    /**
     * Запись актуальных данных 'за сегодня' в таблицу Incomes
     * @param string $token токен доступа к api
     */
    public static function updateIncomesTable(string $token)
    {
        $url = 'http://89.108.115.241:6969/api/incomes';
        $dateFrom = Carbon::now()->format('Y-m-d');
        $dateTo = Carbon::now()->format('Y-m-d');
        $keyForData = 'data';

        //Проверяем, привязан ли аккаунт к токену
        $accountId = Account_api_service::query()
            ->where('token_access', '=', $token)
            ->value('account_id');
        if (!$accountId) {
            self::debugInfo('Аккаунт не существует');
            return;
        }

        //Актуальные данные, полученные по api
        $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData);

        //Если по api не получили никаких новых данных
        if ($allData->isEmpty()){
            self::debugInfo('Новых данных нет');
            return;
        }

        //Данные из моей таблицы
        $myData = Income::query()
            ->where('date', $dateFrom)
            ->get();

        //Если количество данных, полученных по api, и в моей БД совпадают
        if ($allData->count() === $myData->count()) {
            self::debugInfo('Новых данных нет');
            return;
        }

        //Удаляем данные из моей таблицы за сегодня
        Income::query()->where('date', $dateFrom)->delete();

        //Вставляем обновленные данные за сегодня в мою таблицу
        foreach ($allData as $data) {
            $income = Income::query()->create([
                'account_id' => $accountId,
                'income_id' => $data['income_id'],
                'number' => $data['number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'quantity' => $data['quantity'],
                'total_price' => $data['total_price'],
                'date_close' => $data['date_close'],
                'warehouse_name' => $data['warehouse_name'],
                'nm_id' => $data['nm_id'],
            ]);
        }
        self::debugInfo('Данные в таблице Incomes успешно обновлены');
    }
}
