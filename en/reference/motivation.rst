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

