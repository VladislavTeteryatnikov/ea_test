<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:update-incomes-table')->twiceDaily(1, 13);;
Schedule::command('app:update-orders-table')->twiceDaily(1, 13);;
Schedule::command('app:update-sales-table')->twiceDaily(1, 13);;
Schedule::command('app:update-stocks-table')->twiceDaily(1, 13);;

//php artisan schedule:work на локальном
//docker exec -it <имя_контейнера> php artisan <команда>
