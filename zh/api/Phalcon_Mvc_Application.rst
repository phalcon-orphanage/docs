Class **Phalcon\\Mvc\\Application**
===================================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

<<<<<<< HEAD
This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired. 
=======
*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     class Application extends \Phalcon\Mvc\Application
     {
    
    	/**
    	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
    	 *\/
    	protected function _registerServices()
    	{
    
    	}
    
    	/**
    	 * This method execute the right module
    	 *\/
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
---------

<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()

Returns the internal event manager



public  **registerModules** (*array* $modules)
=======
public  **registerModules** (*array* $modules, *boolean* $merge)
>>>>>>> 0.7.0

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



<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **handle** ()
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **handle** ()
>>>>>>> 0.7.0

Handles a MVC request



<<<<<<< HEAD
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable

Returns the internal event manager



>>>>>>> 0.7.0
public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



