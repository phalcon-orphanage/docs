* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Annotations\Reader'

* * *

# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/reader.zep" class="btn btn-default btn-sm">Исходный код на GitHub</a>

Parses docblocks returning an array with the found annotations

## Methods

public **parse** (*mixed* $className)

Reads annotations from the class dockblocks, its methods and/or properties

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Parses a raw doc block returning the annotations found