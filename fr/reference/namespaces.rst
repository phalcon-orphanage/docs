Working with Namespaces
=======================
Namespaces_ can be used to avoid class name collisions; this means that if you have two controllers in an application with the same name,
a namespace can be used to differentiate them. Namespaces are also useful for creating bundles or modules.

Setting up the framework
------------------------
Using namespaces has some implications when loading the appropriate controller. To adjust the framework behavior to namespaces is necessary
to perform one or all of the following tasks:

Use an autoload strategy that takes into account the namespaces, for example with Phalcon\\Loader:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        array(
           'Store\Admin\Controllers'    => "../bundles/admin/controllers/",
           'Store\Admin\Models'    => "../bundles/admin/models/",
        )
    );

Specify it in the routes as a separate parameter in the route's paths:

.. code-block:: php

    <?php

    $router->add(
        '/admin/users/my-profile',
        array(
            'namespace'  => 'Store\Admin',
            'controller' => 'Users',
            'action"     => 'profile',
        )
    );

Passing it as part of the route:

.. code-block:: php

    <?php

    $router->add(
        '/:namespace/admin/users/my-profile',
        array(
            'namespace'  => 1,
            'controller' => 'Users',
            'action'     => 'profile',
        )
    );

If you are only working with the same namespace for every controller in your application, then you can define a default namespace
in the Dispatcher, by doing this, you don't need to specify a full class name in the router path:

.. code-block:: php

    <?php

    //Registering a dispatcher
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Store\Admin\Controllers');
        return $dispatcher;
    });

Controllers with Namespaces
---------------------------
The following example shows how to implement a controller that use namespaces:

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

.. _Namespaces: http://php.net/manual/en/language.namespaces.php