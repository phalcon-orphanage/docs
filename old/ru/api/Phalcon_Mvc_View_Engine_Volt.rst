Class **Phalcon\\Mvc\\View\\Engine\\Volt**
==========================================

*extends* abstract class :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

*implements* :doc:`Phalcon\\Mvc\\View\\EngineInterface <Phalcon_Mvc_View_EngineInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/view/engine/volt.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Designer friendly and fast template engine for PHP written in Zephir/C


Methods
-------

public  **setOptions** (*array* $options)

Set Volt's options



public  **getOptions** ()

Return Volt's options



public  **getCompiler** ()

Returns the Volt's compiler



public  **render** (*mixed* $templatePath, *mixed* $params, [*mixed* $mustClean])

Renders a view using the template engine



public  **length** (*mixed* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen



public  **isIncluded** (*mixed* $needle, *mixed* $haystack)

Checks if the needle is included in the haystack



public  **convertEncoding** (*mixed* $text, *mixed* $from, *mixed* $to)

Performs a string conversion



public  **slice** (*mixed* $value, [*mixed* $start], [*mixed* $end])

Extracts a slice from a string/array/traversable object value



public  **sort** (*array* $value)

Sorts an array



public  **callMacro** (*mixed* $name, [*array* $arguments])

Checks if a macro is defined and calls it



public  **__construct** (:doc:`Phalcon\\Mvc\\ViewBaseInterface <Phalcon_Mvc_ViewBaseInterface>` $view, [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector]) inherited from :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

Phalcon\\Mvc\\View\\Engine constructor



public  **getContent** () inherited from :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

Returns cached output on another view stage



public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

Renders a partial inside another view



public  **getView** () inherited from :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

Returns the view component related to the adapter



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the dependency injector



public  **getDI** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the event manager



public  **getEventsManager** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal event manager



public  **__get** (*mixed* $propertyName) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Magic method __get



