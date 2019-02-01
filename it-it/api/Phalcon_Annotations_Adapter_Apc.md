---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Apc'
---
# Class **Phalcon\Annotations\Adapter\Apc**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/apc.zep)

Stores the parsed annotations in APC. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apc;

$annotations = new Apc();

```

## Metodi

public **__construct** ([*array* $options])

Phalcon\Annotations\Adapter\Apc constructor

public **read** (*mixed* $key)

Reads parsed annotations from APC

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Writes parsed annotations to APC

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Imposta il parser delle annotazioni

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Restituisce il lettore dell'annotazione

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Analizza o recupera tutte le annotazioni presenti in una classe

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Restituisce le annotazioni presenti nei metodi di tutta la classe

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Restituisce le annotazioni trovate nel metodo specifico

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Restituisce le annotazioni presenti nei metodi di tutta la classe

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Restituisce le annotazioni trovate nella proprietà specifica