Tests unitaires
===============

Ecrire de bons tests aide à écrire de meilleurs logiciels. Si vous définissez de bons cas de tests vous pouvez éliminer la plupart des bugs fonctionnels et mieux maintenir votre logiciel.

Intégrer PHPunit à phalcon
--------------------------
Si vous n'avez pas encore phpunit d'installé, vous pouvez le faire en suivant cette commande composer:

.. code-block:: bash

    composer require phpunit/phpunit:^5.0


ou bien en l'ajoutant manuellement à composer.json:

.. code-block:: json

    {
        "require-dev": {
            "phpunit/phpunit": "^5.0"
        }
    }

Une fois phpunit installé, créez un répertoire appelé "tests" depuis le dossier racine du projet:

.. code-block:: bash

    app/
    public/
    tests/

Ensuite, nous avons besoin d'un fichier "assistant" pour amorcer l'application lors des tests unitaires.

Le fichier d'assistance de PHPunit
----------------------------------
Un fichier d'assistance est nécessaire pour amorcer l'application lors d'exécution de tests. Nous avons préparé un échantillon. Enregistrez le fichier dans votre répertoire tests/ sous le nom de TestHelper.php.

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Loader;

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    define("ROOT_PATH", __DIR__);

    set_include_path(
        ROOT_PATH . PATH_SEPARATOR . get_include_path()
    );

    // Nécessaire pour phalcon/incubator
    include __DIR__ . "/../vendor/autoload.php";

    // Utilise l'autoloader pour charger automatiquement les classes
    // Charge les dépendances trouvées dans composer
    $loader = new Loader();

    $loader->registerDirs(
        [
            ROOT_PATH,
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    Di::reset();

    // Ajoutez ici au DI les services nécessaires

    Di::setDefault($di);

Si vous avez besoin de tester un composant quelconque de votre librairie, ajouter le au chargeur automatique ou bien utilisez le chargeur de votre application principale.

Vous vous aider à construire des tests unitaires, nous avons créé quelques classes abstraites que vous pouvez utiliser pour amorcer les tests.
Ces fichiers sont disponibles dans l'incubateur @ https://github.com/phalcon/incubator.

Vous pouvez utiliser la librairie de l'incubateur en l'ajoutant en tant que dépendance:

.. code-block:: bash

    composer require phalcon/incubator


ou manuellement en l'ajoutant à composer.json:

.. code-block:: json

    {
        "require": {
            "phalcon/incubator": "^3.0"
        }
    }

Vous pouvez également cloner le dépôt en suivant le lien précédemment indiqué.

Le fichier PHPunit.xml
----------------------
Et maintenant, créons le fichier phpunit:

.. code-block:: xml

    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit bootstrap="./TestHelper.php"
             backupGlobals="false"
             backupStaticAttributes="false"
             verbose="true"
             colors="false"
             convertErrorsToExceptions="true"
             convertNoticesToExceptions="true"
             convertWarningsToExceptions="true"
             processIsolation="false"
             stopOnFailure="false"
             syntaxCheck="true">
        <testsuite name="Phalcon - Testsuite">
            <directory>./</directory>
        </testsuite>
    </phpunit>

Modifiez phpunit.xml selon vos besoins et enregistrez le dans "tests/".

Ceci fera que les tests seront exécutés dans le répertoire "tests/".

Exemple de test unitaire
------------------------
Pour réaliser un test unitaire vous devez d'abord le définir. Le chargeur automatique se charge de vérifier que les bons fichiers soient chargés. Tous ce que vous avez à faire est de créer les fichiers et phpunit réalisera les tests pour vous.

Cet exemple ne contient pas de fichier de configuration, cependant dans la plupart des cas vous risquez d'en avoir besoin. Vous pouvez l'ajouter au DI afin d'obtenir le fichier UnitTestCase.

Créons tout d'abord une base de test unitaire appelée UnitTestCase.php dans votre dossier /tests:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Test\UnitTestCase as PhalconTestCase;

    abstract class UnitTestCase extends PhalconTestCase
    {
        /**
         * @var bool
         */
        private $_loaded = false;



        public function setUp()
        {
            parent::setUp();

            // Chargez d'autres services qui pourraient être nécessaires aux tests
            $di = Di::getDefault();

            // Récupèration des composant du DI. Si vous avez une configuration soyez sûr de le transmettre au parent.

            $this->setDi($di);

            $this->_loaded = true;
        }

        /**
         * Vérification que le cas de test soit correctement configuré
         *
         * @throws \PHPUnit_Framework_IncompleteTestError;
         */
        public function __destruct()
        {
            if (!$this->_loaded) {
                throw new \PHPUnit_Framework_IncompleteTestError(
                    "Please run parent::setUp()."
                );
            }
        }
    }

C'est une bonne idée que de séparer vos tests unitaires par des espaces de noms. Pour ce test nous créerons l'espace de noms 'Test'. Créons donc un fichier nommé \tests\Test\UnitTest.php:

.. code-block:: php

    <?php

    namespace Test;

    /**
     * Class UnitTest
     */
    class UnitTest extends \UnitTestCase
    {
        public function testTestCase()
        {
            $this->assertEquals(
                "works",
                "works",
                "This is OK"
            );

            $this->assertEquals(
                "works",
                "works1",
                "This will fail"
            );
        }
    }

Maintenant lorsque vous lancez 'phpunit' en ligne de commande depuis le répertoire \tests vous devriez obtenir la sortie suivante:

.. code-block:: bash

    $ phpunit
    PHPUnit 3.7.23 by Sebastian Bergmann.

    Configuration read from /private/var/www/tests/phpunit.xml

    Time: 3 ms, Memory: 3.25Mb

    There was 1 failure:

    1) Test\UnitTest::testTestCase
    This will fail
    Failed asserting that two strings are equal.
    --- Expected
    +++ Actual
    @@ @@
    -'works'
    +'works1'

    /private/var/www/tests/Test/UnitTest.php:25

    FAILURES!
    Tests: 1, Assertions: 2, Failures: 1.

Vous êtes maintenant capable de construire vos propres tests unitaires. Vous trouverez un excellent guide en anglais ici (nous recommandons également de lire la documentation de PHPunit si vous n'êtes pas familier avec):

http://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/
