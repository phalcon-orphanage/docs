Interface **Phalcon\\Mvc\\Model\\ManagerInterface**
===================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **initialize** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setModelSource** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $source)

...


abstract public  **getModelSource** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setModelSchema** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $schema)

...


abstract public  **getModelSchema** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionService)

...


abstract public  **setReadConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionService)

...


abstract public  **getReadConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **setWriteConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionService)

...


abstract public  **getWriteConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getReadConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getWriteConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **isInitialized** (*mixed* $modelName)

...


abstract public  **getLastInitialized** ()

...


abstract public  **load** (*mixed* $modelName, [*mixed* $newInstance])

...


abstract public  **addHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...


abstract public  **addBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...


abstract public  **addHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...


abstract public  **existsBelongsTo** (*mixed* $modelName, *mixed* $modelRelation)

...


abstract public  **existsHasMany** (*mixed* $modelName, *mixed* $modelRelation)

...


abstract public  **existsHasOne** (*mixed* $modelName, *mixed* $modelRelation)

...


abstract public  **getBelongsToRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

...


abstract public  **getHasManyRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

...


abstract public  **getHasOneRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

...


abstract public  **getBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **getRelations** (*mixed* $modelName)

...


abstract public  **getRelationsBetween** (*mixed* $first, *mixed* $second)

...


abstract public  **createQuery** (*mixed* $phql)

...


abstract public  **executeQuery** (*mixed* $phql, [*mixed* $placeholders])

...


abstract public  **createBuilder** ([*mixed* $params])

...


abstract public  **addBehavior** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>` $behavior)

...


abstract public  **notifyEvent** (*mixed* $eventName, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

...


abstract public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $eventName, *mixed* $data)

...


abstract public  **getLastQuery** ()

...


abstract public  **getRelationByAlias** (*mixed* $modelName, *mixed* $alias)

...


