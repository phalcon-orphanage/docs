Class **Phalcon\\Mvc\\Model\\MetaData\\Apc**
============================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Phalcon\\Mvc\\Model\\MetaData\\Apc   Stores model meta-data in the APC cache. Data will erased if the web server is restarted   By default meta-data is stored 48 hours (172800 seconds)   You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-local-app')  

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

**__construct** (*array* **$options**)

*array* **read** ()

**write** (*array* **$data**)

**_initializeMetaData** ()

**getAttributes** (*unknown* **$model**)

**getPrimaryKeyAttributes** (*unknown* **$model**)

**getNonPrimaryKeyAttributes** (*unknown* **$model**)

**getNotNullAttributes** (*unknown* **$model**)

**getDataTypes** (*unknown* **$model**)

**getDataTypesNumeric** (*unknown* **$model**)

**getIdentityField** (*unknown* **$model**)

**storeMetaData** ()

**isEmpty** ()

**reset** ()

