Class **Phalcon\\Mvc\\View\\Engine**
====================================

*extends* :doc:`Phalcon\\Mvc\\User <Phalcon_Mvc_User>`

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\\Mvc\\View component.


Methods
---------

public **__construct** (*Phalcon\Mvc\View* $view, *unknown* $dependencyInjector)

Phalcon\\Mvc\\View\\Engine constructor



*array* public **getContent** ()

Returns cached ouput on another view stage



public **partial** (*string* $partialPath)

Renders a partial inside another view



public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **__get** (*unknown* $propertyName)

