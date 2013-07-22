Class **Phalcon\\Annotations\\Reader**
======================================

*implements* :doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>`

Parses docblocks returning an array with the found annotations


Methods
---------

public *array*  **parse** (*string* $className)

Reads annotations from the class dockblocks, its methods and/or properties



public static *array*  **parseDocBlock** (*string* $docBlock, [*string* $file], [*int* $line])

Parses a raw doc block returning the annotations found



