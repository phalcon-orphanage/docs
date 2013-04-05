Class **Phalcon\\Annotations\\Collection**
==========================================

*implements* Iterator, Traversable, Countable

Methods
---------

public  **__construct** ([*array* $reflectionData])

Phalcon\\Annotations\\Collection constructor



public *int*  **count** ()

Returns the number of annotations in the collection



public  **rewind** ()

Rewinds the internal iterator



public :doc:`Phalcon\\Annotations\\Annotation <Phalcon_Annotations_Annotation>`  **current** ()

Returns the current annotation in the iterator



public *int*  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public *boolean*  **valid** ()

Check if the current annotation in the iterator is valid



public :doc:`Phalcon\\Annotations\\Annotation <Phalcon_Annotations_Annotation>` [] **getAnnotations** ()

Returns the internal annotations as an array



public :doc:`Phalcon\\Annotations\\Annotation <Phalcon_Annotations_Annotation>`  **get** (*string* $name)

Returns an annotation by its name



public *boolean*  **has** (*string* $name)

Check if an annotation exists in a collection



