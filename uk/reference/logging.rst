Logging
=======

:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` is a component whose purpose is to provide logging services for applications. It offers logging to different backends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` for every logging need your application has, from debugging processes to tracing application flow.

Adapters
--------
This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface
which provides the ability to easily switch backends if necessary. The adapters supported are:

+---------+---------------------------+----------------------------------------------------------------------------------+
| Adapter | Description               | API                                                                              |
+=========+===========================+==================================================================================+
| File    | Logs to a plain text file | :doc:`Phalcon\\Logger\\Adapter\\File <../api/Phalcon_Logger_Adapter_File>`       |
+---------+---------------------------+----------------------------------------------------------------------------------+
| Stream  | Logs to a PHP Streams     | :doc:`Phalcon\\Logger\\Adapter\\Stream <../api/Phalcon_Logger_Adapter_Stream>`   |
+---------+---------------------------+----------------------------------------------------------------------------------+
| Syslog  | Logs to the system logger | :doc:`Phalcon\\Logger\\Adapter\\Syslog <../api/Phalcon_Logger_Adapter_Syslog>`   |
+---------+---------------------------+----------------------------------------------------------------------------------+
| Firephp | Logs to the FirePHP       | :doc:`Phalcon\\Logger\\Adapter\\FirePHP <../api/Phalcon_Logger_Adapter_Firephp>` |
+---------+---------------------------+----------------------------------------------------------------------------------+

Creating a Log
--------------
The example below shows how to create a log and add messages to it:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");

    // These are the different log levels available:
    $logger->critical("This is a critical message");
    $logger->emergency("This is an emergency message");
    $logger->debug("This is a debug message");
    $logger->error("This is an error message");
    $logger->info("This is an info message");
    $logger->notice("This is a notice message");
    $logger->warning("This is a warning message");
    $logger->alert("This is an alert message");

    // You can also use the log() method with a Logger constant:
    $logger->log("This is another error message", Logger::ERROR);

    // If no constant is given, DEBUG is assumed.
    $logger->log("This is a message");

The log generated is below:

.. code-block:: none

    [Tue, 28 Jul 15 22:09:02 -0500][CRITICAL] This is a critical message
    [Tue, 28 Jul 15 22:09:02 -0500][EMERGENCY] This is an emergency message
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a debug message
    [Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is an error message
    [Tue, 28 Jul 15 22:09:02 -0500][INFO] This is an info message
    [Tue, 28 Jul 15 22:09:02 -0500][NOTICE] This is a notice message
    [Tue, 28 Jul 15 22:09:02 -0500][WARNING] This is a warning message
    [Tue, 28 Jul 15 22:09:02 -0500][ALERT] This is an alert message
    [Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is another error message
    [Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a message

You can also set a log level using the :code:`setLogLevel()` method. This method takes a Logger constant and will only save log messages that are as important or more important than the constant:

.. code-block:: php

    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");

    $logger->setLogLevel(Logger::CRITICAL);

In the example above, only critical and emergency messages will get saved to the log. By default, everything is saved.

Transactions
------------
Logging data to an adapter i.e. File (file system) is always an expensive operation in terms of performance. To combat that, you
can take advantage of logging transactions. Transactions store log data temporarily in memory and later on write the data to the
relevant adapter (File in this case) in a single atomic operation.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Create the logger
    $logger = new FileAdapter("app/logs/test.log");

    // Start a transaction
    $logger->begin();

    // Add messages
    $logger->alert("This is an alert");
    $logger->error("This is another error");

    // Commit messages to file
    $logger->commit();

Logging to Multiple Handlers
----------------------------
:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` can send messages to multiple handlers with a just single call:

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Logger\Multiple as MultipleStream;
    use Phalcon\Logger\Adapter\File as FileAdapter;
    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    $logger = new MultipleStream();

    $logger->push(new FileAdapter('test.log'));
    $logger->push(new StreamAdapter('php://stdout'));

    $logger->log("This is a message");
    $logger->log("This is an error", Logger::ERROR);
    $logger->error("This is another error");

The messages are sent to the handlers in the order they were registered.

Message Formatting
------------------
This component makes use of 'formatters' to format messages before sending them to the backend. The formatters available are:

+---------+----------------------------------------------------------+--------------------------------------------------------------------------------------+
| Adapter | Description                                              | API                                                                                  |
+=========+==========================================================+======================================================================================+
| Line    | Formats the messages using a one-line string             | :doc:`Phalcon\\Logger\\Formatter\\Line <../api/Phalcon_Logger_Formatter_Line>`       |
+---------+----------------------------------------------------------+--------------------------------------------------------------------------------------+
| Firephp | Formats the messages so that they can be sent to FirePHP | :doc:`Phalcon\\Logger\\Formatter\\Firephp <../api/Phalcon_Logger_Formatter_Firephp>` |
+---------+----------------------------------------------------------+--------------------------------------------------------------------------------------+
| Json    | Prepares a message to be encoded with JSON               | :doc:`Phalcon\\Logger\\Formatter\\Json <../api/Phalcon_Logger_Formatter_Json>`       |
+---------+----------------------------------------------------------+--------------------------------------------------------------------------------------+
| Syslog  | Prepares a message to be sent to syslog                  | :doc:`Phalcon\\Logger\\Formatter\\Syslog <../api/Phalcon_Logger_Formatter_Syslog>`   |
+---------+----------------------------------------------------------+--------------------------------------------------------------------------------------+

Line Formatter
^^^^^^^^^^^^^^
Formats the messages using a one-line string. The default logging format is:

.. code-block:: none

    [%date%][%type%] %message%

You can change the default format using :code:`setFormat()`, this allows you to change the format of the logged
messages by defining your own. The log format variables allowed are:

+-----------+------------------------------------------+
| Variable  | Description                              |
+===========+==========================================+
| %message% | The message itself expected to be logged |
+-----------+------------------------------------------+
| %date%    | Date the message was added               |
+-----------+------------------------------------------+
| %type%    | Uppercase string with message type       |
+-----------+------------------------------------------+

The example below shows how to change the log format:

.. code-block:: php

    <?php

    use Phalcon\Logger\Formatter\Line as LineFormatter;

    // Changing the logger format
    $formatter = new LineFormatter("%date% - %message%");
    $logger->setFormatter($formatter);

Implementing your own formatters
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Logger\\FormatterInterface <../api/Phalcon_Logger_FormatterInterface>` interface must be implemented in order to
create your own logger formatter or extend the existing ones.

Adapters
--------
The following examples show the basic use of each adapter:

Stream Logger
^^^^^^^^^^^^^
The stream logger writes messages to a valid registered stream in PHP. A list of streams is available `here <http://php.net/manual/en/wrappers.php>`_:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    // Opens a stream using zlib compression
    $logger = new StreamAdapter("compress.zlib://week.log.gz");

    // Writes the logs to stderr
    $logger = new StreamAdapter("php://stderr");

File Logger
^^^^^^^^^^^
This logger uses plain files to log any kind of data. By default all logger files are opened using
append mode which opens the files for writing only; placing the file pointer at the end of the file.
If the file does not exist, an attempt will be made to create it. You can change this mode by passing additional options to the constructor:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Create the file logger in 'w' mode
    $logger = new FileAdapter(
        "app/logs/test.log",
        array(
            'mode' => 'w'
        )
    );

Syslog Logger
^^^^^^^^^^^^^
This logger sends messages to the system logger. The syslog behavior may vary from one operating system to another.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

    // Basic Usage
    $logger = new SyslogAdapter(null);

    // Setting ident/mode/facility
    $logger = new SyslogAdapter(
        "ident-name",
        array(
            'option'   => LOG_NDELAY,
            'facility' => LOG_MAIL
        )
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
    $logger->log("This is a message");
    $logger->log("This is an error", Logger::ERROR);
    $logger->error("This is another error");

Implementing your own adapters
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Logger\\AdapterInterface <../api/Phalcon_Logger_AdapterInterface>` interface must be implemented in order to
create your own logger adapters or extend the existing ones.
