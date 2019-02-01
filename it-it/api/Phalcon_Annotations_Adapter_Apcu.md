---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Apcu'
---
# Class **Phalcon\Annotations\Adapter\Apcu**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/apcu.zep)

Stores the parsed annotations in APCu. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$annotations = new Apcu();

```

## Metodi

public **__construct** ([*array* $options])

Phalcon\Annotations\Adapter\Apcu constructor

public **read** (*mixed* $key)

Legge le annotazioni analizzate da APCu

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Scrive le annotazioni analizzate su APCu

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