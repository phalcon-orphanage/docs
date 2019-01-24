---
layout: article
language: 'de-de'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Antworten zurückgeben

Part of the HTTP cycle is returning responses to clients. [Phalcon\Http\Response](api/Phalcon_Http_Response) is the Phalcon component designed to achieve this task. HTTP responses are usually composed by headers and body. The following is an example of basic usage:

```php
<?php

use Phalcon\Http\Response;

// Generiert eine Antwort Instanz
$response = new Response();

// Setzt den status code
$response->setStatusCode(404, 'Not Found');

// Legt den Inhalt der Antwort fest
$response->setContent("Tut uns leid, aber die Seite existiert nicht");

// Sendet die Antwort an den Client
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
        // Generiert eine Antwort Instanz
        $response = new Response();

        $feed = // ... Hier den feed laden

        // Legt den Inhalt der Antwort fest
        $response->setContent(
            $feed->asString()
        );

        // Gibt die Antwort zurück
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

// Setzt einen header anhand des Namens
$response->setHeader('Content-Type', 'application/pdf');
$response->setHeader('Content-Disposition', "attachment; filename='downloaded.pdf'");

// Setzt einen rohen header
$response->setRawHeader('HTTP/1.1 200 OK');
```

A [Phalcon\Http\Response\Headers](api/Phalcon_Http_Response_Headers) bag internally manages headers. This class retrieves the headers before sending it to client:

```php
<?php

// Alle Header erhalten
$headers = $response->getHeaders();

// Header anhand des Namens erhalten
$contentType = $headers->get('Content-Type');
```

<a name='redirections'></a>

## Umleitungen erstellen

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

// Umleitung basierend auf einer benannten Route
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

## HTTP-Cache

One of the easiest ways to improve the performance in your applications and reduce the traffic is using HTTP Cache. Most modern browsers support HTTP caching and is one of the reasons why many websites are currently fast.

HTTP Cache can be altered in the following header values sent by the application when serving a page for the first time:

* **`Expires:`** Mit diesen Header kann die Anwendung ein Datum in der Zukunft oder die Vergangenheit festlegen, um dem Browsers mitzuteilen, wann die Seite ablaufen muss.
* **`Cache-Control:`** Dieser Header erlaubt es anzugeben, wie lange eine Seite im Browser als neu behandelt werden soll.
* **`Last-Modified:`** This header tells the browser which was the last time the site was updated avoiding page re-loads.
* **`ETag:`** An etag is a unique identifier that must be created including the modification timestamp of the current page.

<a name='http-cache-expiration-time'></a>

### Eine Ablaufzeit einstellen

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

### Cache Kontrolle

This header provides a safer way to cache the pages served. We simply must specify a time in seconds telling the browser how long it must keep the page in its cache:

```php
<?php

// Jetzt starten, die Seite für einen Tag cachen
$response->setHeader('Cache-Control', 'max-age=86400');
```

The opposite effect (avoid page caching) is achieved in this way:

```php
<?php

// Seite niemals cachen
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

An `entity-tag` or `E-tag` is a unique identifier that helps the browser realize if the page has changed or not between two requests. The identifier must be calculated taking into account that this must change if the previously served content has changed:

```php
<?php

// E-Tag anhand der Änderungszeit der letzten news berechnen
$mostRecentDate = News::maximum(
    [
        'column' => 'created_at'
    ]
);

$eTag = md5($mostRecentDate);

// Sendet einen E-Tag header
$response->setHeader('E-Tag', $eTag);
```