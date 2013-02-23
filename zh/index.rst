Welcome!
========

欢迎使用Phalcon php 框架，我们的使命是给你一个开发网站及应用的高级工具，而你却不必担心性能问题.

什么是 Phalcon?
------------------

Phalcon 是一个开源的，全堆栈的，用C语言写成的php5框架，专为高性能设计。你不需要学习和使用C语言的功能，因为这是一个PHP框架，只不过用C写成而已。同时Phalcon是松耦合的，您可以根据需要使用其他组件。

Phalcon不只是性能优越，我们的目标是让它强大而且易于使用!

译者说明
----------------------
一般都是直接看英文资料，大都能看得懂。但看到Phalcon框架如此优秀，在学习后就想和大家分享，但发现国内的人几乎没有使用的，故想翻译一下，一旦翻译才发现读懂和译出一篇好文章真的不太一样。
故前一期翻译的部分章节有点生硬，等有空的时候再回头重译吧，后面的一部分也是以英文文档为基础，但并不再是逐句翻译了。

09年左右，大量的框架出现，我看过的框架不下20种，最先看到的可能就是php.MVC了，这是一个按照struts 1x编写的，只不过同时加载的类库太多了，效率不高而且不太完善。

后来稍有名的包括 cakephp, Symfony, Akelos, Prado, Kohana等，最近几年流行的就是 zf, yii, ci等，当然还有国内几个比较有名的框架，如fleaphp, thinkphp等。

在上面的一些框架中，我比较感冒的还是ci,yii,thinkphp等。ci,thinkphp够简单，速度也不错。yii是生活在国外的华人开发，功能够全而强大，速度也不错，国内的应用也不少。

一直不太喜欢zf，记得几年前就和同行朋友聊天的时候说，像ZEND公司完全可以用C语言开发出一个扩展来，这样效率会高得多，为毛非得用PHP开发呢，事实被我验证了，但开发扩展的不是ZEND公司，而是国内一个PHP大鸟，人称鸟哥。这个框架就是非常出名的YAF，因此YAF扩展是我必装的扩展之一。同时这也是我发现的第一个C语言写的扩展框架。

但YAF的缺点是，功能非常不完善，在我看来只是简单实现了MVC结构及路由，分发等功能，像一些ORM之类的功能完全没有开发，作者好像也没有开发的意思：）

后来就发现了Phalcon，一看文档就爱上了她，功能，速度等都是我想要的，我花了一周时间看文档学习她，并在一个下午的过程中，发现了文档中的三个错误并提交了这些错误：），我决定为完善它也贡献一点自己的力量。

本文档的中文地址存放在 http://phalcon.5iunix.net

Github上的地址为： https://github.com/netstu/phalcondocs ，您如果发现有些地方译的有些操蛋，烦请你fork它，并完善她。

目录
-------------

.. toctree::
   :maxdepth: 2

   reference/motivation
   reference/benchmark
   reference/install
   reference/tutorial
   reference/tutorial-invo
   reference/tutorial-rest
   reference/di
   reference/mvc
   reference/controllers
   reference/models
   reference/phql
   reference/odm
   reference/views
   reference/tags
   reference/volt
   reference/applications
   reference/routing
   reference/dispatching
   reference/micro
   reference/namespaces
   reference/events
   reference/request
   reference/response
   reference/url
   reference/flash
   reference/session
   reference/filter
   reference/config
   reference/pagination
   reference/cache
   reference/acl
   reference/translate
   reference/loader
   reference/logging
   reference/cli
   reference/db
   reference/intl
   reference/migrations
   reference/debug
   reference/tools
   api/index
   reference/license

其他格式
---------------

* `PDF <http://media.readthedocs.org/pdf/phalcon-php-framework-documentation/latest/phalcon-php-framework-documentation.pdf>`_
* `HTML in one Zip <http://media.readthedocs.org/htmlzip/phalcon-php-framework-documentation/latest/phalcon-php-framework-documentation.zip>`_
* `ePub <http://media.readthedocs.org/epub/phalcon-php-framework-documentation/latest/phalcon-php-framework-documentation.epub>`_