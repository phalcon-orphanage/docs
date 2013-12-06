ロギング
=======
:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` is a component whose purpose is to provide logging services for applications. It offers logging to different backends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` for every logging need your application has, from debugging processes to tracing application flow.

アダプタ
--------
This component makes use of adapters to store the logged messages. The use of adapters allows for a common interface for logging
while switching backends if necessary. The adapters supported are:

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

ログの作成
--------------
The example below shows how to create a log and add messages to it:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");

The log generated is below:

.. code-block:: php

    [Tue, 17 Apr 12 22:09:02 -0500][DEBUG] This is a message
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is an error
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is another error

トランザクション
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

複数のハンドラへのロギング
----------------------------
:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` allows to send messages to multiple handlers with a just single call:

.. code-block:: php

    <?php

    use Phalcon\Logger,
        Phalcon\Logger\Multiple as MultipleStream,
        Phalcon\Logger\Adapter\File as FileAdapter,
        Phalcon\Logger\Adapter\Stream as StreamAdapter;

    $logger = new MultipleStream();

    $logger->push(new FileAdapter('test.log'));
    $logger->push(new StreamAdapter('php://stdout'));

    $logger->log("This is a message");
    $logger->log("This is an error", Logger::ERROR);
    $logger->error("This is another error");

The messages are sent to the handlers in the order they where registered.

メッセージフォーマット
------------------
This component makes use of 'formatters' to format messages before sent them to the backend. The formatters available are:

+---------+-----------------------------------------------+------------------------------------------------------------------------------------+
| Adapter | Description                                   | API                                                                                |
+=========+===============================================+====================================================================================+
| Line    | Formats the messages using an one-line string | :doc:`Phalcon\\Logger\\Formatter\\Line <../api/Phalcon_Logger_Formatter_Line>`     |
+---------+-----------------------------------------------+------------------------------------------------------------------------------------+
| Json    | Prepares a message to be encoded with JSON    | :doc:`Phalcon\\Logger\\Formatter\\Json <../api/Phalcon_Logger_Formatter_Json>`     |
+---------+-----------------------------------------------+------------------------------------------------------------------------------------+
| Syslog  | Prepares a message to be sent to syslog       | :doc:`Phalcon\\Logger\\Formatter\\Syslog <../api/Phalcon_Logger_Formatter_Syslog>` |
+---------+-----------------------------------------------+------------------------------------------------------------------------------------+

行フォーマット
^^^^^^^^^^^^^^
Formats the messages using a one-line string. The default logging format is:

[%date%][%type%] %message%

You can change the default format using setFormat(), this allows you to change the format of the logged
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

    //Changing the logger format
    $formatter = new LineFormatter("%date% - %message%");
    $logger->setFormatter($formatter);

独自フォーマッタの実装
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Logger\\FormatterInterface <../api/Phalcon_Logger_FormatterInterface>` interface must be implemented in order to
create your own logger formatter or extend the existing ones.

アダプタ
--------
The following examples show the basic use of each adapter:

ストリーム ロガー
^^^^^^^^^^^^^
The stream logger writes messages to a valid registered stream in PHP. A list of streams is available `here <http://php.net/manual/en/wrappers.php>`_:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    // Opens a stream using zlib compression
    $logger = new StreamAdapter("compress.zlib://week.log.gz");

    // Writes the logs to stderr
    $logger = new StreamAdapter("php://stderr");

ファイル ロガー
^^^^^^^^^^^
This logger uses plain files to log any kind of data. By default all logger files are open using
append mode which open the files for writing only; placing the file pointer at the end of the file.
If the file does not exist, attempt to create it. You can change this mode passing additional options to the constructor:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // Create the file logger in 'w' mode
    $logger = new FileAdapter("app/logs/test.log", array(
        'mode' => 'w'
    ));

Syslog ロガー
^^^^^^^^^^^^^
This logger sends messages to the system logger. The syslog behavior may vary from one operating system to another.

.. code-block:: php

    <?php
    use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

    // Basic Usage
    $logger = new SyslogAdapter(null);

    // Setting ident/mode/facility
    $logger = new SyslogAdapter("ident-name", array(
        'option' => LOG_NDELAY,
        'facility' => LOG_MAIL
    ));    
    
    
FirePHP ロガー
^^^^^^^^^^^^^^
This logger sends messages to the FirePHP.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Firephp as Firephp;

    $logger = new Firephp("");
 	$logger->log("This is a message");
 	$logger->log("This is an error", \Phalcon\Logger::ERROR);
 	$logger->error("This is another error");

独自アダプタの実装
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Logger\\AdapterInterface <../api/Phalcon_Logger_AdapterInterface>` interface must be implemented in order to
create your own logger adapters or extend the existing ones.
