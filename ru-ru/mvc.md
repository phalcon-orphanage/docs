---
layout: default
language: 'ru-ru'
version: '4.0'
title: 'Model View Controller (MVC)'
keywords: 'model, view, controller, model view controller, mvc'
---

# MVC - Model View Controller

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Введение

Model View Controller ([MVC](https://en.wikipedia.org/wiki/Model–view–controller)) is a software architectural pattern, which divides the application logic into three interconnected elements, separating internal representations of information of the application.

Phalcon offers the object-oriented classes, necessary to implement the Model View Controller in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Отделение бизнес-логики от пользовательского интерфейса и работы с базой данных
* Позволяет располагать разные части в разных местах, что благоприятно сказывается на поддержке и обслуживании

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in Zephir, which is translated to C, offering a high performance implementation of the MVC pattern in PHP applications.

## Модели

Модель представляет собой информацию (данные) приложения и правила для манипуляции этими данными. Модели в основном используется для управления соответствующей таблицей базы данных и правил взаимодействия с ней. В большинстве случаев, каждая таблица в вашей базе данных соответствует одной модели в вашем приложении. Большая часть всей бизнес-логики вашего приложения будет сосредоточена в моделях. [more...](db-models)

## Views

Views represent the user interface of your application. Чаще всего это HTML файлы с вставками PHP кода исключительно для вывода данных. Этот слой отвечает за вывод данных в веб-браузер или другой инструмент, который обращается к вашему приложению. [more...](views)

## Контроллеры

The controllers provide the *flow* between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [more...](controllers)