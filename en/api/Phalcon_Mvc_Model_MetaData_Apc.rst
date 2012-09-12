Class **Phalcon\\Mvc\\Model\\MetaData\\Apc**
============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Stores model meta-data in the APC cache. Data will erased if the web server is restarted By default meta-data is stored 48 hours (172800 seconds) You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-local-app') 

.. code-block:: php

    <?php

     $metaData = new Phalcon\Mvc\Model\Metadata\Apc(array(
        'suffix' => 'my-app-id',
        'lifetime' => 86400
     ));



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

public  **__construct** (*array* $options)

Phalcon\\Mvc\\Model\\MetaData\\Apc constructor



public *array*  **read** ()

Reads meta-data from APC



public  **write** (*array* $data)

Writes the meta-data to APC



protected  **_initializeMetaData** () inherited from Phalcon\\Mvc\\Model\\MetaData

Initialize the metadata for certain table



public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns table attributes names (fields)



public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of fields which are part of the primary key



public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an arrau of fields which are not part of the primary key



public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of not null attributes



public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes and their data types



public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes which types are numerical



public *array*  **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the name of identity field (if one is present)



public  **storeMetaData** () inherited from Phalcon\\Mvc\\Model\\MetaData

Stores meta-data using to the internal adapter



public *boolean*  **isEmpty** () inherited from Phalcon\\Mvc\\Model\\MetaData

Checks if the internal meta-data container is empty



public  **reset** () inherited from Phalcon\\Mvc\\Model\\MetaData

Resets internal meta-data in order to regenerate it



