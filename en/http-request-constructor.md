---
layout: article
language: 'en'
version: '4.0'
category: 'http-request'
---
# HTTP Request (PSR-7)
<hr/>

## Constructor

```php
public function __construct(
    [string $method = "GET" [, mixed $uri = null [, mixed $body = "php://temp" [, array $headers = [] ]]]]
)
```
The constructor accepts parameters allowing you to create the object with certain properties populated. You can define the target HTTP method, the URL, the body as well as the headers. All parameters are optional.

### `method`
It defaults to `GET`. The supported methods are:
- `GET`     
- `CONNECT` 
- `DELETE`  
- `HEAD`    
- `OPTIONS` 
- `PATCH`   
- `POST`    
- `PUT`     
- `TRACE`  

### `uri`
An instance of `Phalcon\Http\Message\Uri` or a URL.

### `body`
It defaults to `php://memory`. The method accepts either an object that implements the `StreamInterface` or a string such as the name of the stream. The default mode for the stream is `w+b`. If a non valid stream is passed, an `\InvalidArgumentException` is thrown

### `headers`
A key value array, with key as the header name and value as the header value.

