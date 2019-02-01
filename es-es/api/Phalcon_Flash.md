---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Flash'
---
# Abstract class **Phalcon\Flash**

*implements* [Phalcon\FlashInterface](Phalcon_FlashInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/flash.zep)

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS

```php
<?php

$flash->success("The record was successfully deleted");
$flash->error("Cannot open the file");

```

## Métodos

public **__construct** ([*mixed* $cssClasses])

Phalcon\Flash constructor

public **getAutoescape** ()

Devuelve el modo autoescape en el Html generado

public **setAutoescape** (*mixed* $autoescape)

Establece el modo autoescape en el html generado

public **getEscaperService** ()

Devuelve el servicio Escaper

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService)

Establece el servicio Escaper

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el inyector de dependencia

public **getDI** ()

Devuelve el inyector de dependencias interno

public **setImplicitFlush** (*mixed* $implicitFlush)

Establece si la salida debe ser implícitamente vaciado a la salida o devuelto como una cadena

public **setAutomaticHtml** (*mixed* $automaticHtml)

Establece si la salida debe ser implícitamente formateada con HTML

public **setCssClasses** (*array* $cssClasses)

Configura un arreglo con clases CSS para formatear los mensajes

public **error** (*mixed* $message)

Muestra un mensaje de error HTML

```php
<?php

$flash->error("This is an error");

```

public **notice** (*mixed* $message)

Muestra un mensaje de información o notificación HTML

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message)

Muestra un mensaje de éxito HTML

```php
<?php

$flash->success("The process was finished successfully");

```

public **warning** (*mixed* $message)

Muestra un mensaje de advertencia HTML

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message)

Genera un mensaje que lo formatea con HTML

```php
<?php

$flash->outputMessage("error", $message);

```

public **clear** ()

Borra los mensajes acumulados cuando el vaciado implícito está deshabilitado

abstract public **message** (*mixed* $type, *mixed* $message) inherited from [Phalcon\FlashInterface](Phalcon_FlashInterface)

...