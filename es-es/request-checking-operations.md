---
layout: article
language: 'es-es'
version: '4.0'
category: 'request'
---
# Componente de Petición HTTP

* * *

## Comprobando operaciones

El componente [Phalcon\Http\Request](api/Phalcon_Http_Request) contiene una serie de métodos que te ayudan a comprobar la operación actual. Por ejemplo, si quieres comprobar si se ha realizado una solicitud en particular usando AJAX, puedes hacerlo usando el método `isAjax()`. Todos los métodos llevan el prefijo `is`. - `isAjax()`: comprueba si solicitud ha sido formulada utilizando AJAX - `isConnect()`: comprueba si el método HTTP es CONNECT - `isDelete()`: comprueba si método HTTP es DELETE - `isGet()`: comprueba si método HTTP es GET - `isHead()`: comprueba si método HTTP es HEAD - `isMethod()`: comprueba si el método HTTP coincide con ninguno de los métodos pasados - `isOptions()`: comprueba si el método HTTP es OPTIONS - `isPatch()`: comprueba si el método HTTP es PATCH - `isPost()`: comprueba si método HTTP es POST - `isPurge()`: comprueba si el método HTTP es PURGE (soporte para Squid y Varnish) - `isPut()`: comprueba si el método HTTP se PUT - `isSecure()`: comprueba si solicitud ha sido formulada con alguna capa segura - `isSoap()`: comprueba si solicitud ha sido formulada con SOAP - `isTrace()`: comprueba si método HTTP es TRACE - `isValidHttpMethod()`: comprueba si un método es un método HTTP válido

## Comprobando existencia

Hay un número de métodos disponibles que le permiten comprobar la existencia de elementos de la solicitud. Estos métodos llevan el prefijo `has`. Dependiendo del método utilizado, puede comprobar si existe un elemento en el `$_REQUEST`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, caché PUT y los encabezados de solicitud. - `has()`: comprueba si la superglobal $_REQUEST tiene un cierto elemento - `hasFiles()`: comprueba si la solicitud tiene subido archivos - `hasHeader()`: comprueba si las cabeceras tienen un cierto elemento - `hasPost()`: comprueba si $_POST superglobal tiene un cierto elemento - `hasPut()`: comprueba si PUT tiene un cierto elemento - `hasQuery()`: comprueba si la superglobal $_GET tiene un cierto elemento - `hasServer()`: comprueba si la superglobal $_SERVER tiene un cierto elemento