Class **Phalcon\\Mvc\\Model\\Manager**
======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\ManagerInterface <Phalcon_Mvc_Model_ManagerInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A ModelsManager is injected to a model via a Dependency Injector/Services Container such as Phalcon\\DI.  

.. code-block:: php

    <?php

     $di = new \Phalcon\DI();
    
     $di->set('modelsManager', function() {
          return new \Phalcon\Mvc\Model\Manager();
     });
    
     $robot = new Robots($di);



Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (*unknown* $eventsManager)

Sets a global events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setCustomEventsManager** (*unknown* $model, *unknown* $eventsManager)

Sets a custom events manager for a specific model



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getCustomEventsManager** (*unknown* $model)

Returns a custom events manager related to a model



public *boolean*  **initialize** (*unknown* $model)

Initializes a model in the model manager



public *bool*  **isInitialized** (*unknown* $modelName)

Check whether a model is already initialized



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()

Get last initialized model



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **load** (*unknown* $modelName, [*unknown* $newInstance])

Loads a model throwing an exception if it doesn't exist



public  **setModelSource** (*unknown* $model, *unknown* $source)

Sets the mapped source for a model



public *string*  **getModelSource** (*unknown* $model)

Returns the mapped source for a model



public  **setModelSchema** (*unknown* $model, *unknown* $schema)

Sets the mapped schema for a model



public *string*  **getModelSchema** (*unknown* $model)

Returns the mapped schema for a model



public  **setConnectionService** (*unknown* $model, *unknown* $connectionService)

Sets both write and read connection service for a model



public  **setWriteConnectionService** (*unknown* $model, *unknown* $connectionService)

Sets write connection service for a model



public  **setReadConnectionService** (*unknown* $model, *unknown* $connectionService)

Sets read connection service for a model



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getReadConnection** (*unknown* $model)

Returns the connection to read data related to a model



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getWriteConnection** (*unknown* $model)

Returns the connection to write data related to a model



public  **getReadConnectionService** (*unknown* $model)

Returns the connection service name used to read data related to a model



public  **getWriteConnectionService** (*unknown* $model)

Returns the connection service name used to write data related to a model



public  **notifyEvent** (*unknown* $eventName, *unknown* $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



public *boolean*  **missingMethod** (*unknown* $model, *unknown* $eventName, *unknown* $data)

Dispatch a event to the listeners and behaviors This method expects that the endpoint listeners/behaviors returns true meaning that a least one was implemented



public  **addBehavior** (*unknown* $model, *unknown* $behavior)

Binds a behavior to a model



public  **keepSnapshots** (*unknown* $model, *unknown* $keepSnapshots)

Sets if a model must keep snapshots



public *boolean*  **isKeepingSnapshots** (*unknown* $model)

Checks if a model is keeping snapshots for the queried records



public  **useDynamicUpdate** (*unknown* $model, *unknown* $dynamicUpdate)

Sets if a model must use dynamic update instead of the all-field update



public *boolean*  **isUsingDynamicUpdate** (*unknown* $model)

Checks if a model is using dynamic update instead of all-field update



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addHasOne** (*unknown* $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

Setup a 1-1 relation between two models



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addBelongsTo** (*unknown* $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

Setup a relation reverse many to one between two models



public  **addHasMany** (*unknown* $model, *unknown* $fields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

Setup a relation 1-n between two models



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addHasManyToMany** (*unknown* $model, *unknown* $fields, *unknown* $intermediateModel, *unknown* $intermediateFields, *unknown* $intermediateReferencedFields, *unknown* $referencedModel, *unknown* $referencedFields, [*unknown* $options])

Setups a relation n-m between two models



public *boolean*  **existsBelongsTo** (*unknown* $modelName, *unknown* $modelRelation)

Checks whether a model has a belongsTo relation with another model



public *boolean*  **existsHasMany** (*unknown* $modelName, *unknown* $modelRelation)

Checks whether a model has a hasMany relation with another model



public *boolean*  **existsHasOne** (*unknown* $modelName, *unknown* $modelRelation)

Checks whether a model has a hasOne relation with another model



public *boolean*  **existsHasManyToMany** (*unknown* $modelName, *unknown* $modelRelation)

Checks whether a model has a hasManyToMany relation with another model



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>` |false **getRelationByAlias** (*unknown* $modelName, *unknown* $alias)

Returns a relation by its alias



public :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>` |:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>` |false **getRelationRecords** (*unknown* $relation, *unknown* $method, *unknown* $record, [*unknown* $parameters])

Helper method to query records based on a relation definition



public *object*  **getReusableRecords** (*unknown* $modelName, *unknown* $key)

Returns a reusable object from the internal list



public  **setReusableRecords** (*unknown* $modelName, *unknown* $key, *unknown* $records)

Stores a reusable record in the internal list



public  **clearReusableObjects** ()

Clears the internal reusable list



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getBelongsToRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record, [*unknown* $parameters])

Gets belongsTo related records from a model



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasManyRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record, [*unknown* $parameters])

Gets hasMany related records from a model



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getHasOneRecords** (*unknown* $method, *unknown* $modelName, *unknown* $modelRelation, *unknown* $record, [*unknown* $parameters])

Gets belongsTo related records from a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getBelongsTo** (*unknown* $model)

Gets all the belongsTo relations defined in a model 

.. code-block:: php

    <?php

    $relations = $modelsManager->getBelongsTo(new Robots());




public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getHasMany** (*unknown* $model)

Gets hasMany relations defined on a model



public *array*  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getHasManyToMany** (*unknown* $model)

Gets hasManyToMany relations defined on a model



public *array*  **getHasOneAndHasMany** (*unknown* $model)

Gets hasOne relations defined on a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getRelations** (*string* $modelName)

Query all the relationships defined on a model



public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getRelationsBetween** (*unknown* $first, *unknown* $second)

Query the first relationship defined between two models



public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **createQuery** (*unknown* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **executeQuery** (*unknown* $phql, [*unknown* $placeholders], [*unknown* $types])

Creates a Phalcon\\Mvc\\Model\\Query and execute it



public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **createBuilder** ([*unknown* $params])

Creates a Phalcon\\Mvc\\Model\\Query\\Builder



public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **getLastQuery** ()

Returns the lastest query created or executed in the models manager



public  **registerNamespaceAlias** (*unknown* $alias, *unknown* $namespaceName)

Registers shorter aliases for namespaces in PHQL statements



public *string*  **getNamespaceAlias** (*unknown* $alias)

Returns a real namespace from its alias



public *array*  **getNamespaceAliases** ()

Returns all the registered namespace aliases



