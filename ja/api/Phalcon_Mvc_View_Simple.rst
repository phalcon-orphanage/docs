Class **Phalcon\\Mvc\\View\\Simple**
====================================

*extends* abstract class :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This component allows to render views without hicherquical levels  

.. code-block:: php

    <?php

     $view = new Phalcon\Mvc\View\Simple();
     echo $view->render('templates/my-view', array('content' => $html));



Methods
-------

public  **__construct** ([*array* $options])

Phalcon\\Mvc\\View constructor



public  **setViewsDir** (*string* $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash



public *string*  **getViewsDir** ()

Gets views directory



public  **registerEngines** (*array* $engines)

Register templating engines 

.. code-block:: php

    <?php

    $this->view->registerEngines(array(
      ".phtml" => "Phalcon\Mvc\View\Engine\Php",
      ".volt" => "Phalcon\Mvc\View\Engine\Volt",
      ".mhtml" => "MyCustomEngine"
    ));




public  **getRegisteredEngines** ()

Returns the registered templating engines



protected *array*  **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\\Mvc\\View\\Engine\\Php



protected  **_internalRender** ()

Tries to render the view with every engine registered in the component



public *string*  **render** (*string* $path, [*array* $params])

Renders a view



public  **partial** (*string* $partialPath, [*array* $params])

Renders a partial view 

.. code-block:: php

    <?php

     	//Show a partial inside another view
     	$this->partial('shared/footer');

.. code-block:: php

    <?php

     	//Show a partial inside another view with parameters
     	$this->partial('shared/footer', array('content' => $html));




public :doc:`Phalcon\\Mvc\\View\\Simple <Phalcon_Mvc_View_Simple>`  **setCacheOptions** (*array* $options)

Sets the cache options



public *array*  **getCacheOptions** ()

Returns the cache options



protected :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **_createCache** ()

Create a Phalcon\\Cache based on the internal cache options



public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()

Returns the cache instance used to cache



public :doc:`Phalcon\\Mvc\\View\\Simple <Phalcon_Mvc_View_Simple>`  **cache** ([*boolean|array* $options])

Cache the actual view render to certain level 

.. code-block:: php

    <?php

      $this->view->cache(array('key' => 'my-key', 'lifetime' => 86400));




public :doc:`Phalcon\\Mvc\\View\\Simple <Phalcon_Mvc_View_Simple>`  **setParamToView** (*string* $key, *mixed* $value)

Adds parameters to views (alias of setVar) 

.. code-block:: php

    <?php

    $this->view->setParamToView('products', $products);




public :doc:`Phalcon\\Mvc\\View\\Simple <Phalcon_Mvc_View_Simple>`  **setVars** (*array* $params, [*boolean* $merge])

Set all the render params 

.. code-block:: php

    <?php

    $this->view->setVars(array('products' => $products));




public :doc:`Phalcon\\Mvc\\View\\Simple <Phalcon_Mvc_View_Simple>`  **setVar** (*string* $key, *mixed* $value)

Set a single view parameter 

.. code-block:: php

    <?php

    $this->view->setVar('products', $products);




public *mixed*  **getVar** (*string* $key)

Returns a parameter previously set in the view



public *array*  **getParamsToView** ()

Returns parameters to views



public :doc:`Phalcon\\Mvc\\View\\Simple <Phalcon_Mvc_View_Simple>`  **setContent** (*string* $content)

Externally sets the view content 

.. code-block:: php

    <?php

    $this->view->setContent("<h1>hello</h1>");




public *string*  **getContent** ()

Returns cached ouput from another view stage



public *string*  **getActiveRenderPath** ()

Returns the path of the view that is currently rendered



public  **__set** (*string* $key, *mixed* $value)

Magic method to pass variables to the views 

.. code-block:: php

    <?php

    $this->view->products = $products;




public *mixed*  **__get** (*string* $key)

Magic method to retrieve a variable passed to the view 

.. code-block:: php

    <?php

    echo $this->view->products;




public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable

Returns the internal event manager



