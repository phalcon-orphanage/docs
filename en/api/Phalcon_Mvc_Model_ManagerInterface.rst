Interface **Phalcon\\Mvc\\Model\\ManagerInterface**
===================================================

Methods
---------

abstract public  **initialize** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Initializes a model in the model manager



abstract public *boolean*  **isInitialized** (*string* $modelName)

Check of a model is already initialized



abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()

Get last initialized model



abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **load** (*string* $modelName)

Loads a model throwing an exception if it doesn't exist



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **addHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, [*array* $options])

Setup a 1-1 relation between two models



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **addBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, [*array* $options])

Setup a relation reverse 1-1  between two models



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **addHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, [*array* $options])

Setup a relation 1-n between two models



abstract public *boolean*  **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



abstract public *boolean*  **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



abstract public *boolean*  **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, [*array* $parameters])

Gets belongsTo related records from a model



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, [*array* $parameters])

Gets hasMany related records from a model



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record, [*array* $parameters])

Gets belongsTo related records from a model



abstract public *array*  **getBelongsTo** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets belongsTo relations defined on a model



abstract public *array*  **getHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasMany relations defined on a model



abstract public *array*  **getHasOne** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



abstract public *array*  **getHasOneAndHasMany** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Gets hasOne relations defined on a model



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>` [] **getRelations** (*string* $modelName)

Query all the relationships defined on a model



abstract public *array*  **getRelationsBetween** (*string* $firstModel, *string* $secondModel)

Query the relations between two models



abstract public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **createQuery** (*string* $phql)

Creates a Phalcon\\Mvc\\Model\\Query without execute it



abstract public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **executeQuery** (*string* $phql, [*array* $placeholders])

Creates a Phalcon\\Mvc\\Model\\Query and execute it



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **createBuilder** ([*string* $params])

Creates a Phalcon\\Mvc\\Model\\Query\\Builder



abstract public  **addBehavior** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>` $behavior)

Binds a behavior to a model



abstract public  **notifyEvent** (*string* $eventName, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



abstract public *boolean*  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $eventName, *array* $data)

Dispatch a event to the listeners and behaviors This method expects that the endpoint listeners/behaviors returns true meaning that a least one is implemented



abstract public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **getLastQuery** ()

Returns the last query created or executed in the



