---
layout: article
language: 'pl-pl'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='architecture'></a>

# The MVC Architecture

Phalcon offers the object-oriented classes, necessary to implement the Model, View, Controller architecture (often referred to as [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Isolation of business logic from the user interface and the database layer
* Making it clear where different types of code belong for easier maintenance

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application.

<a name='models'></a>

## Modele

Model odzwierciedla informacje (dane) z aplikacji oraz zasady ich przetwarzania. Modele są przede wszystkim wykorzystywane do interakcji z odpowiednia bazą danych. W większości przypadków, każda tabela w Twojej bazie danych odpowiada jednemu modelowi w Twojej aplikacji. Większość logiki biznesowej Twojej aplikacji będzie zawarta w modelach. [Learn more](/4.0/en/models)

<a name='views'></a>

## Widoki

Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. [Learn more](/4.0/en/views)

<a name='controllers'></a>

## Kontrolery

The controllers provide the 'flow' between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [Learn more](/4.0/en/controllers)