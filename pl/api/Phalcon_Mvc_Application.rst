Class **Phalcon\\Mvc\\Application**
===================================

*extends* abstract class :doc:`Phalcon\\Application <Phalcon_Application>`

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/application.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component encapsulates all the complex operations behind instantiating every component
needed and integrating it with the rest to allow the MVC pattern to operate as desired.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    class MyApp extends Application
    {
        /**
         * Register the services here to make them general or register
         * in the ModuleDefinition to make them module-specific
         */
        protected function registerServices()
        {

        }

        /**
         * This method registers all the modules in the application
         */
        public function main()
        {
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
        }
    }

    $application = new MyApp();

    $application->main();



Methods
-------

public  **useImplicitView** (*mixed* $implicitView)

By default. The view is implicitly buffering all the output
You can full disable the view component using this method



public  **handle** ([*mixed* $uri])

Handles a MVC request



public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector]) inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Phalcon\\Application



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Sets the events manager



public  **getEventsManager** () inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Returns the internal event manager



public  **registerModules** (*array* $modules, [*mixed* $merge]) inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

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




public  **getModules** () inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Return the modules registered in the application



public  **getModule** (*mixed* $name) inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Gets the module definition registered in the application via module name



public  **setDefaultModule** (*mixed* $defaultModule) inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Sets the module name to be used if the router doesn't return a valid module



public  **getDefaultModule** () inherited from :doc:`Phalcon\\Application <Phalcon_Application>`

Returns the default module name



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the dependency injector



public  **getDI** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal dependency injector



public  **__get** (*mixed* $propertyName) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Magic method __get



