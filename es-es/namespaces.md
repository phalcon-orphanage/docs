---
layout: default
language: 'es-es'
version: '4.0'
title: 'Espacios de nombres'
keywords: 'espacios de nombres, clases con espacios de nombres'
---

# Espacios de nombres

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Los [Espacios de nombres](https://php.net/manual/en/language.namespaces.php) se pueden usar para evitar colisiones de nombres de clase. Esto significa que si tiene dos controladores en una aplicación con el mismo nombre, se puede usar un espacio de nombres para ayudar a PHP a entender que son dos clases diferentes. Los espacios de nombres también son útiles cuando se crean paquetes o módulos.

## Activación

Si decide usar espacios de nombres para su aplicación, necesitará instruir a su autocargador sobre dónde residen sus espacios de nombres. Esta es la forma más común de distinguir entre espacios de nombres en su aplicación. Si elige usar el componente [Phalcon\Loader](loader), entonces necesitará registrar sus espacios de nombres apropiadamente:

```php
<?php

$loader->registerNamespaces(
    [
       'MyApp\Admin\Controllers' => '/app/web/admin/controllers/',
       'MyApp\Admin\Models'      => '/app/web/admin/models/',
    ]
);
```

También puede especificar el espacio de nombres cuando define sus rutas, usando el componente [Router](routing):

```php
<?php

$router->add(
    '/admin/invoices/list',
    [
        'namespace'  => 'MyApp\Admin',
        'controller' => 'Invoices',
        'action'     => 'list',
    ]
);
```

o pasándolo como parte de la ruta como parámetro

```php
<?php

$router->add(
    '/:namespace/invoices/list',
    [
        'namespace'  => 1,
        'controller' => 'Invoices',
        'action'     => 'list',
    ]
);
```

Finalmente, si solo trabaja con el mismo espacio de nombres para todos los controladores, puede definir un espacio de nombres por defecto en su [Despachador](dispatcher). Al hacerlo, no necesitará especificar la clase completa en la ruta del enrutador:

```php
<?php

use Phalcon\Mvc\Dispatcher;

$di->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher->setDefaultNamespace(
            'MyApp\Admin\Controllers'
        );

        return $dispatcher;
    }
);
```

## Controladores

El siguiente ejemplo muestra como implementar un controlador que usa espacio de nombres:

```php
<?php

namespace MyApp\Admin\Controllers;

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction()
    {

    }
}
```

## Modelos

El siguiente ejemplo muestra un modelo con espacio de nombres:

```php
<?php

namespace MyApp\Admin\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{

}
```

Si los modelos tienen relaciones también deberán incluir el espacio de nombres:

```php
<?php

namespace MyApp\Admin\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->hasMany(
            'inv_cst_id',
            Customers::class,
            'cst_id',
            [
                'alias' => 'customers',
            ]
        );
    }
}
```

En PHQL, debe escribir la sentencia incluyendo los espacios de nombres:

```php
<?php

$phql = 'SELECT i.* '
      . 'FROM MyApp\Admin\Models\Invoices i '
      . 'JOIN MyApp\Admin\Models\Customers c';
```
