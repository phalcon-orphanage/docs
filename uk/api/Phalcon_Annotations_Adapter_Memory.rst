Class **Phalcon\\Annotations\\Adapter\\Memory**
===============================================

*extends* abstract class :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

*implements* :doc:`Phalcon\\Annotations\\AdapterInterface <Phalcon_Annotations_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/memory.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Stores the parsed annotations in memory. This adapter is the suitable development/testing


Methods
-------

public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>`  **read** (*string* $key)

Reads parsed annotations from memory



public  **write** (*unknown* $key, :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>` $data)

Writes parsed annotations to memory



public  **setReader** (:doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>` $reader) inherited from Phalcon\\Annotations\\Adapter

Sets the annotations parser



public  **getReader** () inherited from Phalcon\\Annotations\\Adapter

Returns the annotation reader



public  **get** (*string|object* $className) inherited from Phalcon\\Annotations\\Adapter

Parses or retrieves all the annotations found in a class



public  **getMethods** (*unknown* $className) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in all the class' methods



public  **getMethod** (*unknown* $className, *unknown* $methodName) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in a specific method



public  **getProperties** (*unknown* $className) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in all the class' methods



public  **getProperty** (*unknown* $className, *unknown* $propertyName) inherited from Phalcon\\Annotations\\Adapter

Returns the annotations found in a specific property



