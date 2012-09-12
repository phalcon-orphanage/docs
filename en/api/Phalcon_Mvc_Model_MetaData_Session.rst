Class **Phalcon\\Mvc\\Model\\MetaData\\Session**
================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Stores model meta-data in session. Data will erase when the session finishes. Meta-data are permanent while the session is active. You can query the meta-data by printing $_SESSION['$PMM$'] 

.. code-block:: php

    <?php

     $metaData = new Phalcon\Mvc\Model\Metadata\Session(array(
        'suffix' => 'my-app-id'
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

Phalcon\\Mvc\\Model\\MetaData\\Session constructor



public *array*  **read** ()

Reads meta-data from $_SESSION



public  **write** (*array* $data)

Writes the meta-data to $_SESSION



protected  **_initializeMetaData** () inherited from Phalcon\Mvc\Model\MetaData

Initialize the metadata for certain table



public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns table attributes names (fields)



public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns an array of fields which are part of the primary key



public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns an arrau of fields which are not part of the primary key



public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns an array of not null attributes



public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns attributes and their data types



public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns attributes which types are numerical



public *array*  **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\Mvc\Model\MetaData

Returns the name of identity field (if one is present)



public  **storeMetaData** () inherited from Phalcon\Mvc\Model\MetaData

Stores meta-data using to the internal adapter



public *boolean*  **isEmpty** () inherited from Phalcon\Mvc\Model\MetaData

Checks if the internal meta-data container is empty



public  **reset** () inherited from Phalcon\Mvc\Model\MetaData

Resets internal meta-data in order to regenerate it



