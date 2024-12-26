<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/load-into-incomes/{argument}', function ($argument) {
    Artisan::call('app:load-data-into-incomes-table', ['token' => $argument]);
});

Route::get('/load-into-orders/{argument}', function ($argument) {
    Artisan::call('app:load-data-into-orders-table', ['token' => $argument]);
});

Route::get('/load-into-sales/{argument}', function ($argument) {
    Artisan::call('app:load-data-into-sales-table', ['token' => $argument]);
});

Route::get('/load-into-stocks/{argument}', function ($argument) {
    Artisan::call('app:load-data-into-stocks-table', ['token' => $argument]);
});
