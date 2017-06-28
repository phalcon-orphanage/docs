使用命名空间（Working with Namespaces）
=======================================

Namespaces_ 可以用来避免类名的冲突，比如如果在一个应用中有两个控制器使用同样的名称，那么可以用namespace来区分他们。
另外命名空间在创建组件或者模块的时候也是非常有用的。

设置框架（Setting up the framework）
------------------------------------
Using namespaces has some implications when loading the appropriate controller. To adjust the framework behavior to namespaces is necessary
to perform one or all of the following tasks:

Use an autoload strategy that takes into account the namespaces, for example with :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        [
           "Store\\Admin\\Controllers" => "../bundles/admin/controllers/",
           "Store\\Admin\\Models"      => "../bundles/admin/models/",
        ]
    );

Specify it in the routes as a separate parameter in the route's paths:

.. code-block:: php

    <?php

    $router->add(
        "/admin/users/my-profile",
        [
            "namespace"  => "Store\\Admin",
            "controller" => "Users",
            "action"     => "profile",
        ]
    );

Passing it as part of the route:

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/admin/users/my-profile",
        [
            "namespace"  => 1,
            "controller" => "Users",
            "action"     => "profile",
        ]
    );

If you are only working with the same namespace for every controller in your application, then you can define a default namespace
in the Dispatcher, by doing this, you don't need to specify a full class name in the router path:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // Registering a dispatcher
    $di->set(
        "dispatcher",
        function () {
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace(
                "Store\\Admin\\Controllers"
            );

            return $dispatcher;
        }
    );

控制器加入命名空间（Controllers in Namespaces）
-----------------------------------------------
The following example shows how to implement a controller that use namespaces:

.. code-block:: php

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

模型加入命名空间（Models in Namespaces）
----------------------------------------
Take the following into consideration when using models in namespaces:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {

    }

If models have relationships they must include the namespace too:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->hasMany(
                "id",
                "Store\\Models\\Parts",
                "robots_id",
                [
                    "alias" => "parts",
                ]
            );
        }
    }

In PHQL you must write the statements including namespaces:

.. code-block:: php

    <?php

    $phql = "SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p";

.. _Namespaces: http://php.net/manual/en/language.namespaces.php
