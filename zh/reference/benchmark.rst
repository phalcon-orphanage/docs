框架基准测试（Framework Benchmarks）
====================
在过去，当开发web应用时，性能不是作为最高优先级之一被考虑的。因为硬件可以填补这块的空缺。
然而，当Google决定将网站的速度纳入搜索排名时，性能成为了与功能并起并坐的最高优先级之一。
这也就是说一个可以提高网站性能的方式，将对站点有着正面积极的意义和影响。

以下的基准测试，展示了相比传统的PHP框架，Phalcon是多么地高效。

我们鼓励
or comments please `write us`_. `Check out source at Github`_

怎样的测试环境？（What was the test environment?）
------------------------------
APC_ intermediate code cache was enabled for all frameworks. Any Apache mod-rewrite feature was disabled when possible
to avoid potentially additional overheads.

The testing hardware environment is as follows:

* Operating System: Mac OS X Lion 10.7.4
* Web Server: Apache httpd 2.2.22
* PHP: 5.3.15
* CPU: 2.04 Ghz Intel Core i5
* Main Memory: 4GB 1333 MHz DDR3
* Hard Drive: 500GB SATA Disk

*PHP version and info:*

.. figure:: ../_static/img/bench-4.png
    :align: center

*APC settings:*

.. figure:: ../_static/img/bench-5.png
    :align: center


基准测试列表（List of Benchmarks）
------------------
.. toctree::
   :maxdepth: 1

   benchmark/hello-world
   benchmark/micro

变更日志（ChangeLog）
---------
.. versionadded:: 1.0
    Update Mar-20-2012: Benchmarks redone changing the apc.stat setting to Off. More Info

.. versionchanged:: 1.1
    Update May-13-2012: Benchmarks redone PHP plain templating engine instead of Twig for Symfony. Configuration settings for Yii were also changed as recommended.

.. versionchanged:: 1.2
    Update May-20-2012: Fuel framework was added to benchmarks.

.. versionchanged:: 1.3
    Update Jun-4-2012: Cake framework was added to benchmarks. It is not however present in the graphics, since it takes  30 seconds to run only 10 of 1000.

.. versionchanged:: 1.4
    Update Ago-27-2012: PHP updated to 5.3.15, APC updated to 3.1.11, Yii updated to 1.1.12, Phalcon updated to 0.5.0, Added Laravel, OS updated to Mac OS X Lion. Hardware upgraded.

外部资源（External Resources）
------------------
* `For Impatient Web Users, an Eye Blink Is Just Too Long to Wait <http://www.nytimes.com/2012/03/01/technology/impatient-web-users-flee-slow-loading-sites.html?pagewanted=all&_r=0>`_
* `Millionaires performance cases: Impact of performance <https://github.com/zenorocha/browser-diet/wiki/Impact-of-performance>`_
* `How fast are we going now? <http://www.stevesouders.com/blog/2013/05/09/how-fast-are-we-going-now/>`_
* `Speed, performance and human perception` <http://chimera.labs.oreilly.com/books/1230000000545/ch10.html#SPEED_PERFORMANCE_HUMAN_PERCEPTION>`_

.. _decided: http://googlewebmastercentral.blogspot.com/2010/04/using-site-speed-in-web-search-ranking.html
.. _write us: https://github.com/phalcon/framework-bench
.. _Check out source at Github: https://github.com/phalcon/framework-bench
.. _APC: http://php.net/manual/en/book.apc.php
