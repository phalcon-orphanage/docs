Travailler avec les espaces de nom
==================================

Namespaces_, c'est le nom anglais des espaces de nom. Ces derniers peuvent être utilisés pour éviter le conflit des noms de classe.
Par exemple si vous avez deux controlleurs dans votre application avec le même nom, un namespace peut être utilisé pour les différencier.
Les espaces de nom sont aussi utiles pour créer des paquets ou des modules.

Mise en place
-------------
Utiliser les espaces de nom a quelques implications quand on charge le controlleur approprié.
Pour ajuster le comportement du framework aux namespaces, il est nécessaire de faire une (ou toutes)les tâches suivante:

Utiliser un autoload qui prends en compte les espaces de nom, par exemple :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        [
           "Store\\Admin\\Controllers" => "../bundles/admin/controllers/",
           "Store\\Admin\\Models"      => "../bundles/admin/models/",
        ]
    );

Vous pouvez le spécifier aux routes comme un paramètre séparé :

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

Le passer en tant que partie du chemin:

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

Si vous travaillez avec le même namespace pour tous les controlleurs de votre application, vous pouvez le définir en tant que namespace par défaut dans le dispatcher,
ainsi, vous n'avez pas besoin de spécifier le nom complet de la classe dans le chemin du routeur:

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

Controlleur avec namespace
--------------------------
L'exemple suivante montre comment implémenter un controlleur qui utilise des espaces de nom:

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

Modèles et Espaces de Nom
-------------------------
Prenez en considération ce qui suit lors de l'utilisation de modèles dans les espaces ne nom:

.. code-block:: php

    <?php

    namespace Store\Models;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {

    }

Si des modèles contiennent des relations, ils doivent inclurent aussi l'espace de nom:

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

En PHQL vous devez inclure les espaces de nom dans les instructions:

.. code-block:: php

    <?php

    $phql = "SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p";

.. _Namespaces: http://php.net/manual/fr/language.namespaces.php
