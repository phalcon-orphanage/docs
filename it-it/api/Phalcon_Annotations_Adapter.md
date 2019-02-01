---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## Metodi

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Imposta il parser delle annotazioni

public **getReader** ()

Restituisce il lettore dell'annotazione

public **get** (*string* | *object* $className)

Analizza o recupera tutte le annotazioni presenti in una classe

public **getMethods** (*mixed* $className)

Restituisce le annotazioni presenti nei metodi di tutta la classe

public **getMethod** (*mixed* $className, *mixed* $methodName)

Restituisce le annotazioni trovate nel metodo specifico

public **getProperties** (*mixed* $className)

Restituisce le annotazioni presenti nei metodi di tutta la classe

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Restituisce le annotazioni trovate nella proprietà specifica