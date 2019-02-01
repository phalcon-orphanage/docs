---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Flash\Session'
---
# Class **Phalcon\Flash\Session**

*extends* abstract class [Phalcon\Flash](Phalcon_Flash)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\FlashInterface](Phalcon_FlashInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/flash/session.zep)

Se almacena temporalmente los mensajes en la sesión, luego se pueden imprimir los mensajes en la siguiente consulta

## Métodos

protected **_getSessionMessages** (*mixed* $remove, [*mixed* $type])

Devuelve los mensajes almacenados en la sesión

protected **_setSessionMessages** (*array* $messages)

Almacena los mensajes en la sesión

public **message** (*mixed* $type, *mixed* $message)

Agrega un mensaje al flasher de la sesión

public **has** ([*mixed* $type])

Comprueba si hay mensajes

public **getMessages** ([*mixed* $type], [*mixed* $remove])

Devuelve los mensajes en el flasher de la sesión

public **output** ([*mixed* $remove])

Imprime los mensajes en el flasher de la sessión

public **clear** ()

Borra los mensajes en el messenger de la sesión

public **__construct** ([*mixed* $cssClasses]) inherited from [Phalcon\Flash](Phalcon_Flash)

Phalcon\Flash constructor

public **getAutoescape** () inherited from [Phalcon\Flash](Phalcon_Flash)

Devuelve el modo autoescape en el Html generado

public **setAutoescape** (*mixed* $autoescape) inherited from [Phalcon\Flash](Phalcon_Flash)

Establece el modo autoescape en el html generado

public **getEscaperService** () inherited from [Phalcon\Flash](Phalcon_Flash)

Devuelve el servicio Escaper

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService) inherited from [Phalcon\Flash](Phalcon_Flash)

Establece el servicio Escaper

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Flash](Phalcon_Flash)

Configura el inyector de dependencia

public **getDI** () inherited from [Phalcon\Flash](Phalcon_Flash)

Devuelve el inyector de dependencias interno

public **setImplicitFlush** (*mixed* $implicitFlush) inherited from [Phalcon\Flash](Phalcon_Flash)

Establece si la salida debe ser implícitamente vaciado a la salida o devuelto como una cadena

public **setAutomaticHtml** (*mixed* $automaticHtml) inherited from [Phalcon\Flash](Phalcon_Flash)

Establece si la salida debe ser implícitamente formateada con HTML

public **setCssClasses** (*array* $cssClasses) inherited from [Phalcon\Flash](Phalcon_Flash)

Configura un arreglo con clases CSS para formatear los mensajes

public **error** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Muestra un mensaje de error HTML

```php
<?php

$flash->error("This is an error");

```

public **notice** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Muestra un mensaje de información o notificación HTML

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Muestra un mensaje de éxito HTML

```php
<?php

$flash->success("The process was finished successfully");

```

public **warning** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Muestra un mensaje de advertencia HTML

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Genera un mensaje que lo formatea con HTML

```php
<?php

$flash->outputMessage("error", $message);

```