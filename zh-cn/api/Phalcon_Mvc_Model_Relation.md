* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Relation'

* * *

# Class **Phalcon\Mvc\Model\Relation**

*implements* [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/relation.zep" class="btn btn-default btn-sm">源码在GitHub</a>

This class represents a relationship between two models

## 常量

*integer* **BELONGS_TO**

*integer* **HAS_ONE**

*integer* **HAS_MANY**

*integer* **HAS_ONE_THROUGH**

*integer* **HAS_MANY_THROUGH**

*integer* **NO_ACTION**

*integer* **ACTION_RESTRICT**

*integer* **ACTION_CASCADE**

## 方法

public **__construct** (*int* $type, *string* $referencedModel, *string* | *array* $fields, *string* | *array* $referencedFields, [*array* $options])

Phalcon\Mvc\Model\Relation constructor

public **setIntermediateRelation** (*string* | *array* $intermediateFields, *string* $intermediateModel, *string* $intermediateReferencedFields)

Sets the intermediate model data for has-*-through relations

public **getType** ()

Returns the relation type

public **getReferencedModel** ()

Returns the referenced model

public *string* | *array* **getFields** ()

Returns the fields

public *string* | *array* **getReferencedFields** ()

Returns the referenced fields

public *string* | *array* **getOptions** ()

Returns the options

public **getOption** (*mixed* $name)

Returns an option by the specified name If the option doesn't exist null is returned

public **isForeignKey** ()

Check whether the relation act as a foreign key

public *string* | *array* **getForeignKey** ()

Returns the foreign key configuration

public *array* **getParams** ()

Returns parameters that must be always used when the related records are obtained

public **isThrough** ()

Check whether the relation is a 'many-to-many' relation or not

public **isReusable** ()

Check if records returned by getting belongs-to/has-many are implicitly cached during the current request

public *string* | *array* **getIntermediateFields** ()

Gets the intermediate fields for has-*-through relations

public **getIntermediateModel** ()

Gets the intermediate model for has-*-through relations

public *string* | *array* **getIntermediateReferencedFields** ()

Gets the intermediate referenced fields for has-*-through relations