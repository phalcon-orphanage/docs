Reading Configurations
======================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` - это компонент для чтения конфигурации в разных форматах (используя адаптеры), и преобразования её
в PHP-объекты для использования в приложении.

Нативные массивы
----------------
Следующий пример показывает, как конвертировать нативный массив в объект :doc:`Phalcon\\Config <../api/Phalcon_Config>`. Адаптер для нативных массивов более производителен,
так как файлы не разбираются при обращении.

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

Если вы хотите лучшей организации для вашего проекта, можно сохранить массив в другой файл и затем прочитать его.

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";

    $config = new Config($settings);

Адаптеры файлов
---------------
Доступные адаптеры:

+----------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------+
| Тип файла                                                                  | Описание                                                                                      |
+============================================================================+===============================================================================================+
| :doc:`Phalcon\\Config\\Adapter\\Ini <../api/Phalcon_Config_Adapter_Ini>`   | Использует INI-файлы для хранения конфигурации. Использует PHP-функцию parse_ini_file.        |
+----------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Json <../api/Phalcon_Config_Adapter_Json>` | Uses JSON files to store settings.                                                            |
+----------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Php <../api/Phalcon_Config_Adapter_Php>`   | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance. |
+----------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Yaml <../api/Phalcon_Config_Adapter_Yaml>` | Uses YAML files to store settings.                                                            |
+----------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------+

Чтение INI-файлов
-----------------
Ini-файлы являются довольно распространённым способом хранения конфигурации. Для чтения таких файлов :doc:`Phalcon\\Config <../api/Phalcon_Config>`
использует оптимизированную PHP-функцию parse_ini_file. Разделы файла разбиваются в подпункты конфигурации для более лёгкого доступа.

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

Чтение файла можно произвести таким способом:

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Объединение конфигураций
------------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` позволяет объединить объекты конфигурации друг в друга рекурсивно:

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

Код выше выдаёт такой результат:

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

Существует еще несколько типов адаптеров конфигурации, их можно получить в "Инкубаторе" - `Phalcon Incubator <https://github.com/phalcon/incubator>`_

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
