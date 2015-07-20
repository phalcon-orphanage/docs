Tutoriel 2: Expliquer INVO
===========================
Dans ce second tutoriel, nous allons expliquer une application plus complète de manière à approfondir le développement de Phalcon.
INVO est l'une des applications que nous avons créé en tant qu'exemples. INVO est un petit site web qui permet aux utilisateur de générer des factures et faire
d'autres tâches comme gérer ses clients et ses produits. Vous pouvez cloner son code à partir de Github_.

Aussi, INVO utilise `Twitter Bootstrap`_ comme framework côté client. Même si l'application ne génère pas de factures, cela donne un exemple pour comprendre comment le framework fonctionne.


Structure du projet
------------------
Une fois que vous avez cloné le projet, à partir de la racine, vous verrez la structure suivante :

.. code-block:: bash

    invo/
        app/
            app/config/
            app/controllers/
            app/library/
            app/models/
            app/plugins/
            app/views/
        public/
            public/bootstrap/
            public/css/
            public/js/
        schemas/

Comme vous l'avez vu précédemment, Phalcon n'impose pas de structure particulière pour développer une application.
Ce projet fournit une simple structure MVC et un document public à la racine.

Une fois l'application ouverte dans votre navigateur à l'adresse : http://localhost/invo vous verrez quelque chose comme ça :

.. figure:: ../_static/img/invo-1.png
   :align: center

Cette application est divisé en deux parties, un frontend, qui est une partie publique où les visiteurs peuvent obtenir des informations à propos d'INVO et des informations de contact.
La seconde partie est le backend, une zone administrative où un utilisateur enregistré peu gérer ses produits et ses clients.

Routage
-------
INVO utilise le routage standard qui est construit avec le composant Router. Ces routes correspondent au schéma suivant : /:controller/:action/:params.
Cela signifie que la première partie de l'URI est le controller, la seconde est l'action et la suite sont les paramètres.

La route suivante /session/register exécute le controlleur "SessionController" et son action "registerAction".

Configuration
-------------
INVO a un fichier de configuration qui définit les paramètres génèraux de l'application. Ce fichier est lu par les premières lignes du fichier boostrap (public/index.php) :

.. code-block:: php

    <?php

    // Read the configuration
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

:doc:`Phalcon\\Config <config>` nous permet de manipuler le fichier comme un objet. Le fichier de configuration contient les paramètres suivants :

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = /../app/controllers/
    modelsDir      = /../app/models/
    viewsDir       = /../app/views/
    pluginsDir     = /../app/plugins/
    libraryDir     = /../app/library/
    baseUri        = /invo/

    ;[metadata]
    ;adapter = "Apc"
    ;suffix = my-suffix
    ;lifetime = 3600

Phalcon n'a pas de convention de codage défini. Les sections nous permettent d'organiser les options de manière appropriée. Dans ce fichier il y a trois sections que l'on utilisera plus tard.

Autoloaders
-----------
La seconde partie du fichier boostrap (public/index.php) est l'autoloader (mécanisme de chargement automatique).
L'autoloader enregistre un ensemble de dossies où l'application va chercher les classes dont il va avoir besoin.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();
    
Notez que ce qu'il fait est d'enregistrer les dossiers qui sont définis dans le fichier de configuration.
Le seul dossier qui n'est pas enregistré est viewsDir parce qu'il ne contient pas de classes mais des fichiers de type HTML + PHP.

Gérer la requête
--------------------
Allons plus loin dans le fichier, à la fin, la requête est finalement gérée par Phalcon\\Mvc\\Application,
cette classe initialise et exécute tous ce qui est nécessaire pour faire tourner l'application:

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle()->getContent();

    
Injection de dépendances
--------------------
Regardez à la premiére ligne du code juste au dessus, la variable $app reçoit une autre variable $di dans son constructeur.
Quel est le but de cette variable ? Phalcon est un framework fortement découplé, donc on a besoin d'un composant qui agit comme une sorte de colle pour que tout fonctionne ensemble, correctement.

Ce composant est Phalcon\\DI. C'est un conteneur de services qui fait des injections de dépendances et qui instancie tous les composants quand ils sont nécessaires pour l'application.

Il y a différents moyens d'enregistrer les services dans un conteneur. Dans INVO la plupart des services ont été enregistrés en utilisant des fonctions anonymes.
Grace à cela, les objets sont instanciés paresseusement (= uniquement lorsque nécessaire) , ce qui réduit les ressources requises par l'application.

Par exemple, dans l'extrait suivant, le service de session est enregistré, la fonction anonyme sera appelée uniquement lorsque l'application aura besoin d'accéder aux données de la session:

.. code-block:: php

    <?php

    // Start the session the first time when some component request the session service
    $di->set('session', function () {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

Dans cette situation, on a la possibilité de changer l'adaptateur, de faire des initialisation supplémentaires ainsi que beaucoup d'autres choses.
Notez que le service est enregistré avec le nom "session", c'est une convention qui va permettre au framework d'identifier le service actifdans le conteneur de service.

Une requête peux utiliser plusieurs services, enregistrer chaque services un par un peux être une lourde tâche.
Pour cette raison le framework fournit une variante à Phalcon\\DI appelée Phalcon\\DI\\FactoryDefault qui a pour mission d'enregistrer tous les services, fournissant ainsi un framework complet.

.. code-block:: php

    <?php

    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full stack framework
    $di = new \Phalcon\DI\FactoryDefault();

Cet extrait enregistre la majorité des services avec les composants fournis par le framework. Si on a besoin d'outrepasser la définition de certains services
on pourrait le modifier comme on l'a fait pour la "session" au dessus. C'est l'intérêt de la variable $di.


Se connecter à l'application
------------------------
Se connecter va nous premettre de travailler sur les controlleurs du backend. La séparation entre les controlleurs du backend et du frontend sont purement d'ordre logique,
car tous les contrôleurs sont localisés dans le même dossier (app/controllers/).

Pour se connecter il faut un nom d'utilsateur et un mot de passe valide. Les utilisateurs sont stockés dans la table "users" de la base de données "invo".

Avant de pouvoir commencer une session, nous devons configurer la connexion à la base de données. Un service appelé "db" est utilisé dans le conteneur de service avec cette information.
Pour ce qui est de l'autoloader, on prends en paramètres les informations du fichier de configuration de manière à configurer le service :

.. code-block:: php

    <?php

    // Database connection is created based on the parameters defined in the configuration file
    $di->set('db', function () use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

Ici on retourne une instance de l'adaptateur de connexion à MySQL.
Si nécessaire on pourrait faire des actions supplémentaire tel qu'ajouter un logger, un profileur ou changer l'adaptateur, ...

Le formulaire (app/views/session/index.phtml) demande les informations de connexion.
Certaines lignes HTML ont été supprimés dans l'extrait suivant pour rendre l'exemple plus concis:

.. code-block:: html+php

    <?php echo Tag::form('session/start') ?>

        <label for="email">Username/Email</label>
        <?php echo Tag::textField(array("email", "size" => "30")) ?>

        <label for="password">Password</label>
        <?php echo Tag::passwordField(array("password", "size" => "30")) ?>

        <?php echo Tag::submitButton(array('Login')) ?>

    </form>


Le SessionController::startAction (app/controllers/SessionController.phtml) a pour tâche de valider les données entrées à la recherche d'un utilisateur valide dans la base de données :

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {

        // ...

        private function _registerSession($user)
        {
            $this->session->set('auth', array(
                'id' => $user->id,
                'name' => $user->name
            ));
        }

        public function startAction()
        {
            if ($this->request->isPost()) {

                // Receiving the variables sent by POST
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                // Find for the user in the database
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);

                    // Forward to the 'invoices' controller if the user is valid
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            // Forward to the login form again
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'index'
            ));

        }

    }

Pour des raisons de simplicité, nous avons utilisé "sha1_" pour stocker le mot de passe hashé dans la base de données, cependant cet algorithme n'est pas recommandé pour une vraie application,
il est préférable d'utiliser " :doc:`bcrypt <security>`" à la place.

Veuillez noter que plusieurs attributs public sont accessibles dans le contrôleur avec $this->flash, $this->request ou $this->session.
Ceux-ci sont des servies défini dans le conteneur de service de tout à l'heure. Quand ils sont accédés pour la première fois, ils sont insérés dans le controlleur.

Ces services sont partagés, ce qui signifie qu'on accéde à la même instance sans tenir compte de l'endroit où on les a créés.

Par exemple, ici on créé le service de sessions et on enregistre l'identité de utilisateur dans la variable "auth":

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

Sécuriser le Backend
--------------------
Le backend est une zone privé où seul les personnes enregistrés ont accès. Par conséquent il est nécessaire de vérifier que seul les utilisateurs enregistrés ont accés à ces contrôleurs.
Si vous n'êtes pas connectés à l'application et que vous essayez d'accéder au contrôleur product, par exemple, vous verrez le message suivant :

.. figure:: ../_static/img/invo-2.png
   :align: center

A chaque fois que quelqu'un essaye d'accéder à n'importe quel contrôleur/action, l'application va vérifier que le rôle de l'utilisateur (en session) lui permet d'y accéder,
sinon il affiche un message comme celui du dessus et transfert le flux à la page d'accueil.

Maintenant, découvrons comment l'application fait cela. La première chose à savoir est qu'il y a un composant appelé :doc:`Dispatcher <dispatching>`.
Il est informé de la route trouvé par le composant :doc:`Routing <routing>`. Puis, il est responsable de charger le contrôleur approprié et d'exécuter l'action correspondante.

En temps normal, le framework créé le dispatcher automatiquement. Dans notre cas, nous voulons faire une vérification avant d'exécuter l'action requise,
vérifier si l'utilisateur y a accès ou pas. Pour faire cela, nous avons remplacé le composant en créant une fonction dans le bootstrap (public/index.php):

.. code-block:: php

    <?php

    $di->set('dispatcher', function () use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

Nous avons maintenant un contrôle complet sur le dispatcher utilisé dans notre application.
Plusieurs composants du framework déclenchent des évènements qui nous autorisent à modifier le flux interne des opérations.
Comme l'injecteur de dépendances agit comme une "colle" pour composants, un nouveau composant appelé :doc:`EventsManager <events>`
nous aide à intercepter les évènements produits par un composant routant les évènements aux listeners.


Gestion des évènements
^^^^^^^^^^^^^^^^^
Un :doc:`EventsManager <events>` (gestionnaire d'évènement) nous permet d'attacher un ou plusieurs listeners à un type particulier d'évènement.
Le type d'évènement qui nous intéresse actuellement est le "dispatch", la code suivant filtre tous les évènements produit par le dispatcher :


.. code-block:: php

    <?php

    $di->set('dispatcher', function () use ($di) {

        // Obtain the standard eventsManager from the DI
        $eventsManager = $di->getShared('eventsManager');

        // Instantiate the Security plugin
        $security = new Security($di);

        // Listen for events produced in the dispatcher using the Security plugin
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        // Bind the EventsManager to the Dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Le plugin de sécurité est une classe situé dans (app/plugins/Security.php). Cette classe implémente une méthode "beforeExecuteRoute".
C'est le même nom qu'un des évènement produit dans le dispatcer :


.. code-block:: php

    <?php

    use Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\User\Plugin;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }

    }

Les évènements "hooks" reçoivent toujours un premier paramètre qui contient le contexte de l'information de l'évènement produit ($event)
et un second paramètre qui est l'objet produit par l'évènement lui-même ($dispatcher). Il n'est pas obligatoire de faire étendre le plugin de la classe
Phalcon\\Mvc\\User\\Plugin, mais en faisant ainsi on a un accès facilité aux services disponibles de l'application.

Maintenant nous allons vérifier le rôle de la session courrante, vérifier si l'utilisateur a accès en utilisant les listes ACL (access control list).
S'il/elle n'a pas accès, il/elle sera redirigé(e) vers la page d'accueil comme expliqué précédemment.


.. code-block:: php

    <?php

    use Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\User\Plugin;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {

            // Check whether the "auth" variable exists in session to define the active role
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            // Take the active controller/action from the dispatcher
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            // Obtain the ACL list
            $acl = $this->_getAcl();

            // Check if the Role have access to the controller (resource)
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Phalcon\Acl::ALLOW) {

                // If he doesn't have access forward him to the index controller
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                // Returning "false" we tell to the dispatcher to stop the current operation
                return false;
            }

        }

    }

Fournir une liste ACL
^^^^^^^^^^^^^^^^^^^^^
Dans l'exemple précédent, nous avons obtenu les ACL en utilisant la méthode $this->_getAcl(). Cette méthode est aussi
implémentée dans Plugin. Maintenant nous allons expliquer étape par étape comment nous avons construit les ACL (access control list) :


.. code-block:: php

    <?php

    // Create the ACL
    $acl = new Phalcon\Acl\Adapter\Memory();

    // The default action is DENY access
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    // Register two roles, Users is registered users
    // and guests are users without a defined identity
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

On défini les ressources pour chaque zone. Le nom des contrôleurs sont des ressources et leurs actions sont accédées pour les ressources :


.. code-block:: php

    <?php

    // Private area resources (backend)
    $privateResources = array(
      'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    // Public area resources (frontend)
    $publicResources = array(
      'index' => array('index'),
      'about' => array('index'),
      'session' => array('index', 'register', 'start', 'end'),
      'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

Les ACL ont maintenant connaissance des contrôleurs et de leurs actions. Le rôle "Users" a accès à toutes les ressources du
backend et du frontend. Le rôle "Guest" en revanche n'a accès qu'à la partie publique :


.. code-block:: php

    <?php

    // Grant access to public areas to both users and guests
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    // Grant access to private area only to role Users
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

Hooray!, les ACL sont maintenant terminés.

Composants utilisateurs
---------------
Tous les éléments graphique et visuels de l'application ont été réalisés principalement avec `Twitter Bootstrap`_.
Certains éléments, comme la barre de navigation, changent en fonction de l'état de l'applicatin (connecté/déconnecté).
Par exemple dans le coin en haut à droite, les liens "Log in/Sign up" (se connecter/s'inscrire) se changent en "Log out" (Se déconnecter)
quand un utilisateur se connecte.

Cette partie de l'application est implémentée en utilisant le composant "Elements" (app/library/Elements.php).

.. code-block:: php

    <?php

    use Phalcon\Mvc\User\Component;

    class Elements extends Component
    {

        public function getMenu()
        {
            // ...
        }

        public function getTabs()
        {
            // ...
        }

    }

Cette classe étend de Phalcon\\Mvc\\User\\Component,il n'est pas imposé d'étendre un composant avec cette classe, mais
cela permet d'accéder plus rapidement/facilement aux services de l'application.
Maintenant enregistrons cette classe au conteneur de service :

.. code-block:: php

    <?php

    // Register an user component
    $di->set('elements', function () {
        return new Elements();
    });

Tout comme les contrôleurs, les plugins et les composants à l'intérieur des vues, ce composant à aussi accès aux services requis dans le conteneur en accédant juste à l'attribut.

.. code-block:: html+php

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">INVO</a>
                <?php echo $this->elements->getMenu() ?>
            </div>
        </div>
    </div>

    <div class="container">
        <?php echo $this->getContent() ?>
        <hr>
        <footer>
            <p>&copy; Company 2012</p>
        </footer>
    </div>

La partie la plus importante est :

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

Travailler avec le CRUD
---------------------
La plupart des options qui manipulent des données (companies, products et types de products), ont été développés
en utilisant un CRUD_ (create/read/update/delete) basique et commun. Chaque CRUD contient les fichiers suivants :


.. code-block:: bash

    invo/
        app/
            app/controllers/
                ProductsController.php
            app/models/
                Products.php
            app/views/
                products/
                    edit.phtml
                    index.phtml
                    new.phtml
                    search.phtml

Chaque contrôleur a les actions suivantes :

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * The start action, it shows the "search" view
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Execute the "search" based on the criteria sent from the "index"
         * Returning a paginator for the results
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Shows the view to create a "new" product
         */
        public function newAction()
        {
            // ...
        }

        /**
         * Shows the view to "edit" an existing product
         */
        public function editAction()
        {
            // ...
        }

        /**
         * Creates a product based on the data entered in the "new" action
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Updates a product based on the data entered in the "edit" action
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Deletes an existing product
         */
        public function deleteAction($id)
        {
            // ...
        }

    }

Formulaire de recherche
^^^^^^^^^^^^^^^
Tous les CRUD commencent avec le formulaire de recherche. Ce formulaire montre tous les champs que la table products possède,
permettant à l'utilisateur de filtrer ses recherches. La tâche "products" est liée à la table "products_types".
Dans notre cas, nous avons déjà demandé des enregistrements de cette table, afin de faciliter la recherche dans ce champ :



.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

Tous les types de produits sont cherchés et passés à la vue en tant que variable locale "productType". Puis, dans la vue
(app/views/index.phtml) on montre un champ "select" remplis avec ces résultats :

.. code-block:: html+php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo Tag::select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Notez que $productTypes contient les données nécessaires pour remplir le tag SELECT en utilisant Phalcon\\Tag::select.
Une fois le formulaire validé, l'action "search" est exécuté dans le contrôleur, réalisant la recherche basé sur les
données entrées par l'utilisateur.


Exécuter une recherche
^^^^^^^^^^^^^^^^^^^
L'action de recherche a un double comportement. Quand on y accéde avec POST, cela fait une recherche basé sur les données
que l'on a envoyé à partir du formulaire. Mais quand on y accéde via GET cela change la page courante dans le paginateur.
Pour différencier la méthode (GET ou POST), nous utilisons le composant :doc:`Request <request>` :

.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            // create the query conditions
        } else {
            // paginate using the existing conditions
        }

        // ...

    }

Avec l'aide de :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` ,nous pouvons créer les conditions de recherche basé sur les types de données envoyé via le formulaire :

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

Cette méthode vérifie quelle valeur est différente de "" (chaine vide) et "null" et les prends en compte pour créer les critères de recherche :

* Si le champs de données est "text" ou similaire (char, varchar, text, etc.). L'opérateur "like" sera utilisé pour filtrer les résultats.
* Si le type de donnée est différent, l'opérateur "=" sera utilisé

De plus, "Criteria" ignore toutes les variables POST qui ne correspondent à aucun champs de la table.
Les valeurs seront automatiquement échappées en utilisant les paramètres liés (bond parameters).

Maintenant, on va stoquer les paramètres dans le "sac" de session du contrôleur :

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Un sac de session est un attribut particulier dans un contrôleur qui est sauvegardé entre les requêtes.
Quand on y accède, cet attribut injecte un service :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` qui est indépendant de chaque contrôleur.

Puis, basé sur les paramètres passé, on génère la requête :

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

Si la recherche ne retourne aucun produit, on transfert l'utilisateur à l'action index. Si la recherche retourne des résultats,
on créé un paginateur pour se déplacer à travers les pages facilement :

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    // Data to paginate
        "limit" => 5,           // Rows per page
        "page" => $numberPage   // Active page
    ));

    // Get active page in the paginator
    $page = $paginator->getPaginate();

Enfin, on passe la page retournée à la vue:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

Dans la vue (app/views/products/search.phtml), on affiche le résultat correspondant à la page actuelle :

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= Tag::linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= Tag::linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

Créer et modifier des entrées
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Voyons comment le CRUD créé et modifie des entrées. A partir des vues "new" et "edit", la donnée entrée par l'utilisateur
est envoyé à l'action "create" et "save" qui exécute l'action de créer ou de modifier les produits.

Dans la page de création, on récupère les données envoyés et on leur assigne une nouvelle instance de produit :

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        $products = new Products();

        $products->id = $this->request->getPost("id", "int");
        $products->product_types_id = $this->request->getPost("product_types_id", "int");
        $products->name = $this->request->getPost("name", "striptags");
        $products->price = $this->request->getPost("price", "double");
        $products->active = $this->request->getPost("active");

        // ...

    }

Les données sont filtrés avant d'être assignés à l'objet. Ce filtrage est optionnel, l'ORM échappe les données entrées et
caste les données en fonction des types des champs.

Quand on sauvegarde, nous saurons si la donnée est conforme aux règles et validations implémentés dans le model Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        // ...

        if (!$products->create()) {

            // The store failed, the following messages were produced
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

Maintenant, dans le cas de la modification de produit, on doit présenter les données à éditer à l'utilisateur en pré-remplissant les champs:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        // ...

        $product = Products::findFirstById($id);

        Tag::setDefault("id", $product->id);
        Tag::setDefault("product_types_id", $product->product_types_id);
        Tag::setDefault("name", $product->name);
        Tag::setDefault("price", $product->price);
        Tag::setDefault("active", $product->active);

    }

L'helper "setDefault" entre les valeurs du produit dans les champs qui portent le même nom comme valeur par défaut.
Grace à cela, l'utilisateur peut changer n'importe quelle valeur et ensuite envoyer ses modifications à la base de données avec l'action "save":

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        // ...

        // Find the product to update
        $product = Products::findFirstById($this->request->getPost("id"));
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        // ... assign the values to the object and store it

    }

Changer le titre de manière dynamique
------------------------------
Quand vous naviguez sur le site, vous remarquerez que le titre change d'une page à l'autre.
Cela est réalisé dans l'"initializer" de chaque contrôleur.

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        public function initialize()
        {
            // Set the document title
            Tag::setTitle('Manage your product types');
            parent::initialize();
        }

        // ...

    }

Notez que la méthode parent::initialize() est aussi appelée, cela ajoute plus de donnée à la suite du titre:

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon\Mvc\Controller
    {

        protected function initialize()
        {
            // Prepend the application name to the title
            Phalcon\Tag::prependTitle('INVO | ');
        }

        // ...
    }

Enfin, le titre est affiché dans la vue principale (app/views/index.phtml) :

.. code-block:: html+php

    <?php use Phalcon\Tag as Tag ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?php echo Tag::getTitle() ?>
        </head>
        <!-- ... -->
    </html>

Conclusion
----------
Ce tutoriel a couvert plusieurs aspect de la construction d'application avec Phalcon, nous espérons qu'il vous aura
permis d'en apprendre plus sur le framework.


.. _Github: https://github.com/phalcon/invo
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
.. _Twitter Bootstrap: http://twitter.github.io/bootstrap/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
