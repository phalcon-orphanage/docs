Class **Phalcon_Model_MetaData**
================================

>Because Phalcon_Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon_Model_Base. Phalcon_Model_MetaData can also use adapters to store temporarily or permanently the meta-data.

A standard Phalcon_Model_MetaData can be used to query model attributes:

.. code-block:: php

    <?php
    
    $metaData   = new Phalcon_Model_MetaData('Memory');
    $attributes = $metaData->getAttributes(new Robots());
    print_r($attributes);

Constants
---------

integer **MODELS_ATTRIBUTES**

integer **MODELS_PRIMARY_KEY**

integer **MODELS_NON_PRIMARY_KEY**

integer **MODELS_NOT_NULL**

integer **MODELS_DATA_TYPE**

integer **MODELS_DATA_TYPE_NUMERIC**

integer **MODELS_DATE_AT**

integer **MODELS_DATE_IN**

integer **MODELS_IDENTITY_FIELD**

Methods
---------

**__construct** (string $adapter, array $options)

Phalcon_Model_MetaData constructor

**array** **getAttributes** (Phalcon_Model_Base $model)

Returns table attributes names (fields)

**array** **getPrimaryKeyAttributes** (Phalcon_Model_Base $model)

Returns an array of fields which are part of the primary key

**array** **getNonPrimaryKeyAttributes** (Phalcon_Model_Base $model)

Returns an array of fields which are not part of the primary key

**array** **getNotNullAttributes** (Phalcon_Model_Base $model)

Returns an array of not null attributes

**array** **getDataTypes** (Phalcon_Model_Base $model)

Returns attributes and their data types

**array** **getDataTypesNumeric** (Phalcon_Model_Base $model)

Returns attributes which types are numerical

**array** **getIdentityField** (Phalcon_Model_Base $model)

Returns the name of identity field (if one is present)

**storeMetaData** ()

Stores meta-data using to the internal adapter

**boolean** **isEmpty** ()

Checks if the internal meta-data container is empty

**reset** ()

Resets internal meta-data in order to regenerate it

