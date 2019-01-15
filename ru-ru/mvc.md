* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='architecture'></a>

# Архитектура MVC

Phalcon offers the object-oriented classes, necessary to implement the Model, View, Controller architecture (often referred to as [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Отделение бизнес-логики от пользовательского интерфейса и работы с базой данных
* Позволяет располагать разные части в разных местах, что благоприятно сказывается на поддержке и обслуживании

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application.

<a name='models'></a>

## Модели

Модель представляет собой информацию (данные) приложения и правила для манипуляции этими данными. Модели в основном используется для управления соответствующей таблицей базы данных и правил взаимодействия с ней. В большинстве случаев, каждая таблица в вашей базе данных соответствует одной модели в вашем приложении. Большая часть всей бизнес-логики вашего приложения будет сосредоточена в моделях. [Learn more](/4.0/en/models)

<a name='views'></a>

## Представления

Представление отвечает за пользовательский интерфейс вашего приложения. Чаще всего это HTML файлы с вставками PHP кода исключительно для вывода данных. Этот слой отвечает за вывод данных в веб-браузер или другой инструмент, который обращается к вашему приложению. [Learn more](/4.0/en/views)

<a name='controllers'></a>

## Контроллеры

The controllers provide the 'flow' between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [Learn more](/4.0/en/controllers)