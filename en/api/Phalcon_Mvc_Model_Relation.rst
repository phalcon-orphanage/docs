Class **Phalcon\\Mvc\\Model\\Relation**
=======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`

This class represents each relationship between two models


Constants
---------

*integer* **BELONGS_TO**

*integer* **HAS_ONE**

*integer* **HAS_MANY**

*integer* **HAS_ONE_THROUGH**

*integer* **HAS_MANY_THROUGH**

*integer* **MANY_TO_MANY**

Methods
---------

public  **__construct** (*int* $type, *string* $referencedModel, *string|array* $fields, *string|array* $referencedFields, [*array* $options])

Phalcon\\Mvc\\Model\\Relation constructor



public *int*  **getType** ()

Returns the relation's type



public *string*  **getReferencedModel** ()

Returns the referenced model



public *string|array*  **getFields** ()

Returns the fields



public *string|array*  **getReferencedFields** ()

Returns the referenced fields



public *string|array*  **getOptions** ()

Returns the options



public *string|array*  **isForeingKey** ()

Check whether the relation act as a foreign key



public *string|array*  **getForeignKey** ()

Returns the foreign key configuration



public *boolean*  **hasThrough** ()

Check whether the relation



public *string*  **getThrough** ()

Returns the 'through' relation if any



public *boolean*  **isReusable** ()

Check if records in belongs-to/has-many are implicitly cached during the current request



