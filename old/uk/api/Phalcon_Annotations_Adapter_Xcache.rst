Class **Phalcon\\Annotations\\Adapter\\Xcache**
===============================================

*extends* abstract class :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

*implements* :doc:`Phalcon\\Annotations\\AdapterInterface <Phalcon_Annotations_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/xcache.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Stores the parsed annotations to XCache. This adapter is suitable for production

.. code-block:: php

    <?php

    $annotations = new \Phalcon\Annotations\Adapter\Xcache();



Methods
-------

public :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>` **read** (*string* $key)

Reads parsed annotations from XCache



public  **write** (*mixed* $key, :doc:`Phalcon\\Annotations\\Reflection <Phalcon_Annotations_Reflection>` $data)

Writes parsed annotations to XCache



public  **setReader** (:doc:`Phalcon\\Annotations\\ReaderInterface <Phalcon_Annotations_ReaderInterface>` $reader) inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Sets the annotations parser



public  **getReader** () inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Returns the annotation reader



public  **get** (*string* | *object* $className) inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Parses or retrieves all the annotations found in a class



public  **getMethods** (*mixed* $className) inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Returns the annotations found in all the class' methods



public  **getMethod** (*mixed* $className, *mixed* $methodName) inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Returns the annotations found in a specific method



public  **getProperties** (*mixed* $className) inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Returns the annotations found in all the class' methods



public  **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from :doc:`Phalcon\\Annotations\\Adapter <Phalcon_Annotations_Adapter>`

Returns the annotations found in a specific property



