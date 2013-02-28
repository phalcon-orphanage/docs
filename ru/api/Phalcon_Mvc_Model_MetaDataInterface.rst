Interface **Phalcon\\Mvc\\Model\\MetaDataInterface**
====================================================

Phalcon\\Mvc\\Model\\MetaDataInterface initializer


Methods
---------

abstract public  **setStrategy** (*Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection* $strategy)

Set the meta-data extraction strategy



abstract public :doc:`Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection <Phalcon_Mvc_Model_MetaData_Strategy_Introspection>`  **getStrategy** ()

Return the strategy to obtain the meta-data



abstract public *array*  **readMetaData** (*Phalcon\\Mvc\\ModelInterface* $model)

Reads meta-data for certain model



abstract public *mixed*  **readMetaDataIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index)

Reads meta-data for certain model using a MODEL_* constant



abstract public  **writeMetaDataIndex** (*Phalcon\\Mvc\\Model* $model, *int* $index, *mixed* $data)

Writes meta-data for certain model using a MODEL_* constant



abstract public *array*  **readColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model)

Reads the ordered/reversed column map for certain model



abstract public  **readColumnMapIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index)

Reads column-map information for certain model using a MODEL_* constant



abstract public *array*  **getAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns table attributes names (fields)



abstract public *array*  **getPrimaryKeyAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns an array of fields which are part of the primary key



abstract public *array*  **getNonPrimaryKeyAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns an arrau of fields which are not part of the primary key



abstract public *array*  **getNotNullAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns an array of not null attributes



abstract public *array*  **getDataTypes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes and their data types



abstract public *array*  **getDataTypesNumeric** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes which types are numerical



abstract public *string*  **getIdentityField** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the name of identity field (if one is present)



abstract public *array*  **getBindTypes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes and their bind data types



abstract public *array*  **getAutomaticCreateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes that must be ignored from the INSERT SQL generation



abstract public *array*  **getAutomaticUpdateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes that must be ignored from the UPDATE SQL generation



abstract public  **setAutomaticCreateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model, *array* $attributes)

Set the attributes that must be ignored from the INSERT SQL generation



abstract public  **setAutomaticUpdateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model, *array* $attributes)

Set the attributes that must be ignored from the UPDATE SQL generation



abstract public *array*  **getColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the column map if any



abstract public *array*  **getReverseColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the reverse column map if any



abstract public *boolean*  **hasAttribute** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $attribute)

Check if a model has certain attribute



abstract public *boolean*  **isEmpty** ()

Checks if the internal meta-data container is empty



abstract public  **reset** ()

Resets internal meta-data in order to regenerate it



abstract public *array*  **read** (*string* $key)

Reads meta-data from the adapter



abstract public  **write** (*string* $key, *array* $data)

Writes meta-data to the adapter



