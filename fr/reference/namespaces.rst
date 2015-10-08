Travailler avec les espaces de nom
=======================

Namespaces_, c'est le nom anglais des espaces de nom. Ces derniers peuvent être utilisés pour éviter le conflit des noms de classe.
Par exemple si vous avez deux controlleurs dans votre application avec le même nom, un namespace peut être utilisé pour les différencier.
Les espaces de nom sont aussi utiles pour créer des paquets ou des modules.

Mise en place
------------------------
Utiliser les espaces de nom a quelques implications quand on charge le controlleur approprié.
Pour ajuster le comportement du framework aux namespaces, il est nécessaire de faire une (ou toutes)les tâches suivante:

Utiliser un autoload qui prends en compte les espaces de nom, par exemple Phalcon\\Loader:

.. code-block:: php

    <?php

    $loader->registerNamespaces(
        array(
           "Store\\Admin\\Controllers" => "../bundles/admin/controllers/",
           "Store\\Admin\\Models"      => "../bundles/admin/models/"
        )
    );

Vous pouvez le spécifier aux routes comme un paramètre séparé :

.. code-block:: php

    <?php

    $router->add(
        "/admin/users/my-profile",
        array(
            "namespace"  => "Store\\Admin",
            "controller" => "Users",
            "action"     => "profile"
        )
    );

Le passer en tant que partie du chemin:

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/admin/users/my-profile",
        array(
            "namespace"  => 1,
            "controller" => "Users",
            "action"     => "profile"
        )
    );

Si vous travailler avec le même namespace pour tous les controlleurs de votre application, vous pouvez le définir en tant que namespace par défaut dans le dispatcher,
ainsi, vous n'avez pas besoin de spécifier le nom complet de la classe dans le chemin du routeur:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // Registering a dispatcher
    $di->set('dispatcher', function () {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace("Store\\Admin\\Controllers");
        return $dispatcher;
    });

Controlleur avec namespace
---------------------------
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

Models in Namespaces
--------------------
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
                array(
                    "alias" => "parts"
                )
            );
        }
    }

In PHQL you must write the statements including namespaces:

.. code-block:: php

    <?php

    $phql = 'SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p';

.. _Namespaces: http://php.net/manual/en/language.namespaces.php
