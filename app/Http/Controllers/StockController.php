<?php

namespace App\Http\Controllers;

use App\Models\Stock;

class StockController extends Controller
{
    /**
     * Запись данных в таблицу stocks
     */
    public static function writeInDb()
    {
        $url = 'http://89.108.115.241:6969/api/stocks';
        $dateFrom = '2024-12-18';
        $dateTo = null;
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        $keyForLinks = 'links';
        $lastLink = self::getLastLink($url, $dateFrom, $dateTo, $token, $keyForLinks);

        for ($page = 1; $page <= (int)$lastLink; $page++) {
            $keyForData = 'data';
            $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData, $page);

            foreach ($allData as $data){
                $stock = Stock::query()->create([
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

}
