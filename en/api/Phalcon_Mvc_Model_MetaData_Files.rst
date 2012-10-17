Class **Phalcon\\Mvc\\Model\\MetaData\\Files**
==============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Stores model meta-data in PHP files. 

.. code-block:: php

    <?php

     $metaData = new Phalcon\Mvc\Model\Metadata\Files(array(
        'metaDataDir' => 'app/cache/metadata/'
     ));



Constants
---------

*integer* **MODELS_ATTRIBUTES**

*integer* **MODELS_PRIMARY_KEY**

*integer* **MODELS_NON_PRIMARY_KEY**

*integer* **MODELS_NOT_NULL**

*integer* **MODELS_DATA_TYPES**

*integer* **MODELS_DATA_TYPES_NUMERIC**

*integer* **MODELS_DATE_AT**

*integer* **MODELS_DATE_IN**

*integer* **MODELS_IDENTITY_COLUMN**

*integer* **MODELS_DATA_TYPES_BIND**

*integer* **MODELS_AUTOMATIC_DEFAULT_INSERT**

*integer* **MODELS_AUTOMATIC_DEFAULT_UPDATE**

Methods
---------

public  **__construct** (*array* $options)

Phalcon\\Mvc\\Model\\MetaData\\Files constructor



public *array*  **read** (*unknown* $key)

Reads meta-data from $_SESSION



public  **write** (*string* $key, *array* $data)

Writes the meta-data to $_SESSION



protected  **_initializeMetaData** () inherited from Phalcon\\Mvc\\Model\\MetaData

Initialize the metadata for certain table



public  **readMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads meta-data for certain model using a MODEL_* constant



public  **writeMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index, *mixed* $data) inherited from Phalcon\\Mvc\\Model\\MetaData

Writes meta-data for certain model using a MODEL_* constant



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



public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the name of identity field (if one is present)



public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes and their bind data types



public  **getAutomaticCreateAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

...


public  **getAutomaticUpdateAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

...


public  **setAutomaticAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the attributes that must be ignored from the insert/update sql generation



public *boolean*  **isEmpty** () inherited from Phalcon\\Mvc\\Model\\MetaData

Checks if the internal meta-data container is empty



public  **reset** () inherited from Phalcon\\Mvc\\Model\\MetaData

Resets internal meta-data in order to regenerate it



