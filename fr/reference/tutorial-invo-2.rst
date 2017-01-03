Tutorial 3: Securing INVO
=========================

In this chapter, we continue explaining how INVO is structured, we'll talk
about the implementation of authentication, authorization using events and plugins and
an access control list (ACL) managed by Phalcon.

Se connecter à l'application
----------------------------
Se connecter va nous premettre de travailler sur les controlleurs du backend. La séparation entre les controlleurs du backend et
du frontend sont purement d'ordre logique, car tous les contrôleurs sont localisés dans le même dossier (app/controllers/).

Pour se connecter il faut un nom d'utilsateur et un mot de passe valide. Les utilisateurs sont stockés dans la table "users"
de la base de données "invo".

Avant de pouvoir commencer une session, nous devons configurer la connexion à la base de données. Un service
appelé "db" est utilisé dans le conteneur de service avec cette information. Pour ce qui est de l'autoloader, on
prends en paramètres les informations du fichier de configuration de manière à configurer le service :

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // ...

    // Database connection is created based on parameters defined in the configuration file
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

Ici on retourne une instance de l'adaptateur de connexion à MySQL. Si nécessaire on pourrait faire des actions supplémentaire tel qu'ajouter un
logger, un profileur ou changer l'adaptateur, ...

Le formulaire (app/views/session/index.volt) demande les informations de connexion.
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

Instead of using raw PHP as the previous tutorial, we started to use :doc:`Volt <volt>`. This is a built-in
template engine inspired in Jinja_ providing a simpler and friendly syntax to create templates.
It will not take too long before you become familiar with Volt.

Le :code:`SessionController::startAction` (app/controllers/SessionController.php) a pour tâche de valider les
données entrées à la recherche d'un utilisateur valide dans la base de données :

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
         * This action authenticate and logs a user into the application
         */
        public function startAction()
        {
            if ($this->request->isPost()) {
                // Get the data from the user
                $email    = $this->request->getPost("email");
                $password = $this->request->getPost("password");

                // Find the user in the database
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

                    // Forward to the 'invoices' controller if the user is valid
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

            // Forward to the login form again
            return $this->dispatcher->forward(
                [
                    "controller" => "session",
                    "action"     => "index",
                ]
            );
        }
    }

Pour des raisons de simplicité, nous avons utilisé "sha1_" pour stocker le mot de passe hashé dans la base de données, cependant cet algorithme
n'est pas recommandé pour une vraie application, il est préférable d'utiliser ":doc:`bcrypt <security>`" à la place.

Veuillez noter que plusieurs attributs public sont accessibles dans le contrôleur avec :code:`$this->flash`, :code:`$this->request` ou :code:`$this->session`.
Ceux-ci sont des servies défini dans le conteneur de service de tout à l'heure (app/config/services.php).
Quand ils sont accédés pour la première fois, ils sont insérés dans le controlleur.

Ces services sont partagés, ce qui signifie qu'on accéde à la même instance sans tenir compte de l'endroit
où on les a créés.

Par exemple, ici on créé le service de sessions et on enregistre l'identité de utilisateur dans la variable "auth":

.. code-block:: php

    <?php

    $this->session->set(
        "auth",
        [
            "id"   => $user->id,
            "name" => $user->name,
        ]
    );

Another important aspect of this section is how the user is validated as a valid one,
first we validate whether the request has been made using method POST:

.. code-block:: php

    <?php

    if ($this->request->isPost()) {

Then, we receive the parameters from the form:

.. code-block:: php

    <?php

    $email    = $this->request->getPost("email");
    $password = $this->request->getPost("password");

Now, we have to check if there is one user with the same username or email and password:

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

Note, the use of 'bound parameters', placeholders :email: and :password: are placed where values should be,
then the values are 'bound' using the parameter 'bind'. This safely replaces the values for those
columns without having the risk of a SQL injection.

If the user is valid we register it in session and forwards him/her to the dashboard:

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

If the user does not exist we forward the user back again to action where the form is displayed:

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
Le backend est une zone privé où seul les personnes enregistrés ont accès. Par conséquent il est nécessaire
de vérifier que seul les utilisateurs enregistrés ont accés à ces contrôleurs. Si vous n'êtes pas connectés
à l'application et que vous essayez d'accéder au contrôleur product, par exemple,
vous verrez le message suivant :

.. figure:: ../_static/img/invo-2.png
   :align: center

A chaque fois que quelqu'un essaye d'accéder à n'importe quel contrôleur/action, l'application va vérifier que
le rôle de l'utilisateur (en session) lui permet d'y accéder, sinon il affiche un message comme celui du dessus et
transfert le flux à la page d'accueil.

Maintenant, découvrons comment l'application fait cela. La première chose à savoir est qu'il
y a un composant appelé :doc:`Dispatcher <dispatching>`. Il est informé de la route
trouvé par le composant :doc:`Routing <routing>`. Puis, il est responsable de charger
le contrôleur approprié et d'exécuter l'action correspondante.

En temps normal, le framework créé le dispatcher automatiquement. Dans notre cas, nous voulons faire une vérification
avant d'exécuter l'action requise, vérifier si l'utilisateur y a accès ou pas. Pour faire cela, nous avons
remplacé le composant en créant une fonction dans le bootstrap (public/index.php):

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

Nous avons maintenant un contrôle complet sur le dispatcher utilisé dans notre application. Plusieurs composants du framework déclenchent
des évènements qui nous autorisent à modifier le flux interne des opérations. Comme l'injecteur de dépendances agit comme une "colle"
pour composants, un nouveau composant appelé :doc:`EventsManager <events>` nous aide à intercepter les évènements produits
par un composant routant les évènements aux listeners.

Gestion des évènements
^^^^^^^^^^^^^^^^^^^^^^
Un :doc:`EventsManager <events>` (gestionnaire d'évènement) nous permet d'attacher un ou plusieurs listeners à un type particulier d'évènement. Le type
d'évènement qui nous intéresse actuellement est le "dispatch", la code suivant filtre tous les évènements produit par le dispatcher :

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Create an events manager
            $eventsManager = new EventsManager();

            // Listen for events produced in the dispatcher using the Security plugin
            $eventsManager->attach(
                "dispatch:beforeExecuteRoute",
                new SecurityPlugin()
            );

            // Handle exceptions and not-found exceptions using NotFoundPlugin
            $eventsManager->attach(
                "dispatch:beforeException",
                new NotFoundPlugin()
            );

            $dispatcher = new Dispatcher();

            // Assign the events manager to the dispatcher
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

When an event called "beforeExecuteRoute" is triggered the following plugin will be notified:

.. code-block:: php

    <?php

    /**
     * Check if the user is allowed to access certain action using the SecurityPlugin
     */
    $eventsManager->attach(
        "dispatch:beforeExecuteRoute",
        new SecurityPlugin()
    );

When a "beforeException" is triggered then other plugin is notified:

.. code-block:: php

    <?php

    /**
     * Handle exceptions and not-found exceptions using NotFoundPlugin
     */
    $eventsManager->attach(
        "dispatch:beforeException",
        new NotFoundPlugin()
    );

Le plugin de sécurité est une classe situé dans (app/plugins/SecurityPlugin.php). Cette classe implémente une méthode
"beforeExecuteRoute". C'est le même nom qu'un des évènement produit dans le dispatcer :

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

Les évènements "hooks" reçoivent toujours un premier paramètre qui contient le contexte de l'information de l'évènement produit (:code:`$event`)
et un second paramètre qui est l'objet produit par l'évènement lui-même (:code:`$dispatcher`). Il n'est pas obligatoire
de faire étendre le plugin de la classe :doc:`Phalcon\\Mvc\\User\\Plugin <../api/Phalcon_Mvc_User_Plugin>`, mais en faisant ainsi on a un accès facilité aux services
disponibles de l'application.

Maintenant nous allons vérifier le rôle de la session courrante, vérifier si l'utilisateur a accès en utilisant les listes ACL (access control list).
S'il/elle n'a pas accès, il/elle sera redirigé(e) vers la page d'accueil comme expliqué précédemment.

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
            // Check whether the "auth" variable exists in session to define the active role
            $auth = $this->session->get("auth");

            if (!$auth) {
                $role = "Guests";
            } else {
                $role = "Users";
            }

            // Take the active controller/action from the dispatcher
            $controller = $dispatcher->getControllerName();
            $action     = $dispatcher->getActionName();

            // Obtain the ACL list
            $acl = $this->getAcl();

            // Check if the Role have access to the controller (resource)
            $allowed = $acl->isAllowed($role, $controller, $action);

            if (!$allowed) {
                // If he doesn't have access forward him to the index controller
                $this->flash->error(
                    "You don't have access to this module"
                );

                $dispatcher->forward(
                    [
                        "controller" => "index",
                        "action"     => "index",
                    ]
                );

                // Returning "false" we tell to the dispatcher to stop the current operation
                return false;
            }
        }
    }

Fournir une liste ACL
^^^^^^^^^^^^^^^^^^^^^
Dans l'exemple précédent, nous avons obtenu les ACL en utilisant la méthode :code:`$this->getAcl()`. Cette méthode est aussi
implémentée dans Plugin. Maintenant nous allons expliquer étape par étape comment nous avons construit les ACL (access control list) :

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Acl\Role;
    use Phalcon\Acl\Adapter\Memory as AclList;

    // Create the ACL
    $acl = new AclList();

    // The default action is DENY access
    $acl->setDefaultAction(
        Acl::DENY
    );

    // Register two roles, Users is registered users
    // and guests are users without a defined identity
    $roles = [
        "users"  => new Role("Users"),
        "guests" => new Role("Guests"),
    ];

    foreach ($roles as $role) {
        $acl->addRole($role);
    }

On défini les ressources pour chaque zone. Le nom des contrôleurs sont des ressources et leurs actions sont
accédées pour les ressources :

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // ...

    // Private area resources (backend)
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



    // Public area resources (frontend)
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

Les ACL ont maintenant connaissance des contrôleurs et de leurs actions. Le rôle "Users" a accès à
toutes les ressources du backend et du frontend. Le rôle "Guest" en revanche n'a accès qu'à la partie publique :

.. code-block:: php

    <?php

    // Grant access to public areas to both users and guests
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow(
                $role->getName(),
                $resource,
                "*"
            );
        }
    }

    // Grant access to private area only to role Users
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow(
                "Users",
                $resource,
                $action
            );
        }
    }

Hooray!, les ACL sont maintenant terminés. In next chapter, we will see how a CRUD is implemented in Phalcon and how you
can customize it.

.. _jinja: http://jinja.pocoo.org/
.. _sha1: http://php.net/manual/fr/function.sha1.php
