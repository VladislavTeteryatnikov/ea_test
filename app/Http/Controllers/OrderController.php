<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Запись данных в таблицу orders
     */
    public static function writeInDb()
    {
        $url = 'http://89.108.115.241:6969/api/orders';
        $dateFrom = '2000-12-17';
        $dateTo = '2024-12-17';
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        $keyForLinks = 'links';
        $lastLink = self::getLastLink($url, $dateFrom, $dateTo, $token, $keyForLinks);

        for ($page = 1; $page <= (int)$lastLink; $page++) {
            $keyForData = 'data';
            $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData, $page);

            foreach ($allData as $data){
                $order = Order::query()->create([
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
        echo 'Данные успешно добавлены в БД';
    }
}
