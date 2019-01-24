---
layout: article
language: 'fr-fr'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='architecture'></a>

# The MVC Architecture

Phalcon offers the object-oriented classes, necessary to implement the Model, View, Controller architecture (often referred to as [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Isolation of business logic from the user interface and the database layer
* Making it clear where different types of code belong for easier maintenance

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application.

<a name='models'></a>

## Modèles

Un modèle représente les informations (données) de l’application et les règles pour manipuler ces données. Les modèles sont principalement utilisés pour gérer les règles d’interaction avec une table de base de données. Dans la plupart des cas, chaque table dans votre base de données correspond à un modèle dans votre application. L’essentiel de la logique métier de votre application est concentré dans les modèles. [Learn more](/4.0/en/models)

<a name='views'></a>

## Vues

Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. [Learn more](/4.0/en/views)

<a name='controllers'></a>

## Controllers

The controllers provide the 'flow' between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [Learn more](/4.0/en/controllers)