Configuration de lecture
========================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` est un composant utilisé pour lire des fichiers de configuration sous différents formats
(en utilisant des adaptateurs) et transformer le contenu en objet PHP pour pouvoir l'utiliser dans une application.

Adaptateur de fichier
---------------------
Les adaptateurs disponibles sont :

+-----------+----------------------------------------------------------------------------------------------------------------------+
| File Type | Description                                                                                                          |
+===========+======================================================================================================================+
| Ini       | Utilise des fichiers INI pour stoquer des paramètres.  L'adaptateur utilise la fonction PHP parse_ini_files          |
+-----------+----------------------------------------------------------------------------------------------------------------------+
| Array     | Utilise les arrays multi-dimensionnel pour stoquer les paramètres. Cet adaptateur offre les meilleures performances. |
+-----------+----------------------------------------------------------------------------------------------------------------------+

Les Array natifs
----------------
L'exemple suivant montre comment convertir les arrays natifs en objets :doc:`Phalcon\\Config <../api/Phalcon_Config>`.
Cette option offre les meilleures performances vu qu'il n'y a pas de fichiers lu pendant la requête.

.. code-block:: php

    <?php

    use Phalcon\Config;

    $settings = array(
        "database" => array(
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db"
        ),
         "app" => array(
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/"
        ),
        "mysetting" => "the-value"
    );

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
        array(
            'database' => array(
                'host'   => 'localhost',
                'dbname' => 'test_db'
            ),
            'debug' => 1
        )
    );

    $config2 = new Config(
        array(
            'database' => array(
                'dbname'   => 'production_db',
                'username' => 'scott',
                'password' => 'secret'
            ),
            'logging' => 1
        )
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
