Class **Phalcon\\Mvc\\Model\\Manager**
======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\ManagerInterface <Phalcon_Mvc_Model_ManagerInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A ModelsManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.  

.. code-block:: php

    <?php

     $dependencyInjector = new Phalcon\DI();
    
     $dependencyInjector->set('modelsManager', function(){
          return new Phalcon\Mvc\Model\Manager();
     });
    
     $robot = new Robots($dependencyInjector);



Methods
---------

public  **setDI** (*Phalcon\\DiInterface* $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (*Phalcon\\Events\\ManagerInterface* $eventsManager)

Sets a global events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setCustomEventsManager** (*Phalcon\\Mvc\\ModelInterface* $model, *Phalcon\\Events\\ManagerInterface* $eventsManager)

Sets a custom events manager for a specific model



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getCustomEventsManager** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns a custom events manager related to a model



public  **initialize** (*Phalcon\\Mvc\\ModelInterface* $model)

Initializes a model in the model manager



public *bool*  **isInitialized** (*string* $modelName)

Check whether a model is already initialized



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()

Get last initialized model



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **load** (*string* $modelName, [*boolean* $newInstance])

Loads a model throwing an exception if it doesn't exist



public *string*  **setModelSource** (*Phalcon\\Mvc\\Model* $model, *string* $source)

Sets the mapped source for a model



public *string*  **getModelSource** (*Phalcon\\Mvc\\Model* $model)

Returns the mapped source for a model



public *string*  **setModelSchema** (*Phalcon\\Mvc\\Model* $model, *string* $schema)

Sets the mapped schema for a model



public *string*  **getModelSchema** (*Phalcon\\Mvc\\Model* $model)

Returns the mapped schema for a model



public  **setConnectionService** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $connectionService)

Sets both write and read connection service for a model



public  **setWriteConnectionService** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $connectionService)

Sets write connection service for a model



public  **setReadConnectionService** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $connectionService)

Sets read connection service for a model



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getWriteConnection** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the connection to write data related to a model



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getReadConnection** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the connection to read data related to a model



public  **getReadConnectionService** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the connection service name used to read data related to a model



public  **getWriteConnectionService** (*Phalcon\\Mvc\\ModelInterface* $model)

Returns the connection service name used to write data related to a model



public  **notifyEvent** (*string* $eventName, *Phalcon\\Mvc\\ModelInterface* $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



public *boolean*  **missingMethod** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $eventName, *array* $data)

Dispatch a event to the listeners and behaviors This method expects that the endpoint listeners/behaviors returns true meaning that a least one is implemented



public  **addBehavior** (*Phalcon\\Mvc\\ModelInterface* $model, *Phalcon\\Mvc\\Model\\BehaviorInterface* $behavior)

Binds a behavior to a model



public  **keepSnapshots** (*Phalcon\\Mvc\\Model* $model, *boolean* $keepSnapshots)

Sets if a model must keep snapshots



public *boolean*  **isKeepingSnapshots** (*unknown* $model)

Checks if a model is keeping snapshots for the queried records



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addHasOne** (*Phalcon\\Mvc\\Model* $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup a 1-1 relation between two models



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addBelongsTo** (*Phalcon\\Mvc\\Model* $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup a relation reverse many to one between two models



public  **addHasMany** (*Phalcon\\Mvc\\ModelInterface* $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup a relation 1-n between two models



public  **addHasManyThrough** ()

...


public *boolean*  **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



public *boolean*  **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



public *boolean*  **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **getRelationByAlias** (*string* $modelName, *string* $alias)

Returns a relation by its alias



public :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>`  **getRelationRecords** (*Phalcon\\Mvc\\Model\\Relation* $relation, *string* $method, *Phalcon\\Mvc\\ModelInterface* $record, [*array* $parameters])

Helper method to query records based on a relation definition



public *object*  **getReusableRecords** (*string* $modelName, *string* $key)

Returns a reusable object from the internal list



public  **setReusableRecords** (*string* $modelName, *string* $key, *mixed* $records)

Stores a reusable record in the internal list



public  **clearReusableObjects** ()

Clears the internal reusable list



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\\Mvc\\Model* $record, [*array* $parameters])

Gets belongsTo related records from a model



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\\Mvc\\Model* $record, [*array* $parameters])

Gets hasMany related records from a model



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\\Mvc\\Model* $record, [*array* $parameters])

Gets belongsTo related records from a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getBelongsTo** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets all the belongsTo relations defined in a model 

.. code-block:: php

    <?php

    $relations = $modelsManager->getBelongsTo(new Robots());




public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getHasMany** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets hasMany relations defined on a model



public *array*  **getHasOne** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets hasOne relations defined on a model



public *array*  **getHasOneAndHasMany** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets hasOne relations defined on a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getRelations** (*string* $modelName)

Query all the relationships defined on a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **getRelationsBetween** (*string* $first, *string* $second)

Query the first relationship defined between two models



public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **createQuery** (*string* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **executeQuery** (*string* $phql, [*array* $placeholders])

Creates a Phalcon\\Mvc\\Model\\Query and execute it



public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **createBuilder** ([*string* $params])

Creates a Phalcon\\Mvc\\Model\\Query\\Builder



public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **getLastQuery** ()

Returns the last query created or executed in the models manager



