Our motivation
==============

Today, there are many frameworks for PHP, but Phalcon is different! (Really, trust us this one). We all tend to use frameworks because they give us lots of functionality and ease of use in charge of more lines executed on every request slowing down our websites and applications. Why we can't have the framework advantages without the worst disadvantages? Here is our motivation to develop Phalcon. 

For the last months we have made research on PHP behavior looking for small and big optimizations, studying deeply the Zend Engine to achieve the omission of unnecessary validations generating low-level solutions to get the best possible performance. 

Why?
----

* Use of frameworks has become mandatory in professional development with PHP
* They offer a philosophy and organized structures to easily maintain projects writing less code and making work more fun


How PHP works?
--------------

* PHP have dynamic and weak variable types. Every time a binary operation is made (ex. 2 + "2"), it must to check the operand types to perform possible conversions
* PHP is interpreted (not compiled). Interpretation has advantages and disadvantages. Losing of performance is one of its disadvantages
* Every time a script is requested should be interpreted by PHP.
* If a bytecode cache (like APC) isn’t used, syntax checking is performed every time for every file in the request

How traditional php frameworks work?
------------------------------------

* Many files with classes and functions are read on every request made. Disk reading is expensive in terms of performance
* Modern frameworks use lazy loading technique (autoload) for load and execute only code needed
* Continuous loading/interpreting could be expensive and impact your application performance
* When you use a framework most of the code remains the same across development. Why load and interpret it every time?

How a PHP C-extension works?
----------------------------

* C extensions are loaded together with PHP once time on the web server daemon start process
* Classes and functions provided by the extension are ready to use for any application
* The code isn’t interpreted because is compiled to a specific platform and processor

How a Phalcon works?
--------------------

* Components are loosely coupled. With Phalcon, nothing is imposed on you: you're free to use the full framework, or just one piece of Phalcon all by itself.
* Low-level optimizations provide the lowest overhead for MVC-based applications
* Interact with databases with maximum performance by using a C-language ORM for PHP
* Phalcon is directly engaged with PHP, so it can directly access internal structures optimizing execution as well

Conclusion
----------
Phalcon is an effort to build the real fastest framework for PHP. You now have an even easier and robust way to develop applications without be worried about performance. Enjoy! 

