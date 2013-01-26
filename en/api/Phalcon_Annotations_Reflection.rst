Class **Phalcon\\Annotations\\Reflection**
==========================================

Allows to manipulate the annotations reflection in an OO manner  

.. code-block:: php

    <?php

     //Parse the annotations in a class
     $reader = new Phalcon\Annotations\Reader();
     $parsing = $reader->parse('MyComponent');
    
     //Create the reflection
     $reflection = new Phalcon\Annotations\Reflection($parsing);
    
     //Get the annotations in the class docblock
     $classAnnotations = $reflection->getClassAnnotations();



Methods
---------

public  **__construct** (*array* $reflectionData)

Phalcon\\Annotations\\Reflection constructor



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>`  **getClassAnnotations** ()

Returns the annotations found in the class docblock



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>` [] **getMethodAnnotations** ()

Returns the annotations found in the methods' docblocks



public :doc:`Phalcon\\Annotations\\Collection <Phalcon_Annotations_Collection>` [] **getPropertiesAnnotations** ()

Returns the annotations found in the properties' docblocks



public *array*  **getReflectionData** ()

Returns the raw parsing intermediate definitions used to construct the reflection



