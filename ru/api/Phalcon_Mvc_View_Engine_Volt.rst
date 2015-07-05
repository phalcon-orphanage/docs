Class **Phalcon\\Mvc\\View\\Engine\\Volt**
==========================================

*extends* abstract class :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Mvc\\View\\EngineInterface <Phalcon_Mvc_View_EngineInterface>`

Designer friendly and fast template engine for PHP written in C


Methods
-------

public  **setOptions** (*unknown* $options)

Set Volt's options



public  **getOptions** ()

Return Volt's options



public  **getCompiler** ()

Returns the Volt's compiler



public  **render** (*unknown* $templatePath, *unknown* $params, [*unknown* $mustClean])

Renders a view using the template engine



public  **length** (*unknown* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen



public  **isIncluded** (*unknown* $needle, *unknown* $haystack)

Checks if the needle is included in the haystack



public  **convertEncoding** (*unknown* $text, *unknown* $from, *unknown* $to)

Performs a string conversion



public  **slice** (*unknown* $value, [*unknown* $start], [*unknown* $end])

Extracts a slice from a string/array/traversable object value



public  **sort** (*unknown* $value)

Sorts an array



public  **__construct** (*unknown* $view, [*unknown* $dependencyInjector]) inherited from Phalcon\\Mvc\\View\\Engine

Phalcon\\Mvc\\View\\Engine constructor



public  **getContent** () inherited from Phalcon\\Mvc\\View\\Engine

Returns cached output on another view stage



public *string*  **partial** (*unknown* $partialPath, [*unknown* $params]) inherited from Phalcon\\Mvc\\View\\Engine

Renders a partial inside another view



public  **getView** () inherited from Phalcon\\Mvc\\View\\Engine

Returns the view component related to the adapter



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get



