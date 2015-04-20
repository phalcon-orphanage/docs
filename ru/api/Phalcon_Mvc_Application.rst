Class **Phalcon\\Mvc\\Application**
===================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

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

public  **__construct** ([*unknown* $dependencyInjector])





public :doc:`Phalcon\\Mvc\\Application <Phalcon_Mvc_Application>`  **useImplicitView** (*unknown* $implicitView)

By default. The view is implicitly buffering all the output You can full disable the view component using this method



public  **registerModules** (*unknown* $modules, [*unknown* $merge])

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



public *array|object*  **getModule** (*unknown* $name)

Gets the module definition registered in the application via module name



public :doc:`Phalcon\\Mvc\\Application <Phalcon_Mvc_Application>`  **setDefaultModule** (*unknown* $defaultModule)

Sets the module name to be used if the router doesn't return a valid module



public *string*  **getDefaultModule** ()

Returns the default module name



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>` |boolean **handle** ([*unknown* $uri])

Handles a MVC request



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get



