Class **Phalcon\\Annotations\\Collection**
==========================================

*implements* Iterator, Traversable, Countable

Represents a collection of annotations. This class allows to traverse a group of annotations easily  

.. code-block:: php

    <?php

     //Traverse annotations
     foreach ($classAnnotations as $annotation) {
         echo 'Name=', $annotation->getName(), PHP_EOL;
     }
    
     //Check if the annotations has a specific
     var_dump($classAnnotations->has('Cacheable'));
    
     //Get an specific annotation in the collection
     $annotation = $classAnnotations->get('Cacheable');



Methods
-------

public  **__construct** ([*array* $reflectionData])

Phalcon\\Annotations\\Collection constructor



public  **count** ()

Returns the number of annotations in the collection



public  **rewind** ()

Rewinds the internal iterator



public :doc:`Phalcon\\Annotations\\Annotation <Phalcon_Annotations_Annotation>`  **current** ()

Returns the current annotation in the iterator



public  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public  **valid** ()

Check if the current annotation in the iterator is valid



public  **getAnnotations** ()

Returns the internal annotations as an array



public  **get** (*unknown* $name)

Returns the first annotation that match a name



public  **getAll** (*unknown* $name)

Returns all the annotations that match a name



public  **has** (*unknown* $name)

Check if an annotation exists in a collection



