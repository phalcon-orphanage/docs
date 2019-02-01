---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Assets\Inline'
---
# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

Merupakan aset inline

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "waspada('halo dunia');");

```

## Metode

publik **berhenti** ()

...

public ** getContent </ 0> ()</p> 

...

public **getFilter** ()

...

public **getAttributes** ()

...

public **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline constructor

publik **perangkat Tipe** (*dicampur* $type)

Menetapkan tipe inline

public **setFilter** (*campuran* $filter)

Menetapkan apakah sumber daya harus disaring atau tidak

public **setAttributes** (*array* $attributes)

Menetapkan beberapa atribut HTML tambahan

publik **getResourceKey** ()

Mendapatkan kunci sumber.