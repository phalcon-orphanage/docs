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

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **initialize** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Initializes a model in the model manager



public *bool*  **isInitialized** (*string* $modelName)

Check of a model is already initialized



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()

Get last initialized model



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **load** (*unknown* $modelName)

Loads a model throwing an exception if it doesn't exist



public  **addHasOne** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a 1-1 relation between two models



public  **addBelongsTo** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation reverse 1-1  between two models



public  **addHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation 1-n between two models



public *boolean*  **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



public *boolean*  **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



public *boolean*  **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



protected :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>`  **_getRelationRecords** ()

Helper method to query records based on a relation definition



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)

Gets belongsTo related records from a model



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)

Gets hasMany related records from a model



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)

Gets belongsTo related records from a model



public *array*  **getBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets belongsTo relations defined on a model



public *array*  **getHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasMany relations defined on a model



public *array*  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



public *array*  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



public *array*  **getRelations** (*string* $first, *string* $second)

Query the relationships between two models



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **createQuery** (*string* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **executeQuery** (*string* $phql, *array* $placeholders)

Creates a Phalcon\\Mvc\\Model\\Query and execute it



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **createBuilder** (*string* $params)

Creates a Phalcon\\Mvc\\Model\\Query\\Builder



