**Проект:** Продукты и логи.

**Окружение:**

Вэб-сервер: **лююбой с поддержкой PHP**

Каркас: **Нет**

База данных: **SQLite**

Индексный файл: **index.html**

**Примечание:**

Настройки БД находятся в файле back/conf/db.ini
Настройки логирования находятся в файле back/conf/log.ini

Папки, в которых находятся файлы БД и лог,
должны быть доступны для записи пользователю вэб-сервера.

SQLite не умеет в регистронезависимое сравнение не-ASCII символов.
Поэтому БД не находит записи по вхождениям "ЛАДА" или "лада" при том,
что есть записи, содержащие "Лада".

Значение настройки driver_name из db.ini должно совпадать
с шаблоном названия файла и класса драйвера БД.

Сигнатура:
Настройка в db.ini: driver_name=NNN
Названия файла и класса драйвера БД: NNNDBDriver.php и NNNDBDriver

Для SQLite это:
Настройка в db.ini:
driver_name=SQLite

Название файла:
SQLiteDBDriver.php

Имя класса:
SQLiteDBDriver