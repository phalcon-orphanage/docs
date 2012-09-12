Class **Phalcon\\CLI\\Console**
===============================

This component allows to create CLI applications using Phalcon


Methods
---------

public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the DependencyInjector container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



public **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the events manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **registerModules** (*array* $modules)

Register an array of modules present in the console 

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




public **addModules** (*array* $modules)

Merge modules with the existing ones



*array* public **getModules** ()

Return the modules registered in the console



*mixed* public **handle** (*array* $arguments)

Handle the whole command-line tasks



