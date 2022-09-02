---
layout: default
language: 'es-es'
version: '4.0'
title: 'Modelo Vista Controlador (MVC)'
keywords: 'modelo, vista, controlador, modelo vista controlador, mvc'
---

# MVC - Modelo Vista Controlador

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Modelo Vista Controlador ([MVC](https://en.wikipedia.org/wiki/Model–view–controller)) es un patrón de arquitectura de *software*, que divide la lógica de la aplicación en tres elementos interconectados, separando representaciones internas de la información de la aplicación.

Phalcon ofrece las clases orientadas a objetos, necesarias para implementar el Modelo Vista Controlador en su aplicación. Este patrón de diseño es ampliamente utilizado por otros *frameworks* web y aplicaciones de escritorio.

Los beneficios de MVC incluyen:

* Aislamiento de la lógica de negocio de la interfaz de usuario y la capa de base de datos
* Deja claro a cual parte de esta arquitectura pertenece cada tipo de código para facilitar el mantenimiento

Si decide usar MVC, cada petición a los recursos de su aplicación será gestionada por la arquitectura MVC. Las clases de Phalcon están escritas en Zephir, que se traduce a C, ofreciendo una implementación de alto rendimiento del patrón MVC en aplicaciones PHP.

## Modelos

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos. [más...](db-models)

## Vistas

Las vistas representan la interfaz de usuario de su aplicación. Las vistas, son a menudo, archivos HTML con código PHP incrustado que realizan tareas relacionadas solamente con la presentación de datos. Las vistas llevan a cabo el trabajo de proveer datos al navegador web u otra herramienta que es usada para hacer solicitudes desde su aplicación. [más...](views)

## Controladores

Los controladores proporcional el *flujo* entre modelos y vistas. Los controladores son los responsables de procesar las peticiones entrantes desde el navegador web, solicitar datos a los modelos, y pasar esos datos a las vistas para su presentación. [más...](controllers)
