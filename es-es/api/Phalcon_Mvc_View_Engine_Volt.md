* * *

layout: article language: 'es-es' version: '4.0' title: 'Phalcon\Mvc\View\Engine\Volt'

* * *

# Class **Phalcon\Mvc\View\Engine\Volt**

*extends* abstract class [Phalcon\Mvc\View\Engine](/4.0/en/api/Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](/4.0/en/api/Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](/4.0/en/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](/4.0/en/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/view/engine/volt.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Diseñador de plantilla amigable y rápido para PHP escrito en Zephir/C

## Métodos

public **setOptions** (*array* $options)

Establecer las opciones del Volt

public **getOptions** ()

Obtener las opciones de Volt

public **getCompiler** ()

Devuelve el compilador del Volt

public **render** (*mixed* $templatePath, *mixed* $params, [*mixed* $mustClean])

Renders a view using the template engine

public **length** (*mixed* $item)

Filtro de longitud. Si se pasa un objeto o matriz se realiza un count(), de lo contrario realiza un strlen()/mb_strlen()

public **isIncluded** (*mixed* $needle, *mixed* $haystack)

Comprueba si se incluye la aguja en el pajar

public **convertEncoding** (*mixed* $text, *mixed* $from, *mixed* $to)

Realiza una conversión cadena

public **slice** (*mixed* $value, [*mixed* $start], [*mixed* $end])

Extrae un trozo de un valor de un string/array/objecto iterable

public **sort** (*array* $value)

Ordena una matriz

public **callMacro** (*mixed* $name, [*array* $arguments])

Comprueba si una macro está definida y la llama

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Mvc\View\Engine](/4.0/en/api/Phalcon_Mvc_View_Engine)

Phalcon\Mvc\View\Engine constructor

public **getContent** () inherited from [Phalcon\Mvc\View\Engine](/4.0/en/api/Phalcon_Mvc_View_Engine)

Returns cached output on another view stage

public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from [Phalcon\Mvc\View\Engine](/4.0/en/api/Phalcon_Mvc_View_Engine)

Renders a partial inside another view

public **getView** () inherited from [Phalcon\Mvc\View\Engine](/4.0/en/api/Phalcon_Mvc_View_Engine)

Returns the view component related to the adapter

public **setDI** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/4.0/en/api/Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](/4.0/en/api/Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/4.0/en/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/4.0/en/api/Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](/4.0/en/api/Phalcon_Di_Injectable)

Devuelve el administrador de eventos interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/4.0/en/api/Phalcon_Di_Injectable)

Magic method __get