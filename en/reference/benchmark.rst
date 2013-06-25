Framework Benchmarks
====================
In the past, performance was not considered one of the top priorities when developing web applications. Reasonable hardware was
able to compensate for that. However when Google decided_ to take site speed into account in the search rankings, performance
became one of the top priorities alongside functionality. This is yet another way in which improving web performance will
have a positive impact on a website.

The benchmarks below, show how efficient Phalcon is when compared with other traditional PHP frameworks. These benchmarks
are updated as stable versions are released from any of the frameworks mentioned or Phalcon itself.

We encourage programmers to clone the test suite that we are using for our benchmarks. If you have any additional optimizations
or comments please `write us`_. `Check out source at Github`_

What was the test environment?
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

External Resources
------------------
* `For Impatient Web Users, an Eye Blink Is Just Too Long to Wait <http://www.nytimes.com/2012/03/01/technology/impatient-web-users-flee-slow-loading-sites.html?pagewanted=all&_r=0>`_
* `Millionaires performance cases: Impact of performance <https://github.com/zenorocha/browser-diet/wiki/Impact-of-performance>`_
* `How fast are we going now? <http://www.stevesouders.com/blog/2013/05/09/how-fast-are-we-going-now/>`_

.. _decided: http://googlewebmastercentral.blogspot.com/2010/04/using-site-speed-in-web-search-ranking.html
.. _write us: https://github.com/phalcon/framework-bench
.. _Check out source at Github: https://github.com/phalcon/framework-bench
.. _APC: http://php.net/manual/en/book.apc.php
