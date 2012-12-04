Interface **Phalcon\\Mvc\\Model\\MetaDataInterface**
====================================================

Phalcon\\Mvc\\Model\\MetaDataInterface initializer


Methods
---------

abstract public *array*  **readMetaData** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Reads meta-data for certain model



abstract public *mixed*  **readMetaDataIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index)

Reads meta-data for certain model using a MODEL_* constant



abstract public  **writeMetaDataIndex** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *int* $index, *mixed* $data)

Writes meta-data for certain model using a MODEL_* constant



abstract public *array*  **readColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Reads the ordered/reversed column map for certain model



abstract public  **readColumnMapIndex** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *int* $index)

Reads column-map information for certain model using a MODEL_* constant



abstract public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns table attributes names (fields)



abstract public *array*  **getPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns an array of fields which are part of the primary key



abstract public *array*  **getNonPrimaryKeyAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns an arrau of fields which are not part of the primary key



abstract public *array*  **getNotNullAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns an array of not null attributes



abstract public *array*  **getDataTypes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns attributes and their data types



abstract public *array*  **getDataTypesNumeric** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns attributes which types are numerical



abstract public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the name of identity field (if one is present)



abstract public *array*  **getBindTypes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns attributes and their bind data types



abstract public *array*  **getAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns attributes that must be ignored from the INSERT SQL generation



abstract public *array*  **getAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns attributes that must be ignored from the UPDATE SQL generation



abstract public  **setAutomaticCreateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *array* $attributes)

Set the attributes that must be ignored from the INSERT SQL generation



abstract public  **setAutomaticUpdateAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *array* $attributes)

Set the attributes that must be ignored from the UPDATE SQL generation



abstract public *array*  **getColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the column map if any



abstract public *array*  **getReverseColumnMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the reverse column map if any



abstract public *boolean*  **hasAttribute** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $attribute)

Check if a model has certain attribute



abstract public *boolean*  **isEmpty** ()

Checks if the internal meta-data container is empty



abstract public  **reset** ()

Resets internal meta-data in order to regenerate it



abstract public *array*  **read** (*unknown* $key)

Reads meta-data from the adapter



abstract public  **write** (*string* $key, *array* $data)

Writes meta-data to the adapter



