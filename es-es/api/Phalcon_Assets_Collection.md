---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Assets\Collection'
---
# Class **Phalcon\Assets\Collection**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

Representa una colección de recursos

## Métodos

public **getPrefix** ()

...

public **getLocal** ()

...

public **getResources** ()

...

public **getCodes** ()

...

public **getPosition** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

public **__construct** ()

Phalcon\Assets\Collection constructor

public **add** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Agrega un recurso a la colección

public **addInline** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Añade un código en línea a la colección

public **has** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Esto comprueba que el recurso se haya agregado a la colección.

```php
<?php

use Phalcon\Assets\Resource;
use Phalcon\Assets\Collection;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // verdadero

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Agrega un recurso CSS a la colección

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Agrega un CSS en línea a la colección

public [Phalcon\Assets\Collection](Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Agrega un recurso javascript a la colección

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Agrega un javascript en línea a la colección

public **count** ()

Devuelve la cantidad de elementos en el formulario

public **rewind** ()

Rebobina el iterador interno

public **current** ()

Devuelve el actual recurso en el iterador

public *int* **key** ()

Devuelve la llave/posición actual del iterador

public **next** ()

Mueve el puntero interno de iteración a la siguiente posición

public **valid** ()

Verificar si el elemento actual en el iterador es válido

public **setTargetPath** (*mixed* $targetPath)

Establece la ruta de destino del archivo de la salida filtrada o adjuntada

public **setSourcePath** (*mixed* $sourcePath)

Establece una ruta base de origen para todos los recursos de esta colección

public **setTargetUri** (*mixed* $targetUri)

Establece un identificador uri de destino para el HTML generado

public **setPrefix** (*mixed* $prefix)

Establece un prefijo común para todos los recursos

public **setLocal** (*mixed* $local)

Establece si la colección utiliza los recursos locales por defecto

public **setAttributes** (*array* $attributes)

Establece los atributos HTML extras

public **setFilters** (*array* $filters)

Establece una arreglo de filtros en la colección

public **setTargetLocal** (*mixed* $targetLocal)

Establece el destino local

public **join** (*mixed* $join)

Define si todos recursos filtrados de la colección deben estar Unidos en un archivo final único

public **getRealTargetPath** (*mixed* $basePath)

Devuelve la ubicación completa donde la colección unida/filtrada debe estar grabada

public **addFilter** ([Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface) $filter)

Añade un filtro a la colección

final protected **addResource** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Agrega un recurso o código en línea a la colección