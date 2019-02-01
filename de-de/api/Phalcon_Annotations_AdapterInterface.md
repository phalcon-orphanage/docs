---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

This interface must be implemented by adapters in Phalcon\Annotations

## Methoden

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Setzt den Anmerkungen-parser

abstract public **getReader** ()

Gibt den Annotation-Leser zurück

abstract public **get** (*string|object* $className)

Analysiert oder gibt alle Anmerkungen, welche in einer Klasse gefunden wurden, zurück

abstract public **getMethods** (*string* $className)

Returns the annotations found in all the class methods

abstract public **getMethod** (*string* $className, *string* $methodName)

Gibt die Anmerkungen, die in einer bestimmten Methode gefunden wurden, zurück

abstract public **getProperties** (*string* $className)

Returns the annotations found in all the class methods

abstract public **getProperty** (*string* $className, *string* $propertyName)

Gibt die Anmerkungen, die in einer bestimmten Eigenschaft gefunden wurden, zurück