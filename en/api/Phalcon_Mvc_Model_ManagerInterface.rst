Interface **Phalcon\\Mvc\\Model\\ManagerInterface**
===================================================

Phalcon\\Mvc\\Model\\ManagerInterface initializer


Methods
---------

abstract public  **initialize** (*Phalcon\\Mvc\\ModelInterface* $model)

Initializes a model in the model manager



abstract public *boolean*  **isInitialized** (*string* $modelName)

Check of a model is already initialized



abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()

Get last initialized model



abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **load** (*string* $modelName)

Loads a model throwing an exception if it doesn't exist



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **addHasOne** (*Phalcon\\Mvc\\ModelInterface* $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, [*array* $options])

Setup a 1-1 relation between two models



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **addBelongsTo** (*Phalcon\\Mvc\\ModelInterface* $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, [*array* $options])

Setup a relation reverse 1-1  between two models



abstract public :doc:`Phalcon\\Mvc\\Model\\RelationInterface <Phalcon_Mvc_Model_RelationInterface>`  **addHasMany** (*Phalcon\\Mvc\\ModelInterface* $model, *mixed* $fields, *string* $referenceModel, *mixed* $referencedFields, [*array* $options])

Setup a relation 1-n between two models



abstract public *boolean*  **existsBelongsTo** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a belongsTo relation with another model



abstract public *boolean*  **existsHasMany** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasMany relation with another model



abstract public *boolean*  **existsHasOne** (*string* $modelName, *string* $modelRelation)

Checks whether a model has a hasOne relation with another model



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getBelongsToRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\\Mvc\\Model* $record, [*array* $parameters])

Gets belongsTo related records from a model



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasManyRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\\Mvc\\Model* $record, [*array* $parameters])

Gets hasMany related records from a model



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getHasOneRecords** (*string* $method, *string* $modelName, *string* $modelRelation, *Phalcon\\Mvc\\Model* $record, [*array* $parameters])

Gets belongsTo related records from a model



abstract public *array*  **getBelongsTo** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets belongsTo relations defined on a model



abstract public *array*  **getHasMany** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets hasMany relations defined on a model



abstract public *array*  **getHasOne** (*Phalcon\\Mvc\\ModelInterface* $model)

Gets hasOne relations defined on a model



abstract public *array*  **getHasOneAndHasMany** (*Phalcon\\Mvc\\ModelInterface* $model)

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



abstract public  **addBehavior** (*Phalcon\\Mvc\\ModelInterface* $model, *Phalcon\\Mvc\\Model\\BehaviorInterface* $behavior)

Binds a behavior to a model



abstract public  **notifyEvent** (*string* $eventName, *Phalcon\\Mvc\\ModelInterface* $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



abstract public *boolean*  **missingMethod** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $eventName, *array* $data)

Dispatch a event to the listeners and behaviors This method expects that the endpoint listeners/behaviors returns true meaning that a least one is implemented



abstract public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **getLastQuery** ()

Returns the last query created or executed in the



