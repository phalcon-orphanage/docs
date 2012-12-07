Class **Phalcon\\Mvc\\Model\\MetaData\\Apc**
============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

<<<<<<< HEAD
Stores model meta-data in the APC cache. Data will erased if the web server is restarted By default meta-data is stored 48 hours (172800 seconds) You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-local-app') 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>`

Stores model meta-data in the APC cache. Data will erased if the web server is restarted  By default meta-data is stored 48 hours (172800 seconds)  You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-app-id')  
>>>>>>> 0.7.0

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

*integer* **MODELS_DATA_TYPES**

*integer* **MODELS_DATA_TYPES_NUMERIC**

*integer* **MODELS_DATE_AT**

*integer* **MODELS_DATE_IN**

*integer* **MODELS_IDENTITY_COLUMN**

*integer* **MODELS_DATA_TYPES_BIND**

*integer* **MODELS_AUTOMATIC_DEFAULT_INSERT**

*integer* **MODELS_AUTOMATIC_DEFAULT_UPDATE**

<<<<<<< HEAD
=======
*integer* **MODELS_COLUMN_MAP**

*integer* **MODELS_REVERSE_COLUMN_MAP**

>>>>>>> 0.7.0
Methods
---------

public  **__construct** (*array* $options)

Phalcon\\Mvc\\Model\\MetaData\\Apc constructor



public *array*  **read** (*string* $key)

Reads meta-data from APC



public  **write** (*string* $key, *array* $data)

Writes the meta-data to APC



<<<<<<< HEAD
protected  **_initializeMetaData** () inherited from Phalcon\\Mvc\\Model\\MetaData
=======
protected  **_initialize** () inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Initialize the metadata for certain table



<<<<<<< HEAD
public  **readMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **readMetaData** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads meta-data for certain model



public  **readMetaDataIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Reads meta-data for certain model using a MODEL_* constant



<<<<<<< HEAD
public  **writeMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index, *mixed* $data) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public  **writeMetaDataIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index, *mixed* $data) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Writes meta-data for certain model using a MODEL_* constant



<<<<<<< HEAD
public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **readColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads the ordered/reversed column map for certain model



public  **readColumnMapIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads column-map information for certain model using a MODEL_* constant



public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns table attributes names (fields)



<<<<<<< HEAD
public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns an array of fields which are part of the primary key



<<<<<<< HEAD
public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns an arrau of fields which are not part of the primary key



<<<<<<< HEAD
public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns an array of not null attributes



<<<<<<< HEAD
public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns attributes and their data types



<<<<<<< HEAD
public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns attributes which types are numerical



<<<<<<< HEAD
public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns the name of identity field (if one is present)



<<<<<<< HEAD
public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns attributes and their bind data types



<<<<<<< HEAD
public *array*  **getAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns attributes that must be ignored from the INSERT SQL generation



<<<<<<< HEAD
public *array*  **getAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public *array*  **getAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Returns attributes that must be ignored from the UPDATE SQL generation



<<<<<<< HEAD
public  **setAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public  **setAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Set the attributes that must be ignored from the INSERT SQL generation



<<<<<<< HEAD
public  **setAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData
=======
public  **setAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData
>>>>>>> 0.7.0

Set the attributes that must be ignored from the UPDATE SQL generation



<<<<<<< HEAD
=======
public *array*  **getColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the column map if any



public *array*  **getReverseColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the reverse column map if any



public *boolean*  **hasAttribute** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $attribute) inherited from Phalcon\\Mvc\\Model\\MetaData

Check if a model has certain attribute



>>>>>>> 0.7.0
public *boolean*  **isEmpty** () inherited from Phalcon\\Mvc\\Model\\MetaData

Checks if the internal meta-data container is empty



public  **reset** () inherited from Phalcon\\Mvc\\Model\\MetaData

Resets internal meta-data in order to regenerate it



