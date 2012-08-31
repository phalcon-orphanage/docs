Class **Phalcon\\Mvc\\Controller**
==================================

*extends* :doc:`Phalcon\\Mvc\\User <Phalcon_Mvc_User>`

Phalcon\\Mvc\\Controller   Every application controller should extend this class that encapsulates all the controller functionality   The controllers provide the “flow” between models and views. Controllers are responsible  for processing the incoming requests from the web browser, interrogating the models for data,  and passing that data on to the views for presentation.  

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
       return $this->dispatcher->forward('/people/index');
      }
    
      //This action will be executed when a non existent action is requested
      public function notFoundAction()
      {
    
      }
    
    }
    
    





Methods
---------

**__construct** ()

**setDI** (*unknown* **$dependencyInjector**)

**getDI** ()

**setEventsManager** (*unknown* **$eventsManager**)

**getEventsManager** ()

**__get** (*unknown* **$propertyName**)

