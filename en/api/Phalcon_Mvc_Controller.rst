Class **Phalcon\\Mvc\\Controller**
==================================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

Every application controller should extend this class that encapsulates all the controller functionality The controllers provide the “flow” between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. 

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

final public **__construct** ()

Phalcon\\Mvc\\Controller constructor



public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **__get** (*unknown* $propertyName)

