Utilisation de Contrôleurs
==========================

Les contrôleurs fournissent un certain nombre de méthodes qui sont appelées actions. Les actions sont des méthodes du contrôleur qui traitent les requêtes.
Par défaut toutes les méthodes publiques d'un contrôleur sont reliées à des actions et sont accessibles par URL. Les actions sont responsables
de l'interprétation de la requête et de la création de la réponse. Habituellement les réponses sont sous la forme de vues mais il existe d'autres façons de créer des réponses adaptées.

Par exemple, en accédant à une URL comme ceci: http://localhost/blog/posts/show/2015/the-post-title Phalcon par défaut décomposera chaque 
partie comme ceci:

+------------------------+----------------+
| **Répertoire Phalcon** | blog           |
+------------------------+----------------+
| **Contrôleur**         | posts          |
+------------------------+----------------+
| **Action**             | show           |
+------------------------+----------------+
| **Paramètre**          | 2015           |
+------------------------+----------------+
| **Paramètre**          | the-post-title |
+------------------------+----------------+

Dans ce cas, le contrôleur "PostsController" gèrera cette requête. Il n'y a pas d'emplacement particulier pour placer les contrôleurs dans une application,
ils seraient chargés grâçe à un :doc:`chargeur automatique <loader>`, et donc vous restez libre d'organiser vos contrôleurs selon vos besoins.

Les contrôleurs doivent posséder le suffixe "Controller", et les actions le suffixe "Action". Un exemple de contrôleur se trouve ci-après:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {

        }
    }

Les paramètres supplémentaires de l'URI sont définis comme des paramètres de l'action, ainsi ils restent facilement accessibles en utilisant des variables locales.
Un contrôleur peut éventuellement étendre :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`. En faisant ceci, le contrôleur accède
facilement aux services de l'application.

Les paramètres sans valeur par défaut sont correctement gérés. La définition de paramètres optionels se fait comme d'habitude en PHP:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year = 2015, $postTitle = "some default title")
        {

        }
    }

Les paramètres sont assignés dans le même ordre qu'ils sont transmis dans la route. Vous pouvez récupérer arbitrairement des paramètres de la façon suivante:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction()
        {
            $year      = $this->dispatcher->getParam("year");
            $postTitle = $this->dispatcher->getParam("postTitle");
        }
    }

Boucle de répartition (dispatch)
--------------------------------
La boucle de répartition sera exécutée dans le "Dispatcher" tant qu'il reste des actions à exécuter. Dans l'exemple précédent, seule une
action était exécutée. Voyons maintenant comment la méthode :code:`forward()` peut fournir un flot plus complexe d'opération à la boucle de répartition en faisant
suivre le fil d'exécution à un autre contrôleur ou une autre action.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {
            $this->flash->error(
				"Vous n'avez pas la permission d'accéder à cette zone"
			);

            // Redirection du flux à une autre action
            $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "signin",
                ]
            );
        }
    }

Si les utilisateurs n'ont pas la permission d'accéder à une certaine action, ils seront redirigés vers le contrôleur "Users", action "signin".

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function indexAction()
        {

        }

        public function signinAction()
        {

        }
    }

Votre application n'est pas limitée en nombre de "forward", tant qu'il n'y a pas de références circulaires, sinon votre application sera arrêtée.
S'il ne reste plus d'action à répartir dans la boucle, le répartiteur invoquera automatiquement la couche vue du MVC qui est gérée par
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`.

Initialisation des contrôleurs
------------------------------
:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` propose une méthode d'initialisation qui est exécutée en premier avant n'importe quelle
action du contôleur. L'utilisation de la méthode "__construct" est à proscrire.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public $settings;

        public function initialize()
        {
            $this->settings = [
                "mySetting" => "value",
            ];
        }

        public function saveAction()
        {
            if ($this->settings["mySetting"] === "value") {
                // ...
            }
        }
    }

.. highlights::

    La méthode "initialize" n'est appelée que si l'événement "beforeExecuteRoute" est exécuté avec succès.
    Ceci évite l'éxecution de l'initialiseur sans autorisation.

Si vous souhaitez procéder à une initialisation juste après la construction du contrôleur, vous pouvez définir
la méthode "onConstruct":

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function onConstruct()
        {
            // ...
        }
    }

.. highlights::

    Soyez attentifs au fait que la méthode :code:`onConstruct()` sera exécutée même si aucune action n'existe
    dans le contrôleur, ou bien que l'utilisateur n'y ait pas accès (selon le contrôle d'accès fournit
    par le développeur).

Injection de services
---------------------
Si un contrôleur étend :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` il a alors facilement accès au conteneur
de service de l'application. Si vous avez par exemple inscrit un service comme celui-ci:

.. code-block:: php

    <?php

    use Phalcon\Di;

    $di = new Di();

    $di->set(
        "storage",
        function () {
            return new Storage(
                "/un/repertoire"
            );
        },
        true
    );

Nous pouvons alors accéder à ce service de plusieurs façons:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class FilesController extends Controller
    {
        public function saveAction()
        {
            // Injection de service en accédant seulement à la propriété du même nom
            $this->storage->save('/un/fichier');

            // Accès au service depuis le DI
            $this->di->get('storage')->save('/un/fichier');

            // Une autre façon avec l'accesseur magique
            $this->di->getStorage()->save('/un/fichier');

            // Une autre façon avec l'accesseur magique
            $this->getDi()->getStorage()->save('/un/fichier');

            // Avec l'écriture tableau
            $this->di['storage']->save('/un/fichier');
        }
    }

Si vous utilisez Phalcon comme un framework full-stack, vous pouvez consulter les services fournis :doc:`par défaut <di>` par le framework.

Requête et réponse
------------------
En supposant que le framework fournisse un ensemble de services pré-inscrit, nous allons expliquer comment interagir avec l'environnement HTTP.
Le service "request" contient un instance de :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` et le service "response" est une instance de
:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>` qui représente ce qui est renvoyé au client.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Vérifie que la requête utilise la méthode POST
            if ($this->request->isPost()) {
                // Access POST data
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }
    }

Normalement, l'objet réponse n'est pas utilisé directement mais il est construit avant l'exécution de l'action. Parfois, comme
dans l'événement "afterDispatch" il peut être utile d'accéder à la réponse directement:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // Envoi d'une entête de réponse HTTP 404
            $this->response->setStatusCode(404, "Not Found");
        }
    }

Vous apprendrez plus sur l'environnement HTTP dans les articles dédiés à :doc:`request <request>` et :doc:`response <response>`.

Données de Session
------------------
Les sessions nous aident à maintenir la persistence des données entre les requêtes. Vous pouvez accéder à :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
à partir de n'importe quel contrôleur pour encapsuler les données devant être persistantes.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            $this->persistent->name = "Michael";
        }

        public function welcomeAction()
        {
            echo "Welcome, ", $this->persistent->name;
        }
    }

Utilisation des Services en tant que Contrôleurs
------------------------------------------------
Les services peuvent agir comme des contrôleurs. Les classes contrôleur sont toujours intérrogées depuis le conteneur de services.
En conséquence, n'importe quelle autre classe inscrite avec son nom peut aisément remplacer un contrôleur:

.. code-block:: php

    <?php

    // Inscription d'un contrôleur en tant que service
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

    // Inscription d'un contrôleur avec espace de nom en tant que service
        $component = new Component();
    $di->set(
        "Backend\\Controllers\\IndexController",
        function () {
            $component = new Component();

            return $component;

        }
    );

Les Evénements dans les Contrôleurs
-----------------------------------
Les contrôleurs agissent automatiquement comme des écouteurs pour les événements du :doc:`répartiteur <dispatching>`. La réalisation de méthodes
avec ces noms d'événements vous permet de créer des points d'interception avant que les actions ne soient exécutées:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute($dispatcher)
        {
            // Ceci est exécuté avant chaque action trouvée
            if ($dispatcher->getActionName() === "save") {
                $this->flash->error(
                    "You don't have permission to save posts"
                );

                $this->flash->error("Vous n'avez pas l'autorisation d'enregistrer des annonces");
                $this->dispatcher->forward(
                    [
                        "controller" => "home",
                        "action"     => "index",
                    ]
                );

                return false;
            }
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Exécutée après chaque action trouvée
        }
    }

.. _DRY: https://fr.wikipedia.org/wiki/Ne_vous_r%C3%A9p%C3%A9tez_pas
