---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

Adaptadores de Phalcon\Annotations debe implementar esta interfaz

## Métodos

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Establece el analizador de anotaciones

abstract public **getReader** ()

Devuelve el lector de anotaciones

abstract public **get** (*string|object* $className)

Analiza o recupera todas las anotaciones encontradas una clase

abstract public **getMethods** (*string* $className)

Devuelve las anotaciones encontradas en todos los métodos de la clase

abstract public **getMethod** (*string* $className, *string* $methodName)

Devuelve las anotaciones encontradas un método específico

abstract public **getProperties** (*string* $className)

Devuelve las anotaciones encontradas en todos los métodos de la clase

abstract public **getProperty** (*string* $className, *string* $propertyName)

Devuelve las anotaciones que se encuentran en una propiedad específica