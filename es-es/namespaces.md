* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Trabajando con Espacios de Nombres

[Namespaces](https://php.net/manual/en/language.namespaces.php) can be used to avoid class name collisions; this means that if you have two controllers in an application with the same name, a namespace can be used to differentiate them. Los espacios de nombres también son útiles para crear paquetes o módulos.

<a name='setting-up'></a>

## Configurando el framework

Utilizar espacios de nombres tiene algunas implicaciones cuando se carga el controlador adecuado. Para ajustar el comportamiento del framework a los espacios de nombres es necesario realizar una o todas de las siguientes tareas:

Use an autoload strategy that takes into account the namespaces, for example with [Phalcon\Loader](api/Phalcon_Loader):

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

If you are only working with the same namespace for every controller in your application, then you can define a default namespace in the [Dispatcher](/4.0/en/dispatcher), by doing this, you don't need to specify a full class name in the router path:

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

<a name='controllers'></a>

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

<a name='models'></a>

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