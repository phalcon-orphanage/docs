# Abstract class **Phalcon\\Mvc\\Controller**

*extends* abstract class [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ControllerInterface](/en/3.2/api/Phalcon_Mvc_ControllerInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/controller.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Every application controller should extend this class that encapsulates all the controller functionality

The controllers provide the “flow” between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation.

```php
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

```

## Methods

final public **__construct** ()

Phalcon\\Mvc\\Controller constructor

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Returns the internal event manager

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Magic method __get