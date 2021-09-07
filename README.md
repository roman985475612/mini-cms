# Mini.CMS
## Простая CMS для создания блогов и сайтов - визиток
### Установка
1. Запустить composer `composer install`
2. Замините файл `config/config.example.json` на `config/config.json`
3. Инициализируйте систему миграций базы данных `php manage.php migrate:init`
4. Запустите миграцию базы данных `php manage.php migrate`