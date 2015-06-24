Class **Phalcon\\Mvc\\Model\\Relation**
=======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`

This class represents a relationship between two models


Constants
---------

*integer* **BELONGS_TO**

*integer* **HAS_ONE**

*integer* **HAS_MANY**

*integer* **HAS_ONE_THROUGH**

*integer* **HAS_MANY_THROUGH**

*integer* **NO_ACTION**

*integer* **ACTION_RESTRICT**

*integer* **ACTION_CASCADE**

Methods
-------

public  **__construct** (*unknown* $type, *unknown* $referencedModel, *unknown* $fields, *unknown* $referencedFields, [*unknown* $options])

Phalcon\\Mvc\\Model\\Relation constructor



public  **setIntermediateRelation** (*unknown* $intermediateFields, *unknown* $intermediateModel, *unknown* $intermediateReferencedFields)

Sets the intermediate model data for has-*-through relations



public *int*  **getType** ()

Returns the relation type



public *string*  **getReferencedModel** ()

Returns the referenced model



public *string|array*  **getFields** ()

Returns the fields



public *string|array*  **getReferencedFields** ()

Returns the referenced fields



public *string|array*  **getOptions** ()

Returns the options



public *boolean*  **isForeignKey** ()

Check whether the relation act as a foreign key



public *string|array*  **getForeignKey** ()

Returns the foreign key configuration



public *array*  **getParams** ()

Returns parameters that must be always used when the related records are obtained



public *boolean*  **isThrough** ()

Check whether the relation is a 'many-to-many' relation or not



public *boolean*  **isReusable** ()

Check if records returned by getting belongs-to/has-many are implicitly cached during the current request



public *string|array*  **getIntermediateFields** ()

Gets the intermediate fields for has-*-through relations



public *string*  **getIntermediateModel** ()

Gets the intermediate model for has-*-through relations



public *string|array*  **getIntermediateReferencedFields** ()

Gets the intermediate referenced fields for has-*-through relations



