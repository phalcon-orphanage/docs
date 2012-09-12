Class **Phalcon\\Mvc\\Model\\MetaData\\Memory**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Stores model meta-data in memory. Data will be erased when the request finishes


Constants
---------

*integer* **MODELS_ATTRIBUTES**

*integer* **MODELS_PRIMARY_KEY**

*integer* **MODELS_NON_PRIMARY_KEY**

*integer* **MODELS_NOT_NULL**

*integer* **MODELS_DATA_TYPE**

*integer* **MODELS_DATA_TYPE_NUMERIC**

*integer* **MODELS_DATE_AT**

*integer* **MODELS_DATE_IN**

*integer* **MODELS_IDENTITY_FIELD**

Methods
---------

public **__construct** (*array* $options)

Phalcon\\Mvc\\Model\\MetaData constructor



*array* public **read** ()

Reads the meta-data from temporal memory



public **write** ()

Writes the meta-data to temporal memory



protected **_initializeMetaData** () inherited from Phalcon_Mvc_Model_MetaData

Initialize the metadata for certain table



*array* public **getAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns table attributes names (fields)



*array* public **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns an array of fields which are part of the primary key



*array* public **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns an arrau of fields which are not part of the primary key



*array* public **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns an array of not null attributes



*array* public **getDataTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns attributes and their data types



*array* public **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns attributes which types are numerical



*array* public **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon_Mvc_Model_MetaData

Returns the name of identity field (if one is present)



public **storeMetaData** () inherited from Phalcon_Mvc_Model_MetaData

Stores meta-data using to the internal adapter



*boolean* public **isEmpty** () inherited from Phalcon_Mvc_Model_MetaData

Checks if the internal meta-data container is empty



public **reset** () inherited from Phalcon_Mvc_Model_MetaData

Resets internal meta-data in order to regenerate it



