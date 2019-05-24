---
layout: default
language: 'pt-br'
version: '4.0'
category: 'http-request'
---
# HTTP Request (PSR-7)

* * *

## Overview

`Phalcon\Http\Message\Request` is an implementation of the PSR-7 HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/psr/psr-7/).

![](/assets/images/implements-PSR--7-orange.svg)

Applications often need to send requests to external endpoints. To achieve this you can use the `Phalcon\Http\Message\Request` object. In return, our application will receive back a response object.

> **NOTE** Phalcon does not restrict you in using a specific HTTP Client. Any PSR-7 compliant client will work with this component so that you can perform your requests.
{: .alert .alert-info }


```php
<?php

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Uri;

$request = new Request();
$uri     = new Uri('https://api.phalconphp.com/companies/1');
$jwtToken = 'abc.def.ghi';

$request = $request
   :withMethod('POST')
   :withHeader('Authorization', 'Bearer ' , $jwtToken)
   :withHeader('Content-Type', 'application/json')
;

$result = $httpClient->send($request);
```

We are creating a new `Phalcon\Http\Message\Request` object and a new [Phalcon\Http\Message\Uri](http-uri) object with the target URL. Following that we define the method (`POST`) and additional headers that we need to send with our request. The client then sends the request by using the request object. In the above example, `$httpClient` is the client of your choice which implements PSR-7.

The above example can be implemented by only using the constructor parameters:

```php
<?php

use Phalcon\Http\Message\Request;

$jwtToken = 'abc.def.ghi';
$request  = new Request(
    'POST',
    'https://api.phalconphp.com/companies/1',
    'php://memory',
    [
        'Authorization' => 'Bearer ' , $jwtToken,
        'Content-Type'  => 'application/json',

    ]
);

$result = $httpClient->send($request);
```

The `Request` object created is immutable, meaning it will never change. Any call to methods prefixed with `with*` will return a clone of the object to maintain immutability, as per the standard.