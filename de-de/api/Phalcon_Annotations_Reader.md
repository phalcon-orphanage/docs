---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\Reader'
---
# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reader.zep)

Parses docblocks returning an array with the found annotations

## Methoden

public **parse** (*mixed* $className)

Liest Anmerkungen aus der Klasse Dockblocks, seine Methoden und Eigenschaften

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Analysiert einen rohen Doc-Block und gibt die gefundenen Anmerkungen zurück