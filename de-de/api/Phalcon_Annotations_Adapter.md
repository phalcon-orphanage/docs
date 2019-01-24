---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## Methoden

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Setzt den Anmerkungen-parser

public **getReader** ()

Gibt den Annotation-Leser zurück

public **get** (*string* | *object* $className)

Analysiert oder gibt alle Anmerkungen, welche in einer Klasse gefunden wurden, zurück

public **getMethods** (*mixed* $className)

Gibt die Anmerkungen aus allen Methoden der Klasse zurück

public **getMethod** (*mixed* $className, *mixed* $methodName)

Gibt die Anmerkungen, die in einer bestimmten Methode gefunden wurden, zurück

public **getProperties** (*mixed* $className)

Gibt die Anmerkungen aus allen Methoden der Klasse zurück

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Gibt die Anmerkungen, die in einer bestimmten Eigenschaft gefunden wurden, zurück