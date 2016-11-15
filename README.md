# Тестовое задание

[Вакансия] (https://hh.ru/vacancy/18863043)

## Задание

Необходимо создать страницу, на которой в режиме реального времени(периодичность опроса источника 10 сек), будет выводиться текущий курс доллара по отношению к российскому рублю.

1. Источники для получения курса:

    http://www.cbr.ru/scripts/XML_daily.asp

    https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDRUB,EURRUB%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=

    предполагается, что список может быть расширен.

2. Должен быть задан порядок опроса источников.

3. В случае, если источник недоступен, необходимо переключиться на прием данных с другого источника.

Реализация на PHP с использованием методологии ООП, желательно применение фреймворка.

## Реализация

Тестовое задание реализовано на Laravel 5.3.

Курсы обновлются в бекграунде и сохраняются в кеш.

На фронтенде данные обновляются через ajax (jquery).

Для возможности расширения списка источников курсов все реализовано через
интерфейсы и всегда возможно без проблем добавить новый источник. По
сути, если наследовать его от абстрактного базового класса, то достаточно
реализовать только функцию *parse()*, все остальные функции реализованы
в базовом классе.


## Установка

Создайте папку *[folder]* и зайдите туда из консоли. Выполните следующие команды:

```bash

    composer create-project --prefer-dist laravel/laravel htdocs
    git clone https://github.com/lubyshev/azovsky.git test

```

Далее необходимо скопировать с замещением все файлы из папки *[folder]/test* в папку *[folder]/htdocs*.
Проект готов к работе.

## Запуск

Перед запуском веб-сервера необходимо запустить бекграунд-процесс, отвечающий
за обновление текущего курса.

Откройте консоль, зайдите в папку *[folder]/htdocs* и запустите комманду

```bash

    php artisan rates:get

```

**Внимание!** Через 20 минут процесс остановится, и необходимо его перезапустить!
Подробнее смотрите раздел "Настройки".

Далее необходимо запустить веб-сервер. Откройте новую консоль, и из папки
*[folder]/htdocs* и выполните

```bash

    php artisan serve

```

Теперь, если перейти в браузере по адресу [http://localhost:8000] (http://localhost:8000)
должно открыться приложение.

## Настройка

Все настройки хранятся в файле [folder]/htdocs/config/rates.php.
Некоторые настройки можно менять "на ходу".

1. CronJobTtl - как долго будет работать бекграунд процесс (в минутах).

2. CommandLoopTimeout - как часто обновлять текущий курс (в секундах).

3. sources - список источников курсов. В этих записях можно менять приоритеты (priority).
   Чем меньше приоритет, тем раньше обработается источник.
