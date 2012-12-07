Class **Phalcon\\Mvc\\Model\\MetaData**
=======================================

<<<<<<< HEAD
Because Phalcon\\Mvc\\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\\Model\\Base. Phalcon\\Mvc\\Model\\MetaData can also use adapters to store temporarily or permanently the meta-data.   A standard Phalcon\\Mvc\\Model\\MetaData can be used to query model attributes:   
=======
Because Phalcon\\Mvc\\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\\Model\\Base. Phalcon\\Mvc\\Model\\MetaData can also use adapters to store temporarily or permanently the meta-data.    A standard Phalcon\\Mvc\\Model\\MetaData can be used to query model attributes:    
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $metaData = new Phalcon\Mvc\Model\MetaData\Memory();
    $attributes = $metaData->getAttributes(new Robots());
    print_r($attributes);



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
Methods
---------

protected  **_initializeMetaData** ()
=======
*integer* **MODELS_COLUMN_MAP**

*integer* **MODELS_REVERSE_COLUMN_MAP**

Methods
---------

protected  **_initialize** ()
>>>>>>> 0.7.0

Initialize the metadata for certain table



<<<<<<< HEAD
public  **readMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index)
=======
public *array*  **readMetaData** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Reads meta-data for certain model



public  **readMetaDataIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index)
>>>>>>> 0.7.0

Reads meta-data for certain model using a MODEL_* constant



<<<<<<< HEAD
public  **writeMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index, *mixed* $data)
=======
public  **writeMetaDataIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index, *mixed* $data)
>>>>>>> 0.7.0

Writes meta-data for certain model using a MODEL_* constant



<<<<<<< HEAD
public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **readColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Reads the ordered/reversed column map for certain model



public  **readColumnMapIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index)

Reads column-map information for certain model using a MODEL_* constant



public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns table attributes names (fields)



<<<<<<< HEAD
public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns an array of fields which are part of the primary key



<<<<<<< HEAD
public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns an arrau of fields which are not part of the primary key



<<<<<<< HEAD
public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns an array of not null attributes



<<<<<<< HEAD
public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns attributes and their data types



<<<<<<< HEAD
public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns attributes which types are numerical



<<<<<<< HEAD
public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns the name of identity field (if one is present)



<<<<<<< HEAD
public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns attributes and their bind data types



<<<<<<< HEAD
public *array*  **getAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns attributes that must be ignored from the INSERT SQL generation



<<<<<<< HEAD
public *array*  **getAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Returns attributes that must be ignored from the UPDATE SQL generation



<<<<<<< HEAD
public  **setAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *array* $attributes)
=======
public  **setAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *array* $attributes)
>>>>>>> 0.7.0

Set the attributes that must be ignored from the INSERT SQL generation



<<<<<<< HEAD
public  **setAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *array* $attributes)
=======
public  **setAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *array* $attributes)
>>>>>>> 0.7.0

Set the attributes that must be ignored from the UPDATE SQL generation



<<<<<<< HEAD
public *boolean*  **isEmpty** ()

Checks if the internal meta-data container is empty



public  **reset** ()

Resets internal meta-data in order to regenerate it



abstract public  **read** ()

...


abstract public  **write** ()

...
=======
public *array*  **getColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the column map if any



public *array*  **getReverseColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the reverse column map if any



public *boolean*  **hasAttribute** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $attribute)

Check if a model has certain attribute



public *boolean*  **isEmpty** ()

Checks if the internal meta-data container is empty



public  **reset** ()

Resets internal meta-data in order to regenerate it

>>>>>>> 0.7.0


