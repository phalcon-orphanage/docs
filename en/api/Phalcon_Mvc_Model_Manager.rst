Class **Phalcon\\Mvc\\Model\\Manager**
======================================

Phalcon\\Mvc\\Model\\Manager   This components controls the initialization of models, keeping record of relations  between the different models of the application.   A ModelsManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.   

.. code-block:: php

    <?php

    
     $dependencyInjector = new Phalcon\DI();
    
     $dependencyInjector->set('modelsManager', function(){
          return new Phalcon\Mvc\Model\Manager();
     });
    
     $robot = new Robots($dependencyInjector);
     





Methods
---------

**__construct** ()

**setDI** (*unknown* **$dependencyInjector**)

**getDI** ()

**setEventsManager** (*Phalcon\Events\Manager* **$eventsManager**)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` **getEventsManager** ()

**initialize** (*Phalcon\Mvc\Model* **$model**)

**isInitialized** (*unknown* **$modelName**)

**getLastInitialized** ()

**load** (*unknown* **$modelName**)

**addHasOne** (*Phalcon\Mvc\Model* **$model**, *mixed* **$fields**, *string* **$referenceModel**, *mixed* **$referencedFields**, *array* **$options**)

**addBelongsTo** (*Phalcon\Mvc\Model* **$model**, *mixed* **$fields**, *string* **$referenceModel**, *mixed* **$referencedFields**, *array* **$options**)

**addHasMany** (*Phalcon\Mvc\Model* **$model**, *mixed* **$fields**, *string* **$referenceModel**, *mixed* **$referencedFields**, *array* **$options**)

*boolean* **existsBelongsTo** (*string* **$modelName**, *string* **$modelRelation**)

*boolean* **existsHasMany** (*string* **$modelName**, *string* **$modelRelation**)

*boolean* **existsHasOne** (*string* **$modelName**, *string* **$modelRelation**)

**_getRelationRecords** ()

:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` **getBelongsToRecords** (*string* **$method**, *string* **$modelName**, *string* **$modelRelation**, *Phalcon\Mvc\Model* **$record**)

:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` **getHasManyRecords** (*string* **$method**, *string* **$modelName**, *string* **$modelRelation**, *Phalcon\Mvc\Model* **$record**)

:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` **getHasOneRecords** (*string* **$method**, *string* **$modelName**, *string* **$modelRelation**, *Phalcon\Mvc\Model* **$record**)

*array* **getBelongsTo** (*Phalcon\Mvc\Model* **$model**)

*array* **getHasMany** (*Phalcon\Mvc\Model* **$model**)

*array* **getHasOne** (*Phalcon\Mvc\Model* **$model**)

*array* **getHasOneAndHasMany** (*Phalcon\Mvc\Model* **$model**)

**getRelations** (*unknown* **$a**, *unknown* **$b**)

**createQuery** (*unknown* **$phql**)

**executeQuery** (*unknown* **$phql**, *unknown* **$placeholders**)

