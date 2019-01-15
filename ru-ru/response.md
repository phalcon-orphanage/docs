* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Возврат ответов

Part of the HTTP cycle is returning responses to clients. [Phalcon\Http\Response](api/Phalcon_Http_Response) is the Phalcon component designed to achieve this task. HTTP responses are usually composed by headers and body. The following is an example of basic usage:

```php
<?php

use Phalcon\Http\Response;

// Получение экземпляра Response
$response = new Response();

// Установка кода статуса
$response->setStatusCode(404, 'Not Found');

// Установка содержимого ответа
$response->setContent("Сожалеем, но страница не существует");

// Отправка ответа клиенту
$response->send();
```

If you are using the full MVC stack there is no need to create responses manually. However, if you need to return a response directly from a controller's action follow this example:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class FeedController extends Controller
{
    public function getAction()
    {
        // Получение экземпляра Response
        $response = new Response();

        $feed = // ... тут данные

        // Установка содержимого ответа
        $response->setContent(
            $feed->asString()
        );

        // Возврат Response ответа
        return $response;
    }
}
```

<a name='working-with-headers'></a>

## Working with Headers

Headers are an important part of the HTTP response. It contains useful information about the response state like the HTTP status, type of response and much more.

You can set headers in the following way:

```php
<?php

// Установка по имени
$response->setHeader('Content-Type', 'application/pdf');
$response->setHeader('Content-Disposition', "attachment; filename='downloaded.pdf'");

// Установка напрямую
$response->setRawHeader('HTTP/1.1 200 OK');
```

A [Phalcon\Http\Response\Headers](api/Phalcon_Http_Response_Headers) bag internally manages headers. This class retrieves the headers before sending it to client:

```php
<?php

// Получение всех заголовков
$headers = $response->getHeaders();

// Получение заголовка по имени
$contentType = $headers->get('Content-Type');
```

<a name='redirections'></a>

## Создание перенаправлений

With [Phalcon\Http\Response](api/Phalcon_Http_Response) you can also execute HTTP redirections:

```php
<?php

// Redirect to the default URI
$response->redirect();

// Redirect to the local base URI
$response->redirect('posts/index');

// Redirect to an external URL
$response->redirect('https://en.wikipedia.org', true);

// Redirect specifying the HTTP status code
$response->redirect('https://www.example.com/new-location', true, 301);
```

All internal URIs are generated using the [url](/4.0/en/url) service (by default [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url)). This example demonstrates how you can redirect using a route you have defined in your application:

```php
<?php

// Перенаправление основаное на имени маршрута
return $response->redirect(
    [
        'for'        => 'index-lang',
        'lang'       => 'jp',
        'controller' => 'index',
    ]
);
```

Even if there is a view associated with the current action, it will not be rendered since `redirect` disables the view.

<a name='http-cache'></a>

## HTTP-кэш

One of the easiest ways to improve the performance in your applications and reduce the traffic is using HTTP Cache. Most modern browsers support HTTP caching and is one of the reasons why many websites are currently fast.

HTTP Cache can be altered in the following header values sent by the application when serving a page for the first time:

* **`Expires:`** Устанавливая этот заголовок в прошлое или будущее можно указывать браузеру срок жизни страницы.
* **`Cache-Control:`** Позволяет указать сколько времени страница должна считаться для браузера актуальной.
* **`Last-Modified:`** Указывает браузеру когда было последнее изменение страницы, что позволяет избежать повторной загрузки страницы.
* **`ETag:`** Представляет собой уникальный идентификатор, который должен быть сформирован с учетом времени изменения текущей страницы.

<a name='http-cache-expiration-time'></a>

### Expires

The expiration date is one of the easiest and most effective ways to cache a page in the client (browser). Starting from the current date we add the amount of time the page will be stored in the browser cache. Until this date expires no new content will be requested from the server:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

The Response component automatically shows the date in GMT timezone as expected in an Expires header.

If we set this value to a date in the past the browser will always refresh the requested page:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

Browsers rely on the client's clock to assess if this date has passed or not. The client clock can be modified to make pages expire and this may represent a limitation for this cache mechanism.

<a name='http-cache-control'></a>

### Cache-Control

This header provides a safer way to cache the pages served. We simply must specify a time in seconds telling the browser how long it must keep the page in its cache:

```php
<?php

// Кэшировать страницу один день, начиная с текущего момента
$response->setHeader('Cache-Control', 'max-age=86400');
```

The opposite effect (avoid page caching) is achieved in this way:

```php
<?php

// Никогда не кэшировать обслуживаемую страницу
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

An `entity-tag` or `E-tag` is a unique identifier that helps the browser realize if the page has changed or not between two requests. The identifier must be calculated taking into account that this must change if the previously served content has changed:

```php
<?php

// Формирование значения E-Tag основанное на последнем времени изменения новости
$mostRecentDate = News::maximum(
    [
        'column' => 'created_at'
    ]
);

$eTag = md5($mostRecentDate);

// Отправка E-Tag
$response->setHeader('E-Tag', $eTag);
```