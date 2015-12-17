パフォーマンス改善: 次なる手は？
====================================

Get faster applications requires refine many aspects: server, client, network, database, web server, static sources, etc.
In this chapter we highlight scenarios where you can improve performance and how detect what is really slow in your application.

サーバー側でのプロファイリング
------------------------------
Each application is different, the permanent profiling is important to understand where performance can be increased.
Profiling gives us a real picture on what is really slow and what does not. Profiles can vary between a request and another,
so it is important to make enough measurements to make conclusions.

XDebugによるプロファイリング
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Xdebug_ provides an easier way to profile PHP applications, just install the extension and enable profiling in the php.ini:

.. code-block:: ini

    xdebug.profiler_enable = On

Using a tool like Webgrind_ you can see which functions/methods are slower than others:

.. figure:: ../_static/img/webgrind.jpg
    :align: center

Xhprofによるプロファイリング
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Xhprof_ is another interesting extension to profile PHP applications. Add the following line to the start of the bootstrap file:

.. code-block:: php

    <?php

    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

Then at the end of the file save the profiled data:

.. code-block:: php

    <?php

    $xhprof_data = xhprof_disable('/tmp');

    $XHPROF_ROOT = "/var/www/xhprof/";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

    $xhprof_runs = new XHProfRuns_Default();
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

    echo "http://localhost/xhprof/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";

Xhprof provides a built-in HTML viewer to analyze the profiled data:

.. figure:: ../_static/img/xhprof-2.jpg
    :align: center

.. figure:: ../_static/img/xhprof-1.jpg
    :align: center

SQL文のプロファイリング
^^^^^^^^^^^^^^^^^^^^^^^^
Most database systems provide tools to identify slow SQL statements. Detecting and fixing slow queries is very important in order to increase performance
in the server side. In the Mysql case, you can use the slow query log to know what SQL queries are taking more time than expected:

.. code-block:: ini

    log-slow-queries = /var/log/slow-queries.log
    long_query_time = 1.5

クライアント側でのプロファイリング
----------------------------------
Sometimes we may need to improve the loading of static elements such as images, javascript and css to improve performance.
The following tools are useful to detect common bottlenecks in the client side:

Chrome/Firefoxによるプロファイリング
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Most modern browsers have tools to profile the page loading time. In Chrome you can use the web inspector to know how much time is taking the
loading of the different resources required by a single page:

.. figure:: ../_static/img/chrome-1.jpg
    :align: center

Firebug_ provides a similar functionality:

.. figure:: ../_static/img/firefox-1.jpg
    :align: center

Yahoo! YSlow
------------
YSlow_ analyzes web pages and suggests ways to improve their performance based on a set of `rules for high performance web pages`_

.. figure:: ../_static/img/yslow-1.jpg
    :align: center

Speed Tracerによるプロファイリング
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
`Speed Tracer`_ is a tool to help you identify and fix performance problems in your web applications. It visualizes metrics that are taken
from low level instrumentation points inside of the browser and analyzes them as your application runs. Speed Tracer is available as a
Chrome extension and works on all platforms where extensions are currently supported (Windows and Linux).

.. figure:: ../_static/img/speed-tracer.jpg
    :align: center

This tool is very useful because it help you to get the real time used to render the whole page including HTML parsing,
Javascript evaluation and CSS styling.

最新バージョンのPHPの使用
-------------------------
PHP is faster every day, using the latest version improves the performance of your applications and also of Phalcon.

PHPバイトコードキャッシュの利用
-------------------------------
APC_ as many other bytecode caches help an application to reduce the overhead of read, tokenize and parse PHP files in each request.
Once the extension is installed use the following setting to enable APC:

.. code-block:: ini

    apc.enabled = On

PHP 5.5 includes a built-in bytecode cache called ZendOptimizer+, this extension is also available for 5.3 and 5.4.

バックグラウンドの動作のブロック
----------------------------------
Process a video, send e-mails, compress a file or an image, etc., are slow tasks that must be processed in background jobs.
There are a variety of tools that provide queuing or messaging systems that work well with PHP:

* `Beanstalkd <http://kr.github.io/beanstalkd/>`_
* `Redis <http://redis.io/>`_
* `RabbitMQ <http://www.rabbitmq.com/>`_
* `Resque <https://github.com/chrisboulton/php-resque>`_
* `Gearman <http://gearman.org/>`_
* `ZeroMQ <http://www.zeromq.org/>`_

Google Page Speed
-----------------
mod_pagespeed_ speeds up your site and reduces page load time. This open-source Apache HTTP server module (also available
for nginx as ngx_pagespeed_) automatically applies web performance best practices to pages, and associated assets
(CSS, JavaScript, images) without requiring that you modify your existing content or workflow.

.. _firebug: http://getfirebug.com/
.. _YSlow: http://developer.yahoo.com/yslow/
.. _rules for high performance web pages: http://developer.yahoo.com/performance/rules.html
.. _XDebug: http://xdebug.org/docs
.. _Xhprof: https://github.com/facebook/xhprof
.. _Speed Tracer: https://developers.google.com/web-toolkit/speedtracer/
.. _Webgrind: https://github.com/jokkedk/webgrind/
.. _APC: http://php.net/manual/en/book.apc.php
.. _mod_pagespeed: https://developers.google.com/speed/pagespeed/mod
.. _ngx_pagespeed: https://developers.google.com/speed/pagespeed/ngx
