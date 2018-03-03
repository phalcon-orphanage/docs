# Interface **Phalcon\\Annotations\\ReaderInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/readerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **parse** (*mixed* $className)

Reads annotations from the class dockblocks, its methods and/or properties

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Parses a raw doc block returning the annotations found