Interface **Phalcon\\Annotations\\AdapterInterface**
====================================================

Phalcon\\Annotations\\AdapterInterface initializer


Methods
---------

abstract public  **setReader** (*Phalcon\\Annotations\\ReaderInterface* $reader)

Sets the annotations parser



abstract public :doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>`  **getReader** ()

Returns the annotation reader



abstract public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>`  **get** (*string|object* $className)

Parses or retrieves all the annotations found in a class



abstract public *array*  **getMethods** (*string* $className)

Returns the annotations found in all the class' methods



abstract public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getMethod** (*string* $className, *string* $methodName)

Returns the annotations found in a specific method



abstract public *array*  **getProperties** (*string* $className)

Returns the annotations found in all the class' methods



abstract public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getProperty** (*string* $className, *string* $propertyName)

Returns the annotations found in a specific property



