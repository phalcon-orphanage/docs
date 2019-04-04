---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filter Component

* * *

## Combining Sanitizers

There are times where one sanitizer is not enough for your data. For instance a very common usage is the `striptags` and `trim` sanitizers for text input. The [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) component offers the ability to accept an array of names for sanitizers to be applied on the input value. The following example demonstrates this:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();

// Returns 'Hello'
$locator->sanitize(
    '   <h1> Hello </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

Note that this feature also works on the [Phalcon\Http\Request](api/Phalcon_Http_Request) object, when calling methods to retrieve data from `GET` and `POST`, namely `getQuery()` and `getPost()`.

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Request $request
 */
class ProductsController extends Controller
{
    public function saveAction()
    {
        if (true === $this->request->isPost()) {
            $message =  $this->request->getPost(
                '   <h1> Hello </h1>   ',
                [
                    'striptags',
                    'trim',
                ]
            );

        }
    }
}
```