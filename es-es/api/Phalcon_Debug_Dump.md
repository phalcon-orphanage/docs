---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Debug\Dump'
---
# Class **Phalcon\Debug\Dump**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug/dump.zep)

Vuelca la información sobre una variable(s)

```php
<?php

$foo = 123;

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```

## Métodos

public **getDetailed** ()

...

public **setDetailed** (*mixed* $detailed)

...

public **__construct** ([*array* $styles], [*mixed* $detailed])

Phalcon\Debug\Dump constructor

public **all** ()

Alias del método variables()

protected **getStyle** (*mixed* $type)

Obtiene el estilo para el tipo

public **setStyles** ([*array* $styles])

Establece estilos para el tipo vars

public **one** (*mixed* $variable, [*mixed* $name])

Alias del método variables()

protected **output** (*mixed* $variable, [*mixed* $name], [*mixed* $tab])

Prepara una cadena HTML de información sobre una única variable.

public **variable** (*mixed* $variable, [*mixed* $name])

Devuelve una cadena HTML de información sobre una única variable.

```php
<?php

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```

public **variables** ()

Devuelve una cadena HTML de información de depuración sobre cualquier nombre de variables, cada una envueltas en una etiqueta "pre".

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```

public **toJson** (*mixed* $variable)

Devuelve una cadena JSON de información sobre una única variable.

```php
<?php

$foo = [
    "key" => "value",
];

echo (new \Phalcon\Debug\Dump())->toJson($foo);

$foo = new stdClass();
$foo->bar = "buz";

echo (new \Phalcon\Debug\Dump())->toJson($foo);

```