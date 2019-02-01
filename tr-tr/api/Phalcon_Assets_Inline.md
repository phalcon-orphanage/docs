---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Assets\Inline'
---
# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

Satır içi bir varlığı belirtir

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");

```

## Metodlar

genel **getType** ()

...

herkese açık **İçeriğe Eriş** ()

...

public **getFilter** ()

...

public **getAttributes** ()

...

public **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline constructor

public **setType** (*mixed* $type)

Satır içi türünü ayarlar

public **setFilter** (*mixed* $filter)

Kaynağın filtrelenmesi gerekip gerekmediğini ayarlar

public **setAttributes** (*array* $attributes)

Ek HTML özellikleri ayarlar

public **getResourceKey** ()

Kaynağın anahtarının getirir.