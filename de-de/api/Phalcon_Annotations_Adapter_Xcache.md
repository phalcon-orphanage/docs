---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Xcache'
---
# Class **Phalcon\Annotations\Adapter\Xcache**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/xcache.zep)

Stores the parsed annotations to XCache. This adapter is suitable for production

```php
<?php

$annotations = new \Phalcon\Annotations\Adapter\Xcache();

```

## Methoden

public [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) **read** (*string* $key)

Liest analysierte Anmerkungen aus XCache

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Schreibt analysierte Anmerkungen nach XCache

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Setzt den Anmerkungen-parser

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Gibt den Annotation-Leser zurück

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Analysiert oder gibt alle Anmerkungen, welche in einer Klasse gefunden wurden, zurück

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Gibt die Anmerkungen aus allen Methoden der Klasse zurück

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Gibt die Anmerkungen, die in einer bestimmten Methode gefunden wurden, zurück

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Gibt die Anmerkungen aus allen Methoden der Klasse zurück

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Gibt die Anmerkungen, die in einer bestimmten Eigenschaft gefunden wurden, zurück