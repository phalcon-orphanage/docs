我们的目的
==========

现在有很多各种各样的PHP框架，但他们没有一个像Phalcon一样（真的，在这点上请相信我）

几乎所有的程序员都喜欢使用框架，这主要是因为框架提供了很多的功能，已经经过了大量的测试，因此保持代码DRY（不要重复造轮子）。然而，框架本身需要包含大量的文件来解释和执行实际应用中的每个请求，因此会降低应用程序的性能，影响用户体验。

The Question
------------

为什么我们不能有这样一个框架，保持它的优势的同时，没有或者很少有缺点呢？

这就是为什么Phalcon诞生了！

在过去的几个月中，我们已经广泛地研究了PHP的行为，调查区域为显着优化（大或小）。
通过Zend引擎的理解，我们设法消除不必要的验证，压缩的代码，进行优化和生成的
低级别的解决方案，从而使Phalcon实现最大的性能。

Why?
----

* The use of frameworks has become mandatory in professional development with PHP
* 框架提供了结构化的理念，以轻松维护项目，编写更少的代码，使工作变得更有趣

Inner workings of PHP?
----------------------

* PHP是一种动态的和弱变量类型语言。每次一个二进制运算（例如，2+“2”），PHP就会检查操作数的类型来进行类型转换
* PHP是解释型语言。主要的缺点是性能上的损失
* 每一个请求，它必须首先解释.
* 如果不使用字节码缓存（如APC），则任何时间的任何一个请求它都会进行语法检查

How traditional PHP frameworks work?
------------------------------------

* Many files with classes and functions are read on every request made. Disk reading is expensive in terms of performance, especially when the file structure includes deep folders
* Modern frameworks use lazy loading (autoload) to increase performance (for load and execute only the code needed)
* Continuous loading or interpreting is expensive and impacts performance
* The framework code does not change very often, therefore an application needs to load and interpret it every time a request is made

How does a PHP C-extension work?
--------------------------------

* C extensions are loaded together with PHP one time on the web server's daemon start process
* Classes and functions provided by the extension are ready to use for any application
* The code isn't interpreted because is already compiled to a specific platform and processor

How does Phalcon work?
----------------------

* Components are loosely coupled. With Phalcon, nothing is imposed on you: you're free to use the full framework, or just some parts of it as a glue components.
* Low-level optimizations provides the lowest overhead for MVC-based applications
* Interact with databases with maximum performance by using a C-language ORM for PHP
* Phalcon directly accesses internal PHP structures optimizing execution in that way as well

Conclusion
----------
Phalcon is an effort to build the fastest framework for PHP. You now have an even easier and robust way to develop applications without be worrying about performance. Enjoy!

