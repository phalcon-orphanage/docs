.. highlights::

    Attention: cette traduction n'est pas parfaite, si des éléments vous paraissent faux ou mal expliqués, merci de modifier la documentation.

Stocker des données dans une session
====================================

Le composant de session fourni un ensemble de fonctions liés à la gestion des sessions.

Pourquoi utiliser ce composant plutôt que les sessions par défaut ?

* Vous pouvez facilement isoler des données de session à travers différentes applications du même domaine.
* Vous pouvez intercepter où les sessions sont définis/récupérés (get/set) dans votre application.
* Changer l'adaptateur de session en fonction de vos besoins.

Commencer la Session
--------------------
Certaines applications sont très dépendantes des sessions, pratiquement chaque action qui est réalisé nécessite l'accès aux données de sessions.
Il y a aussi d'autres applications qui nécessiteront moins les sessions.
Grâce au conteneur de services, on peux s'assurer que les sessions sont accessiblent seulement quand nécessaire :

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // Start the session the first time when some component request the session service
    $di->setShared(
        "session",
        function () {
            $session = new Session();

            $session->start();

            return $session;
        }
    );

Stocker/Récupérer les données en session
----------------------------------------
A partir d'un contrôleur, d'une vue ou de n'importe quel autre composant qui hérite de :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` vous pourrez
accéder aux services de session et stocker/récupérer des informations de cette manière :

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            // Set a session variable
            $this->session->set("user-name", "Michael");
        }

        public function welcomeAction()
        {
            // Check if the variable is defined
            if ($this->session->has("user-name")) {
                // Retrieve its value
                $name = $this->session->get("user-name");
            }
        }

    }

Supprimer / Détruire des sessions
---------------------------------
Il est aussi tout à fait possible de supprimer des variables spécifiques de session ou de supprimer la session entièrement :

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function removeAction()
        {
            // Remove a session variable
            $this->session->remove("user-name");
        }

        public function logoutAction()
        {
            // Destroy the whole session
            $this->session->destroy();
        }
    }

Isoler les données de sessions entre les applications
-----------------------------------------------------
Des fois un utilisateur peut utiliser la même application plusieurs fois sur le même serveur, dans la même session.
Bien sûr, si on utilise des variables de session, nous voulons que chaque application ait ses propres données (même s'ils doivent utiliser les même noms de variable).
Pour résoudre ce problème, vous pouvez ajouter un prefix pour chaque sessions de variable créé dans une certaine application :

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // Isolating the session data
    $di->set(
        "session",
        function () {
            // All variables created will prefixed with "my-app-1"
            $session = new Session(
                [
                    "uniqueId" => "my-app-1",
                ]
            );

            $session->start();

            return $session;
        }
    );

Adding a unique ID is not necessary.

Sac de Session
--------------
:doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` est un composant qui aide à séparer les données de sessions dans des "espaces de noms".
En travaillant de cette manière on peux facilement créer des groupes de sessions dans l'application. En plaçant les variables dans le "sac", cela stocke
automatiquement les données dans la session :

.. code-block:: php

    <?php

    use Phalcon\Session\Bag as SessionBag;

    $user = new SessionBag("user");

    $user->setDI($di);

    $user->name = "Kimbra Johnson";
    $user->age  = 22;


Données persistantes dans les composants
----------------------------------------
Les contrôleurs, composants et classes qui héritent de :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>` peuvent injecter un :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`.
Cette classe isole les variables pour chaque classes.
Grace à cela, vous pouvez faire durer vos données entre les requêtes de chaque classes de manière indépendantes.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            // Create a persistent variable "name"
            $this->persistent->name = "Laura";
        }

        public function welcomeAction()
        {
            if (isset($this->persistent->name)) {
                echo "Welcome, ", $this->persistent->name;
            }
        }
    }

Dans un composant :

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class Security extends Component
    {
        public function auth()
        {
            // Create a persistent variable "name"
            $this->persistent->name = "Laura";
        }

        public function getAuthName()
        {
            return $this->persistent->name;
        }
    }

Les données ajoutés à la session (:code:`$this->session`) sont disponibles à travers toute l'application, tandis qu'avec :code:`$this->persistant`, on ne peux y accéder qu'à
partir de la portée de la classe courante.

Implémenter son propre adaptateur
---------------------------------
:doc:`Phalcon\\Session\\AdapterInterface <../api/Phalcon_Session_AdapterInterface>` est une interface qui doit être implémentée pour créer ses propres adaptateurs de session
ou hériter d'adaptateurs déjà existants.

Il y a plus d'adaptateur disponibles pour ce composant dans l'`Incubator Phalcon <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter>`_
