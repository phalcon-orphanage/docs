Abstract class **Phalcon\\Mvc\\Model\\MetaData**
================================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadata.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Because Phalcon\\Mvc\\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\\Mvc\\Model. Phalcon\\Mvc\\Model\\MetaData can also use adapters to store temporarily or permanently the meta-data.    A standard Phalcon\\Mvc\\Model\\MetaData can be used to query model attributes:    

.. code-block:: php

    <?php

    $metaData = new \Phalcon\Mvc\Model\MetaData\Memory();
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

*integer* **MODELS_DEFAULT_VALUES**

*integer* **MODELS_EMPTY_STRING_VALUES**

*integer* **MODELS_COLUMN_MAP**

*integer* **MODELS_REVERSE_COLUMN_MAP**

Methods
-------

final protected  **_initialize** (*unknown* $model, *unknown* $key, *unknown* $table, *unknown* $schema)

Initialize the metadata for certain table



public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **setStrategy** (*unknown* $strategy)

Set the meta-data extraction strategy



public  **getStrategy** ()

Return the strategy to obtain the meta-data



final public  **readMetaData** (*unknown* $model)

Reads the complete meta-data for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readMetaData(new Robots());




final public  **readMetaDataIndex** (*unknown* $model, *unknown* $index)

Reads meta-data for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readMetaDataIndex(new Robots(), 0);




final public  **writeMetaDataIndex** (*unknown* $model, *unknown* $index, *unknown* $data)

Writes meta-data for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->writeColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP, array('leName' => 'name')));




final public  **readColumnMap** (*unknown* $model)

Reads the ordered/reversed column map for certain model 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMap(new Robots()));




final public  **readColumnMapIndex** (*unknown* $model, *unknown* $index)

Reads column-map information for certain model using a MODEL_* constant 

.. code-block:: php

    <?php

    print_r($metaData->readColumnMapIndex(new Robots(), MetaData::MODELS_REVERSE_COLUMN_MAP));




public  **getAttributes** (*unknown* $model)

Returns table attributes names (fields) 

.. code-block:: php

    <?php

    print_r($metaData->getAttributes(new Robots()));




public  **getPrimaryKeyAttributes** (*unknown* $model)

Returns an array of fields which are part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getPrimaryKeyAttributes(new Robots()));




public  **getNonPrimaryKeyAttributes** (*unknown* $model)

Returns an array of fields which are not part of the primary key 

.. code-block:: php

    <?php

    print_r($metaData->getNonPrimaryKeyAttributes(new Robots()));




public  **getNotNullAttributes** (*unknown* $model)

Returns an array of not null attributes 

.. code-block:: php

    <?php

    print_r($metaData->getNotNullAttributes(new Robots()));




public  **getDataTypes** (*unknown* $model)

Returns attributes and their data types 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypes(new Robots()));




public  **getDataTypesNumeric** (*unknown* $model)

Returns attributes which types are numerical 

.. code-block:: php

    <?php

    print_r($metaData->getDataTypesNumeric(new Robots()));




public *string*  **getIdentityField** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the name of identity field (if one is present) 

.. code-block:: php

    <?php

    print_r($metaData->getIdentityField(new Robots()));




public  **getBindTypes** (*unknown* $model)

Returns attributes and their bind data types 

.. code-block:: php

    <?php

    print_r($metaData->getBindTypes(new Robots()));




public  **getAutomaticCreateAttributes** (*unknown* $model)

Returns attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticCreateAttributes(new Robots()));




public  **getAutomaticUpdateAttributes** (*unknown* $model)

Returns attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    print_r($metaData->getAutomaticUpdateAttributes(new Robots()));




public  **setAutomaticCreateAttributes** (*unknown* $model, *unknown* $attributes)

Set the attributes that must be ignored from the INSERT SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticCreateAttributes(new Robots(), array('created_at' => true));




public  **setAutomaticUpdateAttributes** (*unknown* $model, *unknown* $attributes)

Set the attributes that must be ignored from the UPDATE SQL generation 

.. code-block:: php

    <?php

    $metaData->setAutomaticUpdateAttributes(new Robots(), array('modified_at' => true));




public  **setEmptyStringAttributes** (*unknown* $model, *unknown* $attributes)

Set the attributes that allow empty string values 

.. code-block:: php

    <?php

    $metaData->setEmptyStringAttributes(new Robots(), array('name' => true));




public  **getEmptyStringAttributes** (*unknown* $model)

Returns attributes allow empty strings 

.. code-block:: php

    <?php

    print_r($metaData->getEmptyStringAttributes(new Robots()));




public  **getDefaultValues** (*unknown* $model)

Returns attributes (which have default values) and their default values 

.. code-block:: php

    <?php

    print_r($metaData->getDefaultValues(new Robots()));




public  **getColumnMap** (*unknown* $model)

Returns the column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getColumnMap(new Robots()));




public  **getReverseColumnMap** (*unknown* $model)

Returns the reverse column map if any 

.. code-block:: php

    <?php

    print_r($metaData->getReverseColumnMap(new Robots()));




public  **hasAttribute** (*unknown* $model, *unknown* $attribute)

Check if a model has certain attribute 

.. code-block:: php

    <?php

    var_dump($metaData->hasAttribute(new Robots(), 'name'));




public  **isEmpty** ()

Checks if the internal meta-data container is empty 

.. code-block:: php

    <?php

    var_dump($metaData->isEmpty());




public  **reset** ()

Resets internal meta-data in order to regenerate it 

.. code-block:: php

    <?php

    $metaData->reset();




