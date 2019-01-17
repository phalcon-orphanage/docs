---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations\Reader'
---
# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reader.zep)

Analiza los docblocks para devolver un arreglo con las anotaciones encontradas

## Métodos

public **parse** (*mixed* $className)

Lee las anotaciones de la clase dockblocks, sus métodos y/o propiedades

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Procesa un bloque doc en crudo regresando las anotaciones encontradas