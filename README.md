# Mini.CMS
## Простая CMS для создания блогов и сайтов - визиток
### Установка
1. Замините файл `config/config.example.json` на `config/config.json`
2. Инициализируйте систему миграций базы данных `php .\Console\mini.php migrate:init`
3. Запустите миграцию базы данных `php .\Console\mini.php migrate`