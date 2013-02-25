Class **Phalcon\\CLI\\Console**
===============================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This component allows to create CLI applications using Phalcon


Methods
---------

public  **setDI** (*Phalcon\\DiInterface* $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (*Phalcon\\Events\\ManagerInterface* $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **registerModules** (*array* $modules)

Register an array of modules present in the console 

.. code-block:: php

    <?php

    $application->registerModules(array(
    	'frontend' => array(
    		'className' => 'Multiple\Frontend\Module',
    		'path' => '../apps/frontend/Module.php'
    	),
    	'backend' => array(
    		'className' => 'Multiple\Backend\Module',
    		'path' => '../apps/backend/Module.php'
    	)
    ));




public  **addModules** (*array* $modules)

Merge modules with the existing ones 

.. code-block:: php

    <?php

    $application->addModules(array(
    	'admin' => array(
    		'className' => 'Multiple\Admin\Module',
    		'path' => '../apps/admin/Module.php'
    	)
    ));




public *array*  **getModules** ()

Return the modules registered in the console



public *mixed*  **handle** ([*array* $arguments])

Handle the whole command-line tasks



