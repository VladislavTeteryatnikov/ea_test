<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class SaleController extends Controller
{
    /**
     * Запись данных в таблицу sales
     */
    public static function writeInDb()
    {
        $url = 'http://89.108.115.241:6969/api/sales';
        $dateFrom = '2000-12-17';
        $dateTo = '2024-12-17';
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        $keyForLinks = 'links';
        $lastLink = self::getLastLink($url, $dateFrom, $dateTo, $token, $keyForLinks);
        for ($page = 1; $page <= (int)$lastLink; $page++) {
            $keyForData = 'data';
            $allData = self::getData($url, $dateFrom, $dateTo, $token, $keyForData, $page);

            foreach ($allData as $data){
                $sale = Sale::query()->create([
                    'g_number' => $data['g_number'],
                    'date' => $data['date'],
                    'last_change_date' => $data['last_change_date'],
                    'supplier_article' => $data['supplier_article'],
                    'tech_size' => $data['tech_size'],
                    'barcode' => $data['barcode'],
                    'total_price' => $data['total_price'],
                    'discount_percent' => $data['discount_percent'],
                    'is_supply' => $data['discount_percent'],
                    'is_realization' => $data['is_realization'],
                    'promo_code_discount' => $data['promo_code_discount'],
                    'warehouse_name' => $data['warehouse_name'],
                    'country_name' => $data['country_name'],
                    'oblast_okrug_name' => $data['oblast_okrug_name'],
                    'region_name' => $data['region_name'],
                    'income_id' => $data['income_id'],
                    'sale_id' => $data['sale_id'],
                    'odid' => $data['odid'],
                    'spp' => $data['spp'],
                    'for_pay' => $data['for_pay'],
                    'finished_price' => $data['finished_price'],
                    'price_with_disc' => $data['price_with_disc'],
                    'nm_id' => $data['nm_id'],
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'brand' => $data['brand'],
                    'is_storno' => $data['is_storno'],
                ]);
            }

        }
        echo 'Данные успешно добавлены в БД';
    }
}
