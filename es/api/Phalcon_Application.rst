Abstract class **Phalcon\\Application**
=======================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/application.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Base class for Phalcon\\Cli\\Console and Phalcon\\Mvc\\Application.


Methods
-------

public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])





public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the events manager



public  **getEventsManager** ()

Returns the internal event manager



public  **registerModules** (*array* $modules, [*mixed* $merge])

Register an array of modules present in the application

.. code-block:: php

    <?php

    $this->registerModules(
        [
            "frontend" => [
                "className" => "Multiple\\Frontend\\Module",
                "path"      => "../apps/frontend/Module.php",
            ],
            "backend" => [
                "className" => "Multiple\\Backend\\Module",
                "path"      => "../apps/backend/Module.php",
            ],
        ]
    );




public  **getModules** ()

Return the modules registered in the application



public  **getModule** (*mixed* $name)

Gets the module definition registered in the application via module name



public  **setDefaultModule** (*mixed* $defaultModule)

Sets the module name to be used if the router doesn't return a valid module



public  **getDefaultModule** ()

Returns the default module name



abstract public  **handle** ()

Handles a request



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the dependency injector



public  **getDI** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal dependency injector



public  **__get** (*mixed* $propertyName) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Magic method __get



