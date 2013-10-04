Чтение конфигурации
===================
:doc:`Phalcon\\Config <../api/Phalcon_Config>` - это компонент для чтения конфигурации в разных форматах (используя адаптеры), и преобразования её
в PHP-объекты для использования в приложении.

Адаптеры файлов
----------------
Доступные адаптеры:

+-----------+---------------------------------------------------------------------------------------------------+
| Тип файла | Описание                                                                                          |
+===========+===================================================================================================+
| Ini       | Использует INI-файлы для хранения конфигурации. Использует PHP-функцию parse_ini_file.            |
+-----------+---------------------------------------------------------------------------------------------------+
| Array     | Использует многомерные массивы PHP для конфигурации. Этот адаптер максимально производителен.     |
+-----------+---------------------------------------------------------------------------------------------------+

Нативные массивы
----------------
Следующий пример показывает как конвертировать нативный массив в объект Phalcon\\Config. Адаптер для нативных массивов более производителен,
так как файлы не разбираются при обращении.

.. code-block:: php

    <?php

    $settings = array(
        "database" => array(
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"     => "test_db",
        ),
         "app" => array(
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/",
        ),
        "mysetting" => "the-value"
    );

    $config = new \Phalcon\Config($settings);

    echo $config->app->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

Если вы хотите лучшей организации для вашего проекта, можно сохранить массив в другой файл и затем прочитать его.

.. code-block:: php

    <?php

    require "config/config.php";
    $config = new \Phalcon\Config($settings);

Чтение INI-файлов
-----------------
Ini-файлы являются довольно распространённым способом хранения конфигурации. Для чтения таких файлов Phalcon\\Config 
использует оптимизированную PHP-функцию parse_ini_file. Разделы файла разбиваются в подпункты конфигурации для более лёгкого доступа.

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    dbname     = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

    [models]
    metadata.adapter  = "Memory"

Чтение файла можно произвести таким способом:

.. code-block:: php

    <?php

    $config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Объединение конфигураций
------------------------
Phalcon\\Config позволяет объединить объекты конфигурации друг в друга рекурсивно:

.. code-block:: php

    <?php

    $config = new \Phalcon\Config(array(
        'database' => array(
            'host' => 'localhost',
            'dbname' => 'test_db'
        ),
        'debug' => 1
    ));

    $config2 = new \Phalcon\Config(array(
        'database' => array(
            'username' => 'scott',
            'password' => 'secret',
        )
    ));

    $config->merge($config2);

    print_r($config);

Код выше выдаёт такой результат:

.. code-block:: html

    Phalcon\Config Object
    (
        [database] => Phalcon\Config Object
            (
                [host] => localhost
                [dbname] => test_db
                [username] => scott
                [password] => secret
            )
        [debug] => 1
    )

Существует еще несколько типов адаптеров конфигурации, их можно получить в "Инкубаторе" - `Phalcon Incubator <https://github.com/phalcon/incubator>`_