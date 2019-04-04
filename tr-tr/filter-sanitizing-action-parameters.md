---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filter Component

* * *

## Sanitizing Action Parameters

If you have used the [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) as your DI container, the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) is already registered for you with the default sanitizers. To access it we can use the name `filter`. If you do not use the [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) container, you will need to set the service up in it, so that it can be accessible in your controllers.

We can sanitize values passed into controller actions as follows:

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property FilterLocator $filter
 */
class ProductsController extends Controller
{
    public function showAction($productId)
    {
        $productId = $this->filter->sanitize($productId, 'absint');
    }
}
```