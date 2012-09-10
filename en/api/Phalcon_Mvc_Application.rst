Class **Phalcon\\Mvc\\Application**
===================================

This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired. 

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

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the DependencyInjector container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the DependencyInjector container



public **setEventsManager** (*Phalcon\Events\Manager* $eventsManager)

Sets the events manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **registerModules** (*array* $modules)

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




*array* public **getModules** ()

Return the modules registered in the application



:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **handle** ()

Handles a MVC request



