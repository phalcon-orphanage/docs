---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Assets\Inline'
---
# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

Representa un activo en línea

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hola mundo');");

```

## Métodos

public **getType** ()

...

public **getContent** ()

...

public **getFilter** ()

...

public **getAttributes** ()

...

public **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline constructor

public **setType** (*mixed* $type)

Establece el tipo de activo en línea

public **setFilter** (*mixed* $filter)

Establece si el recurso debe ser filtrado o no

public **setAttributes** (*array* $attributes)

Establece los atributos HTML extras

public **getResourceKey** ()

Obtiene la llave del recurso.