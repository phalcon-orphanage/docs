Abstract class **Phalcon\\Mvc\\Controller**
===========================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\ControllerInterface <Phalcon_Mvc_ControllerInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/controller.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Every application controller should extend this class that encapsulates all the controller functionality

The controllers provide the “flow” between models and views. Controllers are responsible
for processing the incoming requests from the web browser, interrogating the models for data,
and passing that data on to the views for presentation.

.. code-block:: php

    <?php

    <?php

    class PeopleController extends \Phalcon\Mvc\Controller
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
            return $this->dispatcher->forward(
                [
                    "controller" => "people",
                    "action"     => "index",
                ]
            );
        }
    }



Methods
-------

final public  **__construct** ()

Phalcon\\Mvc\\Controller constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the dependency injector



public  **getDI** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the event manager



public  **getEventsManager** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal event manager



public  **__get** (*mixed* $propertyName) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Magic method __get



