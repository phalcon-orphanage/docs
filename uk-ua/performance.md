---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Продуктивність'
keywords: 'performance, profiling, xdebug, xhprof, yslow, bytecode, продуктивність'
---

# Продуктивність

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Огляд

Погано написана програма завжди матиме низьку продуктивність. Найпоширеніший спосіб для розробників підвищити продуктивність своїх продуктів:

> просто забезпечити вищу потужність обладнання для нього
{: .alert .alert-info }

Проблема наведеного вище підходу має два недоліка. На початку в більшості випадків власник понесе додаткові витрати. Друга проблема полягає в тому, що настане момент, коли не можна буде більше покращити обладнання і єдиною альтернативою залишиться використання балансерів, докера, групування серверів і тощо, що тільки примножить витрати.

Але залишиться проблема - *погано написана програма*

Щоб прискорити вашу програму, потрібно переконатися в тому, що вона написана найкращим чином для виконання поставлених завдань. Ніщо не може бути кращим добре продуманого дизайну. Після цього слід братись за інші аспекти: - апаратне забезпечення сервера - маршрутизація клієнтських підключень (місце розташування, браузери) - затримки мережі - обладнання бази даних

і багато іншого. У цій статті ми спробуємо розглянути деякі сценарії, які можуть забезпечити краще розуміння того, де ваш додаток є дуже повільним.

> **ПРИМІТКА** Це **рекомендації** і хороші практики. Ви ні в якому разі не зобов'язані дотримуватися цих порад, і аж ніяк їх список не є вичерпним. Ваші стратегії підвищення продуктивності базуються насамперед на потребах вашого продукту.
{: .alert .alert-danger }

## Сервер

[Профілювання](https://en.wikipedia.org/wiki/Profiling_(computer_programming)) - це форма динамічного аналізу програм, яка пропонує метрики, що відповідають вашому продукту. Профілювання показує справжню картину того, що насправді відбувається в будь-який час у програмі, і таким чином направляйте вас до областей, де потрібна ваша увага. Профілювання має бути безперервним у виробничій програмі.

Це також створює додаткові витрати, що слід врахувати. Найбільш детальне профілювання відбувається з кожним запитом, але все це залежатиме від вашого трафіку. Ми, звичайно, не хочемо збільшувати навантаження на сервер тільки тому, що ми профілюємо додаток. Типовий спосіб профілювання - це один запит на 100 або 1 на 1000. Через деякий час буде достатньо даних для того, щоб зробити висновки щодо того, де відбувається уповільнення, чому виникли піки тощо.

### XDebug

[XDebug](https://xdebug.org/docs) пропонує дуже зручний профайлер прямо з коробки. Вам потрібно лише встановити розширення та увімкнути профілювання у вашому `php.ini`:

```ini
xdebug.profiler_enable = On
```

Використання інструменту, наприклад [Webgrind](https://github.com/jokkedk/webgrind) дозволить вам підключитись до [XDebug](https://xdebug.org/docs) і отримати дуже цінну інформацію про те, що відбувається з вашим кодом. [Webgrind](https://github.com/jokkedk/webgrind) пропонує статистику, які методи повільніші за інші, та іншу статистику.

### Xhprof

[Xhprof](https://github.com/facebook/xhprof) -- інше розширення для PHP додатків. Щоб увімкнути його, вам потрібно додати наступний рядок на початок файлу bootstrap:

```php
<?php

xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
```

Потім в кінці цього ж файлу збережіть профільовані дані:

```php
<?php

$xhprof_data = xhprof_disable('/tmp');

$XHPROF_ROOT = '/var/www/xhprof/';
include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';

$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, 'xhprof_testing');

echo "https://localhost/xhprof/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";
```

Xhprof пропонує вбудований HTML оглядач для аналізу профільованих даних:

![](/assets/images/content/performance-xhprof-2.jpg)

![](/assets/images/content/performance-xhprof-1.jpg)

Як зазначено вище, профілювання може збільшити навантаження на ваш сервер. У випадку використання [Xhprof](https://github.com/facebook/xhprof)ви можете встановити умову, що запуск профілювання буде здійснюватись лише після X запитів.

### SQL-інструкції

Almost all RDBMs offer tools to identify slow SQL statements. Identifying and fixing slow queries is very important in terms of performance on the server side. MariaDB / MySql / AuroraDb offer configuration settings that enable a `slow-query` log. The database then keeps its own metrics and whenever a query takes long to complete it will be logged in the `slow-query` log. The log can then be analyzed by the development team and adjustments can be made.

To enable this feature you will need to add this to `my.cnf` (don't forget to restart your database server)

```ini
log-slow-queries = /var/log/slow-queries.log
long_query_time = 1.5
```

## Client

Another area to focus on is the client. Improving the loading of assets such as images, stylesheets, javascript files can significantly improve performance and enhance user experience. There are a number of tools that can help with identifying bottlenecks on the client:

### Browsers

Most modern browsers have tools to profile a page's loading time. Those are easily called *web inspectors* or *developer tools*. For instance when using Brave or any Chromium based browser you can inspect the page and the developer tools will show a waterfall of what has loaded for the current page (files), how much time it took and the total loading time:

![](/assets/images/content/performance-chrome-1.jpg)

A relatively easy fix for increasing client performance is to set the correct headers for assets so that they expire in the future vs. being loaded from the server on every request. Additionally, [CDN](https://en.wikipedia.org/wiki/Content_delivery_network) providers can help with distributing assets from their distribution centers that are closest to the client originating the request.

### Yahoo! YSlow

[YSlow](https://developer.yahoo.com/yslow) analyzes web pages and suggests ways to improve their performance based on a set of [rules for high performance web pages](https://developer.yahoo.com/performance/rules.html)

![](/assets/images/content/performance-yslow-1.jpg)

## PHP

PHP is becoming faster with every new version. Using the latest version improves the performance of your applications and also of Phalcon.

### Bytecode Cache

[OPcache](https://php.net/manual/en/book.opcache.php) as many other bytecode caches helps applications reduce the overhead of read, tokenize and parse PHP files in each request. The interpreted results are kept in RAM between requests as long as PHP runs as fcgi (fpm) or mod_php. OPcache is bundled with php starting 5.5.0. To check if it is activated, look for the following entry in php.ini:

```ini
opcache.enable = On
opcache.memory_consumption = 128    ;default
```

Furthermore, the amount of memory available for opcode caching needs to be enough to hold all files of your applications. The default of 128MB is usually enough for even larger codebases.

### Serverside cache

[APCu](https://php.net/manual/en/book.apcu.php) can be used to cache the results of computational expensive operations or otherwise slow data sources like webservices with high latency. What makes a result cacheable is another topic, as a rule of thumb: the operations needs to be executed often and yield identical results. Make sure to measure through profiling that the optimizations actually improved execution time.

```ini
apc.enabled = On
apc.shm_size = 32M  ;default
```

As with the aforementioned opcache, make sure, the amount of RAM available suits your application. Alternatives to APCu would be [Redis](https://redis.io/) or [Memcached](https://memcached.org/) - although they need extra processes running on your server or another machine.

## Slow Tasks

Based on the requirements of your application, there maybe times that you will need to perform long running tasks. Examples of such tasks could be processing a video, optimizing images, sending emails, generating PDF documents etc. These tasks should be processed using background jobs. The usual process is: - The application initiates a task by sending a message to a queue service - The user sees a message that the task has been scheduled - In the background (or different server), worker scripts peek at the queue - When a message arrives, the worker script detects the type of message and calls the relevant task script - Once the task finishes, the user is notified that their data is ready.

The above is a simplistic view of how a queue service for background processing works, but can offer ideas on how background tasks can be executed. There are also a variety of queue services available that you can leverage using the relevant PHP libraries:

* [NATS](https://nats.io)
* [RabbitMQ](https://www.rabbitmq.com/)
* [Redis](https://redis.io/)
* [Resque](https://github.com/chrisboulton/php-resque)
* [SQS](https://aws.amazon.com/sqs/)
* [ZeroMQ](https://www.zeromq.org/)

## Page Speed

[mod_pagespeed](https://www.modpagespeed.com/) speeds up your site and reduces page load time. This open-source Apache HTTP server module (also available for nginx) automatically applies web performance best practices to pages, and associated assets (CSS, JavaScript, images) without requiring you to modify your existing content or workflow.