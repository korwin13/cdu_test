# Комментарии
Фреймворков не предполагалось, но для маршрутизации я, все-таки, воспользовался [Klein.php](https://github.com/klein/klein.php). Мне нарвится то, что называется clean URLs (без .php файлов).
Соответственно использовался composer, в т.ч. для autoload'а(см. composer.json).

Предполагается, что сервер настроен искать index.php в корне сайта, а также что-то вроде такого в конфиге сервера(nginx vhost, для маршрутизации):
```
    # Force index.php routing (all requests)
    rewrite ^/(.*)$ /index.php?/$1 last;
```
Для дизайна восползовался bootstrap, а вся frontend-активность - jquery
Используя test.php можно проверить задание 2.3

Вся конфигурация предполагается в config.sh

Ответы на задания ниже.


# Задание
## Дано:
1) БД в PostgreSQL «users», поля: FIO, age, hobby, tm (ФИО, Возраст, Хобби, Таймстамп)
2) использовать языки: JS, php, bash, html, python 

## Задачи:

1. Используя JS/HTML/CSS/AJAX/PHP/PYTHON:

1.1 Web форма добавления новых записей с данными людей в БД
```
см. корень сайта
```
1.2 Создать таблицу users с предварительной проверкой ее существования (в соответствии с вводными данными)
```
./create_users_table.sh
```
1.3 Сделать кнопку дублирования таблицы user, имя новой таблицы user2, user3, …
```
см. корень сайта
```
2. Используя BASH/PHP/PYTHON:

2.1 Сделать еженедельный backup БД в директорию ~/backup/db:
```
crontab -e
0 0 * * 0 /scripts/dump_database.sh
```
2.2 Сделать ежедневную ротацию таблицы «users» по полю tm — время добавления записи в таблицу:
```
crontab -e
0 0 * * * /scripts/rotate_users_table.sh 1
```

2.3 Используя CURL передать содержимое таблицы user, в виде JSON, на  http://123.22.33.55:808/test.ph:
```
dump_users_json.sh | curl -H "Content-Type: application/json" -d @- http://123.22.33.55:808/test.php
```

