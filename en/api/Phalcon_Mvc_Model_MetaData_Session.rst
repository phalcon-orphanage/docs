Class **Phalcon\\Mvc\\Model\\MetaData\\Session**
================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\MetaData <Phalcon_Mvc_Model_MetaData>`

Phalcon\\Mvc\\Model\\MetaData\\Session   Stores model meta-data in session. Data will erase when the session finishes.  Meta-data are permanent while the session is active.   You can query the meta-data by printing $_SESSION['$PMM$']  

.. code-block:: php

    <?php

    
     $metaData = new Phalcon\Mvc\Model\Metadata\Session(array(
        'suffix' => 'my-app-id'
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

