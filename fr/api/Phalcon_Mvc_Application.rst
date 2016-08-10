Class **Phalcon\\Mvc\\Application**
===================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/application.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired.

.. code-block:: php

    <?php

     class Application extends \Phalcon\Mvc\Application
     {

    	/**
    	 * Register the services here to make them general or register
    	 * in the ModuleDefinition to make them module-specific
    	 */
    	protected function _registerServices()
    	{

    	}

    	/**
    	 * This method registers all the modules in the application
    	 */
    	public function main()
    	{
    		$this->registerModules(array(
    			'frontend' => array(
    				'className' => 'Multiple\Frontend\Module',
    				'path' => '../apps/frontend/Module.php'
    			),
    			'backend' => array(
    				'className' => 'Multiple\Backend\Module',
    				'path' => '../apps/backend/Module.php'
    			)
    		));
    	}
    }

    $application = new Application();
    $application->main();



Methods
-------

public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])





public  **useImplicitView** (*unknown* $implicitView)

By default. The view is implicitly buffering all the output You can full disable the view component using this method



public  **registerModules** (*array* $modules, [*unknown* $merge])

Register an array of modules present in the application

.. code-block:: php

    <?php

    $this->registerModules(array(
    	'frontend' => array(
    		'className' => 'Multiple\Frontend\Module',
    		'path' => '../apps/frontend/Module.php'
    	),
    	'backend' => array(
    		'className' => 'Multiple\Backend\Module',
    		'path' => '../apps/backend/Module.php'
    	)
    ));




public *array*  **getModules** ()

Return the modules registered in the application



public *array|object*  **getModule** (*string* $name)

Gets the module definition registered in the application via module name



public  **setDefaultModule** (*unknown* $defaultModule)

Sets the module name to be used if the router doesn't return a valid module



public  **getDefaultModule** ()

Returns the default module name


public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>` \|boolean **handle** ([*string* $uri])

Handles a MVC request



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get
