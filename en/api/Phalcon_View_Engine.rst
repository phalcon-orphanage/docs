Class **Phalcon_View_Engine**
=============================

All the template engine adapters must inherit this class. This provides  basic interfacing between the engine and the Phalcon_View component.

Methods
---------

**__construct** (Phalcon_View $view, array $options)

Phalcon_View_Engine constructor

**initialize** (Phalcon_View $view, array $options)

Initializes the engine adapter

**string** **getControllerName** ()

Gets the name of the controller rendered

**string** **getActionName** ()

Gets the name of the action rendered

**array** **getContent** ()

Returns cached output on another view stage

**string** **url** (array|string $params)

Generates a external absolute path to an application uri

**string** **path** (array|string $params)

Returns a local path

**partial** (string $partialPath)

Renders a partial inside another view

