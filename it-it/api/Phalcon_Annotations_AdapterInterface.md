---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

This interface must be implemented by adapters in Phalcon\Annotations

## Metodi

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Imposta il parser delle annotazioni

abstract public **getReader** ()

Restituisce il lettore dell'annotazione

abstract public **get** (*string|object* $className)

Analizza o recupera tutte le annotazioni presenti in una classe

abstract public **getMethods** (*string* $className)

Returns the annotations found in all the class methods

abstract public **getMethod** (*string* $className, *string* $methodName)

Restituisce le annotazioni trovate nel metodo specifico

abstract public **getProperties** (*string* $className)

Returns the annotations found in all the class methods

abstract public **getProperty** (*string* $className, *string* $propertyName)

Restituisce le annotazioni trovate nella proprietà specifica