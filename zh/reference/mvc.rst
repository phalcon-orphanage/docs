MVC架构
====================

Phalcon提供了面向对象的类，用以在应用程序中实现模型，视图，控制器架构（通常我们称之为 MVC_ 架构）。这种设计模式被广泛的应用到其他Web框架以及桌面应用程序中。

MVC的好处包括：

* 分离业务逻辑与用户界面以及数据库层
* 清晰的代码结构，使代码更容易维护

如果你决定使用MVC架构来开发你的程序，那么应用程序的每个请求都将采用 MVC_ 架构的方式来管理。Phalcon是一个采用C语言开发的php框架，这种模式是一种可以很好的提供高性能的方法。

模型
------
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application's business logic will be concentrated in the models. :doc:`Learn more <models>`

视图
-----
Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. :doc:`Learn more <views>`

控制器
-----------
The controllers provide the "flow" between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. :doc:`Learn more <controllers>`

.. _MVC: http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
