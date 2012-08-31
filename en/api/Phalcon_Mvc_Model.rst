Class **Phalcon\\Mvc\\Model**
=============================

*implements* Serializable

Phalcon\\Mvc\\Model   <p>Phalcon\\Mvc\\Model connects business objects and database tables to create  a persistable domain model where logic and data are presented in one wrapping.  It‘s an implementation of the object-relational mapping (ORM).</p>   <p>A model represents the information (data) of the application and the rules to manipulate that data.  Models are primarily used for managing the rules of interaction with a corresponding database table.  In most cases, each table in your database will correspond to one model in your application.  The bulk of your application’s business logic will be concentrated in the models.</p>   <p>Phalcon\\Mvc\\Model is the first ORM written in C-language for PHP, giving to developers high performance  when interacting with databases while is also easy to use.</p>   

.. code-block:: php

    <?php

    
    
     $robot = new Robots();
     $robot->type = 'mechanical'
     $robot->name = 'Astro Boy';
     $robot->year = 1952;
     if ($robot->save() == false) {
      echo "Umh, We can store robots: ";
      foreach ($robot->getMessages() as $message) {
        echo $message;
      }
     } else {
      echo "Great, a new robot was saved successfully!";
     }
     





Constants
---------

integer **OP_CREATE**

integer **OP_UPDATE**

integer **OP_DELETE**

Methods
---------

**__construct** (*Phalcon\DI* **$dependencyInjector**, *string* **$managerService**, *string* **$dbService**)

**setDI** (*Phalcon\DI* **$dependencyInjector**)

:doc:`Phalcon\\DI <Phalcon_DI>` **getDI** ()

**setEventsManager** (*Phalcon\Events\Manager* **$eventsManager**)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` **getEventsManager** ()

*array* **_createSQLSelect** ()

**_getOrCreateResultset** ()

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **setTransaction** (*Phalcon\Mvc\Model\Transaction* **$transaction**)

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **setSource** ()

*string* **getSource** ()

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **setSchema** ()

*string* **getSchema** ()

**setConnectionService** (*string* **$connectionService**)

*$connectionService* **getConnectionService** ()

**setForceExists** (*unknown* **$forceExists**)

:doc:`Phalcon\\Db <Phalcon_Db>` **getConnection** ()

:doc:`Phalcon\\Mvc\\Model\\Base $result <Phalcon_Mvc_Model_Base $result>` **dumpResult** (*Phalcon\Mvc\Model\Base* **$base**, *array* **$result**)

:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` **find** (*array* **$parameters**)

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **findFirst** (*array* **$parameters**)

*boolean* **_exists** ()

:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` **_prepareGroupResult** ()

:doc:`array|Phalcon\\Mvc\\Model\\Resultset <array|Phalcon_Mvc_Model_Resultset>` **_getGroupResult** ()

*int* **count** (*array* **$parameters**)

*double* **sum** (*array* **$parameters**)

*mixed* **maximum** (*array* **$parameters**)

*mixed* **minimum** (*array* **$parameters**)

*double* **average** (*array* **$parameters**)

*boolean* **_callEvent** ()

*boolean* **_callEventCancel** ()

*boolean* **_cancelOperation** ()

**appendMessage** (*Phalcon\Mvc\Model\Message* **$message**)

**validate** ()

*boolean* **validationHasFailed** ()

:doc:`Phalcon\\Mvc\\Model\\Message[] <Phalcon_Mvc_Model_Message[]>` **getMessages** ()

*boolean* **_checkForeignKeys** ()

*boolean* **_checkForeignKeysReverse** ()

*boolean* **_preSave** ()

*boolean* **_postSave** ()

*boolean* **_doLowInsert** ()

*boolean* **_doLowUpdate** ()

*boolean* **save** ()

**create** ()

**update** ()

*boolean* **delete** ()

*mixed* **readAttribute** (*string* **$attribute**)

**writeAttribute** (*string* **$attribute**, *mixed* **$value**)

**hasOne** ()

**belongsTo** ()

**hasMany** ()

**__getRelatedRecords** ()

*mixed* **__call** (*string* **$method**, *array* **$arguments**)

**serialize** ()

**unserialize** (*unknown* **$data**)

