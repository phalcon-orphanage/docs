* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Mvc\View\Engine\Volt'

* * *

# Class **Phalcon\Mvc\View\Engine\Volt**

*extends* abstract class [Phalcon\Mvc\View\Engine](/3.4/en/api/Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](/3.4/en/api/Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](/3.4/en/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](/3.4/en/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/mvc/view/engine/volt.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

Diseñador de plantilla amigable y rápido para PHP escrito en Zephir/C

## Métodos

public **setOptions** (*array* $options)

Establecer las opciones del Volt

public **getOptions** ()

Obtener las opciones de Volt

public **getCompiler** ()

Devuelve el compilador del Volt

public **render** (*mixed* $templatePath, *mixed* $params, [*mixed* $mustClean])

Representa una vista utilizando el motor de la plantilla

public **length** (*mixed* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen

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

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](/3.4/en/api/Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](/3.4/en/api/Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Mvc\View\Engine](/3.4/en/api/Phalcon_Mvc_View_Engine)

Phalcon\Mvc\View\Engine constructor

public **getContent** () inherited from [Phalcon\Mvc\View\Engine](/3.4/en/api/Phalcon_Mvc_View_Engine)

Devuelve la salida almacenada en caché en otra etapa de visualización

public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from [Phalcon\Mvc\View\Engine](/3.4/en/api/Phalcon_Mvc_View_Engine)

Representa una vista parcial dentro de otro punto de vista

public **getView** () inherited from [Phalcon\Mvc\View\Engine](/3.4/en/api/Phalcon_Mvc_View_Engine)

Devuelve el componente de vista relacionados con el adaptador

public **setDI** ([Phalcon\DiInterface](/3.4/en/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Establece el inyector de dependencias

public **getDI** () inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/3.4/en/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Establece el gestor de eventos

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Devuelve el gestor de eventos interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Método mágico __get