Class **Phalcon\\Mvc\\Model\\MetaData\\Memory**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Stores model meta-data in memory. Data will be erased when the request finishes


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

public **__construct** (*array* $options)

Phalcon\\Mvc\\Model\\MetaData constructor



*array* public **read** ()

Reads the meta-data from temporal memory



public **write** ()

Writes the meta-data to temporal memory



protected **_initializeMetaData** ()

public **getAttributes** (*unknown* $model)

public **getPrimaryKeyAttributes** (*unknown* $model)

public **getNonPrimaryKeyAttributes** (*unknown* $model)

public **getNotNullAttributes** (*unknown* $model)

public **getDataTypes** (*unknown* $model)

public **getDataTypesNumeric** (*unknown* $model)

public **getIdentityField** (*unknown* $model)

public **storeMetaData** ()

public **isEmpty** ()

public **reset** ()

