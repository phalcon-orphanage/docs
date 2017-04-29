Configuration de lecture
========================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` est un composant utilisé pour lire des fichiers de configuration sous différents formats
(en utilisant des adaptateurs) et transformer le contenu en objet PHP pour pouvoir l'utiliser dans une application.

Les Array natifs
----------------
L'exemple suivant montre comment convertir les arrays natifs en objets :doc:`Phalcon\\Config <../api/Phalcon_Config>`.
Cette option offre les meilleures performances vu qu'il n'y a pas de fichiers lu pendant la requête.

.. code-block:: php

    <?php

    use Phalcon\Config;

    $settings = [
        "database" => [
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db"
        ],
         "app" => [
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/"
        ],
        "mysetting" => "the-value"
    ];

    $config = new Config($settings);

    echo $config->app->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

Si vous voulez mieux organiser votre projet vous pouvez sauvegarder le tableau dans un autre fichier pour ensuite le lire.

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";

    $config = new Config($settings);

Adaptateur de fichier
---------------------
Les adaptateurs disponibles sont :

+----------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------+
| File Type                                                                  | Description                                                                                                                    |
+============================================================================+================================================================================================================================+
| :doc:`Phalcon\\Config\\Adapter\\Ini <../api/Phalcon_Config_Adapter_Ini>`   | Utilise des fichiers INI pour conserver la configuration. L'adaptateur utilise la fonction PHP parse_ini_files                 |
+----------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Json <../api/Phalcon_Config_Adapter_Json>` | Utilise des fichiers JSON pour conserver la configuration.                                                                     |
+----------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Php <../api/Phalcon_Config_Adapter_Php>`   | Utilise des tableaux PHP multidimensionnels Pour conserver la configuration. Cet adaptateur offre les meilleures performances. |
+----------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Yaml <../api/Phalcon_Config_Adapter_Yaml>` | Utilise YAML pour conserver la configuration.                                                                                  |
+----------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------+

Lire les fichiers INI
---------------------
Il est habituel d'utiliser les fichiers INI pour conserver la configuration. :doc:`Phalcon\\Config <../api/Phalcon_Config>` exploite la fonction parse_ini_file qui est optimisée pour lire ces fichiers. Pour simplifier l'accès les sections sont décomposées en sous-paramètres.

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    dbname   = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

    [models]
    metadata.adapter  = "Memory"

Vous pouvez lire le fichier comme ceci :

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Fusion de Configurations
------------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` permet de fusionner récursivement un objet configuration avec un autre.
Les nouvelles propriétés sont ajoutées et celles déjà existantes sont mises à jour.

.. code-block:: php

    <?php

    use Phalcon\Config;

    $config = new Config(
        [
            "database" => [
                "host"   => "localhost",
                "dbname" => "test_db",
            ],
            "debug" => 1,
        ]
    );

    $config2 = new Config(
        [
            "database" => [
                "dbname"   => "production_db",
                "username" => "scott",
                "password" => "secret",
            ],
            "logging" => 1,
        ]
    );

    $config->merge($config2);

    print_r($config);

Le code précédent produit le résultat suivant :

.. code-block:: html

    Phalcon\Config Object
    (
        [database] => Phalcon\Config Object
            (
                [host] => localhost
                [dbname]   => production_db
                [username] => scott
                [password] => secret
            )
        [debug] => 1
        [logging] => 1
    )

Vous trouverez d'autres adaptateurs pour ce composant dans l' `Incubateur Phalcon <https://github.com/phalcon/incubator>`_

Injection de Dépendance de Configuration
----------------------------------------
Vous pouvez injecter la dépendances de configuration au contrôleur en utilisant :doc:`Phalcon\\Config <../api/Phalcon_Config>` à l'intérieur de :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`. Pour pouvoir le faire, ajoutez le code qui suit dans votre script d'injecteur de dépendance.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;
    use Phalcon\Config;

    // Création d'un DI
    $di = new FactoryDefault();

    $di->set(
        "config",
        function () {
            $configData = require "config/config.php";

            return new Config($configData);
        }
    );

Maintenant, dans votre contrôleur vous pouvez accéder à votre configuration en utilisant l'attribut "config" de l'injection de dépendance comme dans le code suivant:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class MyController extends Controller
    {
        private function getDatabaseName()
        {
            return $this->config->database->dbname;
        }
    }
