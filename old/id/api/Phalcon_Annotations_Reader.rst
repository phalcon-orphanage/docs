Class **Phalcon\\Annotations\\Reader**
======================================

*implements* :doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/reader.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Parses docblocks returning an array with the found annotations


Methods
-------

public  **parse** (*mixed* $className)

Reads annotations from the class dockblocks, its methods and/or properties



public static  **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Parses a raw doc block returning the annotations found



