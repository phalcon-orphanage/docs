%{namespaces_410df5ec08cfd7e81928a0f39812fa26}%
=======================
%{namespaces_42fcdb4e0d8452859da49e9a5808053e}%

%{namespaces_5034b5fe11096b4eeb1043135044bc64}%
------------------------
%{namespaces_6d2109c5d5dd2e689723029517e3f6f8}%

%{namespaces_7675ee208c8bd2dc92bde0fa3f1b5d1f}%

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        array(
           'Store\Admin\Controllers'    => "../bundles/admin/controllers/",
           'Store\Admin\Models'    => "../bundles/admin/models/",
        )
    );


%{namespaces_6e2541a84721a5f09ef6f57df2158147}%

.. code-block:: php

    <?php

    $router->add(
        '/admin/users/my-profile',
        array(
            'namespace'  => 'Store\Admin',
            'controller' => 'Users',
            'action'     => 'profile',
        )
    );


%{namespaces_25a51770d16d8b9a04ca828a7e814611}%

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


%{namespaces_b4e0ae25071fd246a818cd472f38d085}%

.. code-block:: php

    <?php

    //{%namespaces_d3477be4fcfb5b2e53eb426e85a84ad1%}
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Store\Admin\Controllers');
        return $dispatcher;
    });


%{namespaces_2b7e1df011b57331144cfd6ed3f998cb}%
-------------------------
%{namespaces_80fa39b535ea176e88e04c27287bce90}%

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


%{namespaces_edc8f4356afdd63c106c2e25e75e3a4a}%
--------------------
%{namespaces_f5ea85eb2efe77db362c5d04e5f5f118}%

.. code-block:: php

    <?php

    namespace Store\Models;

    class Robots extends \Phalcon\Mvc\Model
    {

    }


%{namespaces_f272cbbd53cdcd2e714c5918e8c811ce}%

.. code-block:: php

    <?php

    namespace Store\Models;

    class Robots extends Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasMany('id', 'Store\Models\Parts', 'robots_id', array(
                'alias' => 'parts'
            ));
        }
    }


%{namespaces_1047b252842d7d62176454c6c8b8f677}%

