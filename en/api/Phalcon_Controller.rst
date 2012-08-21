Class **Phalcon_Controller**
============================

Every application controller should extend this class that encapsulates all the controller functionality. The controllers provide the "flow" between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation.  

.. code-block:: php

    <?php

    class PeopleController extends \Phalcon\Controller 
    {

        // This action will be executed by default
        public function indexAction()
        {

        }

        public function findAction()
        {

        }

        public function saveAction()
        {
            // Forwards flow to the index action
            return $this->_forward('people/index');
        }

        // This action will be executed when a non existent action is requested
        public function notFoundAction()
        {

    }

    }

Methods
---------

**__construct** (Phalcon_Dispatcher $dispatcher, Phalcon_Request $request, Phalcon_Response $response, Phalcon_View $view, Phalcon_Model_Manager $model)

Constructor for Phalcon_Controller

**_forward** (string $uri)

Forwards execution flow to another controller/action.

**_getParam** (mixed $index)

Returns a param from the dispatching params

**_setParam** (mixed $index, mixed $value)

Set a dispatching parameter

**__get** (string $propertyName)

Magic method __get

