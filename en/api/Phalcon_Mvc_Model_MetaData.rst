Class **Phalcon\\Mvc\\Model\\MetaData**
=======================================

Constants
---------

integer **MODELS_ATTRIBUTES**

integer **MODELS_PRIMARY_KEY**

integer **MODELS_NON_PRIMARY_KEY**

integer **MODELS_NOT_NULL**

integer **MODELS_DATA_TYPE**

integer **MODELS_DATA_TYPE_NUMERIC**

integer **MODELS_DATE_AT**

integer **MODELS_DATE_IN**

integer **MODELS_IDENTITY_FIELD**

Methods
---------

protected **_initializeMetaData** ()

Initialize the metadata for certain table



*array* public **getAttributes** (*Phalcon\Mvc\Model* $model)

Returns table attributes names (fields)



*array* public **getPrimaryKeyAttributes** (*Phalcon\Mvc\Model* $model)

Returns an array of fields which are part of the primary key



*array* public **getNonPrimaryKeyAttributes** (*Phalcon\Mvc\Model* $model)

Returns an arrau of fields which are not part of the primary key



*array* public **getNotNullAttributes** (*Phalcon\Mvc\Model* $model)

Returns an array of not null attributes



*array* public **getDataTypes** (*Phalcon\Mvc\Model* $model)

Returns attributes and their data types



*array* public **getDataTypesNumeric** (*Phalcon\Mvc\Model* $model)

Returns attributes which types are numerical



*array* public **getIdentityField** (*Phalcon\Mvc\Model* $model)

Returns the name of identity field (if one is present)



public **storeMetaData** ()

Stores meta-data using to the internal adapter



*boolean* public **isEmpty** ()

Checks if the internal meta-data container is empty



public **reset** ()

Resets internal meta-data in order to regenerate it



abstract public **write** ()

