框架基准测试（Framework Benchmarks）
====================
在过去，当开发web应用时，性能不是作为最高优先级之一被考虑的。因为硬件可以填补这块的空缺。
然而，当Google `决定`_ 将网站的速度纳入搜索排名时，性能成为了与功能并起并坐的最高优先级之一。
这也就是说一个可以提高网站性能的方式，将对站点有着正面积极的意义和影响。

以下的基准测试，展示了相比传统的PHP框架，Phalcon是多么地高效。这些基准测试会随着任意被提及到的框架和Phalcon本身发布的稳定版本更新而同步更新。
  
我们鼓励程序员拷贝我们用于进行我们基准测试的测试套件。如果你任何额外的优化方案或者建议，
都可以 `联系我们`_ 。 `从Github上签出源代码`_ 

怎样的测试环境？（What was the test environment?）
------------------------------
APC_ 中间层代码缓存可适用于全部框架。任何Apache模块重定向特性可以被禁止掉以避免额外不必要的开销。

测试环境的硬件设备如下：

* Operating System: Mac OS X Lion 10.7.4
* Web Server: Apache httpd 2.2.22
* PHP: 5.3.15
* CPU: 2.04 Ghz Intel Core i5
* Main Memory: 4GB 1333 MHz DDR3
* Hard Drive: 500GB SATA Disk

*PHP 版本和相关信息:*

.. figure:: ../_static/img/bench-4.png
    :align: center

*APC 配置：*

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
.. 添加版本:: 1.0
    2012-03-20更新：改变apc.stat配置为Off并重做基准测试。更多信息

.. 版本修改 :: 1.1
    2012-05-13更新：为Symfony用纯PHP模板引擎重做基准测试。Yii下的配置也根据推荐进行调整。

.. 版本修改 :: 1.2
    2012-05-20更新：增加Fuel框架到基准测试。

.. 版本修改 :: 1.3
    2012-06-04更新：增加Cake框架到基准测试。它并没有在图表中呈现，因为它用了30秒却只执行了千分之10。

.. 版本修改 :: 1.4
    2012-08-27更新：PHP更新到5.3.15, APC更新到3.1.11, Yii更新到1.1.12, Phalcon更新到0.5.0, 添加Laravel, OS更新到Mac OS X Lion。硬件升级。.

外部资源（External Resources）
------------------
* `对于没有耐心的网页用户，打开一个漫长的Eye Blink就难以等待 <http://www.nytimes.com/2012/03/01/technology/impatient-web-users-flee-slow-loading-sites.html?pagewanted=all&_r=0>`_
* `百万性能的案例： 性能的影响 <https://github.com/zenorocha/browser-diet/wiki/Impact-of-performance>`_
* `我们前进有多快？ <http://www.stevesouders.com/blog/2013/05/09/how-fast-are-we-going-now/>`_
* `速度，性能和人类的知觉 ` <http://chimera.labs.oreilly.com/books/1230000000545/ch10.html#SPEED_PERFORMANCE_HUMAN_PERCEPTION>`_

.. _决定: http://googlewebmastercentral.blogspot.com/2010/04/using-site-speed-in-web-search-ranking.html
.. _联系我们: https://github.com/phalcon/framework-bench
.. _从Github上签出源代码: https://github.com/phalcon/framework-bench
.. _APC: http://php.net/manual/en/book.apc.php
