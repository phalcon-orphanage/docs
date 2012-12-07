Class **Phalcon\\Mvc\\Controller**
==================================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

<<<<<<< HEAD
Every application controller should extend this class that encapsulates all the controller functionality The controllers provide the “flow” between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. 
=======
*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Every application controller should extend this class that encapsulates all the controller functionality  The controllers provide the “flow” between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    class PeopleController extends \Phalcon\Mvc\Controller
    {
    
      //This action will be executed by default
      public function indexAction()
      {
    
      }
    
      public function findAction()
      {
    
      }
    
      public function saveAction()
      {
       //Forwards flow to the index action
       return $this->dispatcher->forward(array('controller' => 'people', 'action' => 'index'));
      }
    
      //This action will be executed when a non existent action is requested
      public function notFoundAction()
      {
    
      }
    
    }



Methods
---------

final public  **__construct** ()

Phalcon\\Mvc\\Controller constructor



<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
=======
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



