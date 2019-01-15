* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='architecture'></a>

# La Arquitectura MVC

Phalcon ofrece las clases orientadas a objetos necesarias para implementar el arquitectura Modelo, Vista, Controlador (referido a menudo como [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) en su aplicación. Este patrón es ampliamente utilizado por otros frameworks web y aplicaciones de escritorio.

Los beneficios de MVC incluyen:

* Aislamiento de la lógica de negocio de la interfaz de usuario y la capa de base de datos
* Deja claro a cual parte de esta arquitectura pertenece cada tipo de código para facilitar el mantenimiento

Si usted decide utilizar MVC, cada solicitud a los recursos de la aplicación será administrada por la arquitectura MVC. Las clases de Phalcon están escritas en lenguaje C, ofreciendo un enfoque de alto rendimiento de este patrón en una aplicación basada en PHP.

<a name='models'></a>

## Modelos

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos. [Learn more](/4.0/en/models)

<a name='views'></a>

## Vistas

Las vistas representan la interfaz de usuario de su aplicación. Las vistas, son a menudo, archivos HTML con código PHP incrustado que realizan tareas relacionadas solamente a la presentación de datos. Las vistas llevan a cabo el trabajo de proveer datos al navegador web u otra herramienta que es usada para hacer solicitudes desde su aplicación. [Learn more](/4.0/en/views)

<a name='controllers'></a>

## Controladores

Los controladores proporcionan el 'flujo' entre modelos y vistas. Los controladores son responsables de procesar las peticiones entrantes desde el navegador web, solicitar datos a los modelos y pasar esos datos a las vistas para la representación de la información. [Learn more](/4.0/en/controllers)