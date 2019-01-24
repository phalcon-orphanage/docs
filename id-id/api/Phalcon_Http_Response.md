---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\Response'
---
# Class **Phalcon\Http\Response**

*implements* [Phalcon\Http\ResponseInterface](Phalcon_Http_ResponseInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response.zep)

Part of the HTTP cycle is return responses to the clients. Phalcon\HTTP\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.

```php
<?php

$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();

```

## Metode

publik **__construct** ([*mixed* $content], [*mixed* $code], [*mixed* $status])

Phalcon\Http\Response constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

publik **setStatusCode** (*mixed* $code, [*mixed* $message])

Menyetel kode respon HTTP

```php
<?php

$response->setStatusCode(404, "Not Found");

```

publik **getStatusCode** ()

Mengembalikan status kode

```php
<?php

print_r(
    $response->getStatusCode()
);

```

public **setHeaders** ([Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface) $headers)

Menetapkan tas header untuk respon eksternal

public **getHeaders** ()

Mengembalikan headers yang ditetapkan oleh pengguna

public **getReasonPhrase** (): *string* | *null*

Returns the reason phrase from the response status

```php
<?php

echo $response->getReasonPhrase();
```

public **setCookies** ([Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface) $cookies)

Menetapkan tas header untuk respon eksternal

public [Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface) **getCookies** ()

Mengembalikan cookie yang ditetapkan oleh pengguna

publik **setHeader** (*mixed* $name, *mixed* $value)

Menimpa header dalam respon

```php
<?php

$response->setHeader("Content-Type", "text/plain");

```

publik **setRawHeader** (*mixed* $header)

Kirim header baku ke respon

```php
<?php

$response->setRawHeader("HTTP/1.1 404 Not Found");

```

publik **resetHeaders** ()

Menyetel ulang semua tajuk yang ditetapkan

public **setExpires** ([DateTime](https://php.net/manual/en/class.datetime.php) $datetime)

Menetapkan header Expires dalam respon yang memungkinkan untuk menggunakan cache HTTP

```php
<?php

$this->response->setExpires(
    new DateTime()
);

```

public **setLastModified** ([DateTime](https://php.net/manual/en/class.datetime.php) $datetime)

Sets Last-Modified header

```php
<?php

$this->response->setLastModified(
    new DateTime()
);

```

publik **setCache** (*mixed* $minutes)

Menetapkan header Cache untuk menggunakan cache HTTP

```php
<?php

$this->response->setCache(60);

```

publik **setNotModified** ()

Mengirimkan respons Tidak Modifikasi

publik **setContentType** (*mixed* $contentType, [*mixed* $charset])

Mengatur jenis konten respons mime, opsional charset

```php
<?php

$response->setContentType("application/pdf");
$response->setContentType("text/plain", "UTF-8");

```

publik **setContentLength** (*mixed* $contentLength)

Menetapkan respons konten-panjang

```php
<?php

$response->setContentLength(2048);

```

publik **setEtag** (*mixed* $etag)

Tetapkan ETag kustom

```php
<?php

$response->setEtag(md5(time()));

```

publik **redirect** ([*mixed* $location], [*mixed* $externalRedirect], [*mixed* $statusCode])

Redirect oleh HTTP ke tindakan atau URL lain

```php
<?php

// Using a string redirect (internal/external)
$response->redirect("posts/index");
$response->redirect("https://en.wikipedia.org", true);
$response->redirect("https://www.example.com/new-location", true, 301);

// Making a redirection based on a named route
$response->redirect(
    [
        "for"        => "index-lang",
        "lang"       => "jp",
        "controller" => "index",
    ]
);

```

publik **setContent** (*mixed* $content)

Mengatur HTTP response body

```php
<?php

$response->setContent("<h1>Hello!</h1>");

```

public **setJsonContent** (*mixed* $content, [*mixed* $jsonOptions], [*mixed* $depth])

Sets HTTP response body. The parameter is automatically converted to JSON and also sets default header: Content-Type: "application/json; charset=UTF-8"

```php
<?php

$response->setJsonContent(
    [
        "status" => "OK",
    ]
);

```

public **appendContent** (*mixed* $content)

Tambahkan string ke badan respons HTTP

public ** getContent </ 0> ()</p> 

Mendapatkan respon HTTP tubuh

public **isSent** ()

Periksa apakah respon sudah terkirim

public **sendHeaders** ()

Mengirimkan header ke klien

public **sendCookies** ()

Mengirimkan cookies ke klien

publik **kirim** ()

Mencetak respons HTTP ke klien

public **setFileToSend** (*mixed* $filePath, [*mixed* $attachmentName], [*mixed* $attachment])

Menetapkan file terlampir untuk dikirim pada akhir permintaan