框架基准测试
=================

在过去，开发的web应用程序，性能问题并不是作为首要考虑的问题之一。因为硬件可以填补这方面的不足。然后，当Google决定把网站的速度作为搜索排名的条件之一时，性能的重要性就体现出来了。

以下的基准测试，将展示Phalcon和其他传统的PHP框架的性能对比，这些基准框架的版本都是最新的稳定版本。

我们欢迎程序员利用我们的基准测试程序进行测试，如果您有更好的优化方案或意见，请 `write us`_. `Check out source at Github`_

测试的环境?
-------------------
所有的框架都开启了 APC_ 缓存，且禁用了apache mod_rewrite模块，以避免产生额外的性能开销.

下面是测试的硬件环境:

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


List of Benchmarks
------------------

.. toctree::
   :maxdepth: 1

   benchmark/hello-world
   benchmark/micro

ChangeLog
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

.. _decided: http://googlewebmastercentral.blogspot.com/2010/04/using-site-speed-in-web-search-ranking.html
.. _write us: https://github.com/phalcon/framework-bench
.. _Check out source at Github: https://github.com/phalcon/framework-bench
.. _APC: http://php.net/manual/en/book.apc.php

