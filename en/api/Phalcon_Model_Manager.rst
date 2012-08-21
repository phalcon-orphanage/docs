Class **Phalcon_Model_Manager**
===============================

Manages the creation of models into applications and their relationships. Phacon_Model_Manager helps to control the creation of models across a request execution.   

.. code-block:: php

    <?php
    
    $manager = new Phalcon_Model_Manager();
    $manager->setModelsDir('../apps/models/');
    $robot = new Robots($manager);

Methods
---------

**__construct** (Phalcon_Config|stdClass $options)

Constructor for Phalcon_Model_Manager

**setBasePath** (string $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash

**setMetaData** (object $metadata)

Overwrites default meta-data manager

**Phalcon_Model_Metadata** **getMetaData** ()

Returns active meta-data manager. If not exist then one will be created

**setCache** (Phalcon_Cache_Backend|object $cache)

Set the cache object or cache parameters to make the view caching

**Phalcon_Cache_Backend** **getCache** ()

Returns the default cache backend. This cache will be used to store resultsets and generated SQL

**setModelsDir** (string $modelsDir)

Sets the models directory. Depending of your platform, always add a trailing slash or backslash

**string** **getModelsDir** ()

Gets active models directory

**boolean** **isModel** (string $modelName)

Checks whether the given name is an existing model  

.. code-block:: php

    <?php
    
    // Is there a "Robots" model?
    $isModel = $manager->isModel('Robots');
    
**boolean** **load** (string $modelName)

Loads a model looking for its file and initializing them

**boolean** **getModel** (string $modelName)

Gets/Instantiates model from directory  

.. code-block:: php

    <?php
    
    // Get the "Robots" model
    $Robots = $manager->getModel('Robots');
     
**initialize** (Phalcon_Model_Base $model)

Initializes a model in the model manager

**boolean** **getSource** (string $modelName)

Gets the possible source model name from its class name

**setConnection** (Phalcon_Db $connection)

Sets the main connection that automatically is binded to all created models

**Phalcon_Db** **getConnection** ()

Gets default connection to the database. All models by default will use connection returned by this method

**setAutoConnection** (boolean $autoConnection)

Sets if the models manager should create a default connection automatically and bind it to the created models

**boolean** **haveAutoConnection** ()

Check whether the manager binds a database connection automatically to the created models

**addHasOne** (Phalcon_Model_Base $model, mixed $fields, string $referenceModel, mixed $referencedFields, array $options)

Setup a 1-1 relation between two models

**addBelongsTo** (Phalcon_Model_Base $model, mixed $fields, string $referenceModel, mixed $referencedFields, array $options)

Setup a relation reverse 1-1  between two models

**addHasMany** (Phalcon_Model_Base $model, mixed $fields, string $referenceModel, mixed $referencedFields, array $options)

Setup a relation 1-n between two models

**boolean** **existsBelongsTo** (string $modelName, string $modelRelation)

Checks whether a model has a belongsTo relation with another model

**boolean** **existsHasMany** (string $modelName, string $modelRelation)

Checks whether a model has a hasMany relation with another model

**boolean** **existsHasOne** (string $modelName, string $modelRelation)

Checks whether a model has a hasOne relation with another model

**_getRelationRecords** (array $relation, string $method, Phalcon_Model_Base $record)

Helper method to query records based on a relation definition

**Phalcon_Model_Resultset** **getBelongsToRecords** (string $method, string $modelName, string $modelRelation, Phalcon_Model_Base $record)

Gets belongsTo related records from a model

**Phalcon_Model_Resultset** **getHasManyRecords** (string $method, string $modelName, string $modelRelation, Phalcon_Model_Base $record)

Gets hasMany related records from a model

**Phalcon_Model_Resultset** **getHasOneRecords** (string $method, string $modelName, string $modelRelation, Phalcon_Model_Base $record)

Gets belongsTo related records from a model

**array** **getBelongsTo** (Phalcon_Model_Base $model)

Gets belongsTo relations defined on a model

**array** **getHasMany** (Phalcon_Model_Base $model)

Gets hasMany relations defined on a model

**array** **getHasOne** (Phalcon_Model_Base $model)

Gets hasOne relations defined on a model

**array** **getHasOneAndHasMany** (Phalcon_Model_Base $model)

Gets hasOne relations defined on a model

**string** **getCompleteModelsPath** ()

Returns the complete on which manager is looking for models

**autoload** (string $className)

Autoload function for model lazy loading

**Phalcon_Model_Manager** **getDefault** ()

Get the default Phalcon_Model_Manager (usually this first instantiated)

**reset** ()

Resets internal default manager

