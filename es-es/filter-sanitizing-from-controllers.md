---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Componente Filtro

* * *

## Limpieza en controladores

Los controladores pueden emplear el objeto [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) con los datos de usuario que llegan mediante `GET` o `POST` (a través del objeto de petición). El primer parámetro es el nombre de la variable que se desea obtener; el segundo es el filtro que se desea aplicar. El segundo parámetro también puede ser una matriz con todos los limpiadores a utilizar.

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
            // Limpiar el precio
            $precio = $this->request->getPost('precio', 'double');

            // Limpiar la dirección de correo electrónico
            $emilio = $this->request->getPost('emilioUsuario', FilterLocator::FILTER_EMAIL);
        }
    }
}
```