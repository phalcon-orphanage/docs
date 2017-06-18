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

Si vous voulez mieux organiser votre projet vous pouvez sauvegarder l'array dans un autre fichier pour ensuite le lire.

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";

    $config = new Config($settings);

Adaptateur de fichier
---------------------
Les adaptateurs disponibles sont :

+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| File Type                                                                  | Description                                                                                                |
+============================================================================+============================================================================================================+
| :doc:`Phalcon\\Config\\Adapter\\Ini <../api/Phalcon_Config_Adapter_Ini>`   | Utilise des fichiers INI pour stoquer des paramètres. L'adaptateur utilise la fonction PHP parse_ini_files |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Json <../api/Phalcon_Config_Adapter_Json>` | Uses JSON files to store settings.                                                                         |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Php <../api/Phalcon_Config_Adapter_Php>`   | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.              |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Yaml <../api/Phalcon_Config_Adapter_Yaml>` | Uses YAML files to store settings.                                                                         |
+----------------------------------------------------------------------------+------------------------------------------------------------------------------------------------------------+

Lire les fichiers INI
---------------------
Les fichiers INI sont un moyen habituel pour stoquer des paramètres.
:doc:`Phalcon\\Config <../api/Phalcon_Config>` utilise la fonction parse_ini_file optimisé pour lire ces fichiers.
Les sections sont parsé en sous-paramètres pour un accès simplifié.

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

Vous pouvez lire le fichier comme cela :

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Configuration de fusion
-----------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` permet de fusionner une configuration objet en un autre de manière récursif :

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

Le code fournit le résultat suivant :

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

Il y a plus d'adaptateurs disponible pour ce composant dans l'
There are more adapters available for this components in the `Incubateur Phalcon <https://github.com/phalcon/incubator>`_

Injecting Configuration Dependency
----------------------------------
You can inject configuration dependency to controller allowing us to use :doc:`Phalcon\\Config <../api/Phalcon_Config>` inside :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`. To be able to do that, add following code inside your dependency injector script.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;
    use Phalcon\Config;

    // Create a DI
    $di = new FactoryDefault();

    $di->set(
        "config",
        function () {
            $configData = require "config/config.php";

            return new Config($configData);
        }
    );

Now in your controller you can access your configuration by using dependency injection feature using name `config` like following code:

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
