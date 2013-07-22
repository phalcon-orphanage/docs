Nossa Motivação
==============
Hoje em dia existem muitos frameworks em php, todavia nenhum deles é como o Phalcon (Sério, acredite no que estamos dizendo).

A maioria dos programadores preferem utilizar um framework.Isso basicamente acontece pelo grande conjunto de funcionalidades já prontas e testadas para o uso, mantendo o código base DRY (acrônimo de Don't Repeat Yourself, conceito que diz respeito a não repetição de códigos, mantendo o code base mais limpo e reutilizável). Entretanto, um framework por si só demanda uma porção de inclusões de arquivos e centenas de linhas de código para serem interpretadas e executadas a cada requisição da aplicação. Frameworks Orientados à Objetos sempre adicionam bastante overhead à cada execução, deixando a aplicação complexa e lenta. Todas essas operações retardam a aplicação e consequentemente afeta a experiencia do usuário final.

The Question
------------
Why can't we have a robust framework with all of its advantages but with none or very few disadvantages?

This is why Phalcon was born!

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant optimizations
(big or small). Through this understanding, we managed to remove unnecessary validations, compacted code, performed optimizations
and generated low-level solutions so as to achieve maximum performance from Phalcon.

Why?
----
* The use of frameworks has become mandatory in professional development with PHP
* Frameworks offer a structured philosophy to easily maintain projects writing less code and making work more fun
* We love PHP and we think it can be used to create larger and more ambitious projects

Inner workings of PHP?
----------------------
* PHP has dynamic and weak variable types. Every time a binary operation is made (ex. 2 + "2"), PHP checks the operand types to perform potential conversions
* PHP is interpreted and not compiled. The major disadvantage is performance loss
* Every time a script is requested it must be first interpreted
* If a bytecode cache (like APC) isn't used, syntax checking is performed every time for every file in the request

How traditional PHP frameworks work?
------------------------------------
* Many files with classes and functions are read on every request made. Disk reading is expensive in terms of performance, especially when the file structure includes deep folders
* Modern frameworks use lazy loading (autoload) to increase performance (for load and execute only the code needed)
* Some of these classes contain methods that aren't used in every request but they're loaded always consuming memory
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

Why do I need Phalcon?
----------------------
Each application requirements and tasks are different than another's. Some for instance are designed to do a set
of tasks and generate content that rarely changes. These applications can be created with any programming language or
framework. Using a front-end cache, usually makes such an application, no matter how poorly designed or slow it might be,
perform very fast.

Other applications generate content almost immediately that changes from request to request. In this case, PHP is used
to address all requests and generate the content. These applications can be APIs, discussion forums with high traffic loads,
blogs with a high number of comments and contributors, statistic applications, admin dashboards, enterprise resource
planners (ERP), business-intelligence software dealing with real time data and more.

An application will be as slow as its slowest component/process. Phalcon offers a very fast yet feature rich framework
that allows developers to concentrate on making their applications/code faster. Following proper coding processes,
Phalcon can deliver a lot more functionality/requests with less memory consumption and processing cycles.

Conclusion
----------
Phalcon is an effort to build the fastest framework for PHP. You now have an even easier and robust way
to develop applications with a framework implemented with the philosophy "Performance Really Matters"! Enjoy!
