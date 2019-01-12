* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\ManagerInterface'

* * *

# Interface **Phalcon\Mvc\Model\ManagerInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/managerinterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

abstract public **initialize** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setModelSource** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $source)

...

abstract public **getModelSource** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setModelSchema** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $schema)

...

abstract public **getModelSchema** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setConnectionService** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

...

abstract public **setReadConnectionService** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

...

abstract public **getReadConnectionService** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **setWriteConnectionService** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

...

abstract public **getWriteConnectionService** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getReadConnection** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getWriteConnection** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **isInitialized** (*mixed* $modelName)

...

abstract public **getLastInitialized** ()

...

abstract public **load** (*mixed* $modelName, [*mixed* $newInstance])

...

abstract public **addHasOne** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...

abstract public **addBelongsTo** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...

abstract public **addHasMany** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *mixed* $referencedModel, *mixed* $referencedFields, [*mixed* $options])

...

abstract public **existsBelongsTo** (*mixed* $modelName, *mixed* $modelRelation)

...

abstract public **existsHasMany** (*mixed* $modelName, *mixed* $modelRelation)

...

abstract public **existsHasOne** (*mixed* $modelName, *mixed* $modelRelation)

...

abstract public **getBelongsToRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

...

abstract public **getHasManyRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

...

abstract public **getHasOneRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

...

abstract public **getBelongsTo** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getHasMany** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getHasOne** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getHasOneAndHasMany** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **getRelations** (*mixed* $modelName)

...

abstract public **getRelationsBetween** (*mixed* $first, *mixed* $second)

...

abstract public **createQuery** (*mixed* $phql)

...

abstract public **executeQuery** (*mixed* $phql, [*mixed* $placeholders])

...

abstract public **createBuilder** ([*mixed* $params])

...

abstract public **addBehavior** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, [Phalcon\Mvc\Model\BehaviorInterface](/4.0/en/api/Phalcon_Mvc_Model_BehaviorInterface) $behavior)

...

abstract public **notifyEvent** (*mixed* $eventName, [Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

...

abstract public **missingMethod** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $eventName, *mixed* $data)

...

abstract public **getLastQuery** ()

...

abstract public **getRelationByAlias** (*mixed* $modelName, *mixed* $alias)

...