Interface **Phalcon\\Mvc\\Model\\ManagerInterface**
===================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **initialize** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setModelSource** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $source)

...


abstract public  **getModelSource** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setModelSchema** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $schema)

...


abstract public  **getModelSchema** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $connectionService)

...


abstract public  **setReadConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $connectionService)

...


abstract public  **getReadConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setWriteConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $connectionService)

...


abstract public  **getWriteConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getReadConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getWriteConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **isInitialized** (*unknown* $modelName)

...


abstract public  **getLastInitialized** ()

...


abstract public  **load** (*unknown* $modelName, [*unknown* $newInstance])

...


abstract public  **addHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

...


abstract public  **addBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

...


abstract public  **addHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

...


abstract public  **existsBelongsTo** (*unknown* $modelName, *unknown* $modelRelation)

...


abstract public  **existsHasMany** (*unknown* $modelName, *unknown* $modelRelation)

...


abstract public  **existsHasOne** (*unknown* $modelName, *unknown* $modelRelation)

...


abstract public  **getBelongsToRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*unknown* $parameters])

...


abstract public  **getHasManyRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*unknown* $parameters])

...


abstract public  **getHasOneRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*unknown* $parameters])

...


abstract public  **getBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

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


abstract public  **addBehavior** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>` $behavior)

...


abstract public  **notifyEvent** (*unknown* $eventName, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *unknown* $eventName, *unknown* $data)

...


abstract public  **getLastQuery** ()

...


abstract public  **getRelationByAlias** (*unknown* $modelName, *unknown* $alias)

...


