Abstract class **Phalcon\\Annotations\\Adapter**
================================================

*implements* :doc:`Phalcon\\Annotations\\AdapterInterface <Phalcon_Annotations_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is the base class for Phalcon\\Annotations adapters


Methods
-------

public  **setReader** (:doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>` $reader)

Sets the annotations parser



public  **getReader** ()

Returns the annotation reader



public  **get** (*string* | *object* $className)

Parses or retrieves all the annotations found in a class



public  **getMethods** (*mixed* $className)

Returns the annotations found in all the class' methods



public  **getMethod** (*mixed* $className, *mixed* $methodName)

Returns the annotations found in a specific method



public  **getProperties** (*mixed* $className)

Returns the annotations found in all the class' methods



public  **getProperty** (*mixed* $className, *mixed* $propertyName)

Returns the annotations found in a specific property



