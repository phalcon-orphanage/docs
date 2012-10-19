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

public  **__construct** ()

...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()

Returns the internal event manager



public  **initialize** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Initializes a model in the model manager



public *bool*  **isInitialized** (*string* $modelName)

Check of a model is already initialized



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getLastInitialized** ()

Get last initialized model



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **load** (*unknown* $modelName)

Loads a model throwing an exception if it doesn't exist



public  **addHasOne** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a 1-1 relation between two models



public  **addBelongsTo** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation reverse 1-1  between two models



public  **addHasMany** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation 1-n between two models



public *boolean*  **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



public *boolean*  **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



public *boolean*  **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



protected :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>`  **_getRelationRecords** ()

Helper method to query records based on a relation definition



public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)

Gets belongsTo related records from a model



public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)

Gets hasMany related records from a model



public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)

Gets belongsTo related records from a model



public *array*  **getBelongsTo** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Gets belongsTo relations defined on a model



public *array*  **getHasMany** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Gets hasMany relations defined on a model



public *array*  **getHasOne** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Gets hasOne relations defined on a model



public *array*  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)

Gets hasOne relations defined on a model



public *array*  **getRelations** (*string* $first, *string* $second)

Query the relations between two models



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **createQuery** (*string* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **executeQuery** (*string* $phql, *array* $placeholders)

Creates a Phalcon\\Mvc\\Model\\Query and execute it



