使用命名空间
=======================
Namespaces_ 可以用来避免类名冲突，这意味着，如果你有两个控制器，在应用程序中使用相同的名称，
可以使用命名空间来区分他们。命名空间是也可用于创建module。

Setting up the framework
------------------------
使用命名空间时对加载相应控制器会有一定的影响。需要调整框架命名空间的行为，可以实现加载一个或全部：

使用自动加载的方式需要考虑命名空间的影响，以下是使用 Phalcon\\Loader 的示例：

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        array(
           'Store\Admin\Controllers'    => "../bundles/admin/controllers/",
           'Store\Admin\Models'    => "../bundles/admin/models/",
        )
    );

在定义路由时，控制器的路径可以指定控制器的全名称：

.. code-block:: php

    <?php

    $router->add(
        "/admin/users/my-profile",
        array(
            "controller" => "Store\Admin\Users",
            "action"     => "profile",
        )
    );

把命名空间当作路由定义的参数(详见路由器章节)：

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/admin/users/my-profile",
        array(
            "namespace"  => 1,
            "controller" => "Users",
            "action"     => "profile",
        )
    );

如果你只在你的应用程序中对每个控制器使用相同的命名空间，那么你可以在注册分发器时定义一个默认的命名空间，这样做的话，你就不再需要在定义路由的时候指定完整的类名称了：

.. code-block:: php

    <?php

    //Registering a dispatcher
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Store\Admin\Controllers\\');
        return $dispatcher;
    });

Controllers with Namespaces
---------------------------
下面的示例演示如何实现使用命名空间来编写一个控制器：

.. code-block:: php

    <?php

    namespace Store\Admin\Controllers;

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function profileAction()
        {

        }

    }

Models in Namespaces
--------------------
对于模型，使用getSource来指定关联的数据表是非常必要的：

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "robots";
        }

    }

另外，因为命名空间的原因，一些魔术方法不能如预期般运行，你可以按如下方式手工定义正确的行为：

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "robots";
        }

        public function initialize()
        {
            $this->hasMany("id", 'Store\Toys\RobotsParts', 'robots_id');
        }

        public function getRobotsParts($arguments=null)
        {
            return $this->getRelated('Store\Toys\RobotsParts', $arguments);
        }

    }

.. _Namespaces: http://php.net/manual/en/language.namespaces.php