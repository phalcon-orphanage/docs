---
layout: default
language: 'es-es'
version: '4.0'
---
# Espacios de nombres

* * *

## Trabajando con Espacios de Nombres

Los [Espacios de Nombres](https://php.net/manual/en/language.namespaces.php) se pueden utilizar para evitar colisiones de nombres de clase; esto significa que si tienes dos controladores en una aplicación con el mismo nombre, se puede utilizar un espacio de nombres para diferenciarlos. Los espacios de nombres también son útiles para crear paquetes o módulos.

## Configurando el framework

El uso de espacios de nombres tiene algunas implicaciones al cargar el controlador apropiado. Para ajustar el comportamiento del framework a espacios de nombres, es necesario realizar una o todas las siguientes tareas:

Usar una estrategia de autocarga que tome en cuenta los espacios de nombres, por ejemplo utilizando [Phalcon\Loader](api/Phalcon_Loader):

```php
<?php

$loader->registerNamespaces(
    [
       'Store\Admin\Controllers' => '../bundles/admin/controllers/',
       'Store\Admin\Models'      => '../bundles/admin/models/',
    ]
);
```

Especifíquelo en las rutas como un parámetro separado en las rutas de la ruta:

```php
<?php

$router->add(
    '/admin/users/my-profile',
    [
        'namespace'  => 'Store\Admin',
        'controller' => 'Users',
        'action'     => 'profile',
    ]
);
```

Pasandolo como parte de la ruta:

```php
<?php

$router->add(
    '/:namespace/admin/users/my-profile',
    [
        'namespace'  => 1,
        'controller' => 'Users',
        'action'     => 'profile',
    ]
);
```

Si sólo está trabajando con el mismo espacio de nombres para cada controlador de la aplicación, entonces se puede definir un espacio de nombres predeterminado en el [despachador](dispatcher), haciendo esto, no necesita especificar un nombre de clase completo en la ruta del router:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// Registrando un despachador
$di->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher->setDefaultNamespace(
            'Store\Admin\Controllers'
        );

        return $dispatcher;
    }
);
```

## Controladores en espacios de nombres

En el ejemplo siguiente se muestra cómo implementar un controlador que utiliza espacios de nombres:

```php
<?php

namespace Store\Admin\Controllers;

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function profileAction()
    {

    }
}
```

## Modelos en Espacios de Nombres

Tener en cuenta lo siguiente al utilizar modelos en los espacios de nombres:

```php
<?php

namespace Store\Models;

use Phalcon\Mvc\Model;

class Robots extends Model
{

}
```

Si los modelos tienen relaciones también debe incluir el espacio de nombres:

```php
<?php

namespace Store\Models;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->hasMany(
            'id',
            'Store\Models\Parts',
            'robots_id',
            [
                'alias' => 'parts',
            ]
        );
    }
}
```

En PHQL también debe escribir las declaraciones incluyendo los espacios de nombres:

```php
<?php

$phql = 'SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p';
```