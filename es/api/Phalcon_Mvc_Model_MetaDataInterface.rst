Interface **Phalcon\\Mvc\\Model\\MetaDataInterface**
====================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadatainterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setStrategy** (*unknown* $strategy)

...


abstract public  **getStrategy** ()

...


abstract public  **readMetaData** (*unknown* $model)

...


abstract public  **readMetaDataIndex** (*unknown* $model, *unknown* $index)

...


abstract public  **writeMetaDataIndex** (*unknown* $model, *unknown* $index, *unknown* $data)

...


abstract public  **readColumnMap** (*unknown* $model)

...


abstract public  **readColumnMapIndex** (*unknown* $model, *unknown* $index)

...


abstract public  **getAttributes** (*unknown* $model)

...


abstract public  **getPrimaryKeyAttributes** (*unknown* $model)

...


abstract public  **getNonPrimaryKeyAttributes** (*unknown* $model)

...


abstract public  **getNotNullAttributes** (*unknown* $model)

...


abstract public  **getDataTypes** (*unknown* $model)

...


abstract public  **getDataTypesNumeric** (*unknown* $model)

...


abstract public  **getIdentityField** (*unknown* $model)

...


abstract public  **getBindTypes** (*unknown* $model)

...


abstract public  **getAutomaticCreateAttributes** (*unknown* $model)

...


abstract public  **getAutomaticUpdateAttributes** (*unknown* $model)

...


abstract public  **setAutomaticCreateAttributes** (*unknown* $model, *unknown* $attributes)

...


abstract public  **setAutomaticUpdateAttributes** (*unknown* $model, *unknown* $attributes)

...


abstract public  **setEmptyStringAttributes** (*unknown* $model, *unknown* $attributes)

...


abstract public  **getEmptyStringAttributes** (*unknown* $model)

...


abstract public  **getDefaultValues** (*unknown* $model)

...


abstract public  **getColumnMap** (*unknown* $model)

...


abstract public  **getReverseColumnMap** (*unknown* $model)

...


abstract public  **hasAttribute** (*unknown* $model, *unknown* $attribute)

...


abstract public  **isEmpty** ()

...


abstract public  **reset** ()

...


abstract public  **read** (*unknown* $key)

...


abstract public  **write** (*unknown* $key, *unknown* $data)

...


