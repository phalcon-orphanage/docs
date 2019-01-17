---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Memory'
---
# Class **Phalcon\Annotations\Adapter\Memory**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/memory.zep)

Stores the parsed annotations in memory. This adapter is the suitable development/testing

## Métodos

public **read** (*mixed* $key)

Lee las anotaciones analizadas desde la memoria

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Escribe la anotaciones analizadas en la memoria

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Establece el analizador de anotaciones

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Devuelve el lector de anotaciones

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Analiza o recupera todas las anotaciones encontradas una clase

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas un método específico

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Devuelve las anotaciones que se encuentran en una propiedad específica