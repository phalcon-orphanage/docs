---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Http\Cookie'
---
# Class **Phalcon\Http\Cookie**

*implements* [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookie.zep)

Proporciona contenedores OO para administrar una cookie HTTP

## Métodos

public **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\Http\Cookie constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el inyector de dependencia

public **getDI** ()

Devuelve el inyector de dependencias interno

public [Phalcon\Http\Cookie](Phalcon_Http_Cookie) **setValue** (*string* $value)

Establece el valor de la cookie

public *mixed* **getValue** ([*string* | *array* $filters], [*string* $defaultValue])

Devuelve el valor del cookie

public **send** ()

Envía el cookie al cliente HTTP. Almacena la definición de la cookie en la sesión

public **restore** ()

Lee la información relacionada a la cookie desde la SESIÓN para restaurar la cookie como fue establecida. Este método se llama automáticamente e internamente y por lo general no se necesita llamarlo

public **delete** ()

Elimina la cookie al configurar una fecha de expiración en el pasado

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Establece si la cookie debe ser cifrada o descifrada automáticamente

public **isUsingEncryption** ()

Comprueba si la cookie utiliza un cifrado implícito

public **setExpiration** (*mixed* $expire)

Establece la fecha de expiración de la cookie

public **getExpiration** ()

Devuelve la fecha de expiración actual

public **setPath** (*mixed* $path)

Establece la fecha de expiración de la cookie

public **getName** ()

Devuelve el nombre de la cookie actual

public **getPath** ()

Devuelve la ruta de la cookie actual

public **setDomain** (*mixed* $domain)

Establece el dominio al cual la cookie está disponible

public **getDomain** ()

Devuelve el dominio para el cual la cookie está disponible

public **setSecure** (*mixed* $secure)

Establece si la cookie debe ser enviada solamente cuando la conexión es segura (HTTPS)

public **getSecure** ()

Devuelve si la cookie debe ser enviada solamente cuando la conexión es segura (HTTPS)

public **setHttpOnly** (*mixed* $httpOnly)

Establece si la cookie puede ser accedida solamente mediante el protocolo HTTP

public **getHttpOnly** ()

Devuelve si la cookie puede ser accedida solamente mediante el protocolo HTTP

public **__toString** ()

El método Magic __toString convierte el valor de la cookie a una cadena