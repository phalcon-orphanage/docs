Class **Phalcon\\Mvc\\Model\\MetaData\\Session**
================================================

*extends* abstract class :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>`

Stores model meta-data in session. Data will erased when the session finishes. Meta-data are permanent while the session is active.  You can query the meta-data by printing $_SESSION['$PMM$']  

.. code-block:: php

    <?php

     $metaData = new \Phalcon\Mvc\Model\Metadata\Session(array(
        'prefix' => 'my-app-id'
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

*integer* **MODELS_DEFAULT_VALUES**

*integer* **MODELS_COLUMN_MAP**

*integer* **MODELS_REVERSE_COLUMN_MAP**

Methods
-------

public  **__construct** ([*unknown* $options])

Phalcon\\Mvc\\Model\\MetaData\\Session constructor



public *array*  **read** (*unknown* $key)

Reads meta-data from $_SESSION



public  **write** (*unknown* $key, *unknown* $data)

Writes the meta-data to $_SESSION



final protected  **_initialize** (*unknown* $model, *unknown* $key, *unknown* $table, *unknown* $schema) inherited from Phalcon\\Mvc\\Model\\MetaData

Initialize the metadata for certain table



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Mvc\\Model\\MetaData

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the DependencyInjector container



public  **setStrategy** (*unknown* $strategy) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the meta-data extraction strategy



public :doc:`Phalcon\\Mvc\\Model\\MetaData\\StrategyInterface <Phalcon_Mvc_Model_MetaData_StrategyInterface>`  **getStrategy** () inherited from Phalcon\\Mvc\\Model\\MetaData

Return the strategy to obtain the meta-data



final public *array*  **readMetaData** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads the complete meta-data for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readMetaData(new Robots());




final public *mixed*  **readMetaDataIndex** (*unknown* $model, *unknown* $index) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




final public  **writeMetaDataIndex** (*unknown* $model, *unknown* $index, *unknown* $data) inherited from Phalcon\\Mvc\\Model\\MetaData

Writes meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




final public *array*  **readColumnMap** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads the ordered/reversed column map for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMap(new Robots()));




final public  **readColumnMapIndex** (*unknown* $model, *unknown* $index) inherited from Phalcon\\Mvc\\Model\\MetaData

Reads column-map information for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP));




public *array*  **getAttributes** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns table attributes names (fields) 

.. code-block:: php

    <?php

    print_r($metaData->getAttributes(new Robots()));




public *array*  **getPrimaryKeyAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of fields which are part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getPrimaryKeyAttributes(new Robots()));




public *array*  **getNonPrimaryKeyAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of fields which are not part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getNonPrimaryKeyAttributes(new Robots()));




public *array*  **getNotNullAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns an array of not null attributes 

.. code-block:: php

    <?php

    print_r($metaData->getNotNullAttributes(new Robots()));




public *array*  **getDataTypes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes and their data types 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypes(new Robots()));




public *array*  **getDataTypesNumeric** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes which types are numerical 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypesNumeric(new Robots()));




public *string*  **getIdentityField** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the name of identity field (if one is present) 

.. code-block:: php

    <?php

    print_r($metaData->getIdentityField(new Robots()));




public *array*  **getBindTypes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes and their bind data types 

.. code-block:: php

    <?php

    print_r($metaData->getBindTypes(new Robots()));




public *array*  **getAutomaticCreateAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticCreateAttributes(new Robots()));




public *array*  **getAutomaticUpdateAttributes** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticUpdateAttributes(new Robots()));




public  **setAutomaticCreateAttributes** (*unknown* $model, *unknown* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticCreateAttributes(new Robots(), array('created_at' => true));




public  **setAutomaticUpdateAttributes** (*unknown* $model, *unknown* $attributes) inherited from Phalcon\\Mvc\\Model\\MetaData

Set the attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticUpdateAttributes(new Robots(), array('modified_at' => true));




public *array*  **getDefaultValues** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns attributes (which have default values) and their default values 

.. code-block:: php

    <?php

    print_r($metaData->getDefaultValues(new Robots()));




public *array*  **getColumnMap** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getColumnMap(new Robots()));




public *array*  **getReverseColumnMap** (*unknown* $model) inherited from Phalcon\\Mvc\\Model\\MetaData

Returns the reverse column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getReverseColumnMap(new Robots()));




public *boolean*  **hasAttribute** (*unknown* $model, *unknown* $attribute) inherited from Phalcon\\Mvc\\Model\\MetaData

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




