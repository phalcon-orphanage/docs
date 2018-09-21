<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Working with Namespaces</a> <ul>
        <li>
          <a href="#setting-up">フレームワークの設定</a>
        </li>
        <li>
          <a href="#controllers">コントローラでの名前空間</a>
        </li>
        <li>
          <a href="#models">モデルでの名前空間</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Working with Namespaces

[名前空間](http://php.net/manual/en/language.namespaces.php) は、クラス名の衝突を避けるために使用できます。つまり、もし同じクラス名を持つコントローラがアプリケーションに 2 つ存在する場合は、それらを区別するために名前空間を使用することができます。 名前空間はバンドルやモジュールの作成に役立ちます。

<a name='setting-up'></a>

## フレームワークの設定

名前空間を利用することは、適切なコントローラを読み込む時にいくつかの意味を持ちます。次のタスクの内、1 つまたは全てを実行するためには、名前空間に合わせてフレームワークの振る舞いを調整する必要があります。

`Phalcon\Loader` などの名前空間を考慮したオートロードを利用する場合:

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

## コントローラでの名前空間

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

## モデルでの名前空間

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