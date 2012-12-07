Class **Phalcon\\CLI\\Task**
============================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Every command-line task should extend this class that encapsulates all the task functionality  A task can be used to run "tasks" such as migrations, cronjobs, unit-tests, or anything that you want. The Task class should at least have a "runAction" method  

.. code-block:: php

    <?php

    class HelloTask extends \Phalcon\CLI\Task
    {
    
      //This action will be executed by default
      public function runAction()
      {
    
      }
    
      public function findAction()
      {
    
      }
    
      //This action will be executed when a non existent action is requested
      public function notFoundAction()
      {
    
      }
    
    }



>>>>>>> 0.7.0
Methods
---------

final public  **__construct** ()

<<<<<<< HEAD
...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
=======
Phalcon\\CLI\\Task constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** () inherited from Phalcon\\DI\\Injectable
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Returns the internal dependency injector



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\\DI\\Injectable
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Sets the event manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



