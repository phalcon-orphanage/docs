---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations\ReaderInterface'
---
# Interface **Phalcon\Annotations\ReaderInterface**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/readerinterface.zep)

## Métodos

abstract public **parse** (*mixed* $className)

Lee las anotaciones de la clase dockblocks, sus métodos y/o propiedades

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Procesa un bloque doc en crudo regresando las anotaciones encontradas