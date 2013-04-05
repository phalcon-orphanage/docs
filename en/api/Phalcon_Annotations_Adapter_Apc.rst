Class **Phalcon\\Annotations\\Adapter\\Apc**
============================================

*extends* :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

*implements* :doc:`Phalcon\\Annotations\\AdapterInterface <Phalcon_Annotations_AdapterInterface>`

Phalcon\\Annotations\\Adapter\\Files  Stores the parsed annotations in APC. This adapter is the suitable for production  

.. code-block:: php

    <?php

     $annotations = new \Phalcon\Annotations\Adapter\Apc();



Methods
---------

public *array*  **read** (*string* $key)

Reads parsed annotations from Apc



public  **write** (*string* $key, *array* $data)

Writes parsed annotations to APC



public  **setReader** (:doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>` $reader) inherited from Phalcon\\Annotations\\Adapter

Sets the annotations parser



public :doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>`  **getReader** () inherited from Phalcon\\Annotations\\Adapter

Returns the annotation reader



public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>`  **get** (*string|object* $className) inherited from Phalcon\\Annotations\\Adapter

Parses or retrieves all the annotations found in a class



public *array*  **getMethods** (*string* $className) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in all the class' methods



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getMethod** (*string* $className, *string* $methodName) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in a specific method



public *array*  **getProperties** (*string* $className) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in all the class' methods



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getProperty** (*string* $className, *string* $propertyName) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in a specific property



