---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Forms\Form'
---
# Class **Phalcon\Forms\Form**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/form.zep)

Este componente permite construir formularios utilizando una interfaz object-oriented

## Métodos

public **setValidation** (*mixed* $validation)

...

public **getValidation** ()

...

public **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\Forms\Form constructor

public **setAction** (*mixed* $action)

Establece la acción del formulario

public **getAction** ()

Devuelve la acción del formulario

public **setUserOption** (*string* $option, *mixed* $value)

Establece una opción para el formulario

public **getUserOption** (*string* $option, [*mixed* $defaultValue])

Devuelve el valor de una opción si está presente

public **setUserOptions** (*array* $options)

Configura las opciones para el elemento

public **getUserOptions** ()

Devuelve las opciones para el elemento

public **setEntity** (*object* $entity)

Establece la entidad relacionada con el modelo

public *object* **getEntity** ()

Devuelve la entidad relacionada con el modelo

public **getElements** ()

Devuelve los elementos del formulario agregados al mismo

public **bind** (*array* $data, *object* $entity, [*array* $whitelist])

Vincula datos a la entidad

public **isValid** ([*array* $data], [*object* $entity])

Valida el formato

public **getMessages** ([*mixed* $byItemName])

Devuelve los mensajes generados en la validación

public **getMessagesFor** (*mixed* $name)

Devuelve los mensajes generados para un elemento específico

public **hasMessagesFor** (*mixed* $name)

Verificar si se generaron mensajes para un elemento específico

public **add** ([Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) $element, [*mixed* $position], [*mixed* $type])

Agrega un elemento al formulario

public **render** (*string* $name, [*array* $attributes])

Presenta un elemento específico en el formulario

public **get** (*mixed* $name)

Devuelve un elemento agregado al formulario por su nombre

public **label** (*mixed* $name, [*array* $attributes])

Genera la etiqueta de un elemento agregado al formulario, incluido HTML

public **getLabel** (*mixed* $name)

Devuelve una etiqueta para un elemento

public **getValue** (*mixed* $name)

Obtiene un valor de la entidad relacionada interna o del valor predeterminado

public **has** (*mixed* $name)

Compruebe si el formulario contiene un elemento

public **remove** (*mixed* $name)

Elimina un elemento de la forma

public **clear** ([*array* $fields])

Restaura cada elemento en el formulario a su valor por defecto

public **count** ()

Devuelve la cantidad de elementos en el formulario

public **rewind** ()

Rebobina el iterador interno

public **current** ()

Devuelve el elemento actual en el iterador

public **key** ()

Devuelve la llave/posición actual del iterador

public **next** ()

Mueve el puntero interno de iteración a la siguiente posición

public **valid** ()

Verificar si el elemento actual en el iterador es válido

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Configura el inyector de dependencia

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Establece el gestor de eventos

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el administrador de eventos interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get