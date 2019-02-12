---
layout: article
language: 'en'
version: '4.0'
category: 'request'
---
# HTTP Request Component
<hr/>

## Preset sanitizers
It is relatively common that certain fields are using the same name throughout your application. A field posted from a form in your application can have the same name and function to another form in a different area. Examples of this behavior could be `id` fields, `name` etc.

To make the sanitization process easier, when retrieving such fields, [Phalcon\Http\Request](api/Phalcon_Http_Request) offers a method to define those sanitizing filters based on HTTP methods when setting up the object.

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterLocator;
use Phalcon\Http\Request;

$container = new Di();

$container->set(
    'request',
    function () {
        $request = new Request();
        $request
            ->setParameterFilters('id', FilterLocator::FILTER_ABSINT, ['post'])
            ->setParameterFilters('name', ['trim', 'string'], ['post'])
        ;
        
        return $request;
    }
);

```

The above will automatically sanitize any parameter that is POSTed from a form that has a name `id` or `name` with their respective filters. Sanitization takes place when calling the following methods (one per HTTP method)
- `getFilteredPost()`
- `getFilteredPut()`
- `getFilteredQuery()`

These methods accept the same parameters as the `getPost()`, `getPut()` and `getQuery()` but without the `$filter` parameter.
