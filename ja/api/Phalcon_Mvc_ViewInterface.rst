Interface **Phalcon\\Mvc\\ViewInterface**
=========================================

Phalcon\\Mvc\\ViewInterface initializer


Methods
-------

abstract public  **setViewsDir** (*string* $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash



abstract public *string*  **getViewsDir** ()

Gets views directory



abstract public  **setLayoutsDir** (*string* $layoutsDir)

Sets the layouts sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash



abstract public *string*  **getLayoutsDir** ()

Gets the current layouts sub-directory



abstract public  **setPartialsDir** (*string* $partialsDir)

Sets a partials sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash



abstract public *string*  **getPartialsDir** ()

Gets the current partials sub-directory



abstract public  **setBasePath** (*string* $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash



abstract public  **setRenderLevel** (*string* $level)

Sets the render level for the view



abstract public  **setMainView** (*string* $viewPath)

Sets default view name. Must be a file without extension in the views directory



abstract public *string*  **getMainView** ()

Returns the name of the main view



abstract public  **setLayout** (*string* $layout)

Change the layout to be used instead of using the name of the latest controller name



abstract public *string*  **getLayout** ()

Returns the name of the main view



abstract public  **setTemplateBefore** (*string|array* $templateBefore)

Appends template before controller layout



abstract public  **cleanTemplateBefore** ()

Resets any template before layouts



abstract public  **setTemplateAfter** (*string|array* $templateAfter)

Appends template after controller layout



abstract public  **cleanTemplateAfter** ()

Resets any template before layouts



abstract public  **setParamToView** (*string* $key, *mixed* $value)

Adds parameters to views (alias of setVar)



abstract public  **setVar** (*string* $key, *mixed* $value)

Adds parameters to views



abstract public *array*  **getParamsToView** ()

Returns parameters to views



abstract public *string*  **getControllerName** ()

Gets the name of the controller rendered



abstract public *string*  **getActionName** ()

Gets the name of the action rendered



abstract public *array*  **getParams** ()

Gets extra parameters of the action rendered



abstract public  **start** ()

Starts rendering process enabling the output buffering



abstract public  **registerEngines** (*array* $engines)

Register templating engines



abstract public  **render** (*string* $controllerName, *string* $actionName, [*array* $params])

Executes render process from dispatching data



abstract public  **pick** (*string* $renderView)

Choose a view different to render than last-controller/last-action



abstract public *string*  **partial** (*string* $partialPath)

Renders a partial view



abstract public  **finish** ()

Finishes the render process by stopping the output buffering



abstract public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()

Returns the cache instance used to cache



abstract public  **cache** ([*boolean|array* $options])

Cache the actual view render to certain level



abstract public  **setContent** (*string* $content)

Externally sets the view content



abstract public *string*  **getContent** ()

Returns cached ouput from another view stage



abstract public *string*  **getActiveRenderPath** ()

Returns the path of the view that is currently rendered



abstract public  **disable** ()

Disables the auto-rendering process



abstract public  **enable** ()

Enables the auto-rendering process



abstract public  **reset** ()

Resets the view component to its factory default values



