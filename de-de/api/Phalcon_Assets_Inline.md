---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Assets\Inline'
---
# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

Stellt ein Inline Asset dar

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");

```

## Methoden

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

Legt den Inline-Typ fest

public **setFilter** (*mixed* $filter)

Legt fest, ob die Ressource gefiltert werden muss oder nicht

public **setAttributes** (*array* $attributes)

Sets extra HTML attributes

public **getResourceKey** ()

Gibt den Ressourcenschlüssel zurück.