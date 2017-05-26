Логирование
===========

:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` является компонентом для обеспечения ведения логов в приложении. Он позволяет
вести логирование разных типов с использованием различных адаптеров. Он также предлагает регистрацию транзакций, параметров конфигурации, различных форматов и фильтров.
Вы можете использовать :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` для логирования всех операций, отладки процессов и отслеживания работы приложения.

Адаптеры
--------
Этот компонент позволяет использовать адаптеры для хранения журнала сообщений. Использование адаптеров обеспечивает общий интерфейс для регистрации
время переключения интерфейсов при необходимости. Реализованные адаптеры:

+----------------------------------------------------------------------------------+--------------------------------+
| Адаптер                                                                          | Описание                       |
+==================================================================================+================================+
| :doc:`Phalcon\\Logger\\Adapter\\File <../api/Phalcon_Logger_Adapter_File>`       | Логирование в текстовой файл   |
+----------------------------------------------------------------------------------+--------------------------------+
| :doc:`Phalcon\\Logger\\Adapter\\Stream <../api/Phalcon_Logger_Adapter_Stream>`   | Логирование в PHP поток        |
+----------------------------------------------------------------------------------+--------------------------------+
| :doc:`Phalcon\\Logger\\Adapter\\Syslog <../api/Phalcon_Logger_Adapter_Syslog>`   | Логирование в системный журнал |
+----------------------------------------------------------------------------------+--------------------------------+
| :doc:`Phalcon\\Logger\\Adapter\\FirePHP <../api/Phalcon_Logger_Adapter_Firephp>` | Logs to the FirePHP            |
+----------------------------------------------------------------------------------+--------------------------------+

Создание журнала
----------------
В приведенном ниже примере показано, как создать журнал и добавить в него запись:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");



    // These are the different log levels available:

    $logger->critical(
        "This is a critical message"
    );

    $logger->emergency(
        "This is an emergency message"
    );

    $logger->debug(
        "This is a debug message"
    );

    $logger->error(
        "This is an error message"
    );

    $logger->info(
        "This is an info message"
    );

    $logger->notice(
        "This is a notice message"
    );

    $logger->warning(
        "This is a warning message"
    );

    $logger->alert(
        "This is an alert message"
    );



    // You can also use the log() method with a Logger constant:
    $logger->log(
        "Это тоже про ошибку",
        Logger::ERROR
    );

    // If no constant is given, DEBUG is assumed.
    $logger->log(
        "Это сообщение"
    );

    // You can also pass context parameters like this
    $logger->log(
        "This is a {message}", 
        [ 
            'message' => 'parameter' 
        ]
    );

Результат кода:

.. code-block:: none

    [Tue, 28 Jul 15 22:09:02 -0500][CRITICAL] This is a critical message
    [Tue, 28 Jul 15 22:09:02 -0500][EMERGENCY] This is an emergency message
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a debug message
    [Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is an error message
    [Tue, 28 Jul 15 22:09:02 -0500][INFO] This is an info message
    [Tue, 28 Jul 15 22:09:02 -0500][NOTICE] This is a notice message
    [Tue, 28 Jul 15 22:09:02 -0500][WARNING] This is a warning message
    [Tue, 28 Jul 15 22:09:02 -0500][ALERT] This is an alert message
    [Tue, 28 Jul 15 22:09:02 -0500][ERROR] Это тоже про ошибку
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] Это сообщение
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a parameter

You can also set a log level using the :code:`setLogLevel()` method. This method takes a Logger constant and will only save log messages that are as important or more important than the constant:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");

    $logger->setLogLevel(
        Logger::CRITICAL
    );

In the example above, only critical and emergency messages will get saved to the log. By default, everything is saved.

Транзакции
----------
Запись данных в адаптер т.е. в файл (файловая система) всегда является 'дорогостоящей' операцией с точки зрения производительности.
Для решения этой задачи, можно использовать транзакции при логировании. Транзакции временно хранят записи в памяти, а затем переносят их
соответствующий адаптер (в данном случае в файл).

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Создание логгера
    $logger = new FileAdapter("app/logs/test.log");

    // Начало транзакции
    $logger->begin();

    // Добавление записей

    $logger->alert(
        "This is an alert"
    );

    $logger->error(
        "This is another error"
    );

    // Размещение записей в файл
    $logger->commit();

Одновременное логирование нескольких обработчиков
-------------------------------------------------
:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` позволяет отправку сообщений на несколько обработчиков одним вызовом:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Multiple as MultipleStream;
    use Phalcon\Logger\Adapter\File as FileAdapter;
    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    $logger = new MultipleStream();



    $logger->push(
        new FileAdapter("test.log")
    );

    $logger->push(
        new StreamAdapter("php://stdout")
    );



    $logger->log(
        "This is a message"
    );

    $logger->log(
        "This is an error",
        Logger::ERROR
    );

    $logger->error(
        "This is another error"
    );

Сообщения отправляются на обработчик в порядке их регистраций.

Форматирование сообщений
------------------------
Данный компонент позволяет использовать 'formatters' для форматирования сообщений перед тем как их отправить на бэкенд.
Реализованные следующие форматеры:

+--------------------------------------------------------------------------------------+----------------------------------------------------------+
| Адаптер                                                                              | Описание                                                 |
+======================================================================================+==========================================================+
| :doc:`Phalcon\\Logger\\Formatter\\Line <../api/Phalcon_Logger_Formatter_Line>`       | Оформление записей одной строкой                         |
+--------------------------------------------------------------------------------------+----------------------------------------------------------+
| :doc:`Phalcon\\Logger\\Formatter\\Firephp <../api/Phalcon_Logger_Formatter_Firephp>` | Formats the messages so that they can be sent to FirePHP |
+--------------------------------------------------------------------------------------+----------------------------------------------------------+
| :doc:`Phalcon\\Logger\\Formatter\\Json <../api/Phalcon_Logger_Formatter_Json>`       | Подготовка записей для преобразование в JSON             |
+--------------------------------------------------------------------------------------+----------------------------------------------------------+
| :doc:`Phalcon\\Logger\\Formatter\\Syslog <../api/Phalcon_Logger_Formatter_Syslog>`   | Подготовка записи для отправки в системный журнал        |
+--------------------------------------------------------------------------------------+----------------------------------------------------------+

Линейный Оформитель
^^^^^^^^^^^^^^^^^^^
Оформление записей в одну строку. Формат по умолчанию:

.. code-block:: none

    [%date%][%type%] %message%

Вы можете изменить вид сообщений по умолчанию используя :code:`setFormat()`, этот метод позволяет менять формат конечных сообщений, определяя свой ​​собственный.
Поддерживаются такие переменные:

+-----------+------------------------------------------+
| Переменные| Описание                                 |
+===========+==========================================+
| %message% | Запись, которая будет внесена            |
+-----------+------------------------------------------+
| %date%    | Дата добавления записи в журнал          |
+-----------+------------------------------------------+
| %type%    | Тип записи заглавными буквами            |
+-----------+------------------------------------------+

В приведенном примере показано, как изменить формат сообщений в логе:

.. code-block:: php

    <?php

    use Phalcon\Logger\Formatter\Line as LineFormatter;

    $formatter = new LineFormatter("%date% - %message%");

    // Установка формата сообщений в логе
    $logger->setFormatter($formatter);

Реализация собственного оформителя
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Для создания оформителя необходимо реализовать интерфейс :doc:`Phalcon\\Logger\\FormatterInterface <../api/Phalcon_Logger_FormatterInterface>` или расширить существующий.

Адаптеры
--------
В Phalcon есть несколько реализованных адаптеров логирования, примеры ниже показывают, как их можно использовать:

Stream Logger
^^^^^^^^^^^^^
Записывает сообщения в зарегистрированные потоки PHP. Поддерживаемые протоколы перечислены `здесь <http://php.net/manual/en/wrappers.php>`_:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    // Открывает поток с использованием zlib компрессии
    $logger = new StreamAdapter("compress.zlib://week.log.gz");

    // Пишет сообщения в stderr
    $logger = new StreamAdapter("php://stderr");

File Logger
^^^^^^^^^^^
Этот регистратор использует обычные файлы для ведения логов всех типов. По умолчанию все файлы регистратор открывает в
режиме добавления записей, размещая новую запись в конце файла. Если файл не существует, регистратор попытается его создать. Вы можете
изменить этот режим, передавая дополнительную опцию в конструктор:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Создание регистратора с поддержкой записи
    $logger = new FileAdapter(
        "app/logs/test.log",
        [
            "mode" => "w",
        ]
    );

Syslog Logger
^^^^^^^^^^^^^
Этот регистратор отправляет сообщения в системный журнал. Работа такого журнала может варьироваться от одной операционной системы к другой.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

    // Основное использование
    $logger = new SyslogAdapter(null);

    // Установка ident/mode/facility
    $logger = new SyslogAdapter(
        "ident-name",
        [
            "option"   => LOG_NDELAY,
            "facility" => LOG_MAIL,
        ]
    );

FirePHP Logger
^^^^^^^^^^^^^^
This logger sends messages in HTTP response headers that are displayed by `FirePHP <http://www.firephp.org/>`_,
a `Firebug <http://getfirebug.com/>`_ extension for Firefox.

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\Firephp as Firephp;

    $logger = new Firephp("");



    $logger->log(
        "This is a message"
    );

    $logger->log(
        "This is an error",
        Logger::ERROR
    );

    $logger->error(
        "This is another error"
    );

Реализация собственных адаптеров
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Для создания адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Logger\\AdapterInterface <../api/Phalcon_Logger_AdapterInterface>` или расширить существующий адаптер.
