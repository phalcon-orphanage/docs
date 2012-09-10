Class **Phalcon\\Mvc\\Model\\Manager**
======================================

This components controls the initialization of models, keeping record of relations between the different models of the application. A ModelsManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI. 

.. code-block:: php

    <?php

     $dependencyInjector = new Phalcon\DI();
    
     $dependencyInjector->set('modelsManager', function(){
          return new Phalcon\Mvc\Model\Manager();
     });
    
     $robot = new Robots($dependencyInjector);



Methods
---------

public **__construct** ()

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the DependencyInjector container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the DependencyInjector container



public **setEventsManager** (*Phalcon\Events\Manager* $eventsManager)

Sets the event manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **initialize** (*Phalcon\Mvc\Model* $model)

Initializes a model in the model manager



*bool* public **isInitialized** (*string* $modelName)

Check of a model is already initialized



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **getLastInitialized** ()

Get last initialized model



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **load** (*unknown* $modelName)

Loads a model throwing an exception if it doesn't exist



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



*array* public **getRelations** (*unknown* $a, *unknown* $b)

Query the relations between two models



:doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>` public **createQuery** (*string* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



:doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>` public **executeQuery** (*string* $phql, *array* $placeholders)

Creates a Phalcon\\Mvc\\Model\\Query and execute it



