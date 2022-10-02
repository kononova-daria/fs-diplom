## Дипломное задание профессии "Веб-разработчик"

Дипломный проект представляет собой создание сайта для бронирования билетов в кинотеатр и разработка информационной системы для администрирования залов, сеансов и предварительного бронирования билетов.

## Технические особенности

- Node Version: 16.17.0;
- PHP Version: 8.0.20;
- Laravel Version: 9.29.0;
- Vue Version: 3.2.39;
- Database: sqlite;

## Запуск проекта

1. Установка пакетов с помощью команд:
```
composer install
npm install
```
2. Создание БД:
    1. В директории database создать файл database.sqlite;
    2. Переименовать файл .env.example в .env и указать следующие DB_CONNECTION и DB_DATABASE:
    ```
    DB_CONNECTION=sqlite
    DB_DATABASE=database\database.sqlite
    ```
    3. Запустить миграции с помощью команды:
    ```
    php artisan migrate
    ```
    4. Заполнить БД первоначальными данными, использовав команду:
    ```
    php artisan db:seed
    ```
    5. Предварительно изменив в .env DB_DATABASE на ..\database\database.sqlite, запустить сервер через команду:
    ```
    php artisan serve
    ```

## Дополнительная информация о проекте

1. Роут клиентской части: '/';
2. Роут административной части: '/admin';
3. Данные для входа в административную часть:
   1. Email: admin1@gotocinema.ru;
   2. Пароль: admin111;

## Реализованные функции:

1. Клиентская часть:
   1. Просмотр расписания и списка фильмов;
   2. Выбор и бронирование мест;
   3. Получение билета;
2. Административная часть:
   1. Создание и удаление залов;
   2. Настройка залов (установление цен, настройка мест);
   3. Добавление и удаление фильмов;
   4. Добавление и удаление сеансов;
   5. Изменение статуса зала (открыт для продажи билетов или нет);
