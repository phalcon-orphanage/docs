Routage
=======

Le composant routeur vous permet de définir des routes qui correspondent à des contrôleurs ou des gestionnaires qui doivent
recevoir la requête. Un routeur analyse l'URI pour extraire cette information. Le routeur dispose de deux modes: MVC,
et correspondance seulement (match-only). Le premier mode est idéal pour travailler sur des applications MVC.

Définir des Routes
------------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` fournit des possibilité de routage avancées. En mode MVC
vous pouvez définir des routes et les faire correspondre à des contrôleurs ou des actions dont vous avez besoin. Une route est défnie comme suit:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Création du routeur
    $router = new Router();

    // Défintion d'une route
    $router->add(
        "/admin/users/my-profile",
        [
            "controller" => "users",
            "action"     => "profile",
        ]
    );

    // Une autre route
    $router->add(
        "/admin/users/change-password",
        [
            "controller" => "users",
            "action"     => "changePassword",
        ]
    );

    $router->handle();

Le premier paramètre de la méthode :code:`add()` est le motif recherché et, optionnellement, le second paramètre est un ensemble de chemins.
Dans ce cas, si l'URI est /admin/users/my-profile, alors l'action "profile" du contrôleur "users" sera exécutée.
Il faut se rappeler que le routeur n'exécute pas l'action du contrôleur, il récupère uniquement cette information
pour en informer le bon composant (par ex. :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`)
que c'est ce contrôleur ou cette action qui doit être exécutée.

Définir les routes une à une d'une application qui possède plusieurs chemins peut être une tâche pénible. Pour ces cas nous pouvons
créer des routes plus flexibles:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Création du routeur
    $router = new Router();

    // Définition de route
    $router->add(
        "/admin/:controller/a/:action/:params",
        [
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        ]
    );

Dans l'exemple précédent nous utilisons des jokers pour rendre la route valide pour plusieurs URIs. Par exemple, cette URL
(/admin/users/a/delete/dave/301) pourrait produire:

+------------+---------------+
| Contrôleur | users         |
+------------+---------------+
| Action     | delete        |
+------------+---------------+
| Paramètre  | dave          |
+------------+---------------+
| Paramètre  | 301           |
+------------+---------------+

La méthode :code:`add()` reçoit un motif qui peut optionnellement avoir des marqueurs et des expressions régulières.
Tous les modtifs de routage doivent commencer avec une barre oblique (/). La syntaxe utilisée pour les expressions régulières
est la même que les `PCRE regular expressions`_. Notez qu'il n'est pas nécessaire d'ajouter les délimiteurs d'expression régulière.
Tous les motifs de route sont insensibles à la casse.

Le second paramètre définit comment les parties reconnues sont reliées aux contrôleur/action/paramètre. Les parties à reconnaître
sont des marqueurs ou des sous-motifs délimités par des parenthèses (round brackets). Dans l'exemple donné précédemment,
le premier sous-motif correspondant (:code:`:controller`) est partie contrôleur de la route, le deuxième est l'action, et ainsi de suite.

Ces marqueurs facilite l'écriture d'expression régulière qui sont plus lisible pour le développeur et facile à comprendre.
Les marqueurs suivant sont supportés:

+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| Marqueur             | Expression régulière        | Utilisation                                                                                            |
+======================+=============================+========================================================================================================+
| :code:`/:module`     | :code:`/([a-zA-Z0-9\_\-]+)` | Correspond à un module valide contenant seulement des caractères alphanumériques                       |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:controller` | :code:`/([a-zA-Z0-9\_\-]+)` | Correspond à un contrôleur valide contenant seulement des caractères alphanumériques                   |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:action`     | :code:`/([a-zA-Z0-9\_]+)`   | Correspond à une action valide contenant seulement des caractères alphanumériques                      |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:params`     | :code:`(/.*)*`              | Correspond à une liste de mots optionnels séparés bar des slashs. A n'utiliser qu'en fin de route !    |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:namespace`  | :code:`/([a-zA-Z0-9\_\-]+)` | Correspond à un espace de nom à un seul niveau                                                         |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:int`        | :code:`/([0-9]+)`           | Correspond à un paramètre de type entier                                                               |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+

Les noms de contrôleur sont "camélisés". Ceci signifie que les caractères (:code:`-`) et (:code:`_`) sont retirés et que le caractère qui suit
est mis en majuscule. Par exemple, un_controleur est convertit en UnControleur.

Depuis que vous pouvez ajouter autant de routes que nécessaire grâce à la méthode  :code:`add()`, l'ordre d'ajout des routes indique
leur pertinence, les dernières routes ajoutés étant plus pertinentes que les premières. En interne, toutes les routes
sont parcourues dans l'ordre inverse jusqu'à ce que :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` trouve
celle qui correspond à l'URI fournie et la traite, ignorant alors le reste.

Paramètres avec des Noms
^^^^^^^^^^^^^^^^^^^^^^^^
L'exemple ci-dessous démontre comment définir des noms pour les paramètres d'une route:

.. code-block:: php

    <?php

    $router->add(
        "/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params",
        [
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1, // ([0-9]{4})
            "month"      => 2, // ([0-9]{2})
            "day"        => 3, // ([0-9]{2})
            "params"     => 4, // :params
        ]
    );

Dans l'exemple précédent, la route ne contient aucune partie "contrôler" ou "action". Ces parties sont remplacées
par des valeurs constantes ("posts" et "show"). L'utilisateur ignore quel est le contrôleur qui est réellement
concerné par la requête. Dans le contrôleur, on peut accéder à ces paramètres nommés de la manière suivante:

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
            // Get "year" parameter
            $year = $this->dispatcher->getParam("year");

            // Get "month" parameter
            $month = $this->dispatcher->getParam("month");

            // Get "day" parameter
            $day = $this->dispatcher->getParam("day");

            // ...
        }
    }

Notez que les valeurs des paramètres sont obtenues depuis le répartiteur. Ceci arrive parce que c'est
le composant qui finalement interagit avec les pilotes de votre application. De plus, il existe une autre
façon de créer des paramètres nommées à l'intérieur du motif:

.. code-block:: php

    <?php

    $router->add(
        "/documentation/{chapter}/{name}.{type:[a-z]+}",
        [
            "controller" => "documentation",
            "action"     => "show",
        ]
    );

Vous pouvez accéder aux valeurs de la même façon que précédemment:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class DocumentationController extends Controller
    {
        public function showAction()
        {
            // Get "name" parameter
            $name = $this->dispatcher->getParam("name");

            // Get "type" parameter
            $type = $this->dispatcher->getParam("type");

            // ...
        }
    }

Syntaxe courte
^^^^^^^^^^^^^^
Si vous n'aimez pas utiliser les tableaux pour définir des routes, une autre syntaxe est possible.
L'exemple suivant produit le même résultat:

.. code-block:: php

    <?php

    // Forme courte
    $router->add(
        "/posts/{year:[0-9]+}/{title:[a-z\-]+}",
        "Posts::show"
    );

    // Forme tableau
    $router->add(
        "/posts/([0-9]+)/([a-z\-]+)",
        [
           "controller" => "posts",
           "action"     => "show",
           "year"       => 1,
           "title"      => 2,
        ]
    );

Mélanger les Syntaxes Tableau et Courtes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Les syntaxes tableau et courtes peuvent être mélangées pour définir une route. Dans ce cas, notez que les paramètres nommées
sont ajoutés automatiquement aux chemins selon la position dans laquelle ils sont définis:

.. code-block:: php

    <?php

    // La première position est ignorée parce qu'elle est utilisée
    // pour le paramètre 'country'
    $router->add(
        "/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])",
        [
            "section" => 2, // Positions start with 2
            "article" => 3,
        ]
    );

Router vers des Modules
^^^^^^^^^^^^^^^^^^^^^^^
Vous pouvez définir des routes dont les chemins incluent des modules. Ceci est spécialement adapté aux application multi-modules.
Il est possible de définir une route qui inclus un joker pour le module:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router(false);

    $router->add(
        "/:module/:controller/:action/:params",
        [
            "module"     => 1,
            "controller" => 2,
            "action"     => 3,
            "params"     => 4,
        ]
    );

Dans le cas le nom de module sera toujours partie intégrante de l'URL. Par exemple, l'URL: /admin/users/edit/sonny
sera traitée comme:

+------------+---------------+
| Module     | admin         |
+------------+---------------+
| Contrôleur | users         |
+------------+---------------+
| Action     | edit          |
+------------+---------------+
| Paramètre  | sonny         |
+------------+---------------+

Ou bien vous pouvez rattacher des routes spécifiques à des modules spécifiques:

.. code-block:: php

    <?php

    $router->add(
        "/login",
        [
            "module"     => "backend",
            "controller" => "login",
            "action"     => "index",
        ]
    );

    $router->add(
        "/products/:action",
        [
            "module"     => "frontend",
            "controller" => "products",
            "action"     => 1,
        ]
    );

Ou les rattacher à des espaces de noms spécifiques:

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/login",
        [
            "namespace"  => 1,
            "controller" => "login",
            "action"     => "index",
        ]
    );

Les noms d'espace de nom et de classe doivent être transmis séparément:

.. code-block:: php

    <?php

    $router->add(
        "/login",
        [
            "namespace"  => "Backend\\Controllers",
            "controller" => "login",
            "action"     => "index",
        ]
    );

Restriction de la Méthode HTTP
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Lorsque vous ajoutez une route en utilisant simplement :code:`add()` la route est défnie pour toutes les méthodes HTTP. De temps en temps, nous pouvons restreindre une route
à une méthode en particulier. Ceci est spécialement utile lors de la création d'applications RESTful:

.. code-block:: php

    <?php

    // Cette route correspondra seulement si la méthode HTTP est GET
    $router->addGet(
        "/products/edit/{id}",
        "Products::edit"
    );

    // Cette route correspondra seulement si la méthode HTTP est POST
    $router->addPost(
        "/products/save",
        "Products::save"
    );

    // Cette route correspondra seulement si la méthode HTTP est POST ou PUT
    $router->add(
        "/products/update",
        "Products::update"
    )->via(
        [
            "POST",
            "PUT",
        ]
    );

Utilisation de Convertisseurs
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Les convertisseurs vous permettent de transformer librement les paramètres d'une route avant de les transmettre au répartiteur.
Les exemples qui suivent vous montre comment s'en servir:

.. code-block:: php

    <?php

    // Le nom de l'action autorise les tirets. Une action peut être: /products/new-ipod-nano-4-generation
    $route = $router->add(
        "/products/{slug:[a-z\-]+}",
        [
            "controller" => "products",
            "action"     => "show",
        ]
    );

    $route->convert(
        "slug",
        function ($slug) {
            // Transforme slug en supprimant les tirets
            return str_replace("-", "", $slug);
        }
    );

Un autre cas d'utilisation des convertisseurs est de relier un modèle à une route. Ceci permet de transmettre directement le modèle à l'action:

.. code-block:: php

    <?php

    // Cet exemple fonctionne en supposant que l'ID est transmis en paramètre dans l'url: /products/4
    $route = $router->add(
        "/products/{id}",
        [
            "controller" => "products",
            "action"     => "show",
        ]
    );

    $route->convert(
        "id",
        function ($id) {
            // Fetch the model
            return Product::findFirstById($id);
        }
    );

Groupe de Routes
^^^^^^^^^^^^^^^^
Si un ensemble de route a des chemins communs, ils peuvent être regroupés pour les maintenir aisément:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Router\Group as RouterGroup;

    $router = new Router();

    // Création d'un groupe avec un module et un contrôleur communs
    $blog = new RouterGroup(
        [
            "module"     => "blog",
            "controller" => "index",
        ]
    );

    // Toutes les routes commencent par /blog
    $blog->setPrefix("/blog");

    // Ajout d'une route au groupe
    $blog->add(
        "/save",
        [
            "action" => "save",
        ]
    );

    // Ajout d'une autre route au groupe
    $blog->add(
        "/edit/{id}",
        [
            "action" => "edit",
        ]
    );

    // Cette route est reliée à un autre contrôleur que celui par défaut
    $blog->add(
        "/blog",
        [
            "controller" => "blog",
            "action"     => "index",
        ]
    );

    // Ajout du groupe au routeur
    $router->mount($blog);

Vous pouvez placer les groupes de routes dans des fichiers distincts pour améliorer l'organisation et la réutilisation de code:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Group as RouterGroup;

    class BlogRoutes extends RouterGroup
    {
        public function initialize()
        {
            // Default paths
            $this->setPaths(
                [
                    "module"    => "blog",
                    "namespace" => "Blog\\Controllers",
                ]
            );

            // Toutes les routes commencent par /blog
            $this->setPrefix("/blog");

            // Ajout d'une route au groupe
            $this->add(
                "/save",
                [
                    "action" => "save",
                ]
            );

            // Ajout d'une autre route au groupe
            $this->add(
                "/edit/{id}",
                [
                    "action" => "edit",
                ]
            );

            // Cette route est reliée à un autre contrôleur que celui par défaut
            $this->add(
                "/blog",
                [
                    "controller" => "blog",
                    "action"     => "index",
                ]
            );
        }
    }

On monte le groupe dans le routeur:

.. code-block:: php

    <?php

    // Ajout du groupe au routeur
    $router->mount(
        new BlogRoutes()
    );

Correspondance de Routes
------------------------
Une URI valide doit être transmise au routeur pour qu'il puisse la traiter et trouver une route correspondante.
Par défaurt, l'URI à router est prise dans la variable :code:`$_GET['_url']` qui est créée par le module de réécriture.
Un ensemble de règles de réécriture qui fonctionne bien avec Phalcon est:

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]

Avec cette configuration, toutes les requêtes vers des fichiers ou des dossiers qui n'existent pas sont envoyés à index.php.

L'exemple suivant montre comment utiliser ce composant dans un mode autonome:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Création du routeur
    $router = new Router();

    // Définition de routes s'il y a
    // ...

    // Récupère l'URI depuis $_GET["_url"]
    $router->handle();

    // Ou en définissant l'URI directement
    $router->handle("/employees/edit/17");

    // Récupération du contrôleur trouvé
    echo $router->getControllerName();

    // Récupération de l'action trouvée
    echo $router->getActionName();

    // Récupération de la route trouvée
    $route = $router->getMatchedRoute();

Routes Nommées
--------------
Chaque route ajoutée au routeur est stockée en interne en tant qu'objet de :doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>`.
Cette classe encapsule tous les détails d'une route. Par exemple, nous pouvons donnée un nom au chemin afin de l'identifier de manière unique dans notre application.
Ceci est particulièrement utile lorsqu'il faut s'en servir pour créer des URLs.

.. code-block:: php

    <?php

    $route = $router->add(
        "/posts/{year}/{title}",
        "Posts::show"
    );

    $route->setName("show-posts");

Ensuite en utilisant par exemple le composant :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` nous pouvons contruire des routes à partir de son nom:

.. code-block:: php

    <?php

    // Retourne /posts/2012/phalcon-1-0-released
    echo $url->get(
        [
            "for"   => "show-posts",
            "year"  => "2012",
            "title" => "phalcon-1-0-released",
        ]
    );

Exemple d'utilisation
---------------------
Ce qui suit sont des exemples de routes personnalisées:

.. code-block:: php

    <?php

    // Trouve "/system/admin/a/edit/7001"
    $router->add(
        "/system/:controller/a/:action/:params",
        [
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        ]
    );

    // Trouve "/es/news"
    $router->add(
        "/([a-z]{2})/:controller",
        [
            "controller" => 2,
            "action"     => "index",
            "language"   => 1,
        ]
    );

    // Trouve "/es/news"
    $router->add(
        "/{language:[a-z]{2}}/:controller",
        [
            "controller" => 2,
            "action"     => "index",
        ]
    );

    // Trouve "/admin/posts/edit/100"
    $router->add(
        "/admin/:controller/:action/:int",
        [
            "controller" => 1,
            "action"     => 2,
            "id"         => 3,
        ]
    );

    // Trouve "/posts/2015/02/some-cool-content"
    $router->add(
        "/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)",
        [
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1,
            "month"      => 2,
            "title"      => 4,
        ]
    );

    // Trouve "/manual/en/translate.adapter.html"
    $router->add(
        "/manual/([a-z]{2})/([a-z\.]+)\.html",
        [
            "controller" => "manual",
            "action"     => "show",
            "language"   => 1,
            "file"       => 2,
        ]
    );

    // Trouve /feed/fr/le-robots-hot-news.atom
    $router->add(
        "/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}",
        "Feed::get"
    );

    // Trouve /api/v1/users/peter.json
    $router->add(
        "/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)",
        [
            "controller" => "api",
            "version"    => 1,
            "format"     => 4,
        ]
    );

.. highlights::

    Prenez garde aux caractères autorisés dans les expressions régulière pour les contrôleurs et les espaces de noms. Comme ils
    deviennent des noms de classe, ils peuvent permettre à des attaquants d'atteindre le système de fichiers et donc de lire des
    fichiers non autorisés. Une expression régulière sûre est :code:`/([a-zA-Z0-9\_\-]+)`

Comportement par Défaut
-----------------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` a un comportement par défaut qui fournit un routage très simple
qui s'attend à ce que l'URI corresponde au motif: /:controller/:action/:params

Par exemple pour une URL du style *http://phalconphp.com/documentation/show/about.html*, le routeur transformera comme suit:

+------------+---------------+
| Contrôleur | documentation |
+------------+---------------+
| Action     | show          |
+------------+---------------+
| Paramètre  | about.html    |
+------------+---------------+

Si vous ne souhaitez pas que le routeur ait ce comportement, vous devez créer le routeur en passant :code:`false` en premier paramètre:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Création du routeur sans route par défaut
    $router = new Router(false);

Définir la route par défaut
---------------------------
Quand votre application est accédée sans aucune route c'est la route '/' qui est utilisée pour déterminer quels sont les chemins à utiliser pour
afficher la page initiale de votre site web ou de votre application:

.. code-block:: php

    <?php

    $router->add(
        "/",
        [
            "controller" => "index",
            "action"     => "index",
        ]
    );

Chemins Introuvables
--------------------
Si aucune des routes spécifiées au routeur ne correspond, vous pouvez définir un groupe de chemin pour ce type de scénario;

.. code-block:: php

    <?php

    // Set 404 paths
    $router->notFound(
        [
            "controller" => "index",
            "action"     => "route404",
        ]
    );

Ceci est typiquement pour une page d'Erreur 404.

Etablir des chemins par défaut
------------------------------
Il est possible de définir des valeurs par défaut pour le module, le contrôleur ou l'action. Lorqu'il manque une route,
n'importe lequel des ces chemin peut être automatiquement complété par le routeur:

.. code-block:: php

    <?php

    // Définition d'un défaut spécifique
    $router->setDefaultModule("backend");
    $router->setDefaultNamespace("Backend\\Controllers");
    $router->setDefaultController("index");
    $router->setDefaultAction("index");

    // Avec un tableau
    $router->setDefaults(
        [
            "controller" => "index",
            "action"     => "index",
        ]
    );

Traitement des slashs terminaux
-------------------------------
Il arrive qu'une route soit accédée avec des slashs terminaux.
Ces slashs en trop peuvent provoquer un état de non-trouvé dans le répartiteur.
Vous pouvez paramétrer le routeur pour qu'il retire automatiquement les slashs qui se trouvent à la fin d'une route:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    // Retrait automatique des slashs terminaux
    $router->removeExtraSlashes(true);

Ou bien, vous pouvez modifier des routes en particulier pour qu'elles acceptent des slashs terminaux:

.. code-block:: php

    <?php

    // The [/]{0,1} autorise cette route de terminer éventuellement avec un slash
    $router->add(
        "/{language:[a-z]{2}}/:controller[/]{0,1}",
        [
            "controller" => 2,
            "action"     => "index",
        ]
    );

Rappel sur Correspondance
--------------------------
De temps en temps, des routes ne peuvent correspondre que si elle remplissent certaines conditions.
Vous pouvez ajouter des conditions arbitraires aux routes en utilisant la fonction de rappel :code:`beforeMatch()`.
Si la fonction retourne :code:`false`, la route sera considérée comme ne pas correspondre:

.. code-block:: php

    <?php

    $route = $router->add("/login",
        [
            "module"     => "admin",
            "controller" => "session",
        ]
    );

    $route->beforeMatch(
        function ($uri, $route) {
            // Vérifie qu'il s'agit d'une requête Ajax
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") {
                return false;
            }

            return true;
        }
    );

Vous pouvez réutiliser des conditions complémentaires dans des classes:

.. code-block:: php

    <?php

    class AjaxFilter
    {
        public function check()
        {
            return $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";
        }
    }

Et exploiter cette classe au lieu d'une fonction anonyme:

.. code-block:: php

    <?php

    $route = $router->add(
        "/get/info/{id}",
        [
            "controller" => "products",
            "action"     => "info",
        ]
    );

    $route->beforeMatch(
        [
            new AjaxFilter(),
            "check"
        ]
    );

Depuis Phalcon 3, il existe une autre façon de vérifier:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
        ]
    );

    $route->beforeMatch(
        function ($uri, $route) {
            /**
             * @var string $uri
             * @var \Phalcon\Mvc\Router\Route $route
             * @var \Phalcon\DiInterface $this
             * @var \Phalcon\Http\Request $request
             */
            $request = $this->getShared("request");

            // Vérifie qu'il s'agit d'une requête Ajax
            return $request->isAjax();
        }
    );
            
Contraintes de Nom d'Hôte
-------------------------
Le routeur vous permet d'établir des contraintes selon le nom de l'hôte, ceci signifie que des routes spécifiques ou des groupes de routes
peuvent être restreintes seulement si la route satisfait la contrainte du nom d'hôte;

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
            "action"     => "login",
        ]
    );
    
	$route->setHostName("admin.company.com");

Le nom d'hôte peut également être transmis sous forme d'expression régulière:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
            "action"     => "login",
        ]
    );

    $route->setHostName("([a-z]+).company.com");

Vous pouvez faire en sorte qu'une contrainte de nom d'hôte s'applique à toutes les routes d'un groupe de routes:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Group as RouterGroup;

    // Création d'un groupe avec un module et un contrôleur communs
    $blog = new RouterGroup(
        [
            "module"     => "blog",
            "controller" => "posts",
        ]
    );

    // Restriction sur le nom de l'hôte
    $blog->setHostName("blog.mycompany.com");

    // Toutes les routes commencent par /blog
    $blog->setPrefix("/blog");

    // Route par défaut
    $blog->add(
        "/",
        [
            "action" => "index",
        ]
    );

    // Ajout d'une route au groupe
    $blog->add(
        "/save",
        [
            "action" => "save",
        ]
    );

    // Ajout d'un autre route au groupe
    $blog->add(
        "/edit/{id}",
        [
            "action" => "edit",
        ]
    );

    // Ajout du groupe au routeur
    $router->mount($blog);

Sources d'URI
-------------
Par défaut l'URI est extraite de la variable :code:`$_GET['_url']` qui est transmise à Phalcon par le moteur de réécriture.
Vous pouvez également utiliser :code:`$_SERVER['REQUEST_URI']` si c'est nécessaire:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // ...

    // Use $_GET["_url"] (default)
    $router->setUriSource(
        Router::URI_SOURCE_GET_URL
    );

    // Use $_SERVER["REQUEST_URI"]
    $router->setUriSource(
		Router::URI_SOURCE_SERVER_REQUEST_URI
    );

Ou bien vous pouvez transmettre manuellement l'URI à la méthode :code:`handle()`:

.. code-block:: php

    <?php

    $router->handle("/some/route/to/handle");

Test de vos routes
------------------
Tant que le composant n'a pas de dépendances, vous pouvez créer un fichier comme montré ci-dessous pour tester vos routes:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // Ces routes simulent de vrai URIs
    $testRoutes = [
        "/",
        "/index",
        "/index/index",
        "/index/test",
        "/products",
        "/products/index/",
        "/products/show/101",
    ];

    $router = new Router();

    // Ajoutez ici vos propres routes
    // ...

    // Test de chaque route
    foreach ($testRoutes as $testRoute) {
        // Gestion de la route
        $router->handle($testRoute);

        echo "Testing ", $testRoute, "<br>";

        // Vérifie que chaque route corresponde
        if ($router->wasMatched()) {
            echo 'Contrôleur: ', $router->getControllerName(), '<br>';
            echo 'Action: ', $router->getActionName(), '<br>';
        } else {
            echo 'La route n\'a pas de correspondance<br>';
        }

        echo "<br>";
    }

Annotations du Routeur
----------------------
Ce composant fournit une variante du service :doc:`annotations <annotations>`. Avec cette stratégie vous
pouvez écrire les routes directement dans les contrôleurs plutôt que les ajouter dans le service d'inscription:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

    $di["router"] = function () {
        // Utilise les annotations du routeur. Nous passons 'faux' si nous ne voulons pas que le routeur ajoute son motif par défaut
        $router = new RouterAnnotations(false);

        // Lecture des annotations depuis ProductsController si l'URI commence par /api/products
        $router->addResource("Products", "/api/products");

        return $router;
    };

Les annotations peuvent être écrites de la façon suivante:

.. code-block:: php

    <?php

    /**
     * @RoutePrefix("/api/products")
     */
    class ProductsController
    {
        /**
         * @Get(
         *     "/"
         * )
         */
        public function indexAction()
        {

        }

        /**
         * @Get(
         *     "/edit/{id:[0-9]+}",
         *     name="edit-robot"
         * )
         */
        public function editAction($id)
        {

        }

        /**
         * @Route(
         *     "/save",
         *     methods={"POST", "PUT"},
         *     name="save-robot"
         * )
         */
        public function saveAction()
        {

        }

        /**
         * @Route(
         *     "/delete/{id:[0-9]+}",
         *     methods="DELETE",
         *     conversors={
         *         id="MyConversors::checkId"
         *     }
         * )
         */
        public function deleteAction($id)
        {

        }

        public function infoAction($id)
        {

        }
    }

Seules les méthodes marquées par une annotation valide sont utilisées comme routes. Voyez la liste des annotations supportées:

+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Nom          | Description                                                                                                    | Exemple de déclaration                                                     |
+==============+================================================================================================================+============================================================================+
| RoutePrefix  | Un préfixe qui sera placé devant chaque route URI. Cette annotation est à placer dans le docblock de la classe | :code:`@RoutePrefix("/api/products")`                                      |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Route        | Cette annotation associe une méthode à une route. Cette annotation est à placer dans le docblock d'une méthode | :code:`@Route("/api/products/show")`                                       |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Get          | Cette annotation associe une méthode à une route avec une restriction sur la méthode HTTP GET                  | :code:`@Get("/api/products/search")`                                       |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Post         | Cette annotation associe une méthode à une route avec une restriction sur la méthode HTTP POST                 | :code:`@Post("/api/products/save")`                                        |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Put          | Cette annotation associe une méthode à une route avec une restriction sur la méthode HTTP PUT                  | :code:`@Put("/api/products/save")`                                         |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Delete       | Cette annotation associe une méthode à une route avec une restriction sur la méthode HTTP DELETE               | :code:`@Delete("/api/products/delete/{id}")`                               |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Options      | Cette annotation associe une méthode à une route avec une restriction sur la méthode HTTP OPTIONS              | :code:`@Option("/api/products/info")`                                      |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

Pour les annotations qui ajoutent des routes, les paramètres suivants sont supportés:

+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Nom          | Description                                                                                                    | Exemple de déclaration                                                     |
+==============+================================================================================================================+============================================================================+
| methods      | Définit une ou plusieurs méthodes HTPP que la route doit respecter                                             | :code:`@Route("/api/products", methods={"GET", "POST"})`                   |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| name         | Définit le nom d'une route                                                                                     | :code:`@Route("/api/products", name="get-products")`                       |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| paths        | Un tableau de chemins identiques à ceux passés à :code:`Phalcon\Mvc\Router::add()`                             | :code:`@Route("/posts/{id}/{slug}", paths={module="backend"})`             |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| conversors   | Un ensemble de convertisseurs qui s'appliquent aux paramètres                                                  | :code:`@Route("/posts/{id}/{slug}", conversors={id="MyConversor::getId"})` |
+--------------+----------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

Si vous utilisez des modules dans votre application, il vaut mieux utiliser la méthode :code:`addModuleResource()`:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

    $di["router"] = function () {
        // Utilise les annotations de routage
        $router = new RouterAnnotations(false);

        // Lecture des annotations depuis Backend\Controllers\ProductsController si l'URI commence par /api/products
        $router->addModuleResource("backend", "Products", "/api/products");

        return $router;
    };

Inscription d'une Instance de Routeur
-------------------------------------
Vous pouvez inscrire le routeur lors de la procédure d'inscription du service dans l'injecteur de dépdendance de Phalcon pour le rendre disponible aux contrôleurs.

Vous devez ajouter le code suivant dans votre fichier d'amorce (par exemple index.php ou app/config/services.php si vous utilisez `Phalcon Developer Tools <http://phalconphp.com/en/download/tools>`_)

.. code-block:: php

    <?php

    /**
     * Ajout de la capacité de routage
     */
    $di->set(
        "router",
        function () {
            require __DIR__ . "/../app/config/routes.php";

            return $router;
        }
    );

Vous devrez créer app/config/routes.php et d'ajouter du code d'initialisation du routeur, comme par exemple:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    $router->add(
        "/login",
        [
            "controller" => "login",
            "action"     => "index",
        ]
    );

    $router->add(
        "/products/:action",
        [
            "controller" => "products",
            "action"     => 1,
        ]
    );

    return $router;

Ecriture de votre propre Routeur
--------------------------------
L'interface :doc:`Phalcon\\Mvc\\RouterInterface <../api/Phalcon_Mvc_RouterInterface>` doit être implémentée pour créer un routeur en remplacement 
de celui fournit par Phalcon.

.. _PCRE regular expressions: http://php.net/manual/fr/book.pcre.php
