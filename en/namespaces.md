<div class='article-menu' markdown='1'>

- [Working with Namespaces](#overview)
    - [Setting up the framework](#setting-up)
    - [Controllers in Namespaces](#controllers)
    - [Models in Namespaces](#models)

</div>

<a name='overview'></a>
# Working with Namespaces
[Namespaces](http://php.net/manual/en/language.namespaces.php) can be used to avoid class name collisions; this means that if you have two controllers in an application with the same name, a namespace can be used to differentiate them. Namespaces are also useful for creating bundles or modules.

<a name='setting-up'></a>
## Setting up the framework
Using namespaces has some implications when loading the appropriate controller. To adjust the framework behavior to namespaces is necessary to perform one or all of the following tasks:

Use an autoload strategy that takes into account the namespaces, for example with `Phalcon\Loader`:

```php
<?php

$loader->registerNamespaces(
    [
       'Store\Admin\Controllers' => '../bundles/admin/controllers/',
       'Store\Admin\Models'      => '../bundles/admin/models/',
    ]
);
```

Specify it in the routes as a separate parameter in the route's paths:
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

Passing it as part of the route:

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

If you are only working with the same namespace for every controller in your application, then you can define a default namespace in the [Dispatcher](/[[language]]/[[version]]/dispatcher), by doing this, you don't need to specify a full class name in the router path:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// Registering a dispatcher
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
## Controllers in Namespaces
The following example shows how to implement a controller that use namespaces:

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
## Models in Namespaces
Take the following into consideration when using models in namespaces:

```php
<?php

namespace Store\Models;

use Phalcon\Mvc\Model;

class Robots extends Model
{

}
```

If models have relationships they must include the namespace too:

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

In PHQL you must write the statements including namespaces:

```php
<?php

$phql = 'SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p';
```
