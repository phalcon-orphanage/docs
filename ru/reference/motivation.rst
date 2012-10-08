Our motivation
==============

There are many PHP frameworks nowadays, but none of them is like Phalcon (Really, trust us on this one).

Almost all programmers prefer to use a framework. This is primarily because it provides a lot of functionality that is already tested and ready to use, therefore keeping code DRY (Don't Repeat Yourself). However, the framework itself demands a lot of file inclusions and hundreds of lines of code to be interpreted and executed on each request from the actual application. This operation slows the application down and subsequently impacts the end user experience.

The Question
------------

Why can't we have a framework with all of its advantages but with none or very few disadvantages?

This is why Phalcon was born!

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant optimizations (big or small). Through understanding of the Zend Engine, we managed to remove unnecessary validations, compacted code, performed optimizations and generated low-level solutions so as to achieve maximum performance from Phalcon. 

Why?
----

* The use of frameworks has become mandatory in professional development with PHP
* Frameworks offer a structured philosophy to easily maintain projects writing less code and making work more fun

Inner workings of PHP?
----------------------

* PHP has dynamic and weak variable types. Every time a binary operation is made (ex. 2 + "2"), PHP checks the operand types to perform potential conversions
* PHP is interpreted and not compiled. The major disadvantage is performance loss
* Every time a script is requested it must be first interpreted.
* If a bytecode cache (like APC) isn't used, syntax checking is performed every time for every file in the request

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

