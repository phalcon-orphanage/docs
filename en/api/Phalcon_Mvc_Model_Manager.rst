Class **Phalcon\Mvc\Model\Manager**
===================================

Methods
---------

public **__construct** ()

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **initialize** (*unknown* $model)

public **isInitialized** (*unknown* $modelName)

public **getLastInitialized** ()

public **load** (*unknown* $modelName)

public **addHasOne** (*unknown* $model, *unknown* $fields, *unknown* $referenceModel, *unknown* $referencedFields, *unknown* $options)

public **addBelongsTo** (*unknown* $model, *unknown* $fields, *unknown* $referenceModel, *unknown* $referencedFields, *unknown* $options)

public **addHasMany** (*unknown* $model, *unknown* $fields, *unknown* $referenceModel, *unknown* $referencedFields, *unknown* $options)

public **existsBelongsTo** (*unknown* $modelName, *unknown* $modelRelation)

public **existsHasMany** (*unknown* $modelName, *unknown* $modelRelation)

public **existsHasOne** (*unknown* $modelName, *unknown* $modelRelation)

protected **_getRelationRecords** ()

public **getBelongsToRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record)

public **getHasManyRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record)

public **getHasOneRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record)

public **getBelongsTo** (*unknown* $model)

public **getHasMany** (*unknown* $model)

public **getHasOne** (*unknown* $model)

public **getHasOneAndHasMany** (*unknown* $model)

public **getRelations** (*unknown* $a, *unknown* $b)

public **createQuery** (*unknown* $phql)

public **executeQuery** (*unknown* $phql, *unknown* $placeholders)

