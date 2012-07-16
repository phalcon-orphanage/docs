The MVC Architecture
====================

Phalcon provides you object oriented classes to implement a Model, View, Controller architecture, usually just called MVC_. This design pattern is widely used by other web frameworks and desktop applications. MVC benefits include: 

.. _MVC: http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller

* Isolation of business logic from the user interface
* Making it clear where different types of code belong for easier maintenance

When you decide to use MVC, every request to an application will be managed by MVC. Phalcon classes written in C language provide a high performance approach of this pattern in a PHP based application. 

Models
------
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application’s business logic will be concentrated in the models. `Learn more </reference/controllers>`_

Views
-----
Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. Learn more

Controllers
-----------
The controllers provide the “flow” between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. Learn more

