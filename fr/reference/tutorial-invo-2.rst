Tutoriel 3: Sécuriser INVO
==========================

Dans ce chapitre, nous continuons à expliquer comment INVO est structurée. nous parlerons
de la mise en œuvre de l'authentification et de l'autorisation en utilisant les événements, les plugins
ainsi que les listes de contrôle d'accès (ACL) gérés par Phalcon.

S'identifier auprès de l'application
------------------------------------
S'identifier va nous permettre d'exploiter les contrôleurs du backend. La séparation entre les contrôleurs du backend et
du frontend sont purement d'ordre logique, puisqu'ils sont localisés dans le même dossier (app/controllers/).

Pour s'authentifier il faut un nom d'utilisateur et un mot de passe valides. Les utilisateurs sont stockés dans la table "users"
de la base de données "invo".

Avant de pouvoir ouvrir une session, nous devons configurer la connexion à la base de données. Un service
appelé "db" est défini dans le conteneur de service avec cette information. De même pour le chargeur automatique, nous
reprenons en paramètre les informations du fichier de configuration de manière à configurer le service :

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // ...

    // La connexion à la base est créée en fonction des paramètres définis dans le fichier de configuration
    $di->set(
        "db",
        function () use ($config) {
            return new DbAdapter(
                [
                    "host"     => $config->database->host,
                    "username" => $config->database->username,
                    "password" => $config->database->password,
                    "dbname"   => $config->database->name,
                ]
            );
        }
    );

Ici on retourne une instance de l'adaptateur de connexion à MySQL. Si nécessaire vous pourriez ajouter des actions complémentaire tel qu'ajouter un
logger, un profileur ou changer l'adaptateur, en adaptant comme vous le souhaitez.

Le formulaire (app/views/session/index.volt) demande les informations d'authentification.
Certaines lignes HTML ont été supprimés dans l'extrait suivant pour rendre l'exemple plus concis:

.. code-block:: html+jinja

    {{ form("session/start") }}
        <fieldset>
            <div>
                <label for="email">
                    Username/Email
                </label>

                <div>
                    {{ text_field("email") }}
                </div>
            </div>

            <div>
                <label for="password">
                    Password
                </label>

                <div>
                    {{ password_field("password") }}
                </div>
            </div>



            <div>
                {{ submit_button("Login") }}
            </div>
        </fieldset>
    {{ endForm() }}

Au lieu d'utiliser du pur PHP comme dans le tuto précédent, nous allons commencer à utiliser :doc:`Volt <volt>`. C'est 
un moteur de gabarits (template engine) inspiré de Jinja_ qui fournit une syntaxe simple et conviviale pour créer des gabarits.
Cela ne devrait pas vous prendre beaucoup de temps pour vous familiariser avec Volt.

La fonction :code:`SessionController::startAction` (app/controllers/SessionController.php) a pour tâche de valider les
données saisies dans le formulaire incluant la présence d'un utilisateur valide dans la base:

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {
        // ...

        private function _registerSession($user)
        {
            $this->session->set(
                "auth",
                [
                    "id"   => $user->id,
                    "name" => $user->name,
                ]
            );
        }

        /**
         * Cette action authentifie un utilisateur auprès l'application
         */
        public function startAction()
        {
            if ($this->request->isPost()) {
                // Récupère les données de l'utilisateur
                $email    = $this->request->getPost("email");
                $password = $this->request->getPost("password");

                // Recherche l'utilisateur dans la base
                $user = Users::findFirst(
                    [
                        "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                        "bind" => [
                            "email"    => $email,
                            "password" => sha1($password),
                        ]
                    ]
                );

                if ($user !== false) {
                    $this->_registerSession($user);

                    $this->flash->success(
                        "Welcome " . $user->name
                    );

                    // Redirige vers le contrôleur 'invoices' si l'utilisateur est valide
                    return $this->dispatcher->forward(
                        [
                            "controller" => "invoices",
                            "action"     => "index",
                        ]
                    );
                }

                $this->flash->error(
                    "Wrong email/password"
                );
            }

            // Redonne la main au formulaire d'authentification
            return $this->dispatcher->forward(
                [
                    "controller" => "session",
                    "action"     => "index",
                ]
            );
        }
    }

Pour des raisons de simplicité, nous avons utilisé "sha1_" pour stocker le mot de passe hashé dans la base de données, cependant cet algorithme
n'est pas recommandé pour une véritable application, il est préférable d'utiliser plutôt ":doc:`bcrypt <security>`".

Veuillez noter que plusieurs attributs publics sont accessibles dans le contrôleur avec :code:`$this->flash`, :code:`$this->request` ou :code:`$this->session`.
Ceux-ci sont des services définis dans le conteneur de service de tout à l'heure (app/config/services.php).
Quand ils sont accédés pour la première fois, ils sont insérés dans le controlleur.

Ces services sont partagés, ce qui signifie qu'on accéde à la même instance sans tenir compte de l'endroit
où on les invoque.

Par exemple, ici on crée le service de sessions et on enregistre l'identité de utilisateur dans la variable "auth":

.. code-block:: php

    <?php

    $this->session->set(
        "auth",
        [
            "id"   => $user->id,
            "name" => $user->name,
        ]
    );

Un autre aspect important de cette section est la façon dont l'utilisateur est validé,
nous vérifions d'abord si la requête est soumise par une méthode POST:

.. code-block:: php

    <?php

    if ($this->request->isPost()) {

Nous recevons alors les paramètres du formulaire:

.. code-block:: php

    <?php

    $email    = $this->request->getPost("email");
    $password = $this->request->getPost("password");

Maintenant nous regardons s'il existe un utilisateur actif avec le même nom ou email ainsi que le même mot de passe:

.. code-block:: php

    <?php

    $user = Users::findFirst(
        [
            "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
            "bind" => [
                "email"    => $email,
                "password" => sha1($password),
            ]
        ]
    );

Notez l'utilisation de paramètres liés. Les étiquettes (placeholder) :email: and :password: sont placé là où les valeurs doivent se trouver,
ainsi les valeurs sont liées en utilisant le paramètre "bind". Ceci permet de remplacer les valeurs
sans prendre le risque d'une injection SQL.

Si l'utilisateur est valide, alors on l'enregistre en session et on le redirige vers le tableau de bord:

.. code-block:: php

    <?php

    if ($user !== false) {
        $this->_registerSession($user);

        $this->flash->success(
            "Welcome " . $user->name
        );

        return $this->dispatcher->forward(
            [
                "controller" => "invoices",
                "action"     => "index",
            ]
        );
    }

Si l'utilisateur n'esiste pas, nous revenons à l'affichage du formulaire:

.. code-block:: php

    <?php

    return $this->dispatcher->forward(
        [
            "controller" => "session",
            "action"     => "index",
        ]
    );

Sécuriser le Backend
--------------------
Le backend est une zone privée où seules les personnes enregistrés ont accès. Par conséquent il est nécessaire
de vérifier que seuls les utilisateurs enregistrés ont accés à ces contrôleurs. Si vous n'êtes pas identifiés auprès
de l'application et que vous essayez d'accéder au contrôleur product (qui est privé),
vous verrez un message comme celui-ci:

.. figure:: ../_static/img/invo-2.png
   :align: center

A chaque fois que quelqu'un tente d'accéder à n'importe quel contrôleur/action, l'application vérifie que
le rôle de l'utilisateur (en session) lui permet d'y accéder, sinon il affiche un message comme celui du dessus et
transfert le flux à la page d'accueil.

Maintenant, découvrons comment l'application fait cela. La première chose à savoir est qu'il
y a un composant appelé :doc:`Dispatcher <dispatching>`. Il est informé de la route
trouvé par le composant :doc:`Routing <routing>`. Puis, il est responsable de charger
le contrôleur approprié et d'exécuter l'action correspondante.

En temps normal, le framework crée le répartiteur (dispatcher) automatiquement. Dans notre cas, nous voulons faire une vérification
avant d'exécuter l'action requise, vérifier si l'utilisateur y a accès ou pas. Pour faire cela, nous avons
remplacé le composant en créant une fonction dans l'amorce (public/index.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // ...

    /**
     * MVC dispatcher
     */
    $di->set(
        "dispatcher",
        function () {
            // ...

            $dispatcher = new Dispatcher();

            return $dispatcher;
        }
    );

Nous avons maintenant un contrôle total sur le répartiteur utilisé dans notre application. Plusieurs composants du framework déclenchent
des événements qui nous autorisent à modifier le flux interne des opérations. Comme l'injecteur de dépendances agit comme un "ciment"
pour composants, un nouveau composant appelé :doc:`EventsManager <events>` nous facilite l'interception des événements produits
par un composant routant les événements aux écouteurs (listeners).

Gestion des événements
^^^^^^^^^^^^^^^^^^^^^^
Un :doc:`EventsManager <events>` (gestionnaire d'évènement) nous permet d'attacher un ou plusieurs écouteur à un type particulier d'évènement. Le type
d'évènement qui nous intéresse actuellement est le "dispatch", le code suivant filtre tous les événements produit par le répartiteur:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Création du gestionnaire d'événement
            $eventsManager = new EventsManager();

            // Listen for events produced in the dispatcher using the Security plugin
            // A l'écoute d'événement produits par le répartiteur en utilisant le plugin "Security"
            $eventsManager->attach(
                "dispatch:beforeExecuteRoute",
                new SecurityPlugin()
            );

            // Gestion les exceptions et les exceptions "non trouvé" avec "NotFoundPlugin"
            $eventsManager->attach(
                "dispatch:beforeException",
                new NotFoundPlugin()
            );

            $dispatcher = new Dispatcher();

            // Assigne le gestionnaire d'événements au répartiteur
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Lorsqu'un événement appelé "beforeExecuteRoute" est déclenché alors le plugin suivant en est informé:

.. code-block:: php

    <?php

    /**
     * Vérifie grâce à SecurityPlugin que l'utilisateur soit autorisé à accéder à certaines actions
     */
    $eventsManager->attach(
        "dispatch:beforeExecuteRoute",
        new SecurityPlugin()
    );

Lorsque "beforeException" est déclenché alors cet autre plugin en est informé:

.. code-block:: php

    <?php

    /**
     * Gestion les exceptions et les exceptions "non trouvé" avec "NotFoundPlugin"
     */
    $eventsManager->attach(
        "dispatch:beforeException",
        new NotFoundPlugin()
    );

Le plugin de sécurité est une classe située dans (app/plugins/SecurityPlugin.php). Cette classe met en œuvre une méthode
"beforeExecuteRoute". C'est le même nom qu'un des événements produit dans le répartiteur:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;

    class SecurityPlugin extends Plugin
    {
        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }
    }

Les évènements "hooks" (détours) reçoivent toujours un premier paramètre qui contient des informations contextuelles de l'évènement produit (:code:`$event`)
et un second paramètre qui est l'objet produit par l'évènement lui-même (:code:`$dispatcher`). Il n'est pas obligatoire
que le plugin étende la classe :doc:`Phalcon\\Mvc\\User\\Plugin <../api/Phalcon_Mvc_User_Plugin>` mais, en faisant ainsi, l'accès aux services disponibles 
de l'application en est facilité.

Maintenant nous allons vérifier le rôle de la session courrante, vérifier si l'utilisateur a accès en utilisant les ACL (access control list).
Si l'utilisateur n'y a pas accès, nous le redirigeons vers l'écran d'accueil comme expliqué précédemment.

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;

    class SecurityPlugin extends Plugin
    {
        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // Vérifie que la variable "auth" existe en session afin de définir le rôle actif
            $auth = $this->session->get("auth");

            if (!$auth) {
                $role = "Guests";
            } else {
                $role = "Users";
            }

            // Récupère le contrôleur ou action actif depuis le répartiteur
            $controller = $dispatcher->getControllerName();
            $action     = $dispatcher->getActionName();

            // Obtention de l'ACL
            $acl = $this->getAcl();

            // Vérifie que ce Rol a accès au contrôleur (ressource)
            $allowed = $acl->isAllowed($role, $controller, $action);

            if (!$allowed) {
                // Si pas autorisé, alors redirection vers le contrôleur "index"
                $this->flash->error(
                    "You don't have access to this module"
                );

                $dispatcher->forward(
                    [
                        "controller" => "index",
                        "action"     => "index",
                    ]
                );

                // Retourne "faux" pour indiquer au répartiteur d'interrompre l'opération courante
                return false;
            }
        }
    }

Fournir une liste ACL
^^^^^^^^^^^^^^^^^^^^^
Dans l'exemple précédent, nous avons obtenu les ACL en utilisant la méthode :code:`$this->getAcl()`. Cette méthode est aussi
mise en œuvre dans Plugin. Maintenant nous allons expliquer étape par étape comment nous avons construit les listes de contrôle d'accès (ACL):

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Acl\Role;
    use Phalcon\Acl\Adapter\Memory as AclList;

    // Création de l'ACL
    $acl = new AclList();

    // L'action par défaut est DENY (refusé)
    $acl->setDefaultAction(
        Acl::DENY
    );

    // Inscription de deux rôles, Users sont les utilisateur identifiés
    // et Guests sont les utilisateurs sans identité (invités)
    $roles = [
        "users"  => new Role("Users"),
        "guests" => new Role("Guests"),
    ];

    foreach ($roles as $role) {
        $acl->addRole($role);
    }

On définit les ressources pour chaque zone. Les noms de contrôleur représentent des ressources et leurs actions sont des 
accès aux ressources:

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // ...

    // Ressource de l'espace privé (backend)
    $privateResources = [
        "companies"    => ["index", "search", "new", "edit", "save", "create", "delete"],
        "products"     => ["index", "search", "new", "edit", "save", "create", "delete"],
        "producttypes" => ["index", "search", "new", "edit", "save", "create", "delete"],
        "invoices"     => ["index", "profile"],
    ];

    foreach ($privateResources as $resourceName => $actions) {
        $acl->addResource(
            new Resource($resourceName),
            $actions
        );
    }



    // Ressources de l'espace public (frontend)
    $publicResources = [
        "index"    => ["index"],
        "about"    => ["index"],
        "register" => ["index"],
        "errors"   => ["show404", "show500"],
        "session"  => ["index", "register", "start", "end"],
        "contact"  => ["index", "send"],
    ];

    foreach ($publicResources as $resourceName => $actions) {
        $acl->addResource(
            new Resource($resourceName),
            $actions
        );
    }

Les ACL ont connaissance maintenant des contrôleurs et de leurs actions. Le rôle "Users" a accès à
toutes les ressources du backend et du frontend. Le rôle "Guest" en revanche n'a accès qu'à l'espace public :

.. code-block:: php

    <?php

    // Autorise l'accès a l'espace public pour les utilisateurs et les invités
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow(
                $role->getName(),
                $resource,
                "*"
            );
        }
    }

    // Autorise l'accès à l'espace privé uniquement au rôle Users
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow(
                "Users",
                $resource,
                $action
            );
        }
    }

Hourra! Les ACL sont maintenant terminés. Dans le chapitre suivant nous verrons comment le CRUD (create, read, update and delete - création, lecture, mise à jour, suppression) 
est mis en oeuvre dans Phalcon et comment vous pouvez le personnaliser.

.. _jinja: http://jinja.pocoo.org/
.. _sha1: http://php.net/manual/fr/function.sha1.php
