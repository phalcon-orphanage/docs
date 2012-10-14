Class **Phalcon\\Mvc\\Model\\MetaData**
=======================================

Because Phalcon\\Mvc\\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\\Model\\Base. Phalcon\\Mvc\\Model\\MetaData can also use adapters to store temporarily or permanently the meta-data.   A standard Phalcon\\Mvc\\Model\\MetaData can be used to query model attributes:   

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

*integer* **MODELS_DATA_TYPE**

*integer* **MODELS_DATA_TYPE_NUMERIC**

*integer* **MODELS_DATE_AT**

*integer* **MODELS_DATE_IN**

*integer* **MODELS_IDENTITY_FIELD**

*integer* **MODELS_DATA_TYPE_BIND**

Methods
---------

protected  **_initializeMetaData** ()

Initialize the metadata for certain table



public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns table attributes names (fields)



public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns an array of fields which are part of the primary key



public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns an arrau of fields which are not part of the primary key



public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns an array of not null attributes



public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns attributes and their data types



public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns attributes and their bind data types



public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns attributes which types are numerical



public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Returns the name of identity field (if one is present)



public  **storeMetaData** ()

...


public *boolean*  **isEmpty** ()

Checks if the internal meta-data container is empty



public  **reset** ()

Resets internal meta-data in order to regenerate it



abstract public  **write** ()

...


