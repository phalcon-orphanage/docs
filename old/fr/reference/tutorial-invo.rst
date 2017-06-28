Tutoriel 2: Présentation d'INVO
===============================

Dans ce second tutoriel, nous allons découvrir une application plus complète de manière à approfondir le développement de Phalcon.
INVO est l'une des applications que nous avons créé en tant qu'exemple. INVO est un petit site web qui permet aux utilisateurs
de générer des factures et faire d'autres tâches comme gérer les clients et ses produits. Vous pouvez cloner son code à partir de Github_.

INVO utilise aussi `Bootstrap`_ comme framework côté client. Même si l'application ne génère pas
de factures, cela donne un exemple pour aider à comprendre comment le framework fonctionne.

Structure du projet
-------------------
Une fois que vous avez cloné le projet, à partir de la racine, vous verrez la structure suivante :

.. code-block:: bash

    invo/
        app/
            config/
            controllers/
            forms/
            library/
            logs/
            models/
            plugins/
            views/
        cache/
            volt/
        docs/
        public/
            css/
            fonts/
            js/
        schemas/

Comme vous l'avez vu précédemment, Phalcon n'impose pas de structure particulière pour développer une application. Ce projet
fournit une simple structure MVC et un document racine public.

Une fois l'application ouverte dans votre navigateur à l'adresse : http://localhost/invo vous verrez quelque chose comme ceci :

.. figure:: ../_static/img/invo-1.png
   :align: center

Cette application est divisée en deux parties, un frontal, qui est une partie publique où les visiteurs peuvent obtenir des informations
à propos d'INVO et des informations de contact. La seconde partie est le backend, une zone administrative où un
utilisateur enregistré peut gérer ses produits et ses clients.

Routage
-------
INVO utilise le routage standard qui est construit avec le composant Router. Ces routes correspondent au motif
suivant : /:controller/:action/:params. Ceci signifie que la première partie de l'URI est le contrôleur, la seconde est
l'action et ensuite viennent les paramètres.

La route suivante `/session/register` exécute le controlleur SessionController et son action registerAction.

Configuration
-------------
INVO a un fichier de configuration qui définit les paramètres génèraux de l'application. Ce fichier
est lu par les premières lignes du fichier d'amorce (public/index.php) :

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    // ...

    // Lecture de la configuration
    $config = new ConfigIni(
        APP_PATH . "app/config/config.ini"
    );

:doc:`Phalcon\\Config <config>` nous permet de manipuler le fichier comme un objet. 
Dans cet exemple, nous utilisons un fichier ini pour la configuration, cependant ils existe d'autres adaptateurs 
pour les fichiers de configuration. Le fichier de configuration contient les paramètres suivants :

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = app/controllers/
    modelsDir      = app/models/
    viewsDir       = app/views/
    pluginsDir     = app/plugins/
    formsDir       = app/forms/
    libraryDir     = app/library/
    baseUri        = /invo/

Phalcon n'a pas de convention de codage prédéfinie. Les sections nous permettent d'organiser les options de manière appropriée.
Dans ce fichier il y a deux sections "application" et "database" que nous utiliserons plus tard.

Chargeurs automatiques
----------------------
La seconde partie du fichier d'amorce (public/index.php) est le chargeur automatique:

.. code-block:: php

    <?php

    /**
     * Configuration de chargement automatique
     */
    require APP_PATH . "app/config/loader.php";

Le chargeur automatique consigne un ensemble de dossiers dans lesquels l'application
cherchera les classes dont il aura éventuellement besoin.

.. code-block:: php

    <?php

    $loader = new Phalcon\Loader();

    // Nous consignons un ensemble de répertoire pris dans le fichier de configuration
    $loader->registerDirs(
        [
            APP_PATH . $config->application->controllersDir,
            APP_PATH . $config->application->pluginsDir,
            APP_PATH . $config->application->libraryDir,
            APP_PATH . $config->application->modelsDir,
            APP_PATH . $config->application->formsDir,
        ]
    );

    $loader->register();

Notez que le code ci-dessous consigne des dossiers qui sont définis dans le fichier de configuration. 
Le seul dossier qui n'est pas enregistré est viewsDir parce qu'il ne contient pas de classes mais des fichiers de type HTML + PHP.
Notez aussi que nous avons utilisé une constante nommée APP_PATH. Cette constante est définie dans l'amorce 
(public/index.php) ce qui nous permet de garder une référence sur la racine de notre projet:

.. code-block:: php

    <?php

    // ...

    define(
        "APP_PATH",
        realpath("..") . "/"
    );

Inscription de services
-----------------------
Un autre fichier qui est requis dans l'amorce est (app/config/services.php). Ce fichier nous permet
d'organiser les services que INVO doit utiliser.

.. code-block:: php

    <?php

    /**
     * Chargement des services de l'application
     */
    require APP_PATH . "app/config/services.php";

L'inscription de service est réalisée comme dans le tutoriel précédents, avec l'utilisation de closures pour
un chargement paresseux des composants requis:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url as UrlProvider;

    // ...

    /**
     * Le composant URL sert à générer toutes sortes d'URL dans l'application
     */
    $di->set(
        "url",
        function () use ($config) {
            $url = new UrlProvider();

            $url->setBaseUri(
                $config->application->baseUri
            );

            return $url;
        }
    );

Nous approfondirons l'étude de ce fichier plus tard.

Gestion de la requête
---------------------
Si nous sautons à la fin du fichier (public/index.php), la requête est finalement gérée par :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
qui initialise et exécute tout ce qui est nécessaire pour faire tourner l'application:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // ...

    $application = new Application($di);

    $response = $application->handle();

    $response->send();

Injection de dépendances
------------------------
Regardez à la première ligne du code ci-dessus, le constructeur de la classe Application reçoit la variable 
:code:`$di` en argument. Quel est le rôle de cette variable ? Phalcon est un framework fortement découplé,
donc on a besoin d'un composant qui agit comme un ciment pour que tout fonctionne ensemble. Ce composant est :doc:`Phalcon\\Di <../api/Phalcon_Di>`.
C'est un conteneur de services qui réalise aussi des injections de dépendance et la localisation de service, 
instanciant tous les composants nécessaires à l'application.

Il y a différents moyens d'inscrire des services dans le conteneur. Dans INVO la plupart des services sont enregistrés en utilisant
des fonctions anonymes. Grâce à cela, les objets sont instanciés paresseusement (= uniquement lorsque nécessaire), ce qui réduit les ressources requises
par l'application.

Par exemple, dans l'extrait suivant, le service de session est inscrit, la fonction anonyme sera
appelée uniquement lorsque l'application aura besoin d'accéder aux données de la session:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as Session;

    // ...

    // Démarre la session à la première demande au composant
    $di->set(
        "session",
        function () {
            $session = new Session();

            $session->start();

            return $session;
        }
    );

Ici, nous avons la possibilité de changer l'adaptateur, de faire des initialisation supplémentaires ainsi que beaucoup d'autres choses.
Notez que le service est inscrit avec le nom "session", c'est une convention qui va permettre au framework d'identifier
le service actif dans le conteneur de service.

Une requête peut utiliser plusieurs services et inscrire chaque services un par un peux être une tâche pénible. Pour cette raison
le framework fournit une variante à :doc:`Phalcon\\Di <../api/Phalcon_Di>` appelée :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` qui a pour mission d'enregistrer
tous les services, fournissant ainsi un framework complet.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    // ...

    // The FactoryDefault Dependency Injector automatically registers the
    // right services providing a full-stack framework
    $di = new FactoryDefault();

Cet extrait inscrit la majorité des services avec les composants fournis par le framework. Si on a besoin de surcharger
la définition de certains services on pourrait le redéfinir comme on l'a fait pour "session" ou "url". 
C'est la raison d'être de la variable :code:`$di`.

Dans le chapitre suivant, nous verrons comment l'authentification et l'autorisations sont mis en œuvre dans INVO.

.. _Github: https://github.com/phalcon/invo
.. _Bootstrap: http://getbootstrap.com/
