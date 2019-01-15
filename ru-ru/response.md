* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Возврат ответов

Одной из частей работы HTTP-протокола является возвращение ответа клиенту. [Phalcon\Http\Response](api/Phalcon_Http_Response) is the Phalcon component designed to achieve this task. Чаще всего HTTP-ответ состоит из заголовков и тела ответа. Далее приведен пример базового использования:

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

Имейте в виду, что при использовании полного стека MVC нет необходимости отправлять результаты Response вручную. Однако, если есть необходимость указать ответ самостоятельно в действии контроллера, то можно использовать такой пример:

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

Заголовки являются важной частью для HTTP-ответов. Они содержат полезную информацию о статусе ответа, его типе и еще многое другое.

Указывать заголовки можно следующим образом:

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

All internal URIs are generated using the [url](/4.0/en/url) service (by default [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url)). Этот пример демонстрирует возможность перенаправления с использованием маршрута (роута), который вы задали в своем приложении:

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

Одним из самых простых способов повышения производительности приложения является снижение трафика с помощью HTTP-кэширования. Большинство современных браузеров поддерживают HTTP-кэширование и это является одной из причин, почему многие веб-сайты в настоящее время работают достаточно быстро.

Поведение HTTP-кэша может быть изменено с помощью заголовков, отправляемых при первой передаче страницы:

* **`Expires:`** Устанавливая этот заголовок в прошлое или будущее можно указывать браузеру срок жизни страницы.
* **`Cache-Control:`** Позволяет указать сколько времени страница должна считаться для браузера актуальной.
* **`Last-Modified:`** Указывает браузеру когда было последнее изменение страницы, что позволяет избежать повторной загрузки страницы.
* **`ETag:`** Представляет собой уникальный идентификатор, который должен быть сформирован с учетом времени изменения текущей страницы.

<a name='http-cache-expiration-time'></a>

### Expires

Указание срока жизни является одним из наиболее удобных и эффективных способов кэширования страниц на стороне клиента (браузера). Начиная с текущей даты мы добавляем некоторое количество времени, в течение которого страница будет храниться в кэше браузера. Это укажет браузеру сохранять страницу в кэше пока этот срок не истечет и не обращаться за ней к серверу:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

Ответ в компоненте Response автоматически преобразует дату для временной зоны GMT, именно так как ожидается в заголовке Expires.

Более того, если мы укажем прошедшую дату, то это указывает браузеру всегда обновлять запрошенную страницу:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

Браузеры основываются на системных часах клиента для определения наступления этой даты. Так как часы на клиенте могут быть изменены, то срок жизни будет некорректен. Это ограничение такого механизма кэширования.

<a name='http-cache-control'></a>

### Cache-Control

Этот заголовок осуществляет более безопасный способ кэширования. Мы просто указываем браузеру время в секундах которое необходимо хранить страницы в кэше:

```php
<?php

// Кэшировать страницу один день, начиная с текущего момента
$response->setHeader('Cache-Control', 'max-age=86400');
```

Противоположный эффект (для запрета кэширования страницы) организуется следующим образом:

```php
<?php

// Никогда не кэшировать обслуживаемую страницу
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

Заголовок `entity-tag` или кратко `E-tag` позволяет браузеру понять, была ли изменена страница между двумя запросами. Идентификатор должен рассчитываться таким образом, что бы измениться если изменено содержимое страницы:

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