---
layout: default
language: 'uk-ua'
version: '5.0'
title: 'Продуктивність'
keywords: 'performance, profiling, xdebug, xhprof, yslow, bytecode, продуктивність'
---

# Продуктивність
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Огляд
Погано написана програма завжди матиме низьку продуктивність. Найпоширеніший спосіб для розробників підвищити продуктивність своїх продуктів:

> just throw more hardware to it 
> 
> {: .alert .alert-info }

Проблема наведеного вище підходу має два недоліка. На початку в більшості випадків власник понесе додаткові витрати. The second issue is that there comes a time that one can no longer upgrade the hardware and will have to resort to load balancers, docker swarms etc. which will skyrocket costs.

The problem will remain: _the poorly written application_

Щоб прискорити вашу програму, потрібно переконатися в тому, що вона написана найкращим чином для виконання поставлених завдань. Ніщо не може бути кращим добре продуманого дизайну. After that, there are many aspects to consider:
- server hardware
- clients connecting (location, browsers)
- network latency
- database hardware

і багато іншого. У цій статті ми спробуємо розглянути деякі сценарії, які можуть забезпечити краще розуміння того, де ваш додаток є дуже повільним.

> **NOTE** These are **recommendations** and good practices. Ви ні в якому разі не зобов'язані дотримуватися цих порад, і аж ніяк їх список не є вичерпним. Ваші стратегії підвищення продуктивності базуються насамперед на потребах вашого продукту. 
> 
> {: .alert .alert-danger }

## Server
[Profiling][profiling] is a form of dynamic application analysis that offers metrics regarding your application. Профілювання показує справжню картину того, що насправді відбувається в будь-який час у програмі, і таким чином направляйте вас до областей, де потрібна ваша увага. Профілювання має бути безперервним у виробничій програмі.

Це також створює додаткові витрати, що слід врахувати. Найбільш детальне профілювання відбувається з кожним запитом, але все це залежатиме від вашого трафіку. Ми, звичайно, не хочемо збільшувати навантаження на сервер тільки тому, що ми профілюємо додаток. Типовий спосіб профілювання - це один запит на 100 або 1 на 1000. Через деякий час буде достатньо даних для того, щоб зробити висновки щодо того, де відбувається уповільнення, чому виникли піки тощо.

### XDebug
[XDebug][xdebug] offers a very handy profiler right out of the box. Вам потрібно лише встановити розширення та увімкнути профілювання у вашому `php.ini`:

```ini
xdebug.profiler_enable = On
```

Using a tool such as [Webgrind][webgrind] will allow you to connect to [XDebug][xdebug] and get very valuable information as to what is going on with your code. [Webgrind][webgrind] offers statistics on which methods are slower than others and other statistics.

### Xhprof
[Xhprof][xhprof] is another extension to profile PHP applications. Щоб увімкнути його, вам потрібно додати наступний рядок на початок файлу bootstrap:

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

Як зазначено вище, профілювання може збільшити навантаження на ваш сервер. In the case of [Xhprof][xhprof], you can introduce a conditional that would start profiling only after X requests.

### SQL-інструкції
Майже всі RDBM пропонують інструменти для визначення повільних SQL-команд. Визначення та виправлення повільних запитів дуже важливо з точки зору продуктивності на стороні сервера. MariaDB / MySql / AuroraDb пропонують налаштування, що дозволяють вести журнал `slow-query`. Після цього база даних зберігає власні метрики, і коли запиту буде потрібно більше часу для завершення, запис про нього буде зроблено в `slow-query` журналі. Цей журнал може бути проаналізовано командою розробників, щоб зробити відповідні правки у коді.

Щоб увімкнути цю функцію, вам потрібно буде додати це до `my.cnf` (не забудьте перезапустити ваш сервер бази даних)

```ini
log-slow-queries = /var/log/slow-queries.log
long_query_time = 1.5
```

## Client
Іншою зоною, що потребує уваги розробника є клієнт. Поліпшення завантаження активів, таких як зображення, таблиці стилів, файли javascript, може значно підвищити продуктивність та покращити користувацький досвід. Є ряд інструментів, які можуть допомогти з ідентифікацією вузьких місць на стороні клієнта:

### Браузери
Більшість сучасних браузерів мають інструменти для обліку часу завантаження сторінки. Those are easily called _web inspectors_ or _developer tools_. Наприклад, при використанні будь-якого браузера на базі Chromium чи Brave, ви можете проінспектувати сторінку, а інструменти розробника покажуть купу всього, що завантажилось для поточної сторінки (файли), скільки часу пройшло і загальний час завантаження:

![](/assets/images/content/performance-chrome-1.jpg)

A relatively easy fix for increasing client performance is to set the correct headers for assets so that they expire in the future vs. being loaded from the server on every request. Additionally, [CDN][cdn] providers can help with distributing assets from their distribution centers that are closest to the client originating the request.

### Yahoo! YSlow
[YSlow][yslow] analyzes web pages and suggests ways to improve their performance based on a set of [rules for high performance web pages][yslow_rules]

![](/assets/images/content/performance-yslow-1.jpg)

## PHP
PHP стає швидшим з кожною новою версією. Використання останньої версії покращує продуктивність ваших продуктів, а також Phalcon.

### Байт-код кеш
[OPcache][opcache] as many other bytecode caches helps applications reduce the overhead of read, tokenize and parse PHP files in each request. Результати інтерпретації зберігаються в оперативній пам'яті між запитами до тих пір, поки PHP запускається як fcgi (fpm) або mod_php. OPcache is bundled with php starting 5.5.0. To check if it is activated, look for the following entry in php.ini:

```ini
opcache.enable = On
opcache.memory_consumption = 128    ;default
```
Разом з тим, кількість доступної пам'яті для кешування opcode має бути достатньою для зберігання всіх файлів вашого продукту. Значення за замовчуванням 128 МБ зазвичай достатньє для навіть великих кодових баз.

### Сервісний кеш
[APCu][apcu] can be used to cache the results of computational expensive operations or otherwise slow data sources like webservices with high latency. Інше питання, як визначити чи потрібно кешувати результат, - для цього є практичне правило: якщо відповідні операції мають часто виконуватись, а їх результат ідентичний. Переконайтеся за допомогою профілювання (інспектування), що така оптимізація фактично покращила час виконання запиту.

```ini
apc.enabled = On
apc.shm_size = 32M  ;default
```

Як і з вищезгаданим opcache, переконайтеся, що кількість оперативної пам'яті достатня для вашого продукту. Alternatives to APCu would be [Redis][redis] or [Memcached][memcached] - although they need extra processes running on your server or another machine.


## Повільні завдання
Виходячи з потреб вашого продукту, може бути час, коли необхідно буде виконувати окремі завдання протягом тривалого часу. Прикладами таких завдань можуть бути: обробка відео, оптимізація зображень, надсилання електронних листів, генерування PDF-документів тощо. Ці завдання повинні бути виконані за допомогою фонових завдань. The usual process is:
- The application initiates a task by sending a message to a queue service
- The user sees a message that the task has been scheduled
- In the background (or different server), worker scripts peek at the queue
- When a message arrives, the worker script detects the type of message and calls the relevant task script
- Once the task finishes, the user is notified that their data is ready.

Це спрощене уявлення про те, як працює черга фонових процесів, але можна запропонувати і кращі ідеї про те, як мають бути виконані фонові завдання. Також є безліч сервісів черг, які можна використовувати за допомогою відповідних бібліотек PHP:

* [NATS][nats]
* [RabbitMQ][rabbitmq]
* [Redis][redis]
* [Resque][resque]
* [SQS][sqs]
* [ZeroMQ][zeromq]

## Швидкість сторінки
[mod_pagespeed][mod_pagespeed] speeds up your site and reduces page load time. Цей модуль Apache HTTP-сервера з відкритим вихідним кодом (також доступний для nginx) автоматично застосовує кращі практики веб продуктивності до сторінок і пов'язаних з ними ресурсами (CSS, JavaScript, зображення), не вимагаючи від вас змінити існуючий контент або робочий процес.

[apcu]: https://php.net/manual/en/book.apcu.php
[cdn]: https://en.wikipedia.org/wiki/Content_delivery_network
[memcached]: https://memcached.org/
[mod_pagespeed]: https://www.modpagespeed.com/
[nats]: https://nats.io
[opcache]: https://php.net/manual/en/book.opcache.php
[profiling]: https://en.wikipedia.org/wiki/Profiling_(computer_programming)
[rabbitmq]: https://www.rabbitmq.com/
[redis]: https://redis.io/
[resque]: https://github.com/chrisboulton/php-resque
[sqs]: https://aws.amazon.com/sqs/
[yslow]: http://yslow.org/
[yslow_rules]: https://developer.yahoo.com/performance/rules.html
[xdebug]: https://xdebug.org/docs
[xhprof]: https://github.com/facebook/xhprof
[webgrind]: https://github.com/jokkedk/webgrind
[zeromq]: https://www.zeromq.org/
