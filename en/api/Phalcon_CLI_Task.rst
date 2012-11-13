Class **Phalcon\\CLI\\Task**
============================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

*implements* Phalcon\Events\EventsAwareInterface, Phalcon\DI\InjectionAwareInterface

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



Methods
---------

final public  **__construct** ()

Phalcon\\CLI\\Task constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



