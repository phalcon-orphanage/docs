---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Model View Controller (MVC)'
keywords: 'model, view, controller, model view controller, mvc'
---

# MVC - Model View Controller

* * *

![](/assets/images/document-status-stable-success.svg)

## 概述

Model View Controller ([MVC](https://en.wikipedia.org/wiki/Model–view–controller)) is a software architectural pattern, which divides the application logic into three interconnected elements, separating internal representations of information of the application.

Phalcon offers the object-oriented classes, necessary to implement the Model View Controller in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Isolation of business logic from the user interface and the database layer
* Making it clear where different types of code belong for easier maintenance

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in Zephir, which is translated to C, offering a high performance implementation of the MVC pattern in PHP applications.

## Models

模型表示的信息 （数据） 的应用程序和规则来操作这些数据。 Models are primarily used for managing the rules of interaction with a corresponding database table. 在大多数情况下，每个数据库中的表将对应于在应用程序中的一个模型。 您的应用程序的业务逻辑的大部分将集中在模型。 [more...](db-models)

## Views

Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. [more...](views)

## Controllers

The controllers provide the *flow* between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [more...](controllers)