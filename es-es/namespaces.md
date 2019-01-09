* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Trabajando con Espacios de Nombres

Los [Espacios de Nombres](http://php.net/manual/en/language.namespaces.php) se pueden utilizar para evitar colisiones de nombres de clase; esto significa que si tienes dos controladores en una aplicación con el mismo nombre, se puede utilizar un espacio de nombres para diferenciarlos. Los espacios de nombres también son útiles para crear paquetes o módulos.

<a name='setting-up'></a>

## Configurando el framework

Using namespaces has some implications when loading the appropriate controller. To adjust the framework behavior to namespaces is necessary to perform one or all of the following tasks:

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

If you are only working with the same namespace for every controller in your application, then you can define a default namespace in the [Dispatcher](/3.4/en/dispatcher), by doing this, you don't need to specify a full class name in the router path:

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

## Modelos en espacios de nombres

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