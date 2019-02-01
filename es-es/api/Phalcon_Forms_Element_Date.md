---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Forms\Element\Date'
---
# Class **Phalcon\Forms\Element\Date**

*extends* abstract class [Phalcon\Forms\Element](Phalcon_Forms_Element)

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element/date.zep)

Component INPUT[type=date] for forms

## Métodos

public **render** ([*array* $attributes])

Renderiza el widget del elemento y devuelve html

public **__construct** (*string* $name, [*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura el formulario principal al elemento

public **getForm** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve el formulario principal al elemento

public **setName** (*mixed* $name) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura el nombre del elemento

public **getName** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve el nombre del elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura los filtros del elemento

public **addFilter** (*mixed* $filter) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Añade un filtro a la lista actual de filtros

public *mixed* **getFilters** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve los filtros del elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Agrega un grupo de validadores

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Agrega un validador al elemento

public **getValidators** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve los validadores registrados para el elemento

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura un atributo por defecto para el elemento

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve el elemento de un atributo si está presente

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Establece los atributos por defecto para el elemento

public **getAttributes** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve los atributos por defecto para el elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura una opción para el elemento

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve el valor de una opción si está presente

public **setUserOptions** (*array* $options) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura las opciones para el elemento

public **getUserOptions** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve las opciones para el elemento

public **setLabel** (*mixed* $label) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura la etiqueta del elemento

public **getLabel** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve la etiqueta del elemento

public **label** ([*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Genera el HTML a la etiqueta del elemento

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Establece un valor por defecto en caso de que el formulario no utilice una entidad o que no haya un valor disponible para el elemento en _POST

public **getDefault** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve el valor por defecto asignado al elemento

public **getValue** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve el valor del elemento

public **getMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Devuelve los mensajes que pertenecen al elemento. El elemento necesita estar adjunto a un formulario

public **hasMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Comprueba si hay mensajes adjuntos al elemento

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Configura los mensajes de validación relacionados al elemento

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Agrega un mensaje a la lista del mensaje interno

public **clear** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Restaura cada elemento en el formulario a su valor por defecto

public **__toString** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Magic method __toString renderiza el widget sin atributos