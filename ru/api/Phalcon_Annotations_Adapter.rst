Abstract class **Phalcon\\Annotations\\Adapter**
================================================

This is the base class for Phalcon\\Annotations adapters


Methods
-------

public  **setReader** (*unknown* $reader)

Sets the annotations parser



public :doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>`  **getReader** ()

Returns the annotation reader



public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>`  **get** (*unknown* $className)

Parses or retrieves all the annotations found in a class



public *array*  **getMethods** (*unknown* $className)

Returns the annotations found in all the class' methods



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getMethod** (*unknown* $className, *unknown* $methodName)

Returns the annotations found in a specific method



public *array*  **getProperties** (*unknown* $className)

Returns the annotations found in all the class' methods



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getProperty** (*unknown* $className, *unknown* $propertyName)

Returns the annotations found in a specific property



