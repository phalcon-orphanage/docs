Class **Phalcon\\Mvc\\Model\\Manager**
======================================

<<<<<<< HEAD
This components controls the initialization of models, keeping record of relations between the different models of the application. A ModelsManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI. 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\ManagerInterface <Phalcon_Mvc_Model_ManagerInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A ModelsManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.  
>>>>>>> 0.7.0

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

<<<<<<< HEAD
...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
Phalcon\\Mvc\\Model\\Manager constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the DependencyInjector container



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

Returns the DependencyInjector container



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)
>>>>>>> 0.7.0

Sets the event manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()
>>>>>>> 0.7.0

Returns the internal event manager



<<<<<<< HEAD
public  **initialize** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public  **initialize** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Initializes a model in the model manager



public *bool*  **isInitialized** (*string* $modelName)

Check of a model is already initialized



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getLastInitialized** ()
=======
public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()
>>>>>>> 0.7.0

Get last initialized model



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **load** (*unknown* $modelName)
=======
public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **load** (*unknown* $modelName)
>>>>>>> 0.7.0

Loads a model throwing an exception if it doesn't exist



public  **addHasOne** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a 1-1 relation between two models



public  **addBelongsTo** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)

Setup a relation reverse 1-1  between two models



<<<<<<< HEAD
public  **addHasMany** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)
=======
public  **addHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, *array* $options)
>>>>>>> 0.7.0

Setup a relation 1-n between two models



public *boolean*  **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



public *boolean*  **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



public *boolean*  **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



protected :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <Phalcon_Mvc_Model_Resultset_Simple>`  **_getRelationRecords** ()

Helper method to query records based on a relation definition



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)
=======
public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)
>>>>>>> 0.7.0

Gets belongsTo related records from a model



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)
=======
public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)
>>>>>>> 0.7.0

Gets hasMany related records from a model



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)
=======
public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, *array* $parameters)
>>>>>>> 0.7.0

Gets belongsTo related records from a model



<<<<<<< HEAD
public *array*  **getBelongsTo** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Gets belongsTo relations defined on a model



<<<<<<< HEAD
public *array*  **getHasMany** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Gets hasMany relations defined on a model



<<<<<<< HEAD
public *array*  **getHasOne** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Gets hasOne relations defined on a model



<<<<<<< HEAD
public *array*  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public *array*  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0

Gets hasOne relations defined on a model



public *array*  **getRelations** (*string* $first, *string* $second)

<<<<<<< HEAD
Query the relations between two models
=======
Query the relationships between two models
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **createQuery** (*string* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **executeQuery** (*string* $phql, *array* $placeholders)

Creates a Phalcon\\Mvc\\Model\\Query and execute it



<<<<<<< HEAD
=======
public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **createBuilder** (*string* $params)

Creates a Phalcon\\Mvc\\Model\\Query\\Builder



>>>>>>> 0.7.0
