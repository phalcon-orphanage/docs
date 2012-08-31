Class **Phalcon\\Mvc\\Model\\MetaData\\Memory**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Phalcon\\Model\\MetaData\\Memory   Stores model meta-data in memory. Data will be erased when the request finishes

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

**__construct** (*array* **$options**)

*array* **read** ()

**write** ()

**_initializeMetaData** ()

**getAttributes** (*unknown* **$model**)

**getPrimaryKeyAttributes** (*unknown* **$model**)

**getNonPrimaryKeyAttributes** (*unknown* **$model**)

**getNotNullAttributes** (*unknown* **$model**)

**getDataTypes** (*unknown* **$model**)

**getDataTypesNumeric** (*unknown* **$model**)

**getIdentityField** (*unknown* **$model**)

**storeMetaData** ()

**isEmpty** ()

**reset** ()

