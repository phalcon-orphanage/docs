日志记录（Logging）
=====================
Phalcon提供了一个日志记录组件即 :doc:`Phalcon\\Logger <../api/Phalcon_Logger>`。 我们可以使用此组件输出日志到不同的流中，如文件，系统日志等。
这个组件还提供了其它的功能如日志事务（类似于数据库的事务）， 配置选项， 还可以输出不同的格式，另外还支持多种过滤器。 :doc:`Phalcon\\Logger <../api/Phalcon_Logger>`
 提供了多种日志记录方式，从调试程序到跟踪应用的执行以满足应用的需求。

适配器（Adapters）
-----------------
此组件使用不同的流适配器来保存日信息。 我们可以按需使用适配器。支持的适配器如下：

+---------+---------------------------+----------------------------------------------------------------------------------+
| 适配器  | 描述                      | 接口                                                                             |
+=========+===========================+==================================================================================+
| File    | 保存日志到普通文件        | :doc:`Phalcon\\Logger\\Adapter\\File <../api/Phalcon_Logger_Adapter_File>`       |
+---------+---------------------------+----------------------------------------------------------------------------------+
| Stream  | 保存日志到PHP流           | :doc:`Phalcon\\Logger\\Adapter\\Stream <../api/Phalcon_Logger_Adapter_Stream>`   |
+---------+---------------------------+----------------------------------------------------------------------------------+
| Syslog  | 保存到系统日志            | :doc:`Phalcon\\Logger\\Adapter\\Syslog <../api/Phalcon_Logger_Adapter_Syslog>`   |
+---------+---------------------------+----------------------------------------------------------------------------------+
| Firephp | 发送日志到FirePHP         | :doc:`Phalcon\\Logger\\Adapter\\FirePHP <../api/Phalcon_Logger_Adapter_Firephp>` |
+---------+---------------------------+----------------------------------------------------------------------------------+

创建日志（Creating a Log）
--------------------------

下面的例子展示了如何创建日志对象及如何添加日志信息：


.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    $logger = new FileAdapter("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");

产生的日志信息如下：

.. code-block:: php

    [Tue, 17 Apr 12 22:09:02 -0500][DEBUG] This is a message
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is an error
    [Tue, 17 Apr 12 22:09:02 -0500][ERROR] This is another error

事务（Transactions）
----------------------
保存日志到适配器如文件(文件系统)是非常消耗系统资源的。 为了减少应用性能上的开销，我们可以使用日志事务。 事务会把日志记录临时的保存到内存中然后再
写入到适配中（此例子中为文件），（这个操作是个原子操作）

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // 生成日志新组件实例
    $logger = new FileAdapter("app/logs/test.log");

    // 开启事务
    $logger->begin();

    // 添加消息
    $logger->alert("This is an alert");
    $logger->error("This is another error");

    //  保存消息到文件中
    $logger->commit();

使用多个处理程序进行日志记录（Logging to Multiple Handlers）
--------------------------------------------------------------------
:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` 也可以同时保存日志信息到多个适配器中：

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

信息发送的顺序和处理器（适配器）注册的顺序相同。

信息格式（Message Formatting）
------------------------------

此组件使用 formatters 在信息发送前格式化日志信息。 支持下而后格式：

+---------+-----------------------------------------------+------------------------------------------------------------------------------------+
| 适配器  | 描述                                          | 接口                                                                               |
+=========+===============================================+====================================================================================+
| Line    | 文本方式格式化信息                            | :doc:`Phalcon\\Logger\\Formatter\\Line <../api/Phalcon_Logger_Formatter_Line>`     |
+---------+-----------------------------------------------+------------------------------------------------------------------------------------+
| Json    | 使用JSON格式格式化信息                        | :doc:`Phalcon\\Logger\\Formatter\\Json <../api/Phalcon_Logger_Formatter_Json>`     |
+---------+-----------------------------------------------+------------------------------------------------------------------------------------+
| Syslog  | 使用系统提供的格式格式化信息                  | :doc:`Phalcon\\Logger\\Formatter\\Syslog <../api/Phalcon_Logger_Formatter_Syslog>` |
+---------+-----------------------------------------------+------------------------------------------------------------------------------------+

行格式化处理（Line Formatter）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
使用单行格式格式化信息。 默认的格式如下：

[%date%][%type%] %message%

我们可以使用setFormat()来设置自定义格式。 下面是格式变量：


+-----------+------------------------------------------+
| 变量      | 描述                                     |
+===========+==========================================+
| %message% | 待记录的日志消息                         |
+-----------+------------------------------------------+
| %date%    | 消息添加的时间                           |
+-----------+------------------------------------------+
| %type%    | 消息类型（使用大写）                   |
+-----------+------------------------------------------+

下面的例子中展示了如何修改日志格式：

.. code-block:: php

    <?php

    use Phalcon\Logger\Formatter\Line as LineFormatter;

    // 修改日志格式
    $formatter = new LineFormatter("%date% - %message%");
    $logger->setFormatter($formatter);

自定义格式处理（Implementing your own formatters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
若要实现自定义的格式则要实现 :doc:`Phalcon\\Logger\\FormatterInterface <../api/Phalcon_Logger_FormatterInterface>` 接口，
这样才能扩展已有的格式或创建自定义的格式


适配器(Adapters)
----------------
下面的例子中展示了每种适配器的简单用法：

数据流日志记录器（Stream Logger）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
系统日志保存消息到一个已注册的有效的PHP流中。 这里列出了可用的流： here <http://php.net/manual/en/wrappers.php>`_:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Stream as StreamAdapter;

    // 使用zlib压缩流
    $logger = new StreamAdapter("compress.zlib://week.log.gz");

    // 发送消息到stderr
    $logger = new StreamAdapter("php://stderr");

文件日志记录器（File Logger）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

文件适配器保存所有的日志信息到普通的文件中。 默认情况下日志文件使用添加模式打开，打开文件后文件的指针会指向文件的尾端。
如果文件不存在，则会尝试创建。 我们可以通过传递附加参数的形式来修改打开的模式：

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as FileAdapter;

    // 使用写模式打开
    $logger = new FileAdapter("app/logs/test.log", array(
        'mode' => 'w'
    ));

Syslog 日志记录器（Syslog Logger）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
使用系统日志适配器。 由于操作系统的不同得到的日志也不尽相同：

.. code-block:: php

    <?php
    use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

    // 基本用法
    $logger = new SyslogAdapter(null);

    // Setting ident/mode/facility 参数设置
    $logger = new SyslogAdapter("ident-name", array(
        'option' => LOG_NDELAY,
        'facility' => LOG_MAIL
    ));


FirePHP 日志记录器（FirePHP Logger）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

发送消息到FirePHP:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\Firephp as Firephp;

    $logger = new Firephp("");
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");

自定义适配器（Implementing your own adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

如果开发者想自定义新的日志组件则需实现此接口： :doc:`Phalcon\\Logger\\AdapterInterface <../api/Phalcon_Logger_AdapterInterface>` 。
