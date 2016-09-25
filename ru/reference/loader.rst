Класс Автозагрузчика
====================

Компонент :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` позволяет осуществлять автоматическую загрузку классов, основываясь
на установленных правилах. Компонент написан на Си и обеспечивает очень низкие накладные расходы на чтение и интерпретацию PHP-файлов.

Поведение компонента основано на стандартной для PHP возможности `автозагрузки классов`_. Если используемый в коде класс не существует,
специальный обработчик будет пытаться найти его и загрузить. :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` создан как раз для этой операции.
Загрузка только необходимых для работы классов положительно сказывается на производительности приложения, так как в работе участвуют только файлы,
непосредственно требуемые для текущей операции. Такая технология называется `отложенная (ленивая) инициализация`_.

С помощью этого класса возможна загрузка файлов сторонних проектов и производителей, компонент полностью совместим со `стандартом PSR-0 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_.

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` поддерживает 4 варианта правил автозагрузки классов. Вы можете использовать их по отдельности, или комбинировать.

Security Layer
--------------
:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` offers a security layer sanitizing by default class names avoiding possible inclusion of unauthorized files.
Consider the following example:

.. code-block:: php

    <?php

    // Basic autoloader
    spl_autoload_register(
        function ($className) {
            $filepath = $className . ".php";

            if (file_exists($filepath)) {
                require $filepath;
            }
        }
    );

The above auto-loader lacks any kind of security. If a function mistakenly launches the auto-loader and
a malicious prepared string is used as parameter this would allow to execute any file accessible by the application:

.. code-block:: php

    <?php

    // This variable is not filtered and comes from an insecure source
    $className = "../processes/important-process";

    // Check if the class exists triggering the auto-loader
    if (class_exists($className)) {
        // ...
    }

If '../processes/important-process.php' is a valid file, an external user could execute the file without
authorization.

To avoid these or most sophisticated attacks, :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` removes invalid characters from the class name,
reducing the possibility of being attacked.

Регистрация пространств имён
----------------------------
Если организация вашего кода подразумевает пространства имён, или использованы внешние библиотеки с их использованием, то для регистрации
стоит использовать метод :code:`registerNamespaces()`. Метод принимает ассоциативный массив, в котором ключами являются префиксы пространств имен,
а их значениями - каталоги в которых эти классы расположены. Разделитель пространства имен (namespace) ("\\"), будет заменен разделителем
директорий ("/"), во время поиска класса загрузчиком. Не забывайте всегда добавлять заключительный слеш в конце пути каталогов:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Создание загрузчика
    $loader = new Loader();

    // Регистрация пространств имён
    $loader->registerNamespaces(
        [
           "Example\Base"    => "vendor/example/base/",
           "Example\Adapter" => "vendor/example/adapter/",
           "Example"         => "vendor/example/",
        ]
    );

    // Регистрация автозагрузчика
    $loader->register();

    // Требуемый файл должен располагаться в vendor/example/adapter/Some.php
    $some = new \Example\Adapter\Some();

Регистрация каталогов
---------------------
Третий вариант - регистрация каталогов для поиска файлов. Этот вариант не очень рекомендуется с точки зрения производительности, при его использовании
Phalcon будет вынужден обрабатывать данные по каждому каталогу и искать в них файл с таким же именем что и название требуемого класса. Важно регистрировать
каталоги в правильном порядке, так же не забывайте всегда добавлять заключительный слеш в конце пути:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Создание загрузчика
    $loader = new Loader();

    // Регистрация каталогов
    $loader->registerDirs(
        [
            "library/MyComponent/",
            "library/OtherComponent/Other/",
            "vendor/example/adapters/",
            "vendor/example/",
        ]
    );

    // Регистрация автозагрузчика
    $loader->register();

    // Требуемый файл будет автоматически подключен из первого каталога в котором он будет найден
    // например library/OtherComponent/Other/Some.php
    $some = new \Some();

Регистрация классов
-------------------
Последний вариант - регистрация названия класса и пути к нему. Это решение может быть полезно при использовании стратегий, не позволяющих
легко получить файл, используя название или путь к классу. Это самый быстрый способ автозагрузки. Но при разрастании приложения, число
файлов так же будет расти, увеличивая список автозагрузки. Разрастание списка снижает эффективность и не рекомендуется по вопросам производительности.

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Создание загрузчика
    $loader = new Loader();

    // Регистрация классов
    $loader->registerClasses(
        [
            "Some"         => "library/OtherComponent/Other/Some.php",
            "Example\Base" => "vendor/example/adapters/Example/BaseClass.php",
        ]
    );

    // Регистрация автозагрузчика
    $loader->register();

    // Искомый класс будет искаться на соответствующее зарегистрированное значение массива
    // например library/OtherComponent/Other/Some.php
    $some = new \Some();

Registering Files
-----------------
You can also registers files that are "non-classes" hence needing a "require". This is very useful for including files that only have functions:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Creates the autoloader
    $loader = new Loader();

    // Register some classes
    $loader->registerFiles(
        [
            "functions.php",
            "arrayFunctions.php",
        ]
    );

    // Register autoloader
    $loader->register();

These files are automatically loaded in the :code:`register()` method.

Дополнительные расширения файлов
--------------------------------
Автозагрузка с использованием префиксов, пространств имён и регистрации каталогов автоматически добавляет расширение "php" во время поиска файлов. Если
у вас используются дополнительные расширения, их можно указать с помощью метода "setExtensions". Файлы при этом будут проверять в порядке регистрации расширений:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Создание загрузчика
    $loader = new Loader();

    // Установка расширений файлов для поиска классов
    $loader->setExtensions(
        [
            "php",
            "inc",
            "phb",
        ]
    );

Изменение текущей стратегии
---------------------------
Additional auto-loading data can be added to existing values by passing "true" as the second parameter:

.. code-block:: php

    <?php

    // Регистрация дополнительных каталогов
    $loader->registerDirs(
        [
            "../app/library/",
            "../app/plugins/",
        ],
        true
    );

События автозагрузки классов
----------------------------
В следующем примере, EventsManager работает с загрузчиком класса, что позволяет нам получать отладочную информацию о выполнении работы:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Loader;

    $eventsManager = new EventsManager();

    $loader = new Loader();

    $loader->registerNamespaces(
        [
            "Example\\Base"    => "vendor/example/base/",
            "Example\\Adapter" => "vendor/example/adapter/",
            "Example"          => "vendor/example/",
        ]
    );

    // Прослушивание всех событий загрузчика
    $eventsManager->attach(
        "loader:beforeCheckPath",
        function (Event $event, Loader $loader) {
            echo $loader->getCheckedPath();
        }
    );

    $loader->setEventsManager($eventsManager);

    $loader->register();

Некоторые события при возвращении логического "false" могут остановить активную операцию. Список поддерживаемых событий:

+------------------+-----------------------------------------------------------------------------------------------------------+-------------------------+
| Название события | Условия срабатывания                                                                                      | Останавливает операцию? |
+==================+===========================================================================================================+=========================+
| beforeCheckClass | До начала процесса автозагрузки                                                                           | Да                      |
+------------------+-----------------------------------------------------------------------------------------------------------+-------------------------+
| pathFound        | Когда найдено расположение класса                                                                         | Нет                     |
+------------------+-----------------------------------------------------------------------------------------------------------+-------------------------+
| afterCheckClass  | После завершения процесса автозагрузки. Событие вызывается, если автозагрузчик не обнаружил искомый класс | Нет                     |
+------------------+-----------------------------------------------------------+-----------------------------------------------+-------------------------+

Устранение неполадок
--------------------
Некоторые вещи, которые стоит иметь в виду при использовании универсального автозагрузчика:

* Загрузчик чувствителен к регистру
* Стратегии, основанные на пространствах имён и префиксах, быстрее, чем стратегии на каталогах
* Если доступен APC_, он будет использован для запрашиваемого файла (и этот файл будет кэширован)

.. _автозагрузки классов: http://www.php.net/manual/ru/language.oop5.autoload.php
.. _отложенная (ленивая) инициализация: http://ru.wikipedia.org/wiki/%D0%9E%D1%82%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%BD%D0%B0%D1%8F_%D0%B8%D0%BD%D0%B8%D1%86%D0%B8%D0%B0%D0%BB%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8F
.. _APC: http://php.net/manual/en/book.apc.php
