Class **Phalcon\\Mvc\\View\\Simple**
====================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\ViewBaseInterface <Phalcon_Mvc_ViewBaseInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/view/simple.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component allows to render views without hierarchical levels  

.. code-block:: php

    <?php

     $view = new \Phalcon\Mvc\View\Simple();
     echo $view->render('templates/my-view', array('content' => $html));
     //or with filename with extension
     echo $view->render('templates/my-view.volt', array('content' => $html));



Methods
-------

public  **getRegisteredEngines** ()

...


public  **__construct** ([*array* $options])

Phalcon\\Mvc\\View\\Simple constructor



public  **setViewsDir** (*unknown* $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash



public  **getViewsDir** ()

Gets views directory



public  **registerEngines** (*unknown* $engines)

Register templating engines 

.. code-block:: php

    <?php

    $this->view->registerEngines(array(
      ".phtml" => "Phalcon\Mvc\View\Engine\Php",
      ".volt" => "Phalcon\Mvc\View\Engine\Volt",
      ".mhtml" => "MyCustomEngine"
    ));




protected *array*  **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\\Mvc\\View\\Engine\\Php



final protected  **_internalRender** (*string* $path, *array* $params)

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




public *\Phalcon\Mvc\View\Simple*  **setCacheOptions** (*array* $options)

Sets the cache options



public *array*  **getCacheOptions** ()

Returns the cache options



protected  **_createCache** ()

Create a Phalcon\\Cache based on the internal cache options



public  **getCache** ()

Returns the cache instance used to cache



public  **cache** ([*unknown* $options])

Cache the actual view render to certain level 

.. code-block:: php

    <?php

      $this->view->cache(array('key' => 'my-key', 'lifetime' => 86400));




public  **setParamToView** (*unknown* $key, *unknown* $value)

Adds parameters to views (alias of setVar) 

.. code-block:: php

    <?php

    $this->view->setParamToView('products', $products);




public  **setVars** (*unknown* $params, [*unknown* $merge])

Set all the render params 

.. code-block:: php

    <?php

    $this->view->setVars(array('products' => $products));




public  **setVar** (*unknown* $key, *unknown* $value)

Set a single view parameter 

.. code-block:: php

    <?php

    $this->view->setVar('products', $products);




public *mixed*  **getVar** (*string* $key)

Returns a parameter previously set in the view



public *array*  **getParamsToView** ()

Returns parameters to views



public  **setContent** (*unknown* $content)

Externally sets the view content 

.. code-block:: php

    <?php

    $this->view->setContent("<h1>hello</h1>");




public  **getContent** ()

Returns cached output from another view stage



public *string*  **getActiveRenderPath** ()

Returns the path of the view that is currently rendered



public  **__set** (*unknown* $key, *unknown* $value)

Magic method to pass variables to the views 

.. code-block:: php

    <?php

    $this->view->products = $products;




public *mixed*  **__get** (*string* $key)

Magic method to retrieve a variable passed to the view 

.. code-block:: php

    <?php

    echo $this->view->products;




public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



