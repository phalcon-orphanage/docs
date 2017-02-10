Utilisation des Vues
====================

Les vues représentent la partie interface de votre application. Les vues sont souvent des fichiers HTML encapsulant du code PHP qui réalise des tâches
uniquement dédiées à la présentation des données. Les vues sont chargées de fournir les données au navigateur web ou tout autres outils qui est
utilisé pour soumettre des requêtes à votre application.

:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` et :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>`
sont responsables de gérer la couche vue de votre application MVC.

Intégration des Vues aux Contrrôleurs
-------------------------------------
Phalcon transmet l'exécution automatiquement au composant vue aussitôt que le contrôleur a terminé son cycle. Le composant vue recherche dans le 
dossier des vues s'il existe un dossier du même nom que le dernier contrôleur exécuté et recherche ensuite un fichier du même nom que la dernière actions
exécutée. Par exemple, si une requête est faite avec l'URL *http://127.0.0.1/blog/posts/show/301* Phalcon décompose l'URL comme suit:

+--------------------+-----------+
| Adresse du serveur | 127.0.0.1 |
+--------------------+-----------+
| Répertoire Phalcon | blog      |
+--------------------+-----------+
| Contrôleur         | posts     |
+--------------------+-----------+
| Action             | show      |
+--------------------+-----------+
| Paramètre          | 301       |
+--------------------+-----------+

Le répartiteur recherche une classe "PostsController" et une action "showAction". Voici un échantillon de contrôleur pour cet example:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($postId)
        {
            // Transmet le paramètre $postId à la vue
            $this->view->postId = $postId;
        }
    }

La méthode :code:`setVar()` nous permet de créer de variables pour les vues qui peuvent être utilisées dans les gabarits de vue. L'exemple précédent démontre
comment transmettre le paramètre :code:`$postId` au gabarit de vue respectif.

Hiérarchie de Rendu
-------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` supporte une hiérarchie de fichiers. Il est le composant par défaut pour le rendu de vues dans Phalcon.
Cette hiérarchie permet des espaces de mise en page communs (vues couramment utilisées), ainsi que des dossiers nommés par le contrôleur contenant des gabarits de vue respectifs. 

Ce composant utilise lui-même PHP comme moteur de gabarit, cependant les vues doivent avoir l'extension .phtml.
Si le répertoire des vues est *app/views* alors le composant vue trouvera automatiquement ces trois fichiers vue.

+---------------------------+-------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Nom                       | Fichier                       | Description                                                                                                                                                                                                          |
+===========================+===============================+======================================================================================================================================================================================================================+
| Vue d'action              | app/views/posts/show.phtml    | Cette vue est relative à l'action. Elle sera affichée uniquement si l'action "show" est exécutée.                                                                                                                    |
+---------------------------+-------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Disposition du contrôleur | app/views/layouts/posts.phtml | Cette vue est relative au contrôleur. Elle sera affichée pour chaque action du contrôleur "posts" que sera exécutée. Tout le code écrit dans la disposition est réutilisé pour toutes les actions dans ce contrôleur |
+---------------------------+-------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Disposition principale    | app/views/index.phtml         | Ceci est la vue principale qui sera affichée pour n'importe que action ou contrôleur exécuté au sein de l'application.                                                                                               |
+---------------------------+-------------------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Vous n'êtes pas obligé de créer tout les fichiers précédemment mentionnés. :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` se déplace simplement au
prochain niveau de vue dans la hiérarchie de fichiers. Si les trois fichiers sont présents, ils seront exécutés dans l'ordre suivant:

.. code-block:: html+php

    <!-- app/views/posts/show.phtml -->

    <h3>This is show view!</h3>

    <p>I have received the parameter <?php echo $postId; ?></p>

.. code-block:: html+php

    <!-- app/views/layouts/posts.phtml -->

    <h2>This is the "posts" controller layout!</h2>

    <?php echo $this->getContent(); ?>

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <html>
        <head>
            <title>Example</title>
        </head>
        <body>

            <h1>This is main layout!</h1>

            <?php echo $this->getContent(); ?>

        </body>
    </html>

Notez les appels à la méhode :code:`$this->getContent()`. Cette méthode indique à :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`
où il faut injecter le contenu de la précédente vue exécutée dans la hiérarchie. Pour l'exemple précédent, la sortie devrait être du style:

.. figure:: ../_static/img/views-1.png
   :align: center

Le code HTML généré par la requête sera:

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <html>
        <head>
            <title>Example</title>
        </head>
        <body>

            <h1>This is main layout!</h1>

            <!-- app/views/layouts/posts.phtml -->

            <h2>This is the "posts" controller layout!</h2>

            <!-- app/views/posts/show.phtml -->

            <h3>This is show view!</h3>

            <p>I have received the parameter 101</p>

        </body>
    </html>

Utilisation de Gabarits
^^^^^^^^^^^^^^^^^^^^^^^
Les gabarits sont des vues qui peuvent utilisées pour partager du code de vue commun. Ils agissent comme les dispositions des contrôleurs, donc il faut les placer dans le dossier des dispositions.

Les gabarits peuvent être rendus avant les dispositions (avec :code:`$this->view->setTemplateBefore()`) ou bien après (avec :code:`this->view->setTemplateAfter()`). Dans l'exemple qui suit, le gabarit (layouts/common.phtml) est rendu après la disposition principale (layouts/posts.phtml):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function initialize()
        {
            $this->view->setTemplateAfter("common");
        }

        public function lastAction()
        {
            $this->flash->notice(
                "These are the latest posts"
            );
        }
    }

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <!DOCTYPE html>
    <html>
        <head>
            <title>Blog's title</title>
        </head>
        <body>
            <?php echo $this->getContent(); ?>
        </body>
    </html>

.. code-block:: html+php

    <!-- app/views/layouts/common.phtml -->

    <ul class="menu">
        <li><a href="/">Home</a></li>
        <li><a href="/articles">Articles</a></li>
        <li><a href="/contact">Contact us</a></li>
    </ul>

    <div class="content"><?php echo $this->getContent(); ?></div>

.. code-block:: html+php

    <!-- app/views/layouts/posts.phtml -->

    <h1>Blog Title</h1>

    <?php echo $this->getContent(); ?>

.. code-block:: html+php

    <!-- app/views/posts/last.phtml -->

    <article>
        <h2>This is a title</h2>
        <p>This is the post content</p>
    </article>

    <article>
        <h2>This is another title</h2>
        <p>This is another post content</p>
    </article>

Le rendu final sera:

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <!DOCTYPE html>
    <html>
        <head>
            <title>Blog's title</title>
        </head>
        <body>

            <!-- app/views/layouts/common.phtml -->

            <ul class="menu">
                <li><a href="/">Home</a></li>
                <li><a href="/articles">Articles</a></li>
                <li><a href="/contact">Contact us</a></li>
            </ul>

            <div class="content">

                <!-- app/views/layouts/posts.phtml -->

                <h1>Blog Title</h1>

                <!-- app/views/posts/last.phtml -->

                <article>
                    <h2>This is a title</h2>
                    <p>This is the post content</p>
                </article>

                <article>
                    <h2>This is another title</h2>
                    <p>This is another post content</p>
                </article>

            </div>

        </body>
    </html>

Si nous avions utilisé :code:`$this->view->setTemplateBefore("common")`, le rendu final aurait pu être:

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <!DOCTYPE html>
    <html>
        <head>
            <title>Blog's title</title>
        </head>
        <body>

            <!-- app/views/layouts/posts.phtml -->

            <h1>Blog Title</h1>

            <!-- app/views/layouts/common.phtml -->

            <ul class="menu">
                <li><a href="/">Home</a></li>
                <li><a href="/articles">Articles</a></li>
                <li><a href="/contact">Contact us</a></li>
            </ul>

            <div class="content">

                <!-- app/views/posts/last.phtml -->

                <article>
                    <h2>This is a title</h2>
                    <p>This is the post content</p>
                </article>

                <article>
                    <h2>This is another title</h2>
                    <p>This is another post content</p>
                </article>

            </div>

        </body>
    </html>

Contrôler les Niveaux de Rendu
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Comme vu précédemment :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` supporte une hiérarchie de vue. Vous pourriez avoir besoin de contrôler le niveau de rendu
produit par le composant vue. La méthode :code:`Phalcon\Mvc\View::setRenderLevel()` offre cette fonctionnalité.

Cette méthode peut être invoquée depuis le contrôleur ou depuis une vue supérieure pour interférer avec le processus de rendu.

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function findAction()
        {
            // Ceci est une réponse Ajax et donc ne génère aucune vue
            $this->view->setRenderLevel(
                View::LEVEL_NO_RENDER
            );

            // ...
        }

        public function showAction($postId)
        {
            // Affiche seulement la vue relative à l'action
            $this->view->setRenderLevel(
                View::LEVEL_ACTION_VIEW
            );
        }
    }

Les différents niveaux de rendus possibles sont:

+-----------------------+--------------------------------------------------------------------------------+-------+
| Constante de classe   | Description                                                                    | Ordre |
+=======================+================================================================================+=======+
| LEVEL_NO_RENDER       | Indique qu'il ne faut générer aucune présentation.                             |       |
+-----------------------+--------------------------------------------------------------------------------+-------+
| LEVEL_ACTION_VIEW     | Génère la présentation de la vue associée à l'action.                          | 1     |
+-----------------------+--------------------------------------------------------------------------------+-------+
| LEVEL_BEFORE_TEMPLATE | Génère la présentation du gabarit qui précède la disposition du contrôleur.    | 2     |
+-----------------------+--------------------------------------------------------------------------------+-------+
| LEVEL_LAYOUT          | Génère la présentation de la disposition du contrôleur.                        | 3     |
+-----------------------+--------------------------------------------------------------------------------+-------+
| LEVEL_AFTER_TEMPLATE  | Génère la présentation du gabarit qui suit la disposition du contrôleur.       | 4     |
+-----------------------+--------------------------------------------------------------------------------+-------+
| LEVEL_MAIN_LAYOUT     | Génère la présentation de la disposition principale. Fichier views/index.phtml | 5     |
+-----------------------+--------------------------------------------------------------------------------+-------+

Désactiver des niveaux de rendu
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Vous pouvez désactiver de façon permanente ou temporaire des niveaux de rendu. Un niveau peut être désactivé de façon permanente s'il n'est pas du tout utilisé au sein de l'application:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    $di->set(
        "view",
        function () {
            $view = new View();

            // Désactive plusieurs niveaux
            $view->disableLevel(
                [
                    View::LEVEL_LAYOUT      => true,
                    View::LEVEL_MAIN_LAYOUT => true,
                ]
            );

            return $view;
        },
        true
    );

Ou désactivé temporairement quelque part dans l'application:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function findAction()
        {
            $this->view->disableLevel(
                View::LEVEL_MAIN_LAYOUT
            );
        }
    }

Sélection de vues
^^^^^^^^^^^^^^^^^
Comme mentionné précédemment, lorsque :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` est gérée par :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`
la vue rendue est celle qui correspond à la dernière action du dernier contrôleur exécuté. Pour pouvez surcharger ceci en utilisant la méthode :code:`Phalcon\Mvc\View::pick()`:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function listAction()
        {
            // Prend "views-dir/products/search" comme vue à rendre
            $this->view->pick("products/search");

            // Prend "views-dir/books/list" comme vue à rendre
            $this->view->pick(
                [
                    "books",
                ]
            );

            // Prend "views-dir/products/search" comme vue à rendre
            $this->view->pick(
                [
                    1 => "search",
                ]
            );
        }
    }

Désactiver la vue
^^^^^^^^^^^^^^^^^
Si votre contrôleur ne doit produire aucune sortie dans la vue (ou n'en a pas) vous pouvez désactiver le composant vue évitant ainsi un traitement inutile:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function closeSessionAction()
        {
            // Fermeture de session
            // ...

            // Désactive la vue pour éviter le rendu
            $this->view->disable();
        }
    }

Autrement vous pouvez retourner :code:`false` pour produire le même effet:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function closeSessionAction()
        {
            // ...

            // Désactive la vue pour éviter le rendu
            return false;
        }
    }

Vous pouvez retourner un objet "response" pour éviter de désactiver la vue manuellement:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function closeSessionAction()
        {
            // Fermeture de session
            // ...

            // Une redirection HTTP
            return $this->response->redirect("index/index");
        }
    }

Rendu simple
------------
:doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` est une alternative à :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`.
Il conserve l'essentiel de la philosophie de :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` à l'exclusion de la hiérarchie de fichier, 
qui en réalité est la principale fonctionnalité de sa contrepartie.

Ce composant permet au développeur de garder le contrôle quand la vue est rendue et son emplacement.
Ce plus, ce composant peut influencer sur l'héritage de vue disponible dans les moteurs de gabarit
comme :doc:`Volt <volt>` et autres.

Le composant par défaut doit être remplacé dans le conteneur de services:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View\Simple as SimpleView;

    $di->set(
        "view",
        function () {
            $view = new SimpleView();

            $view->setViewsDir("../app/views/");

            return $view;
        },
        true
    );

Le rendu automatique doit être désactivé dans :doc:`Phalcon\\Mvc\\Application <applications>` (si nécessaire):

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Mvc\Application;

    try {
        $application = new Application($di);

        $application->useImplicitView(false);

        $response = $application->handle();

        $response->send();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

Pour rendre une vue il est nécessaire d'appeler la méthode de rendu explicitement en indiquant le chemin relatif à la vue que vous souhaitez afficher:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends \Controller
    {
        public function indexAction()
        {
            // Rendu de 'views-dir/index.phtml'
            echo $this->view->render("index");

            // Rendu de 'views-dir/posts/show.phtml'
            echo $this->view->render("posts/show");

            // Rendu de 'views-dir/index.phtml' en passant des variables
            echo $this->view->render(
                "index",
                [
                    "posts" => Posts::find(),
                ]
            );

            // Rendu de 'views-dir/posts/show.phtml' en passant des variables
            echo $this->view->render(
                "posts/show",
                [
                    "posts" => Posts::find(),
                ]
            );
        }
    }

Ceci est différent de :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` dont la méthode :code:`render()` utilise des contrôleurs et des actions en paramètre:

.. code-block:: php

    <?php

    $params = [
        "posts" => Posts::find(),
    ];

    // Phalcon\Mvc\View
    $view = new \Phalcon\Mvc\View();
    echo $view->render("posts", "show", $params);

    // Phalcon\Mvc\View\Simple
    $simpleView = new \Phalcon\Mvc\View\Simple();
    echo $simpleView->render("posts/show", $params);

Utilisation de Portions (partials)
----------------------------------
Les portions (partials) de gabarit sont une autre façon de décomposer le processus de rendu en morceaux plus simple et plus gérables qui peuvent être réutilisés
dans différentes parties de l'application. Avec un fragment vous pouvez déplacer le code de rendu d'un morceau particulier vers son propre fichier.

Une manière d'utiliser les portions est de les considérer comme des routines: comme si on déplaçait les détails hors de la vue pour rendre le code plus facilement compréhensible. Prenons par exemple une vue qui ressemble à cellle-ci:

.. code-block:: html+php

    <div class="top"><?php $this->partial("shared/ad_banner"); ?></div>

    <div class="content">
        <h1>Robots</h1>

        <p>Check out our specials for robots:</p>
        ...
    </div>

    <div class="footer"><?php $this->partial("shared/footer"); ?></div>

La méthode :code:`partial()` accepte en second paramètre un tableau de variables qui n'existent que dans portée du fragment:

.. code-block:: html+php

    <?php $this->partial("shared/ad_banner", ["id" => $site->id, "size" => "big"]); ?>

Transfert de valeurs depuis le contrôleur vers les vues
-------------------------------------------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` est disponible pour chaque contrôleur en utilisant la propriété view (:code:`$this->view`). Vous
pouvez utiliser cet objet pour définir directement des variables pour la vue depuis une action de contrôleur en exploitant la méthode :code:`setVar()`.

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
            $user  = Users::findFirst();
            $posts = $user->getPosts();

            // Transmet "username" et "posts" à la vue 
            $this->view->setVar("username", $user->username);
            $this->view->setVar("posts",    $posts;

            // Avec des mutateurs magiques
            $this->view->username = $user->username;
            $this->view->posts    = $posts;

            // Transmission de plus d'une variable à la fois
            $this->view->setVars(
                [
                    "username" => $user->username,
                    "posts"    => $posts,
                ]
            );
        }
    }

Une variable avec le nom du premier paramètre de :code:`setVar()` sera créé dans la vue, prête à l'emploi. La variable peut être de n'importe quel type,
en allant de simples chaînes de caractères, des entiers, etc. vers des structures plus complexes comme des tableaux, des collections, etc. 

.. code-block:: html+php

    <h1>
        {{ username }}'s Posts
    </h1>

    <div class="post">
    <?php

        foreach ($posts as $post) {
            echo "<h2>", $post->title, "</h2>";
        }

    ?>
    </div>

Mise en cache des portions de vue
---------------------------------
Il arrive que lorsque vous développez des sites web dynamiques et que certaines parties ne soient pas très souvent mises à jour et que la sortie
soit la même pour chaque requête. :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` offre une mise en cache d'une partie ou de tout un rendu
pour améliorer les performances.

:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` s'intègre avec :doc:`Phalcon\\Cache <cache>` pour fournir un moyen facile
de mettre en cache des extraits de sortie. Vous pouvez définir un gestionnaire de cache ou bien fournir un gestionnaire global:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function showAction()
        {
            // Mise en cache de la vue avec les paramètres par défaut
            $this->view->cache(true);
        }

        public function showArticleAction()
        {
            // Mise en cache de la vue pour 1 heure
            $this->view->cache(
                [
                    "lifetime" => 3600,
                ]
            );
        }

        public function resumeAction()
        {
            // Mise en cache pour 1 jour avec la clé "resume-cache"
            $this->view->cache(
                [
                    "lifetime" => 86400,
                    "key"      => "resume-cache",
                ]
            );
        }

        public function downloadAction()
        {
            // Transmission d'un service personnalisé
            $this->view->cache(
                [
                    "service"  => "myCache",
                    "lifetime" => 86400,
                    "key"      => "resume-cache",
                ]
            );
        }
    }

Si nous ne définissons pas une clé pour le cache, le composant en crée une automatiquement en réalisant un hash MD5_ des noms du contrôleur et de la vue en cours de rendu avec le format "contrôleur/vue".
C'est une bonne habitude que de définir une clé pour chaque action ainsi vous pouvez facilement identifier le cache associé à chaque vue.

Lorsque que le composant "View" à besoin de mettre en cache quelque chose, il interroge un service de cache depuis de conteneur de services.
La convention de nom pour ce service est "viewCache":

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Output as OutputFrontend;
    use Phalcon\Cache\Backend\Memcache as MemcacheBackend;

    // Set the views cache service
    $di->set(
        "viewCache",
        function () {
            // Mise en cache pour un jour par défaut
            $frontCache = new OutputFrontend(
                [
                    "lifetime" => 86400,
                ]
            );

            // Memcached connection settings
            $cache = new MemcacheBackend(
                $frontCache,
                [
                    "host" => "localhost",
                    "port" => "11211",
                ]
            );

            return $cache;
        }
    );

.. highlights::
    Le frontend doit toujours être :doc:`Phalcon\\Cache\\Frontend\\Output <../api/Phalcon_Cache_Frontend_Output>` et le service "viewCache" doit être inscrit comme
    toujours ouvert (non partagé) dans le conteneur de services (DI).

Lors de l'utilisation de vues, le cache doit être utilisé pour prévenir que le contrôleur ne génère les données de la vue à chaque requête.

Pour réaliser ceci, nous devons identifier de façon unique chaque cache avec une clé. On vérifie d'abord que le cache n'existe pas ou bien 
a expiré avant de réaliser les calculs ou requêtes pour afficher les données dans la vue:

.. code-block:: html+php

    <?php

    use Phalcon\Mvc\Controller;

    class DownloadController extends Controller
    {
        public function indexAction()
        {
            // Vérifie que le cache avec la clé "douwnloads" existe ou a expiré
            if ($this->view->getCache()->exists("downloads")) {
                // Interroge le dernier "download"
                $latest = Downloads::find(
                    [
                        "order" => "created_at DESC",
                    ]
                );

                $this->view->latest = $latest;
            }

            // Défini le cache avec la même clé "downloads"
            $this->view->cache(
                [
                    "key" => "downloads",
                ]
            );
        }
    }

Consultez `PHP alternative site`_ pour avoir un exemple d'implémentation de cache de portions.

Moteurs de Gabarit
------------------
Les moteurs de gabarit aide les concepteurs à créer des vues sans avoir à utiliser une syntaxe compliquée. Phalcon inclut un moteur de gabarits puissant et rapide 
appelé :doc:`Volt <volt>`.

De plus, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` vous permet d'utiliser un moteur de gabarit autre que le PHP ou Volt.

L'utilisation d'un moteur de gabarit différent nécessite habituellement l'analyse de texte complexe en utilisant des librairies PHP externes afin de générer la sortie finale
pour l'utilisateur. Ceci augmente généralement le nombre de ressources nécessaires à l'application.

Si une moteur de gabarits externe est utilisé, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` fournit exactement la même hiérarchie de vue et il est 
toujours possible d'accéder à l'API depuis ces gabarits avec peu d'effort.

Ce composant utilise des adaptateurs, ce qui aide Phalcon à dialoguer avec ces moteurs de gabarit d'une manière uniforme. Voyons maintenant comment réaliser cette intégration.  

Création de votre propre Adaptateur de Moteur de Gabarit
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Il existe de nombreux moteurs de gabarits que vous pourriez avoir envie d'intégrer ou bien de créer le votre. La première étape pour commencer à intégrer un moteur de gabarit externe est de créer un adaptateur pour celui-ci.

Un adaptateur de moteur de gabarit est une classe qui fait le pont entre :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` et le moteur lui-même.
Normalement, seules deux méthodes doivent être mises en œuvre: :code:`__construct()` and :code:`render()`. La première reçoit l'instance de :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`
qui crée l'adaptateur du moteur et le conteneur DI utilisés par l'application.

La méthode :code:`render()` accepte un chemin absolu vers un fichier vue et les paramètres de la vue sont définis avec :code:`$this->view->setVar()`. Vous pouvez lire ou l'interroger
lorsque c'est nécessaire.

.. code-block:: php

    <?php

    use Phalcon\DiInterface;
    use Phalcon\Mvc\Engine;

    class MyTemplateAdapter extends Engine
    {
        /**
         * Constructeur de l'adaptateur
         *
         * @param \Phalcon\Mvc\View $view
         * @param \Phalcon\Di $di
         */
        public function __construct($view, DiInterface $di)
        {
            // Initialisez ici l'adaptateur
            parent::__construct($view, $di);
        }

        /**
         * Rendu de la vue en utilisant un moteur de gabarit
         *
         * @param string $path
         * @param array $params
         */
        public function render($path, $params)
        {
            // Accès à la vue
            $view = $this->_view;

            // Access options
            $options = $this->_options;

            // Rendu de la vue
            // ...
        }
    }

Changement de Moteur de Gabarit
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Vous pouvez remplacer complètement le moteur de gabarit ou bien en utiliser plus d'un en même temps. La méthode :code:`Phalcon\Mvc\View::registerEngines()`
accepte un tableau qui contient la définition du moteur de gabarit. La clé de chaque moteur est une extension qui aide à les distinguer entre eux.
Les fichiers gabarits rattachés à un moteur de gabarit doivent avoir la même extension.

L'ordre dans lequel chaque moteur de gabarit est défini avec :code:`Phalcon\Mvc\View::registerEngines()` défini la priorité d'exécution. 
Si :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` trouve deux fichiers vue avec le même nom mais une extension différente, seul le premier sera rendu.

Si vous souhaitez inscrire un moteur de gabarit ou plusieurs pour chaque requête de l'application, vous devez le faire lors de la création du service "view": 

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // Définition du composant vue
    $di->set(
        "view",
        function () {
            $view = new View();

            // Un séparateur de répertoire terminal est requis
            $view->setViewsDir("../app/views/");

            // Définit le moteur
            $view->registerEngines(
                [
                    ".my-html" => "MyTemplateAdapter",
                ]
            );

            // Utilisation de plusieurs moteurs de gabarit
            $view->registerEngines(
                [
                    ".my-html" => "MyTemplateAdapter",
                    ".phtml"   => "Phalcon\\Mvc\\View\\Engine\\Php",
                ]
            );

            return $view;
        },
        true
    );

Il existe plusieurs adaptateurs pour des moteurs de gabarit sur le `Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine>`_

Injection de service dans les vues
----------------------------------
Chaque vue exécutée est une instance :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`, facilitant l'accès au conteneur
de services de l'application.

L'exemple qui suit montre comment écrire une `requête Ajax`_ en utilisant une URL selon les conventions du framework.
Le service "url" (normalement :doc:`Phalcon\\Mvc\\Url <url>`) est injecté dans la vue en utilisant une propriété du même nom:

.. code-block:: html+php

    <script type="text/javascript">

    $.ajax({
        url: "<?php echo $this->url->get("cities/get"); ?>"
    })
    .done(function () {
        alert("Done!");
    });

    </script>

Composant autonome
------------------
Tous les composants dans Phalcon peuvent être utilisés comme composant *colle* individuellement parce qu'ils sont faiblement couplés entre eux:

Rendu Hiérarchique
^^^^^^^^^^^^^^^^^^
L'utilisation de :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` en autonome peut être démontré en dessous:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    $view = new View();

    // Un séparateur final de répertoires est requis
    $view->setViewsDir("../app/views/");

    // Transmission de variables aux vues, celles-ci étant créées comme des variables locales
    $view->setVar("someProducts",       $products);
    $view->setVar("someFeatureEnabled", true);

    // Début de la sortie bufferisée
    $view->start();

    // Rendu de toute la hiérarchie de vues relatives à products/list.phtml
    $view->render("products", "list");

    // Finish the output buffering
    $view->finish();

    echo $view->getContent();

Une syntaxe abrégée est également disponible:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    $view = new View();

    echo $view->getRender(
        "products",
        "list",
        [
            "someProducts"       => $products,
            "someFeatureEnabled" => true,
        ],
        function ($view) {
            // Définition d'options supplémentaires

            $view->setViewsDir("../app/views/");

            $view->setRenderLevel(
                View::LEVEL_LAYOUT
            );
        }
    );

Rendu simple
^^^^^^^^^^^^
L'utilisation de :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` dans un mode autonome est démontré ci-dessous:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View\Simple as SimpleView;

    $view = new SimpleView();

    // Un séparateur de répertoire final est nécessaire
    $view->setViewsDir("../app/views/");

    // Rendu d'une vue et retour du contenu dans une chaîne de caractères
    echo $view->render("templates/welcomeMail");

    // Rendu d'une vue en transmettant les paramètres
    echo $view->render(
        "templates/welcomeMail",
        [
            "email"   => $email,
            "content" => $content,
        ]
    );

Evénements de vues
------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` et :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` sont capables d'envoyer des événements à :doc:`EventsManager <events>` s'il existe. Les événements sont déclenchés en utilisant le type "view". Certains événements peuvent stopper l'opération courante en retournant "faux". Les événements qui suivent sont supportés:

+----------------------+------------------------------------------------------------+---------------------+
| Nom d'évt            | Déclenchement                                              | Opération stoppée ? |
+======================+============================================================+=====================+
| beforeRender         | Déclenché avant le début du processus de rendu             | Oui                 |
+----------------------+------------------------------------------------------------+---------------------+
| beforeRenderView     | Déclenché avant le rendu d'une vue existante               | Oui                 |
+----------------------+------------------------------------------------------------+---------------------+
| afterRenderView      | Déclenché après le rendu d'une vue existante               | Non                 |
+----------------------+------------------------------------------------------------+---------------------+
| afterRender          | Déclenché après le processus complet de rendu              | Non                 |
+----------------------+------------------------------------------------------------+---------------------+
| notFoundView         | Déclenché si une vue n'est pas trouvée                     | Non                 |
+----------------------+------------------------------------------------------------+---------------------+

L'exemple suivant démontre comment attacher des écouteurs à ce composant.

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Mvc\View;

    $di->set(
        "view",
        function () {
            // Création d'un gestionnaire d'événement
            $eventsManager = new EventsManager();

            // Attache un écouteur pour le type "view"
            $eventsManager->attach(
                "view",
                function (Event $event, $view) {
                    echo $event->getType(), " - ", $view->getActiveRenderPath(), PHP_EOL;
                }
            );

            $view = new View();

            $view->setViewsDir("../app/views/");

            // Liaison du eventsManager au composant vue
            $view->setEventsManager($eventsManager);

            return $view;
        },
        true
    );

L'exemple qui suit montre comment créer un plugin qui nettoie et répare le code HTML produit par le processus de rendu réalisé par Tidy_:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    class TidyPlugin
    {
        public function afterRender(Event $event, $view)
        {
            $tidyConfig = [
                "clean"          => true,
                "output-xhtml"   => true,
                "show-body-only" => true,
                "wrap"           => 0,
            ];

            $tidy = tidy_parse_string(
                $view->getContent(),
                $tidyConfig,
                "UTF8"
            );

            $tidy->cleanRepair();

            $view->setContent(
                (string) $tidy
            );
        }
    }

    // Attache le plugin comme écouteur
    $eventsManager->attach(
        "view:afterRender",
        new TidyPlugin()
    );

.. _this Github repository: https://github.com/bobthecow/mustache.php
.. _requête Ajax: http://api.jquery.com/jQuery.ajax/
.. _Tidy: http://www.php.net/manual/en/book.tidy.php
.. _md5: http://php.net/manual/en/function.md5.php
.. _PHP alternative site: https://github.com/phalcon/php-site
