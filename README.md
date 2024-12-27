# ea-test
___
### Краткое описание проекта:
Проект выполнен с использованием фреймворка Laravel. Развернут на сервере с использованием docker-compose с 2 сервисами: php и mysql. 
#### Сценарий использования:
Создаем в базе данных компанию, у которой может быть несколько аккаунтов. К каждому аккаунту привязан api-сервис и токен доступа к этому сервису. С помощью приложения стягиваем данные, используя этот api-сервис, и кладем их в нашу базу данных и привязываем эти данные к id аккаунта этой компании. Также данные в этих таблицах обновляются дважды в день.
___
### Возможности проекта:
Проект доступен: http://193.233.114.253:9007/

Тестовый token=E6kUTYrYwZq2tN4QEtyzsbEBk3ie

#### Роуты для браузера
1. http://193.233.114.253:9007/load-into-incomes/{token} - стянуть все данные в таблицу 'incomes' для аккаунта с token={token};

2. http://193.233.114.253:9007/load-into-stocks/{token} - стянуть все данные в таблицу 'stocks' для аккаунта с token={token};
3. http://193.233.114.253:9007/load-into-sales/{token} - стянуть все данные в таблицу 'sales' для аккаунта с token={token};
4. http://193.233.114.253:9007/load-into-orders/{token} - стянуть все данные в таблицу 'orders' для аккаунта с token={token};

#### Консольные команды
1. ```php artisan app:add-company {nameCompany}``` - добавить компанию
2. ```php artisan app:add-account {nameAccount} {idCompany}``` - добавить аккаунт для компании
3. ```php artisan app:add-api-service {nameApiService} {urlApiService}``` - добавить api-сервис
4. ```php artisan app:add-token-type {tokenType}``` - добавить тип токена (bearer,api-key и тд)
5. ```php artisan app:add-token-for-account-and-api-service {accountId} {apiServiceId} {tokenId} {token}``` - добавить сам токен определенного типа для аккаунта и api-сервиса
6. ```php artisan app:load-data-into-incomes-table {token}``` - стянуть все данные в таблицу 'incomes' для аккаунта с token={token} (аналог http://193.233.114.253:9007/load-into-incomes/{token})
7. ```php artisan app:load-data-into-stocks-table {token}``` - стянуть все данные в таблицу 'stocks' для аккаунта с token={token} (аналог http://193.233.114.253:9007/load-into-stocks/{token})
8. ```php artisan app:load-data-into-sales-table {token}``` - стянуть все данные в таблицу 'sales' для аккаунта с token={token} (аналог http://193.233.114.253:9007/load-into-sales/{token})
9. ```php artisan app:load-data-into-orders-table {token}``` - стянуть все данные в таблицу 'sales' для аккаунта с token={token} (аналог http://193.233.114.253:9007/load-into-orders/{token})
10. ```php artisan app:update-incomes-table``` - ручное обновление данных в таблице 'incomes'. Информация обновляется для всех аккаунтов, чьи данные уже присутствуют в таблице 'incomes'
11. ```php artisan app:update-stocks-table``` - ручное обновление данных в таблице 'stocks'. Информация обновляется для всех аккаунтов, чьи данные уже присутствуют в таблице 'stocks'
12. ```php artisan app:update-sales-table``` - ручное обновление данных в таблице 'sales'. Информация обновляется для всех аккаунтов, чьи данные уже присутствуют в таблице 'sales'
13. ```php artisan app:update-orders-table``` - ручное обновление данных в таблице 'orders'. Информация обновляется для всех аккаунтов, чьи данные уже присутствуют в таблице 'orders'
___

### Нюансы:
1. Ежедневное обновление данных организовал с использованием schedule:work, а не schedule:run.
2. Реализовал информарирвоание об ошибке 'Too many requests'. Для преодоления этой ошибки думаю, что можно было бы использовать очереди, то есть добавить задачу в очередь с отложенным временем выполнения. И если задача не выполнится, то логировать это. Также можно повесить middleware на роуты, чтобы ограничивать количество запросов. Мысли такие, реализовать не успел.
3. Не реализовал команду, которая будет привязывать типы токена для api-сервисов (не было в списке задач).

