Interface **Phalcon\\Mvc\\Model\\RelationInterface**
====================================================

Phalcon\\Mvc\\Model\\RelationInterface initializer


Methods
-------

abstract public  **setIntermediateRelation** (*string|array* $intermediateFields, *string* $intermediateModel, *string* $intermediateReferencedFields)

Sets the intermediate model dat for has-*-through relations



abstract public *int*  **getType** ()

Returns the relations type



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



abstract public *boolean*  **isThrough** ()

Check whether the relation is a 'many-to-many' relation or not



abstract public *string|array*  **getIntermediateFields** ()

Gets the intermediate fields for has-*-through relations



abstract public *string*  **getIntermediateModel** ()

Gets the intermediate model for has-*-through relations



abstract public *string|array*  **getIntermediateReferencedFields** ()

Gets the intermediate referenced fields for has-*-through relations



