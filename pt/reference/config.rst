Lendo Configurações
===================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` é um componente usado para ler e transformar arquivos de configuração de vários formatos (usando adaptadores) em Objetos PHP para uso em uma aplicação.

Adaptadores de Arquivo
----------------------
Os adaptadores disponíveis são:

+-----------------+-------------------------------------------------------------------------------------------------------------+
| Tipo de Arquivo | Descrição                                                                                                   |
+=================+=============================================================================================================+
| Ini             | Usa arquivos INI para armazenar configurações. Internamente o adaptador usa a função do PHP parse_ini_file. |
+-----------------+-------------------------------------------------------------------------------------------------------------+
| Array           | Usa arrays multidimensionais para armazenar configurações. Esse adaptador oferece o melhor desempenho       |
+-----------------+-------------------------------------------------------------------------------------------------------------+

Arrays Nativos
--------------
O próximo exemplo mostra como converter arrays nativos em objetos :doc:`Phalcon\\Config <../api/Phalcon_Config>`. Essa opção oferece o melhor desempenho já que nenhum arquivo é lido/carregado durante essa requisição.

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

Se você deseja uma melhor organização do seu projeto, você pode salvar o array em um outro arquivo e posteriormente carregá-lo.

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";
    $config = new Config($settings);

Lendo arquivos INI
------------------
Arquivo INI são usados comumente para armazenar configurações. O :doc:`Phalcon\\Config <../api/Phalcon_Config>` usa a versão otimizada da função PHP parse_ini_file para ler esses arquivos. As seções de arquivo são colocadas em sub-configurações para um acesso mais fácil.

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

Você pode ler o arquivo como no exemplo a seguir:

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Mesclando Configurações
-----------------------
O :doc:`Phalcon\\Config <../api/Phalcon_Config>` permite mesclar um objeto de configuração em outro, recursivamente:

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

O código acima produz o seguinte:

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

Existem mais adaptadores disponíveis para esse componente em `Phalcon Incubator <https://github.com/phalcon/incubator>`_
