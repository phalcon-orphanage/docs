---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## Métodos

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Establece el analizador de anotaciones

public **getReader** ()

Devuelve el lector de anotaciones

public **get** (*string* | *object* $className)

Analiza o recupera todas las anotaciones encontradas una clase

public **getMethods** (*mixed* $className)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getMethod** (*mixed* $className, *mixed* $methodName)

Devuelve las anotaciones encontradas un método específico

public **getProperties** (*mixed* $className)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Devuelve las anotaciones que se encuentran en una propiedad específica