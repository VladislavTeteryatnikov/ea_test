<?php

namespace App\Http\Controllers;

use App\Models\Account_api_service;
use App\Models\Income;

class IncomeController extends Controller
{
    /**
     * Запись данных в таблицу incomes
     */
    public static function writeInDb()
    {
        $url = 'http://89.108.115.241:6969/api/incomes';
        $dateFrom = '2000-12-17';
        $dateTo = '2024-12-17';
        $token = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
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
                $income = Income::query()->create([
                    'account_id' =>  $accountId,
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
        echo 'Данные успешно добавлены в БД';
    }
}
