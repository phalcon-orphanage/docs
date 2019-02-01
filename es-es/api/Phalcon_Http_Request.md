---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Http\Request'
---
# Class **Phalcon\Http\Request**

*implements* [Phalcon\Http\RequestInterface](Phalcon_Http_RequestInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request.zep)

Encapsula la información de solicitud para un acceso fácil y seguro desde los controladores de la aplicación.

The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

if ($request->isPost() && $request->isAjax()) {
    echo "Request was made using POST and AJAX";
}

$request->getServer("HTTP_HOST"); // Retrieve SERVER variables
$request->getMethod();            // GET, POST, PUT, DELETE, HEAD, OPTIONS, PATCH, PURGE, TRACE, CONNECT
$request->getLanguages();         // An array of languages the client accepts

```

## Métodos

public **getHttpMethodParameterOverride** ()

...

public **setHttpMethodParameterOverride** (*mixed* $httpMethodParameterOverride)

...

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el inyector de dependencia

public **getDI** ()

Devuelve el inyector de dependencias interno

public **get** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
<?php

// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");

```

public **getPost** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Obtiene una variable del $_POST superglobal aplicando filtros si es necesario. Si no se proporcionan parámetros se devuelve el $_POST superglobal

```php
<?php

// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");

```

public **getPut** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Obtiene una variable del PUT request

```php
<?php

// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");

```

public **getQuery** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Obtiene una variable del $_GET superglobal aplicando filtros si es necesario. Si no se proporcionan parámetros se devuelve el $_GET superglobal

```php
<?php

// Returns value from $_GET["id"] without sanitizing
$id = $request->getQuery("id");

// Returns value from $_GET["id"] with sanitizing
$id = $request->getQuery("id", "int");

// Returns value from $_GET["id"] with a default value
$id = $request->getQuery("id", null, 150);

```

final protected **getHelper** (*array* $source, [*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.

public **getServer** (*mixed* $name)

Obtiene una variable del $_SERVER superglobal

public **has** (*mixed* $name)

Comprueba si $_REQUEST superglobal tiene un determinado índice

public **hasPost** (*mixed* $name)

Comprueba si $_POST superglobal tiene un determinado índice

public **hasPut** (*mixed* $name)

Comprueba si los datos PUT tienen un determinado índice

public **hasQuery** (*mixed* $name)

Comprueba si $_GET superglobal tiene un determinado índice

final public **hasServer** (*mixed* $name)

Comprueba si $_SERVER superglobal tiene un determinado índice

final public **getHeader** (*mixed* $header)

Obtiene la cabecera HTTP de los datos de solicitud

public **getScheme** ()

Obtiene el esquema HTTP (http/https)

public **isAjax** ()

Comprueba si se ha hecho una solicitud utilizando ajax

public **isSoap** ()

Comprueba si se ha hecho una solicitud utilizando SOAP

public **isSoapRequested** ()

Alias of isSoap(). It will be deprecated in future versions

public **isSecure** ()

Comprueba si la solicitud se ha hecho utilizando cualquier nivel de seguridad

public **isSecureRequest** ()

Alias of isSecure(). It will be deprecated in future versions

public **getRawBody** ()

Obtiene el cuerpo de solicitud sin procesar HTTP

public **getJsonRawBody** ([*mixed* $associative])

Obtiene el cuerpo de solicitud sin procesar decodificado JSON HTTP

public **getServerAddress** ()

Obtiene el IP de la dirección del servidor activo

public **getServerName** ()

Obtiene el nombre del servidor activo

public **getHttpHost** ()

Obtiene el nombre del host utilizado por la solicitud. `Request::getHttpHost` Intenta encontrar el nombre del host en el siguiente orden: - `$_SERVER["HTTP_HOST"]` - `$_SERVER["SERVER_NAME"]` - `$_SERVER["SERVER_ADDR"]` Opcionalmente `Request::getHttpHost` valida y borra el nombre del host. El `Request::$_strictHostCheck` puede ser utilizado para validar el nombre del host. Nota: la validación y la limpieza tienen un impacto negativo en el rendimiento porque utilizan expresiones regulares.

```php
<?php

use Phalcon\Http\Request;

$request = new Request;

$_SERVER["HTTP_HOST"] = "example.com";
$request->getHttpHost(); // example.com

$_SERVER["HTTP_HOST"] = "example.com:8080";
$request->getHttpHost(); // example.com:8080

$request->setStrictHostCheck(true);
$_SERVER["HTTP_HOST"] = "ex=am~ple.com";
$request->getHttpHost(); // UnexpectedValueException

$_SERVER["HTTP_HOST"] = "ExAmPlE.com";
$request->getHttpHost(); // example.com

```

public **setStrictHostCheck** ([*mixed* $flag])

Establece si el método `Request::getHttpHost` debe utilizar o no una validación estricta del nombre del host

public **isStrictHostCheck** ()

Comprueba si el método `Request::getHttpHost` utilizará o no una validación estricta del nombre del host

public **getPort** ()

Obtiene información sobre el puerto en el cual se realizó la solicitud.

final public **getURI** ()

Obtiene el HTTP URL en el cual se hizo la solicitud

public **getClientAddress** ([*mixed* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]

final public **getMethod** ()

Obtiene el método HTTP en el cual se hizo la solicitud. Si la cabecera X-HTTP-Method-Override esta configurada, y si el método es un POST, entonces se utiliza para determinar el método HTTP deseado y "verdadero". El parámetro de solicitud _method también puede ser utilizado para determinar el método HTTP, pero solo si setHttpMethodParameterOverride(true) ha sido llamado. El método siempre es una cadena en mayúscula.

public **getUserAgent** ()

Obtiene el agente de usuario HTTP utilizado para hacer la solicitud

public **isValidHttpMethod** (*mixed* $method)

Comprueba si un método es un método HTTP válido

public **isMethod** (*mixed* $methods, [*mixed* $strict])

Comprueba si el método HTTP coincide con cualquier método pasado. Cuando strict es true, comprueba si los métodos validados son métodos HTTP verdaderos

public **isPost** ()

Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"

public **isGet** ()

Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"

public **isPut** ()

Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"

public **isPatch** ()

Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"

public **isHead** ()

Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"

public **isDelete** ()

Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"

public **isOptions** ()

Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"

public **isPurge** ()

Checks whether HTTP method is PURGE (Squid and Varnish support). if _SERVER["REQUEST_METHOD"]==="PURGE"

public **isTrace** ()

Checks whether HTTP method is TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"

public **isConnect** ()

Checks whether HTTP method is CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"

public **hasFiles** ([*mixed* $onlySuccessful])

Comprueba si la solicitud incluye archivos adjuntos

final protected **hasFileHelper** (*mixed* $data, *mixed* $onlySuccessful)

Cuenta recursivamente un archivo en un arreglo de archivos

public **getUploadedFiles** ([*mixed* $onlySuccessful])

Gets attached files as Phalcon\Http\Request\File instances

final protected **smoothFiles** (*array* $names, *array* $types, *array* $tmp_names, *array* $sizes, *array* $errors, *mixed* $prefix)

Simplifica $_FILES para tener un arreglo simple con todos los archivos cargados

public **getHeaders** ()

Devuelve las cabeceras disponibles en la solicitud

```php
<?php

$_SERVER = [
    "PHP_AUTH_USER" => "phalcon",
    "PHP_AUTH_PW"   => "secret",
];

$headers = $request->getHeaders();

echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=

```

public **getHTTPReferer** ()

Gets web page that refers active request. ie: https://www.google.com

final protected **_getBestQuality** (*array* $qualityParts, *mixed* $name)

Procesa una cabecera de solicitud y devuelve la que tiene mejor calidad

public **getContentType** ()

Obtiene el tipo de contenido del cual se ha hecho la solicitud

public **getAcceptableContent** ()

Obtiene un arreglo con mime o tipos y su calidad aceptadas por el navegador o cliente desde _SERVER["HTTP_ACCEPT"]

public **getBestAccept** ()

Obtiene el mejor mime o tipo aceptado por el navegador o cliente desde _SERVER["HTTP_ACCEPT"]

public **getClientCharsets** ()

Obtiene un arreglo de conjunto de caracteres y su calidad aceptada por el navegador o cliente desde _SERVER["HTTP_ACCEPT_CHARSET"]

public **getBestCharset** ()

Obtiene el mejor conjunto de caracteres aceptado por el navegador o cliente desde _SERVER["HTTP_ACCEPT_CHARSET"]

public **getLanguages** ()

Obtiene un arreglo de los idiomas y su calidad aceptada por el navegador o cliente desde _SERVER["HTTP_ACCEPT_LANGUAGE"]

public **getBestLanguage** ()

Obtiene el mejor idioma aceptado por el navegador o cliente desde _SERVER["HTTP_ACCEPT_LANGUAGE"]

public **getBasicAuth** ()

Obtiene la información de autentificación aceptada por el navegador o cliente desde $_SERVER["PHP_AUTH_USER"]

public **getDigestAuth** ()

Obtiene la información de autentificación aceptada por el navegador o cliente desde $_SERVER["PHP_AUTH_DIGEST"]

final protected **_getQualityHeader** (*mixed* $serverIndex, *mixed* $name)

Procesa una cabecera de solicitud y devuelve un arreglo de valores con sus atributos