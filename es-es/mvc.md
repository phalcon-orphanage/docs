---
layout: default
language: 'es-es'
version: '4.0'
title: 'Model View Controller (MVC)'
keywords: 'model, view, controller, model view controller, mvc'
---

# MVC - Model View Controller

* * *

![](/assets/images/document-status-stable-success.svg)

## Overview

Model View Controller ([MVC](https://en.wikipedia.org/wiki/Model–view–controller)) is a software architectural pattern, which divides the application logic into three interconnected elements, separating internal representations of information of the application.

Phalcon offers the object-oriented classes, necessary to implement the Model View Controller in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Aislamiento de la lógica de negocio de la interfaz de usuario y la capa de base de datos
* Deja claro a cual parte de esta arquitectura pertenece cada tipo de código para facilitar el mantenimiento

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in Zephir, which is translated to C, offering a high performance implementation of the MVC pattern in PHP applications.

## Modelos

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos. [more...](db-models)

## Vistas

Las vistas representan la interfaz de usuario de su aplicación. Las vistas, son a menudo, archivos HTML con código PHP incrustado que realizan tareas relacionadas solamente a la presentación de datos. Las vistas llevan a cabo el trabajo de proveer datos al navegador web u otra herramienta que es usada para hacer solicitudes desde su aplicación. [more...](views)

## Controladores

The controllers provide the *flow* between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [more...](controllers)