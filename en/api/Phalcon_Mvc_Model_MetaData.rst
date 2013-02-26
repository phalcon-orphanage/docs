Class **Phalcon\\Mvc\\Model\\MetaData**
=======================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Because Phalcon\\Mvc\\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\\Mvc\\Model. Phalcon\\Mvc\\Model\\MetaData can also use adapters to store temporarily or permanently the meta-data.    A standard Phalcon\\Mvc\\Model\\MetaData can be used to query model attributes:    

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

*integer* **MODELS_COLUMN_MAP**

*integer* **MODELS_REVERSE_COLUMN_MAP**

Methods
---------

protected  **_initialize** ()

Initialize the metadata for certain table



public  **setDI** (*Phalcon\\DiInterface* $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setStrategy** (*Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection* $strategy)

Set the meta-data extraction strategy



public :doc:`Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection <Phalcon_Mvc_Model_MetaData_Strategy_Introspection>`  **getStrategy** ()

Return the strategy to obtain the meta-data



public *array*  **readMetaData** (*Phalcon\\Mvc\\ModelInterface* $model)

Reads the complete meta-data for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readMetaData(new Robots());




public  **readMetaDataIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index)

Reads meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




public  **writeMetaDataIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index, *mixed* $data)

Writes meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




public *array*  **readColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model)

Reads the ordered/reversed column map for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMap(new Robots()));




public  **readColumnMapIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index)

Reads column-map information for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP));




public *array*  **getAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns table attributes names (fields) 

.. code-block:: php

    <?php

    print_r($metaData->getAttributes(new Robots()));




public *array*  **getPrimaryKeyAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns an array of fields which are part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getPrimaryKeyAttributes(new Robots()));




public *array*  **getNonPrimaryKeyAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns an arrau of fields which are not part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getNonPrimaryKeyAttributes(new Robots()));




public *array*  **getNotNullAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns an array of not null attributes 

.. code-block:: php

    <?php

    print_r($metaData->getNotNullAttributes(new Robots()));




public *array*  **getDataTypes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes and their data types 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypes(new Robots()));




public *array*  **getDataTypesNumeric** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes which types are numerical 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypesNumeric(new Robots()));




public *string*  **getIdentityField** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the name of identity field (if one is present) 

.. code-block:: php

    <?php

    print_r($metaData->getIdentityField(new Robots()));




public *array*  **getBindTypes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes and their bind data types 

.. code-block:: php

    <?php

    print_r($metaData->getBindTypes(new Robots()));




public *array*  **getAutomaticCreateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticCreateAttributes(new Robots()));




public *array*  **getAutomaticUpdateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticUpdateAttributes(new Robots()));




public  **setAutomaticCreateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model, *array* $attributes)

Set the attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticCreateAttributes(new Robots(), array('created_at' => true));




public  **setAutomaticUpdateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model, *array* $attributes)

Set the attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticUpdateAttributes(new Robots(), array('modified_at' => true));




public *array*  **getColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getColumnMap(new Robots()));




public *array*  **getReverseColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the reverse column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getReverseColumnMap(new Robots()));




public *boolean*  **hasAttribute** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $attribute)

Check if a model has certain attribute 

.. code-block:: php

    <?php

    var_dump($metaData->hasAttribute(new Robots(), 'name'));




public *boolean*  **isEmpty** ()

Checks if the internal meta-data container is empty 

.. code-block:: php

    <?php

    var_dump($metaData->isEmpty());




public  **reset** ()

Resets internal meta-data in order to regenerate it 

.. code-block:: php

    <?php

    $metaData->reset();




