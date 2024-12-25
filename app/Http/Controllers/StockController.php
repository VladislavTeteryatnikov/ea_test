<?php

namespace App\Http\Controllers;

use App\Models\Account_api_service;
use App\Models\Stock;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Запись данных в таблицу stocks
     */
    public static function writeInDb(string $token)
    {
        $url = 'http://89.108.115.241:6969/api/stocks';
        $dateFrom = Carbon::now()->format('Y-m-d');
        $dateTo = '';

        $accountId = Account_api_service::query()
            ->where('token_access', '=', $token)
            ->value('account_id');
        if (!$accountId) {
            echo 'Аккаунт не существует';
            return;
        };
        $keyForLinks = 'links';
        $lastLink = self::getLastLink($url, $dateFrom, $dateTo, $token, $keyForLinks);

        for ($page = 1; $page <= (int)$lastLink; $page++) {
            $keyForData = 'data';
            $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData, $page);

            foreach ($allData as $data){
                $stock = Stock::query()->create([
                    'account_id' =>  $accountId,
                    'date' => $data['date'],
                    'last_change_date' => $data['last_change_date'],
                    'supplier_article' => $data['supplier_article'],
                    'tech_size' => $data['tech_size'],
                    'barcode' => $data['barcode'],
                    'quantity' => $data['quantity'],
                    'is_supply' => $data['is_supply'],
                    'is_realization' => $data['is_realization'],
                    'quantity_full' => $data['quantity_full'],
                    'warehouse_name' => $data['warehouse_name'],
                    'in_way_to_client' => $data['in_way_to_client'],
                    'in_way_from_client' => $data['in_way_from_client'],
                    'nm_id' => $data['nm_id'],
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'brand' => $data['brand'],
                    'sc_code' => $data['sc_code'],
                    'price' => $data['price'],
                    'discount' => $data['discount'],
                ]);
            }

        }
        echo 'Данные успешно добавлены в БД';
    }

    /**
     * Запись актуальных данных 'за сегодня' в таблицу Stocks
     * @param string $token токен доступа к api
     */
    public static function updateStocksTable(string $token)
    {
        $url = 'http://89.108.115.241:6969/api/stocks';
        $dateFrom = Carbon::now()->format('Y-m-d');
        $dateTo = '';
        $keyForData = 'data';

        //Проверяем, привязан ли аккаунт к токену
        $accountId = Account_api_service::query()
            ->where('token_access', '=', $token)
            ->value('account_id');
        if (!$accountId) {
            echo 'Аккаунт не существует';
            return;
        }

        //Данные, полученные по api
        $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData);

        //Если по api не получили никаких новых данных
        if ($allData->isEmpty()){
            echo 'Новых данных нет';
            return;
        }

        //Данные из моей таблицы
        $myData = Stock::query()
            ->where('date', $dateFrom)
            ->get();

        //Если количество данных, полученных по api, и в моей БД совпадают
        if ($allData->count() === $myData->count()) {
            echo 'Новых данных нет';
            return;
        }

        //Удаляем данные из моей таблицы за сегодня
        Stock::query()->where('date', $dateFrom)->delete();

        //Вставляем обновленные данные за сегодня в мою таблицу
        foreach ($allData as $data){
                $stock = Stock::query()->create([
                    'account_id' =>  $accountId,
                    'date' => $data['date'],
                    'last_change_date' => $data['last_change_date'],
                    'supplier_article' => $data['supplier_article'],
                    'tech_size' => $data['tech_size'],
                    'barcode' => $data['barcode'],
                    'quantity' => $data['quantity'],
                    'is_supply' => $data['is_supply'],
                    'is_realization' => $data['is_realization'],
                    'quantity_full' => $data['quantity_full'],
                    'warehouse_name' => $data['warehouse_name'],
                    'in_way_to_client' => $data['in_way_to_client'],
                    'in_way_from_client' => $data['in_way_from_client'],
                    'nm_id' => $data['nm_id'],
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'brand' => $data['brand'],
                    'sc_code' => $data['sc_code'],
                    'price' => $data['price'],
                    'discount' => $data['discount'],
            ]);
        }
        echo 'Данные в таблице Stocks успешно обновлены';
    }

}
