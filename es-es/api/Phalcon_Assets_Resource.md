---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Assets\Resource'
---
# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource.zep)

Representa un recurso activo

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## Métodos

public **getType** ()

public **getPath** ()

public **getLocal** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

public **setType** (*mixed* $type)

Establece el tipo de recursos

public **setPath** (*mixed* $path)

Establece la ruta del recurso

public **setLocal** (*mixed* $local)

Establece si el recurso es local o externo

public **setFilter** (*mixed* $filter)

Establece si el recurso debe ser filtrado o no

public **setAttributes** (*array* $attributes)

Establece los atributos HTML extras

public **setTargetUri** (*mixed* $targetUri)

Establece un identificador uri de destino para el HTML generado

public **setSourcePath** (*mixed* $sourcePath)

Establece la ruta de origen del recurso

public **setTargetPath** (*mixed* $targetPath)

Establece la ruta del objetivo del recurso

public **getContent** ([*mixed* $basePath])

Devuelve el contenido del recurso como una cadena Opcionalmente, se puede establecer una ruta base donde se encuentra localizado el recurso

public **getRealTargetUri** ()

Devuelve el objetivo real uri para el HTML generado

public **getRealSourcePath** ([*mixed* $basePath])

Devuelve la ubicación completa donde se encuentra localizado el recurso

public **getRealTargetPath** ([*mixed* $basePath])

Devuelve la ubicación completa donde el recurso debe ser escrito

public **getResourceKey** ()

Obtiene la llave del recurso.