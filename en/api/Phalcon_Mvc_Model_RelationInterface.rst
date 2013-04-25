Interface **Phalcon\\Mvc\\Model\\RelationInterface**
====================================================

Phalcon\\Mvc\\Model\\RelationInterface initializer


Methods
---------

abstract public  **__construct** (*int* $type, *string* $referencedModel, *string|array* $fields, *string|array* $referencedFields, [*array* $options])

Phalcon\\Mvc\\Model\\Relation constructor



abstract public *int*  **getType** ()

Returns the relation's type



abstract public *string*  **getReferencedModel** ()

Returns the referenced model



abstract public *string|array*  **getFields** ()

Returns the fields



abstract public *string|array*  **getReferencedFields** ()

Returns the referenced fields



abstract public *string|array*  **getOptions** ()

Returns the options



abstract public *string|array*  **isForeignKey** ()

Check whether the relation act as a foreign key



abstract public *string|array*  **getForeignKey** ()

Returns the foreign key configuration



abstract public *boolean*  **hasThrough** ()

Check whether the relation



abstract public *string*  **getThrough** ()

Returns the 'through' relation if any



