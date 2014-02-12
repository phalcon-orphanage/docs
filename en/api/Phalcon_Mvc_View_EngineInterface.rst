Interface **Phalcon\\Mvc\\View\\EngineInterface**
=================================================

Phalcon\\Mvc\\View\\EngineInterface initializer


Methods
-------

abstract public *array*  **getContent** ()

Returns cached ouput on another view stage



abstract public *string*  **partial** (*string* $partialPath)

Renders a partial inside another view



abstract public  **render** (*string* $path, *array* $params, [*boolean* $mustClean])

Renders a view using the template engine



