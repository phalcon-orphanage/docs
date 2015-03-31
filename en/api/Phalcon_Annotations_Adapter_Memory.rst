Class **Phalcon\\Annotations\\Adapter\\Memory**
===============================================

*extends* abstract class :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

*implements* :doc:`Phalcon\\Annotations\\AdapterInterface <Phalcon_Annotations_AdapterInterface>`

* Phalcon\\Annotations\\Adapter\\Memory * * Stores the parsed annotations in memory. This adapter is the suitable development/testing


Methods
-------

public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>`  **read** (*unknown* $key)

Reads parsed annotations from memory



public  **write** (*unknown* $key, *unknown* $data)

Writes parsed annotations to memory



public  **setReader** (*unknown* $reader) inherited from Phalcon\\Annotations\\Adapter

Sets the annotations parser



public :doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>`  **getReader** () inherited from Phalcon\\Annotations\\Adapter

Returns the annotation reader



public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>`  **get** (*unknown* $className) inherited from Phalcon\\Annotations\\Adapter

Parses or retrieves all the annotations found in a class



public *array*  **getMethods** (*unknown* $className) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in all the class' methods



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getMethod** (*unknown* $className, *unknown* $methodName) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in a specific method



public *array*  **getProperties** (*unknown* $className) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in all the class' methods



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getProperty** (*unknown* $className, *unknown* $propertyName) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in a specific property



