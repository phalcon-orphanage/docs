Interface **Phalcon\\Mvc\\View\\EngineInterface**
=================================================

Phalcon\\Mvc\\View\\EngineInterface initializer


Methods
---------

abstract public  **__construct** (:doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>` $view, [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Phalcon\\Mvc\\View\\Engine constructor



abstract public *array*  **getContent** ()

Returns cached ouput on another view stage



abstract public *string*  **partial** (*string* $partialPath)

Renders a partial inside another view



abstract public  **render** (*string* $path, *array* $params, [*boolean* $mustClean])

Renders a view using the template engine



