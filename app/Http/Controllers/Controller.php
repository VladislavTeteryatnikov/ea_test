<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

abstract class Controller
{
    /**
     * Метод для получения data по эндпоинту
     * @param string $url
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $token
     * @param string $key
     * @param int $page
     * @return \Illuminate\Support\Collection
     */
    public static function getData(string $url, string $dateFrom, string $dateTo, string $token, string $key, int $page = 1)
    {
        $response = Http::get($url . "?dateFrom=$dateFrom&dateTo=$dateTo&page=$page&key=$token");
        return $response->collect($key);
    }


    /**
     * Метод для получения 'last page'
     * @param string $url
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $token
     * @param string $key
     * @return string
     */
    protected static function getLastLink(string $url, string $dateFrom, string $dateTo, string $token, string $key)
    {
        $links = self::getData($url, $dateFrom, $dateTo, $token, $key);
        $arr = explode("=", $links['last']);
        return $arr[1];
    }
}
