%{whats-next_ac5979c40cf0f922d23b99b0f63326ef}%
====================================
%{whats-next_4951fecfe8ea04204482ba901a13ac35}%

%{whats-next_8a5e5cd07086bfd5256478af76a0c9db}%
---------------------
%{whats-next_d499955109185531dee06e38e6371a79}%

%{whats-next_5116de9f40ec1c3dd8aafed76c961ba3}%
^^^^^^^^^^^^^^^^^^^^^
%{whats-next_a4925be86d5b8f4d2809c47a6564e026}%

.. code-block:: ini

    xdebug.profiler_enable = On


%{whats-next_b38d10ababd4d8fc1f2ab1d270538b5b}%

.. figure:: ../_static/img/webgrind.jpg
    :align: center



%{whats-next_244719d3a37013227a2f4f2e69954e66}%
^^^^^^^^^^^^^^^^^^^^^
%{whats-next_988fb6562d947f8da0ae75c1501d0da5}%

.. code-block:: php

    <?php

    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);


%{whats-next_c3f35ed9003d3e458d7c35470f58797a}%

.. code-block:: php

    <?php

    $xhprof_data = xhprof_disable('/tmp');

    $XHPROF_ROOT = "/var/www/xhprof/";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

    $xhprof_runs = new XHProfRuns_Default();
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

    echo "http://localhost/xhprof/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";


%{whats-next_efb07d608d7b87bc1a001af0d1f8a864}%

.. figure:: ../_static/img/xhprof-2.jpg
    :align: center

.. figure:: ../_static/img/xhprof-1.jpg
    :align: center



%{whats-next_f7dc7675831e283edd54b6e7e3501a7e}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{whats-next_52ed6613f5a2828779a7c8d3b312fd4c}%

.. code-block:: ini

    log-slow-queries = /var/log/slow-queries.log
    long_query_time = 1.5


%{whats-next_a32a80fb655426107d82517b69a02162}%
---------------------
%{whats-next_05c5af5d5d4afd8b0aebc3b4a61088ae}%

%{whats-next_22c0f83c8d1e0acedd8bee94e7cf349e}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{whats-next_5540d6acf4174d7778e0a7afe8769dc7}%

.. figure:: ../_static/img/chrome-1.jpg
    :align: center



%{whats-next_7d06b0c1d56eb8a4de4749e396711d85}%

.. figure:: ../_static/img/firefox-1.jpg
    :align: center



%{whats-next_2bff9cea84721eb4139848329ad036c8}%
------------
%{whats-next_76659bb548efb3762629b44d48bbd9df|`rules for high performance web pages`_}%

.. figure:: ../_static/img/yslow-1.jpg
    :align: center



%{whats-next_22ac3220308de49b56b20e639030771d}%
^^^^^^^^^^^^^^^^^^^^^^^^^
%{whats-next_2de0509fca5f0aacdab5babd4b953db5|`Speed Tracer`_}%

.. figure:: ../_static/img/speed-tracer.jpg
    :align: center



%{whats-next_c8aefabe5f595f5a833712a524f40565}%

%{whats-next_0e3f773cfbd4657074ab27048bbb56a8}%
------------------------
%{whats-next_995f284bdefafa3803b23d0f65e6dcfb}%

%{whats-next_d06ae3ababdb7f62581c61f473410f6b}%
------------------------
%{whats-next_be4aca0e28427136d4df0db25c8b4068}%

.. code-block:: ini

    apc.enabled = On


%{whats-next_9bdd7f9dc4aee583ebe2cf085ba01f30}%

%{whats-next_8f9d9970427920451acf7c4983e22144}%
----------------------------------
%{whats-next_236c23116970492ef2f675241540f17b}%

* :1:
* `Redis <http://redis.io/>`_
* `RabbitMQ <http://www.rabbitmq.com/>`_
* `Resque <https://github.com/chrisboulton/php-resque>`_
* `Gearman <http://gearman.org/>`_
* `ZeroMQ <http://www.zeromq.org/>`_

%{whats-next_31bc881424156d5e7144482cfb01c98f}%
-----------------
%{whats-next_c5b991040c0cf0ab6cc0b5a08a9523a6}%

