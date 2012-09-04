Class **Phalcon\\Mvc\\Model\\Manager**
======================================

Methods
---------

public **__construct** ()

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*Phalcon\Events\Manager* $eventsManager)

Sets the event manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **initialize** (*Phalcon\Mvc\Model* $model)

Initializes a model in the model manager



public **isInitialized** (*unknown* $modelName)

public **getLastInitialized** ()

public **load** (*unknown* $modelName)

public **addHasOne** (*Phalcon\Mvc\Model* $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a 1-1 relation between two models



public **addBelongsTo** (*Phalcon\Mvc\Model* $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation reverse 1-1  between two models



public **addHasMany** (*Phalcon\Mvc\Model* $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation 1-n between two models



*boolean* public **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



*boolean* public **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



*boolean* public **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



protected **_getRelationRecords** ()

Helper method to query records based on a relation definition



:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` public **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\Mvc\Model* $record)

Gets belongsTo related records from a model



:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` public **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\Mvc\Model* $record)

Gets hasMany related records from a model



:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` public **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\Mvc\Model* $record)

Gets belongsTo related records from a model



*array* public **getBelongsTo** (*Phalcon\Mvc\Model* $model)

Gets belongsTo relations defined on a model



*array* public **getHasMany** (*Phalcon\Mvc\Model* $model)

Gets hasMany relations defined on a model



*array* public **getHasOne** (*Phalcon\Mvc\Model* $model)

Gets hasOne relations defined on a model



*array* public **getHasOneAndHasMany** (*Phalcon\Mvc\Model* $model)

Gets hasOne relations defined on a model



public **getRelations** (*unknown* $a, *unknown* $b)

public **createQuery** (*unknown* $phql)

public **executeQuery** (*unknown* $phql, *unknown* $placeholders)

