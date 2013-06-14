Class **Phalcon\\Mvc\\View\\Engine\\Volt**
==========================================

*extends* :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Mvc\\View\\EngineInterface <Phalcon_Mvc_View_EngineInterface>`

Designer friendly and fast template engine for PHP written in C


Methods
---------

public  **setOptions** (*array* $options)

Set Volt's options



public *array*  **getOptions** ()

Return Volt's options



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **getCompiler** ()

Returns the Volt's compiler



public  **render** (*string* $templatePath, *array* $params, [*boolean* $mustClean])

Renders a view using the template engine



public *int*  **length** (*mixed* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen



public *boolean*  **isIncluded** (*mixed* $needle, *mixed* $haystack)

Checks if the needle is included in the haystack



public *string*  **convertEncoding** (*string* $text, *string* $from, *string* $to)

Performs a string conversion



public  **slice** (*mixed* $value, *unknown* $start, [*unknown* $end])

Extracts a slice from a string/array/traversable object value



public  **__construct** (:doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>` $view, [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector]) inherited from Phalcon\\Mvc\\View\\Engine

Phalcon\\Mvc\\View\\Engine constructor



public *array*  **getContent** () inherited from Phalcon\\Mvc\\View\\Engine

Returns cached ouput on another view stage



public *string*  **partial** (*string* $partialPath, [*array* $params]) inherited from Phalcon\\Mvc\\View\\Engine

Renders a partial inside another view



public :doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>`  **getView** () inherited from Phalcon\\Mvc\\View\\Engine

Returns the view component related to the adapter



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



