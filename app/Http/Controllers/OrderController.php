<?php

namespace App\Http\Controllers;

use App\Models\Account_api_service;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Запись данных в таблицу orders
     */
    public static function writeInDb(string $token)
    {
        $url = 'http://89.108.115.241:6969/api/orders';
        $dateFrom = '2000-12-17';
        $dateTo = Carbon::now()->format('Y-m-d');
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

            foreach ($allData as $data){
                $order = Order::query()->create([
                    'account_id' =>  $accountId,
                    'g_number' => $data['g_number'],
                    'date' => $data['date'],
                    'last_change_date' => $data['last_change_date'],
                    'supplier_article' => $data['supplier_article'],
                    'tech_size' => $data['tech_size'],
                    'barcode' => $data['barcode'],
                    'total_price' => $data['total_price'],
                    'discount_percent' => $data['discount_percent'],
                    'warehouse_name' => $data['warehouse_name'],
                    'oblast' => $data['oblast'],
                    'income_id' => $data['income_id'],
                    'odid' => $data['odid'],
                    'nm_id' => $data['nm_id'],
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'brand' => $data['brand'],
                    'is_cancel' => $data['is_cancel'],
                    'cancel_dt' => $data['cancel_dt'],
                ]);
            }
        }
        self::debugInfo('Данные успешно добавлены в БД');
    }

    /**
     * Запись актуальных данных 'за сегодня' в таблицу Orders
     * @param string $token токен доступа к api
     */
    public static function updateOrdersTable(string $token)
    {
        $url = 'http://89.108.115.241:6969/api/orders';
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
        $myData = Order::query()
            ->where('date', $dateFrom)
            ->get();

        //Если количество данных, полученных по api, и в моей БД совпадают
        if ($allData->count() === $myData->count()) {
            self::debugInfo('Новых данных нет');
            return;
        }

        //Удаляем данные из моей таблицы за сегодня
        Order::query()->where('date', $dateFrom)->delete();

        //Вставляем обновленные данные за сегодня в мою таблицу
        foreach ($allData as $data){
            $order = Order::query()->create([
                'account_id' =>  $accountId,
                'g_number' => $data['g_number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'total_price' => $data['total_price'],
                'discount_percent' => $data['discount_percent'],
                'warehouse_name' => $data['warehouse_name'],
                'oblast' => $data['oblast'],
                'income_id' => $data['income_id'],
                'odid' => $data['odid'],
                'nm_id' => $data['nm_id'],
                'subject' => $data['subject'],
                'category' => $data['category'],
                'brand' => $data['brand'],
                'is_cancel' => $data['is_cancel'],
                'cancel_dt' => $data['cancel_dt'],
            ]);
        }
        self::debugInfo('Данные в таблице Orders успешно обновлены');
    }
}
