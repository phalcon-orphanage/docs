* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Forms\Element'

* * *

# Abstract class **Phalcon\Forms\Element**

*implements* [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/forms/element.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is a base class for form elements

## Methods

public **__construct** (*string* $name, [*array* $attributes])

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](/4.0/en/api/Phalcon_Forms_Form) $form)

Sets the parent form to the element

public **getForm** ()

Returns the parent form to the element

public **setName** (*mixed* $name)

Sets the element name

public **getName** ()

Returns the element name

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters)

Sets the element filters

public **addFilter** (*mixed* $filter)

Adds a filter to current list of filters

public *mixed* **getFilters** ()

Returns the element filters

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge])

Adds a group of validators

public **addValidator** ([Phalcon\Validation\ValidatorInterface](/4.0/en/api/Phalcon_Validation_ValidatorInterface) $validator)

Adds a validator to the element

public **getValidators** ()

Returns the validators registered for the element

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked])

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value)

Sets a default attribute for the element

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

Returns the value of an attribute if present

public **setAttributes** (*array* $attributes)

Sets default attributes for the element

public **getAttributes** ()

Returns the default attributes for the element

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the element

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present

public **setUserOptions** (*array* $options)

Sets options for the element

public **getUserOptions** ()

Returns the options for the element

public **setLabel** (*mixed* $label)

Sets the element label

public **getLabel** ()

Returns the element label

public **label** ([*array* $attributes])

Generate the HTML to label the element

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value)

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST

public **getDefault** ()

Returns the default value assigned to the element

public **getValue** ()

Returns the element value

public **getMessages** ()

Returns the messages that belongs to the element The element needs to be attached to a form

public **hasMessages** ()

Checks whether there are messages attached to the element

public **setMessages** ([Phalcon\Validation\Message\Group](/4.0/en/api/Phalcon_Validation_Message_Group) $group)

Sets the validation messages related to the element

public **appendMessage** ([Phalcon\Validation\MessageInterface](/4.0/en/api/Phalcon_Validation_MessageInterface) $message)

Appends a message to the internal message list

public **clear** ()

Clears every element in the form to its default value

public **__toString** ()

Magic method __toString renders the widget without attributes

abstract public **render** ([*mixed* $attributes]) inherited from [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface)

...