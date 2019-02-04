---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filtro'
---
# Componente Filtro

* * *

## Combinación de limpiadores

Hay ocasiones en las que usar un solo limpiador no es suficiente para sanear los datos. Un caso muy común, por ejemplo, es el uso de los limpiadores `striptags` y `trim` para las entradas de texto. En estos casos, [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) puede recibir una matriz de nombres de limpiadores a utilizar con los datos de entrada. Por ejemplo:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$fabrica = new FilterLocatorFactory();
$localizador = $fabrica->newInstance();

// Devuelve 'Hola'
$localizador->sanitize(
    '   <h1> Hola </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

Esta cualidad también se puede utilizar con el objeto [Phalcon\Http\Request](api/Phalcon_Http_Request), cuando se utilizan los métodos `getQuery()` y `getPost()` para procesar las entradas `GET` y `POST`. Por ejemplo:

```php
<?php

use Phalcon\Filter\FilterLocator;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductosController
 * 
 * @property Request $request
 */
class ProductosController extends Controller
{
    public function guardarAction()
    {
        if (true === $this->request->isPost()) {
            $mensaje =  $this->request->getPost(
                '   <h1> Hola </h1>   ',
                [
                    'striptags',
                    'trim',
                ]
            );

        }
    }
}
```