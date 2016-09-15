Class **Phalcon\\Mvc\\Model\\Manager**
======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\ManagerInterface <Phalcon_Mvc_Model_ManagerInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/manager.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A ModelsManager is injected to a model via a Dependency Injector/Services Container such as Phalcon\\Di.  

.. code-block:: php

    <?php

     use Phalcon\Di;
     use Phalcon\Mvc\Model\Manager as ModelsManager;
    
     $di = new Di();
    
     $di->set('modelsManager', function() {
          return new ModelsManager();
     });
    
     $robot = new Robots($di);



Methods
-------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets a global events manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setCustomEventsManager** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets a custom events manager for a specific model



public  **getCustomEventsManager** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns a custom events manager related to a model



public  **initialize** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Initializes a model in the model manager



public  **isInitialized** (*mixed* $modelName)

Check whether a model is already initialized



public  **getLastInitialized** ()

Get last initialized model



public  **load** (*mixed* $modelName, [*mixed* $newInstance])

Loads a model throwing an exception if it doesn't exist



public  **setModelSource** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $source)

Sets the mapped source for a model



final public  **isVisibleModelProperty** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $property)

Check whether a model property is declared as public. 

.. code-block:: php

    <?php

     $isPublic = $manager->isVisibleModelProperty(new Robots(), 'name');




public  **getModelSource** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the mapped source for a model



public  **setModelSchema** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $schema)

Sets the mapped schema for a model



public  **getModelSchema** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the mapped schema for a model



public  **setConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionService)

Sets both write and read connection service for a model



public  **setWriteConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionService)

Sets write connection service for a model



public  **setReadConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionService)

Sets read connection service for a model



public  **getReadConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the connection to read data related to a model



public  **getWriteConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the connection to write data related to a model



protected  **_getConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionServices)

Returns the connection to read or write data related to a model depending on the connection services.



public  **getReadConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the connection service name used to read data related to a model



public  **getWriteConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the connection service name used to write data related to a model



public  **_getConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $connectionServices)

Returns the connection service name used to read or write data related to a model depending on the connection services



public  **notifyEvent** (*mixed* $eventName, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Receives events generated in the models and dispatches them to an events-manager if available Notify the behaviors that are listening in the model



public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $eventName, *mixed* $data)

Dispatch an event to the listeners and behaviors This method expects that the endpoint listeners/behaviors returns true meaning that a least one was implemented



public  **addBehavior** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>` $behavior)

Binds a behavior to a model



public  **keepSnapshots** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $keepSnapshots)

Sets if a model must keep snapshots



public  **isKeepingSnapshots** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Checks if a model is keeping snapshots for the queried records



public  **useDynamicUpdate** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $dynamicUpdate)

Sets if a model must use dynamic update instead of the all-field update



public  **isUsingDynamicUpdate** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Checks if a model is using dynamic update instead of all-field update



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addHasOne** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup a 1-1 relation between two models



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addBelongsTo** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup a relation reverse many to one between two models



public  **addHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup a relation 1-n between two models



public :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>`  **addHasManyToMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $fields, *string* $intermediateModel, *string* $intermediateFields, *string* $intermediateReferencedFields, *string* $referencedModel, *string* $referencedFields, [*array* $options])

Setups a relation n-m between two models



public  **existsBelongsTo** (*mixed* $modelName, *mixed* $modelRelation)

Checks whether a model has a belongsTo relation with another model



public  **existsHasMany** (*mixed* $modelName, *mixed* $modelRelation)

Checks whether a model has a hasMany relation with another model



public  **existsHasOne** (*mixed* $modelName, *mixed* $modelRelation)

Checks whether a model has a hasOne relation with another model



public  **existsHasManyToMany** (*mixed* $modelName, *mixed* $modelRelation)

Checks whether a model has a hasManyToMany relation with another model



public  **getRelationByAlias** (*mixed* $modelName, *mixed* $alias)

Returns a relation by its alias



final protected  **_mergeFindParameters** (*mixed* $findParamsOne, *mixed* $findParamsTwo)

Merge two arrays of find parameters



public :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>` |Phalcon\Mvc\Model\Resultset\Simple|int|false **getRelationRecords** (:doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` $relation, *mixed* $method, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

Helper method to query records based on a relation definition



public  **getReusableRecords** (*mixed* $modelName, *mixed* $key)

Returns a reusable object from the internal list



public  **setReusableRecords** (*mixed* $modelName, *mixed* $key, *mixed* $records)

Stores a reusable record in the internal list



public  **clearReusableObjects** ()

Clears the internal reusable list



public  **getBelongsToRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

Gets belongsTo related records from a model



public  **getHasManyRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

Gets hasMany related records from a model



public  **getHasOneRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record, [*mixed* $parameters])

Gets belongsTo related records from a model



public  **getBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets all the belongsTo relations defined in a model 

.. code-block:: php

    <?php

    $relations = $modelsManager->getBelongsTo(new Robots());




public  **getHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasMany relations defined on a model



public  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



public  **getHasManyToMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasManyToMany relations defined on a model



public  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



public  **getRelations** (*mixed* $modelName)

Query all the relationships defined on a model



public  **getRelationsBetween** (*mixed* $first, *mixed* $second)

Query the first relationship defined between two models



public  **createQuery** (*mixed* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



public  **executeQuery** (*mixed* $phql, [*mixed* $placeholders], [*mixed* $types])

Creates a Phalcon\\Mvc\\Model\\Query and execute it



public  **createBuilder** ([*mixed* $params])

Creates a Phalcon\\Mvc\\Model\\Query\\Builder



public  **getLastQuery** ()

Returns the last query created or executed in the models manager



public  **registerNamespaceAlias** (*mixed* $alias, *mixed* $namespaceName)

Registers shorter aliases for namespaces in PHQL statements



public  **getNamespaceAlias** (*mixed* $alias)

Returns a real namespace from its alias



public  **getNamespaceAliases** ()

Returns all the registered namespace aliases



public  **__destruct** ()

Destroys the current PHQL cache



