Trabalhando com Namespaces
==========================

Namespaces_ pode ser usado para evitar colisões de nomes de classe; isto significa que se você tem dois controladores em uma aplicação com o mesmo nome,
um namespace pode ser usado para diferenciá-los. Os namespaces também são úteis para a criação de bundles or modules.

Configurando o framework
------------------------
Using namespaces has some implications when loading the appropriate controller. Para ajustar o comportamento da estrutura para namespaces é necessário
realizar uma ou todas as seguintes tarefas:

Use uma estratégia de carregador automático que leva em conta os espaços de nomes, por exemplo, com :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        [
           "Store\\Admin\\Controllers" => "../bundles/admin/controllers/",
           "Store\\Admin\\Models"      => "../bundles/admin/models/",
        ]
    );

Especificá-lo nas rotas como um parâmetro separado in the route's paths:

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

Passando-o como parte da rota:

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

Se você está apenas trabalhando com o mesmo namespace para cada controller em seu aplicativo, em seguida, você pode definir um namespace padrão
na Dispatcher, ao fazer isso, você não precisa especificar um nome completo da classe no caminho de router:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // Registrando um dispatcher
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

Controllers in Namespaces
-------------------------
O exemplo a seguir mostra como implementar um controller que usa namespaces:

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

Models in Namespaces
--------------------
Leve em consideração o seguinte quando utilizar models nos namespaces:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {

    }

Se os models têm relações que deve incluir o namespace também:

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

Em PHQL você deve escrever as declarações, incluindo namespaces:

.. code-block:: php

    <?php

    $phql = "SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p";

.. _Namespaces: http://php.net/manual/en/language.namespaces.php
