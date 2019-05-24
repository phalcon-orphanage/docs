---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Http\Message\Request'
---

# Class **Phalcon\Http\Message\Request**

**implements** [Psr\Http\Message\RequestFactoryInterface](https://www.php-fig.org/psr/psr-17)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/message/requestfactory.zep)

This class offers a factory for creating client-side requests as per the [PSR-17](https://www.php-fig.org/psr/psr-17) specification.

## Methods

```php
string $method   // The method to create the request with
mixed  $uri      // The Uri to create the request with

public function createRequest( string $method, mixed $uri ): RequestInterface
```

Create a new request

* * *