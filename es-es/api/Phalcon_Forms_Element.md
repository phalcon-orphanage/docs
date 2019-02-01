---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Forms\Element'
---
# Abstract class **Phalcon\Forms\Element**

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element.zep)

Esta es una clase base para elementos de formulario

## Métodos

public **__construct** (*string* $name, [*array* $attributes])

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form)

Configura el formulario principal al elemento

public **getForm** ()

Devuelve el formulario principal al elemento

public **setName** (*mixed* $name)

Configura el nombre del elemento

public **getName** ()

Devuelve el nombre del elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters)

Configura los filtros del elemento

public **addFilter** (*mixed* $filter)

Añade un filtro a la lista actual de filtros

public *mixed* **getFilters** ()

Devuelve los filtros del elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge])

Agrega un grupo de validadores

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Agrega un validador al elemento

public **getValidators** ()

Devuelve los validadores registrados para el elemento

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked])

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value)

Configura un atributo por defecto para el elemento

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

Devuelve el elemento de un atributo si está presente

public **setAttributes** (*array* $attributes)

Establece los atributos por defecto para el elemento

public **getAttributes** ()

Devuelve los atributos por defecto para el elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value)

Configura una opción para el elemento

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue])

Devuelve el valor de una opción si está presente

public **setUserOptions** (*array* $options)

Configura las opciones para el elemento

public **getUserOptions** ()

Devuelve las opciones para el elemento

public **setLabel** (*mixed* $label)

Configura la etiqueta del elemento

public **getLabel** ()

Devuelve la etiqueta del elemento

public **label** ([*array* $attributes])

Genera el HTML a la etiqueta del elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value)

Establece un valor por defecto en caso de que el formulario no utilice una entidad o que no haya un valor disponible para el elemento en _POST

public **getDefault** ()

Devuelve el valor por defecto asignado al elemento

public **getValue** ()

Devuelve el valor del elemento

public **getMessages** ()

Devuelve los mensajes que pertenecen al elemento. El elemento necesita estar adjunto a un formulario

public **hasMessages** ()

Comprueba si hay mensajes adjuntos al elemento

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group)

Configura los mensajes de validación relacionados al elemento

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Agrega un mensaje a la lista del mensaje interno

public **clear** ()

Restaura cada elemento en el formulario a su valor por defecto

public **__toString** ()

Magic method __toString renderiza el widget sin atributos

abstract public **render** ([*mixed* $attributes]) inherited from [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

...