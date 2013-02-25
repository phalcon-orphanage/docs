Class **Phalcon\\Mvc\\Model\\MetaData\\Memory**
===============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>`

Stores model meta-data in memory. Data will be erased when the request finishes


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

public  **__construct** ([*array* $options])

Phalcon\\Mvc\\Model\\MetaData\\Memory constructor



public *array*  **read** (*string* $key)

Reads the meta-data from temporal memory



public  **write** (*string* $key, *array* $metaData)

Writes the meta-data to temporal memory



protected  **_initialize** () inherited from Phalcon\\Mvc\\Model\\MetaData

Initialize the metadata for certain table



public  **setDI** (*Phalcon\\DiInterface* $dependencyInjector) inherited from Phalcon\\Mvc\\Model\\MetaData

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the DependencyInjector container



public  **setStrategy** (*Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection* $strategy) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the meta-data extraction strategy



public :doc:`Phalcon\\Mvc\\Model\\MetaData\\Strategy\\Introspection <Phalcon_Mvc_Model_MetaData_Strategy_Introspection>`  **getStrategy** () inherited from Phalcon\\Mvc\\Model\\MetaData

Return the strategy to obtain the meta-data



public *array*  **readMetaData** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads the complete meta-data for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readMetaData(new Robots());




public  **readMetaDataIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




public  **writeMetaDataIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index, *mixed* $data) inherited from Phalcon\\Mvc\\Model\\MetaData

Writes meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




public *array*  **readColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads the ordered/reversed column map for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMap(new Robots()));




public  **readColumnMapIndex** (*Phalcon\\Mvc\\ModelInterface* $model, *int* $index) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads column-map information for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP));




public *array*  **getAttributes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns table attributes names (fields) 

.. code-block:: php

    <?php

    print_r($metaData->getAttributes(new Robots()));




public *array*  **getPrimaryKeyAttributes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of fields which are part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getPrimaryKeyAttributes(new Robots()));




public *array*  **getNonPrimaryKeyAttributes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an arrau of fields which are not part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getNonPrimaryKeyAttributes(new Robots()));




public *array*  **getNotNullAttributes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of not null attributes 

.. code-block:: php

    <?php

    print_r($metaData->getNotNullAttributes(new Robots()));




public *array*  **getDataTypes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes and their data types 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypes(new Robots()));




public *array*  **getDataTypesNumeric** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes which types are numerical 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypesNumeric(new Robots()));




public *string*  **getIdentityField** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the name of identity field (if one is present) 

.. code-block:: php

    <?php

    print_r($metaData->getIdentityField(new Robots()));




public *array*  **getBindTypes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes and their bind data types 

.. code-block:: php

    <?php

    print_r($metaData->getBindTypes(new Robots()));




public *array*  **getAutomaticCreateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticCreateAttributes(new Robots()));




public *array*  **getAutomaticUpdateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticUpdateAttributes(new Robots()));




public  **setAutomaticCreateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticCreateAttributes(new Robots(), array('created_at' => true));




public  **setAutomaticUpdateAttributes** (*Phalcon\\Mvc\\ModelInterface* $model, *array* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticUpdateAttributes(new Robots(), array('modified_at' => true));




public *array*  **getColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getColumnMap(new Robots()));




public *array*  **getReverseColumnMap** (*Phalcon\\Mvc\\ModelInterface* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the reverse column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getReverseColumnMap(new Robots()));




public *boolean*  **hasAttribute** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $attribute) inherited from Phalcon\\Mvc\\Model\\MetaData

Check if a model has certain attribute 

.. code-block:: php

    <?php

    var_dump($metaData->hasAttribute(new Robots(), 'name'));




public *boolean*  **isEmpty** () inherited from Phalcon\\Mvc\\Model\\MetaData

Checks if the internal meta-data container is empty 

.. code-block:: php

    <?php

    var_dump($metaData->isEmpty());




public  **reset** () inherited from Phalcon\\Mvc\\Model\\MetaData

Resets internal meta-data in order to regenerate it 

.. code-block:: php

    <?php

    $metaData->reset();




