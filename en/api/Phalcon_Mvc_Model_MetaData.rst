Class **Phalcon\\Mvc\\Model\\MetaData**
=======================================

Phalcon\\Mvc\\Model\\MetaData   <p>Because Phalcon\\Mvc\\Model requires meta-data like field names, data types, primary keys, etc.  this component collect them and store for further querying by Phalcon\\Model\\Base.  Phalcon\\Mvc\\Model\\MetaData can also use adapters to store temporarily or permanently the meta-data.</p>   <p>A standard Phalcon\\Mvc\\Model\\MetaData can be used to query model attributes:</p>   

.. code-block:: php

    <?php

    
     $metaData = new Phalcon\Mvc\Model\MetaData\Memory();
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

**_initializeMetaData** ()

*array* **getAttributes** (*Phalcon\Mvc\Model* **$model**)

*array* **getPrimaryKeyAttributes** (*Phalcon\Mvc\Model* **$model**)

*array* **getNonPrimaryKeyAttributes** (*Phalcon\Mvc\Model* **$model**)

*array* **getNotNullAttributes** (*Phalcon\Mvc\Model* **$model**)

*array* **getDataTypes** (*Phalcon\Mvc\Model* **$model**)

*array* **getDataTypesNumeric** (*Phalcon\Mvc\Model* **$model**)

*array* **getIdentityField** (*Phalcon\Mvc\Model* **$model**)

**storeMetaData** ()

*boolean* **isEmpty** ()

**reset** ()

**write** ()

