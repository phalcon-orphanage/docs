Class **Phalcon\\Mvc\\Model\\MetaData\\Apc**
============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Stores model meta-data in the APC cache. Data will erased if the web server is restarted  By default meta-data is stored 48 hours (172800 seconds)  You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-local-app')  

.. code-block:: php

    <?php

     $metaData = new Phalcon\Mvc\Model\Metadata\Apc(array(
        'suffix' => 'my-app-id',
        'lifetime' => 86400
     ));



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

public **__construct** (*array* $options)

Phalcon\\Mvc\\Model\\MetaData\\Apc constructor



*array* public **read** ()

Reads meta-data from APC



public **write** (*array* $data)

Writes the meta-data to APC



protected **_initializeMetaData** ()

public **getAttributes** (*unknown* $model)

public **getPrimaryKeyAttributes** (*unknown* $model)

public **getNonPrimaryKeyAttributes** (*unknown* $model)

public **getNotNullAttributes** (*unknown* $model)

public **getDataTypes** (*unknown* $model)

public **getDataTypesNumeric** (*unknown* $model)

public **getIdentityField** (*unknown* $model)

public **storeMetaData** ()

public **isEmpty** ()

public **reset** ()

