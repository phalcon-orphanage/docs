Tutoriel 2: Introducing INVO
============================
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

In next chapter, we will see how to authentication and authorization is implemented in INVO.

.. _Github: https://github.com/phalcon/invo
.. _Twitter Bootstrap: http://twitter.github.io/bootstrap/
