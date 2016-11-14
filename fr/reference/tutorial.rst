Tutoriel 1: Apprenons par l'exemple
====================================
Au travers de ce premier tutoriel nous allons vous emmener dans la création d'une application avec un simpe formulaire
d'inscription en partant de zéro. Nous expliquerons les aspects élémentaire du comportement du framework. Si vous êtes 
intéressés par des outils de génération de code pour Phalcon, allez voir :doc:`outils pour développeur <tools>`.

La meilleure façon d'utiliser ce guide est de le suivre étape par étape. Vous pouvez récupérer 
le code complet `ici <https://github.com/phalcon/tutorial>`_.

Structure des fichiers
----------------------
Phalcon n'impose pas une structure particulière des fichiers pour le développement d'application. Comme il est
faiblement couplé vous pouvez réaliser de puissantes applications avec une structure de fichiers qui vous convienne.

Pour les besoins de ce tutoriel et comme point de départ, nous suggérons cette simple structure:

.. code-block:: php

    tutorial/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/

Notez que nous n'avons pas besoin d'un dossier "library" en rapport avec Phalcon. Ce framework est disponible en mémoire 
prêt à l'emploi.

Avant de poursuivre, soyez certains d'avoir installé Phalcon avec succès et configuré un serveur parmi :doc:`Nginx <nginx>`, :doc:`Apache <apache>` ou :doc:`Cherokee <cherokee>`.

Amorce
------
Le premier fichier que nous devons créer est le fichier d'amorce. Ce fichier est vraiment important; comme il sert
de base à votre application, il vous donne le contrôle sur tous ses aspects. Dans ce fichier vous pouvez y mettre
l'initialisation des composants ainsi que définir le comportement de l'application.

Il est responsable de trois choses:

1. Préparer le chargeur automatique
2. Configurer l'injecteur de dépendances (DI).
3. Gérer les requête à l'application.

Chargement automatique
^^^^^^^^^^^^^^^^^^^^^^
La première chose que nous trouvons dans l'amorce est l'inscription d'un chargeur automatique. Ceci permet de charger les classes des contrôleurs et des modèles de l'application. Par exemple vous pouvez inscrire un ou plusieurs répertoire de contrôleurs améliorant ainsi la flexibilité de l'application. Dans notre exemple nous avons utilisé le composant :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`.

Grâce à ceci, nous pouvons charger les classes selon différentes stratégies, mais pour cet exemple, nous avons choisi de placer les classes dans des dossiers prédéfinis:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // ...

    $loader = new Loader();

    $loader->registerDirs(
        [
            "../app/controllers/",
            "../app/models/",
        ]
    );

    $loader->register();

Gestion de dépendance
^^^^^^^^^^^^^^^^^^^^^
Un concept très important qui doit être compris avec Phalcon est son :doc:`conteneur d'injection de dépendances <di>`. Cela peut sembler compliqué mais il est en réalité très simple et pratique.

Un conteneur de service est un sac où nous stockons généralement les services que votre application doit utiliser pour fonctionner. A chaque fois que le framework a besoin d'un composant, il interroge le conteneur en utilisant une convention de nommage pour le service. Comme Phalcon est un framework fortement découplé, agît comme un ciment facilitant l'intégration des différents composants en parvenant à les faire travailler ensemble d'une façon transparente.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    // ...

    // Create a DI
    $di = new FactoryDefault();

:doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` est une variante de :doc:`Phalcon\\Di <../api/Phalcon_Di>`. Afin de faciliter les choses,
la plupart des composants fournis avec Phalcon sont inscrits. Ainsi nous n'aurons pas à les inscrire un par un.
Nous verrons plus tard qu'il n'y a aucun problème à remplacer un service d'usine.

Dans la partie suivante, nous inscrivons le service "view" en indiquant au framework le répertoire où il trouvera les définitions de vues.
Comme les vues ne correspondent pas à des classes elles ne peuvent pas prises en compte par le chargeur automatique.

Les service peuvent être inscrits de plusieurs façon, mais dans ce tutoriel nous utiliserons une `fonction anonyme`_:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // ...

    // Configuration du composant vue
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../app/views/");

            return $view;
        }
    );

Ensuite nous inscrivons une URI de base afin que toutes les URIs générées par Phalcon incluent le dossier "tutorial" que nous avions défini préalablement.
Ceci deviendra important plus loin dans ce tutoriel lorsque nous utiliserons la classe :doc:`Phalcon\\Tag <../api/Phalcon_Tag>` 
pour créer des hyperliens.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url as UrlProvider;

    // ...

    // Définition d'une URI de base afin que les URIs générées incluent le dossier "tutorial"
    $di->set(
        "url",
        function () {
            $url = new UrlProvider();

            $url->setBaseUri("/tutorial/");

            return $url;
        }
    );

Traitement des requêtes
^^^^^^^^^^^^^^^^^^^^^^^
Dans la dernière partie de ce fichier nous trouvons :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. Son rôle
est de préparer l'environnement pour les requêtes, de router les requêtes entrante et de répartir entre les différentes actions trouvées;
il assemble les réponses et les retourne dès que le processus est complet.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // ...

    $application = new Application($di);

    $response = $application->handle();

    $response->send();

Tout mettre ensemble
^^^^^^^^^^^^^^^^^^^^
Le fichier tutorial/public/index.php doit ressembler à ceci:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Mvc\Url as UrlProvider;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;



    // Inscription du chargeur automatique
    $loader = new Loader();

    $loader->registerDirs(
        [
            "../app/controllers/",
            "../app/models/",
        ]
    );

    $loader->register();



    // Création du DI
    $di = new FactoryDefault();

    // Configuration du composant vue
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../app/views/");

            return $view;
        }
    );

    // Définition d'une URI de base afin que les URIs générées incluent le dossier "tutorial"
    $di->set(
        "url",
        function () {
            $url = new UrlProvider();

            $url->setBaseUri("/tutorial/");

            return $url;
        }
    );



    $application = new Application($di);

    try {
        // Gestion de la requête
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Comme vous pouvez le voir, le fichier d'amorce est vraiment court et ne nécessite pas l'inclusion de fichier supplémentaire. Nous avons
réalisé une application MVC en moins de 30 lignes de code.

Création d'un contrôleur
------------------------
Par défaut Phalcon recherche un contrôleur nommé "Index". Ceci est le point de départ lorqu'aucun contrôleur ou 
action est transmise dans la requête. Ce contrôleur index (app/controllers/IndexController.php) ressemble à:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {
            echo "<h1>Hello!</h1>";
        }
    }

Les classes contrôleur doit avoir le suffixe "Controller" et les actions du contrôleur doivent avoir le suffixe "Action". Si vous accédez à l'application depuis votre navigateur, vous devez quelque chose comme:

.. figure:: ../_static/img/tutorial-1.png
    :align: center

Félicitations ! Vous volez avec Phalcon !

Sortie vers une vue
-------------------
Les sorties à l'écran depuis le contrôleur est parfois nécessaire mais indésirable comme l'attestent la plupart des puristes de la communité MVC. Tout doit être transmis à la vue qui est responsable de l'affichage des données à l'écran. Phalcon recherche une vue qui porte le même nom que la dernière action exécutée dans un répertoire qui porte le nom du dernier contrôleur exécuté. Dans notre cas (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";

Notre contrôleur (app/controllers/IndexController.php) contient maintenant une définition d'action vide:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {

        }
    }

La sortie dans le navigateur doit rester la même. Le composant statique :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` est automatiquement créé à la fin de l'exécution de l'action. Apprenez plus sur :doc:`l'utilisation des vues ici <views>`.

Conception du formulaire d'inscription
--------------------------------------
Modifions maintenant le fichier vue index.phtml afin d'ajouter un lien vers un nouveau contrôleur appelé "signup". L'objectif est de permettre aux utlisateurs de s'inscrire dans notre application.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo PHP_EOL;

    echo PHP_EOL;

    echo $this->tag->linkTo(
        "signup",
        "Sign Up Here!"
    );

Le code HTML généré affiche une balise ancre HTML ("a") désignant un nouveau contrôleur:

.. code-block:: html

    <h1>Hello!</h1>

    <a href="/tutorial/signup">Sign Up Here!</a>

Pour générer la balise nous utilisons la classe :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`. C'est une classe utilitaire qui nous 
permet de construire des balises HTML en respectant les conventions du framework. Comme cette classe est également un service inscrite dans le DI
nous utilisons :code:`$this->tag` pour y accéder.

Un article plus détaillé concernant la génération HTML peut être :doc:`trouvée ici <tags>`

.. figure:: ../_static/img/tutorial-2.png
    :align: center

Voici le contrôleur Signup (app/controllers/SignupController.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }
    }

L'action index vide permet un passage propre à la vue qui contient la définition du formulaire (app/views/signup/index.phtml):

.. code-block:: html+php

    <h2>
        Sign up using this form
    </h2>

    <?php echo $this->tag->form("signup/register"); ?>

        <p>
            <label for="name">
                Name
            </label>

            <?php echo $this->tag->textField("name"); ?>
        </p>

        <p>
            <label for="email">
                E-Mail
            </label>

            <?php echo $this->tag->textField("email"); ?>
        </p>



        <p>
            <?php echo $this->tag->submitButton("Register"); ?>
        </p>

    </form>

L'affichage du formulaire dans votre navigateur devrait montrer quelque chose comme:

.. figure:: ../_static/img/tutorial-3.png
    :align: center

:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` fournit des méthodes utiles à la constructions des élément de formulaire.

La méthode :code:`Phalcon\Tag::form()` ne reçoit qu'un seul paramètre par instance qui est une URI relative vers un contrôleur/action
dans l'application.

En cliquant sur le bouton "Send" vous remarquerez une exception levée par le framework, indiquant que nous avons oublié l'action "register" dans le contrôleur "signup". Notre fichier public/index.php lève cette exception:

    Exception: Action "register" was not found on handler "signup"

Le fait de réaliser cette méthode supprimera cette exception:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }

        public function registerAction()
        {

        }
    }

Si vous cliquez à nouveau sur le bouton "Send", vous tomberez sur une page blanche. Le nom et l'email fournis en entrée par l'utilisateur devrait être stocké en base. Selon les conventions MVC, les interactions avec la base de données sont faites dans les modèles afin d'assurer un code orienté objet propre.

Création d'un modèle
--------------------
Phalcon apporte le premier ORM pour PHP entièrement écrit en langage C. Au lieu d'augmenter la complexité du développement, il le simplifie.

Avant de créer notre premier modèle, nous avons besoin de créer une table dans une base de données de la rattacher. Un simple table pour stocker les utilisateurs inscrits peut être définie ainsi:

.. code-block:: sql

    CREATE TABLE `users` (
        `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
        `name`  varchar(70)          NOT NULL,
        `email` varchar(70)          NOT NULL,

        PRIMARY KEY (`id`)
    );

Le modèle doit être placé dans le répertoire app/models (app/models/Users.php). Le modèle est rattaché à la table "users":

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Users extends Model
    {
        public $id;

        public $name;

        public $email;
    }

Définition de la connexion à la base de données
-----------------------------------------------
Afin de pouvoir utiliser une connexion à une base de donnée et d'accéder aux données grâce aux modèles, nous devons le spécifier dans notre processus d'amorçage. Une connexion à la base de données est juste un autre service de notre application qui peut être utilisé par de nombreux composants:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // Définition du service de base de données
    $di->set(
        "db",
        function () {
            return new DbAdapter(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "test_db",
                ]
            );
        }
    );

Avec les bons paramètres de base, notre modèle est prêt à fonctionner et à interagir avec le reste de l'application.

Stockage de données avec les modèles
------------------------------------
La prochaine étape est la réception des données provenant du formulaire et le stockage dans la table.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }

        public function registerAction()
        {
            $user = new Users();

            // Stocke et vérifie les erreurs
            $success = $user->save(
                $this->request->getPost(),
                [
                    "name",
                    "email",
                ]
            );

            if ($success) {
                echo "Thanks for registering!";
            } else {
                echo "Sorry, the following problems were generated: ";

                $messages = $user->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }

            $this->view->disable();
        }
    }

Nous créons une instance de la classe Users qui correspond à un enregistrement User. Les propriétés publiques de la classe sont reliés aux champs de l'enregistrement
dans la table users. Le fait de définir les valeurs appropriées dans le nouvel enregistrement et d'invoquer :code:`save()` enregistrera les données dans la base pour cet enregistrement. La méthode :code:`save()` retourne un booléen qui indique si le stockage est réussi ou non.

L'ORM échappe automatiquement les entrée pour prévenir des injections SQL, ainsi nous avons juste besoin de transmettre la requête à la méthode :code:`save()`.

Une validation supplémentaire est réalisée automatiquement pour les champs qui sont définis comme non null (requis). Si nous ne renseignons aucun des champs requis dans le formulaire d'inscription notre écran devrait ressembler à ceci:

.. figure:: ../_static/img/tutorial-4.png
    :align: center

Conclusion
----------
Ceci est un tutoriel très simple et, comme vous pouvez le voir, il est facile de commencer la construction d'une application avec Phalcon.
Le fait que Phalcon soit une extension de votre serveur web n'a pas entravé la facilité de développement ou la disponibilité des 
fonctionnalités. Nous vous invitons à continuer de lire le manuel afin que vous puissiez découvrir d'autres fonctionnalités offertes par Phalcon !

.. _fonction anonyme: http://php.net/manual/fr/functions.anonymous.php
