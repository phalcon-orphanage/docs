---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\ReaderInterface'
---
# Interface **Phalcon\Annotations\ReaderInterface**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/readerinterface.zep)

## Methoden

abstract public **parse** (*mixed* $className)

Liest Anmerkungen aus der Klasse Dockblocks, seine Methoden und Eigenschaften

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Analysiert einen rohen Doc-Block und gibt die gefundenen Anmerkungen zurück