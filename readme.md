# Запуск локально #

```
docker-compose -f docker-compose.dev.yml up --build
```

После запуска сайт доступен по адресу:

[http://localhost:8100/](http://localhost:8100/)

---

## Административная часть ##

[http://localhost:8100/admin/?secureadmin=title](http://localhost:8100/admin/?secureadmin=title)
```
admin
title3212211
```
---

## PhpMyAdmin ##

Зайти и в базу данных `db` импортировать базу данных из папки `backup_db`.

[http://localhost:8000/](http://localhost:8000/)
```
root
root
```

---
Создать файл `src/config.php`, скопировать в него содержимое из файла `src/config-dist.php`

В файле `src/config.php` поменять:

```
// HTTP
define('HTTP_SERVER', 'https://prostoseptic.thedev.ru/');

// HTTPS
define('HTTPS_SERVER', 'https://prostoseptic.thedev.ru/');
```
на

```
// HTTP
define('HTTP_SERVER', 'http://localhost:8100/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost:8100/');
```
Проверить чтобы в `DB_USERNAME`, `DB_PASSWORD` и `DB_DATABASE` были проставлены правильные доступы:
```
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'db');
```
---
Создать файл `src/admin/config.php`, скопировать в него содержимое из файла `src/admin/config-dist.php`

В файле `src/admin/config.php` поменять:

```
// HTTP
define('HTTP_SERVER', 'https://prostoseptic.thedev.ru/admin/');
define('HTTP_CATALOG', 'https://prostoseptic.thedev.ru/');

// HTTPS
define('HTTPS_SERVER', 'https://prostoseptic.thedev.ru/admin/');
define('HTTPS_CATALOG', 'https://prostoseptic.thedev.ru/');
```
на

```
// HTTP
define('HTTP_SERVER', 'http://localhost:8100/admin/');
define('HTTP_CATALOG', 'http://localhost:8100/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost:8100/admin/');
define('HTTPS_CATALOG', 'http://localhost:8100/');
```
Проверить чтобы в `DB_USERNAME`, `DB_PASSWORD` и `DB_DATABASE` были проставлены правильные доступы:
```
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'db');
```
---

## Ошибки ##
После запуска сайта могут [http://localhost:8100/](http://localhost:8100/) могут возникнуть ошибки:
1. Не хваает папки `cache`
2. Нужно отключить ЧПУ в настройках сайта

Заходим в папку `src/system/storage` и добавляем туда папку `cache`.

После чего заходим в административную часть `Система -> Настройки` нажимаем редактировать и во вкладке `Сервер` ставим галочку `Включить ЧПУ` - `нет`.

Перезапускаем модификаторы.

---

# Загрузка на сервер #
После загрузки на сервер выполнить команды:
```
chown -R www-data:www-data /var/www/apple-market.ru
find /var/www/apple-market.ru -type d -exec chmod 755 {} \;
find /var/www/apple-market.ru -type f -exec chmod 644 {} \;
```