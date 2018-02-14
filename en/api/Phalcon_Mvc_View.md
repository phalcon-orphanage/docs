# Class **Phalcon\\Mvc\\View**

*extends* abstract class [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/[[language]]/[[version]]/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/[[language]]/[[version]]/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ViewInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_ViewInterface), [Phalcon\Mvc\ViewBaseInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_ViewBaseInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/view.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Phalcon\\Mvc\\View is a class for working with the "view" portion of the model-view-controller pattern.
That is, it exists to help keep the view script separate from the model and controller scripts.
It provides a system of helpers, output filters, and variable escaping.

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

// Setting views directory
$view->setViewsDir("app/views/");

$view->start();

// Shows recent posts view (app/views/posts/recent.phtml)
$view->render("posts", "recent");
$view->finish();

// Printing views output
echo $view->getContent();

```


## Constants
*integer* **LEVEL_MAIN_LAYOUT**

*integer* **LEVEL_AFTER_TEMPLATE**

*integer* **LEVEL_LAYOUT**

*integer* **LEVEL_BEFORE_TEMPLATE**

*integer* **LEVEL_ACTION_VIEW**

*integer* **LEVEL_NO_RENDER**

*integer* **CACHE_MODE_NONE**

*integer* **CACHE_MODE_INVERSE**

## Methods
public  **getRenderLevel** ()

...


public  **getCurrentRenderLevel** ()

...


public  **getRegisteredEngines** ()





public  **__construct** ([*array* $options])

Phalcon\\Mvc\\View constructor



final protected  **_isAbsolutePath** (*mixed* $path)

Checks if a path is absolute or not



public  **setViewsDir** (*mixed* $viewsDir)

Sets the views directory. Depending of your platform,
always add a trailing slash or backslash



public  **getViewsDir** ()

Gets views directory



public  **setLayoutsDir** (*mixed* $layoutsDir)

Sets the layouts sub-directory. Must be a directory under the views directory.
Depending of your platform, always add a trailing slash or backslash

```php
<?php

$view->setLayoutsDir("../common/layouts/");

```



public  **getLayoutsDir** ()

Gets the current layouts sub-directory



public  **setPartialsDir** (*mixed* $partialsDir)

Sets a partials sub-directory. Must be a directory under the views directory.
Depending of your platform, always add a trailing slash or backslash

```php
<?php

$view->setPartialsDir("../common/partials/");

```



public  **getPartialsDir** ()

Gets the current partials sub-directory



public  **setBasePath** (*mixed* $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash

```php
<?php

	$view->setBasePath(__DIR__ . "/");

```



public  **getBasePath** ()

Gets base path



public  **setRenderLevel** (*mixed* $level)

Sets the render level for the view

```php
<?php

// Render the view related to the controller only
$this->view->setRenderLevel(
    View::LEVEL_LAYOUT
);

```



public  **disableLevel** (*mixed* $level)

Disables a specific level of rendering

```php
<?php

// Render all levels except ACTION level
$this->view->disableLevel(
    View::LEVEL_ACTION_VIEW
);

```



public  **setMainView** (*mixed* $viewPath)

Sets default view name. Must be a file without extension in the views directory

```php
<?php

// Renders as main view views-dir/base.phtml
$this->view->setMainView("base");

```



public  **getMainView** ()

Returns the name of the main view



public  **setLayout** (*mixed* $layout)

Change the layout to be used instead of using the name of the latest controller name

```php
<?php

$this->view->setLayout("main");

```



public  **getLayout** ()

Returns the name of the main view



public  **setTemplateBefore** (*mixed* $templateBefore)

Sets a template before the controller layout



public  **cleanTemplateBefore** ()

Resets any "template before" layouts



public  **setTemplateAfter** (*mixed* $templateAfter)

Sets a "template after" controller layout



public  **cleanTemplateAfter** ()

Resets any template before layouts



public  **setParamToView** (*mixed* $key, *mixed* $value)

Adds parameters to views (alias of setVar)

```php
<?php

$this->view->setParamToView("products", $products);

```



public  **setVars** (*array* $params, [*mixed* $merge])

Set all the render params

```php
<?php

$this->view->setVars(
    [
        "products" => $products,
    ]
);

```



public  **setVar** (*mixed* $key, *mixed* $value)

Set a single view parameter

```php
<?php

$this->view->setVar("products", $products);

```



public  **getVar** (*mixed* $key)

Returns a parameter previously set in the view



public  **getParamsToView** ()

Returns parameters to views



public  **getControllerName** ()

Gets the name of the controller rendered



public  **getActionName** ()

Gets the name of the action rendered



public  **getParams** ()

Gets extra parameters of the action rendered



public  **start** ()

Starts rendering process enabling the output buffering



protected  **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\\Mvc\\View\\Engine\\Php



protected  **_engineRender** (*array* $engines, *string* $viewPath, *boolean* $silence, *boolean* $mustClean, [[Phalcon\Cache\BackendInterface](/[[language]]/[[version]]/api/Phalcon_Cache_BackendInterface) $cache])

Checks whether view exists on registered extensions and render it



public  **registerEngines** (*array* $engines)

Register templating engines

```php
<?php

$this->view->registerEngines(
    [
        ".phtml" => "Phalcon\\Mvc\\View\\Engine\\Php",
        ".volt"  => "Phalcon\\Mvc\\View\\Engine\\Volt",
        ".mhtml" => "MyCustomEngine",
    ]
);

```



public  **exists** (*mixed* $view)

Checks whether view exists



public  **render** (*string* $controllerName, *string* $actionName, [*array* $params])

Executes render process from dispatching data

```php
<?php

// Shows recent posts view (app/views/posts/recent.phtml)
$view->start()->render("posts", "recent")->finish();

```



public  **pick** (*mixed* $renderView)

Choose a different view to render instead of last-controller/last-action

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
   public function saveAction()
   {
        // Do some save stuff...

        // Then show the list view
        $this->view->pick("products/list");
   }
}

```



public  **getPartial** (*mixed* $partialPath, [*mixed* $params])

Renders a partial view

```php
<?php

// Retrieve the contents of a partial
echo $this->getPartial("shared/footer");

```

```php
<?php

// Retrieve the contents of a partial with arguments
echo $this->getPartial(
    "shared/footer",
    [
        "content" => $html,
    ]
);

```



public  **partial** (*mixed* $partialPath, [*mixed* $params])

Renders a partial view

```php
<?php

// Show a partial inside another view
$this->partial("shared/footer");

```

```php
<?php

// Show a partial inside another view with parameters
$this->partial(
    "shared/footer",
    [
        "content" => $html,
    ]
);

```



public *string* **getRender** (*string* $controllerName, *string* $actionName, [*array* $params], [*mixed* $configCallback])

Perform the automatic rendering returning the output as a string

```php
<?php

$template = $this->view->getRender(
    "products",
    "show",
    [
        "products" => $products,
    ]
);

```



public  **finish** ()

Finishes the render process by stopping the output buffering



protected  **_createCache** ()

Create a Phalcon\\Cache based on the internal cache options



public  **isCaching** ()

Check if the component is currently caching the output content



public  **getCache** ()

Returns the cache instance used to cache



public  **cache** ([*mixed* $options])

Cache the actual view render to certain level

```php
<?php

$this->view->cache(
    [
        "key"      => "my-key",
        "lifetime" => 86400,
    ]
);

```



public  **setContent** (*mixed* $content)

Externally sets the view content

```php
<?php

$this->view->setContent("<h1>hello</h1>");

```



public  **getContent** ()

Returns cached output from another view stage



public  **getActiveRenderPath** ()

Returns the path (or paths) of the views that are currently rendered



public  **disable** ()

Disables the auto-rendering process



public  **enable** ()

Enables the auto-rendering process



public  **reset** ()

Resets the view component to its factory default values



public  **__set** (*mixed* $key, *mixed* $value)

Magic method to pass variables to the views

```php
<?php

$this->view->products = $products;

```



public  **__get** (*mixed* $key)

Magic method to retrieve a variable passed to the view

```php
<?php

echo $this->view->products;

```



public  **isDisabled** ()

Whether automatic rendering is enabled



public  **__isset** (*mixed* $key)

Magic method to retrieve if a variable is set in the view

```php
<?php

echo isset($this->view->products);

```



protected  **getViewsDirs** ()

Gets views directories



public  **setDI** ([Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Sets the dependency injector



public  **getDI** () inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Returns the internal dependency injector



public  **setEventsManager** ([Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Sets the event manager



public  **getEventsManager** () inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Returns the internal event manager



