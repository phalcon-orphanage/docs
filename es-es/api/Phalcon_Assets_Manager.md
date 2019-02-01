---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Assets\Manager'
---
# Class **Phalcon\Assets\Manager**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/manager.zep)

Administra colecciondes de activos CSS/Javascript

## Métodos

public **__construct** ([*array* $options])

public **setOptions** (*array* $options)

Establece la opciones del administrador

public **getOptions** ()

Muestra las opciones del administrador

public **useImplicitOutput** (*mixed* $implicitOutput)

Configura si el HTML generado debe ser impreso directamente o si debe devuelto

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Agregar un recurso Css a la colección 'css'

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Agrega un Css en línea a la colección 'css'

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Agrega un recurso javascript a la colección 'js'

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Agrega un javascript en línea a la colección 'js'

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Añade un recurso por su tipo

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Agrega un código en línea por su tipo

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Añade un recurso sin procesar al administrador

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Agrega un código en línea sin procesar al administrator

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

Establece una colección en el Administrador de Activos

```php
<?php

$assets->set("js", $collection);

```

public **get** (*mixed* $id)

Devuelve una colección por su identificación.

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

Devuelve la colección de activos CSS

public **getJs** ()

Devuelve la colección de activos CSS

public **collection** (*mixed* $name)

Crea/Devuelve una colección de recursos

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

Recorre la respuesta de la llamada a una colección para generar su HTML

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

Recorre una colección y genera su HTML

public **outputCss** ([*string* $collectionName])

Imprime el HTML para los recursos CCS

public **outputInlineCss** ([*string* $collectionName])

Imprime el HTML para el CCS en línea

public **outputJs** ([*string* $collectionName])

Imprime el HTML para los recursos JS

public **outputInlineJs** ([*string* $collectionName])

Imprime el HTML para el JS en linea

public **getCollections** ()

Devuelve colecciones existentes en el administrador

public **exists** (*mixed* $id)

Devuelve verdadero o falso si las colecciones existenten.

```php
<?php

if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}

```