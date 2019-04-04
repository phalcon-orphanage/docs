---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'request'
---
# HTTP Request Component

* * *

## Accessing the Request from Controllers

The most common place to access the request environment is in an action of a controller. To access the [Phalcon\Http\Request](api/Phalcon_Http_Request) object from a controller you will need to use the `$this->request` public property of the controller:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Request $request
 */
class PostsController extends Controller
{
    public function saveAction()
    {
        // Check if request has made with POST
        if (true === $this->request->isPost()) {
            // Access POST data
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born', 'string', '1984');
        }
    }
}
```