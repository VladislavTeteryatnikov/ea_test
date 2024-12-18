# ea-test
___
### Тестовое задание: 

Вам необходимо стянуть все данные по описанным эндпоинтам и сохранить в БД.
___
### Реализаця:

Выполнил задание с помощью создания консольных команд. Каждая команда отвечает за добавление данных, полученных по api, в определенную таблицу
___

### Доступ к БД:
DB_CONNECTION=mysql
DB_HOST=sql8.freesqldatabase.com
DB_PORT=3306
DB_DATABASE=sql8752840
DB_USERNAME=sql8752840
DB_PASSWORD=uYySF2LbXG
___
### Названия таблиц
1. 'incomes'
2. 'stocks'
3. 'sales'
4. 'orders'
___
### Развернуть проект:
1. Клонировать проект
2. composer install
3. Создать файл .env и скопировать в него данные из .env.example
4. ```php artisan migrate:refresh``` - откатить все миграции и накатить снова
5. ```php artisan app:load-data-into-incomes-table``` - для стягивания данных и внесения в таблицу 'incomes'
6. ```php artisan app:load-data-into-stocks-table``` - для стягивания данных и внесения в таблицу 'stocks'
7. ```php artisan app:load-data-into-sales-table``` - для стягивания данных и внесения в таблицу 'sales'
8. ```php artisan app:load-data-into-orders-table``` - для стягивания данных и внесения в таблицу 'orders'
___
### Нюансы:
Не удалось стянуть абсолютно все данные, так как выделенное место на бесплатном хостинге ограничено и его не хватает

