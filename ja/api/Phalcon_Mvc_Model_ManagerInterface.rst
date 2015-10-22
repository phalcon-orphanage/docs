Interface **Phalcon\\Mvc\\Model\\ManagerInterface**
===================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **initialize** (*unknown* $model)

...


abstract public  **setModelSource** (*unknown* $model, *unknown* $source)

...


abstract public  **getModelSource** (*unknown* $model)

...


abstract public  **setModelSchema** (*unknown* $model, *unknown* $schema)

...


abstract public  **getModelSchema** (*unknown* $model)

...


abstract public  **setConnectionService** (*unknown* $model, *unknown* $connectionService)

...


abstract public  **setReadConnectionService** (*unknown* $model, *unknown* $connectionService)

...


abstract public  **getReadConnectionService** (*unknown* $model)

...


abstract public  **setWriteConnectionService** (*unknown* $model, *unknown* $connectionService)

...


abstract public  **getWriteConnectionService** (*unknown* $model)

...


abstract public  **getReadConnection** (*unknown* $model)

...


abstract public  **getWriteConnection** (*unknown* $model)

...


abstract public  **isInitialized** (*unknown* $modelName)

...


abstract public  **getLastInitialized** ()

...


abstract public  **load** (*unknown* $modelName, [*unknown* $newInstance])

...


abstract public  **addHasOne** (*unknown* $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

...


abstract public  **addBelongsTo** (*unknown* $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

...


abstract public  **addHasMany** (*unknown* $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

...


abstract public  **existsBelongsTo** (*unknown* $modelName, *unknown* $modelRelation)

...


abstract public  **existsHasMany** (*unknown* $modelName, *unknown* $modelRelation)

...


abstract public  **existsHasOne** (*unknown* $modelName, *unknown* $modelRelation)

...


abstract public  **getBelongsToRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record, [*unknown* $parameters])

...


abstract public  **getHasManyRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record, [*unknown* $parameters])

...


abstract public  **getHasOneRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record, [*unknown* $parameters])

...


abstract public  **getBelongsTo** (*unknown* $model)

...


abstract public  **getHasMany** (*unknown* $model)

...


abstract public  **getHasOne** (*unknown* $model)

...


abstract public  **getHasOneAndHasMany** (*unknown* $model)

...


abstract public  **getRelations** (*unknown* $modelName)

...


abstract public  **getRelationsBetween** (*unknown* $first, *unknown* $second)

...


abstract public  **createQuery** (*unknown* $phql)

...


abstract public  **executeQuery** (*unknown* $phql, [*unknown* $placeholders])

...


abstract public  **createBuilder** ([*unknown* $params])

...


abstract public  **addBehavior** (*unknown* $model, *unknown* $behavior)

...


abstract public  **notifyEvent** (*unknown* $eventName, *unknown* $model)

...


abstract public  **missingMethod** (*unknown* $model, *unknown* $eventName, *unknown* $data)

...


abstract public  **getLastQuery** ()

...


abstract public  **getRelationByAlias** (*unknown* $modelName, *unknown* $alias)

...


