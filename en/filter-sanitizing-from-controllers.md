---
layout: article
language: 'en'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filter Component
<hr/>

## Sanitizing from Controllers
You can access the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) object from your controllers when accessing `GET` or `POST` input data (through the request object). The first parameter is the name of the variable to be obtained; the second is the sanitizer to be applied on it. The second parameter can also be an array with any number of sanitizers that you want to apply. 

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
            // Sanitizing price from input
            $price = $this->request->getPost('price', 'double');

            // Sanitizing email from input
            $email = $this->request->getPost('customerEmail', FilterLocator::FILTER_EMAIL);
        }
    }
}
```
