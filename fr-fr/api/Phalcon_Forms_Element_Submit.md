* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Forms\Element\Submit'

* * *

# Class **Phalcon\Forms\Element\Submit**

*extends* abstract class [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

*implements* [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/forms/element/submit.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Component INPUT[type=submit] for forms

## Methods

public **render** ([*array* $attributes])

Renders the element widget

public **__construct** (*string* $name, [*array* $attributes]) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](/4.0/en/api/Phalcon_Forms_Form) $form) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets the parent form to the element

public **getForm** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the parent form to the element

public **setName** (*mixed* $name) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets the element name

public **getName** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the element name

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets the element filters

public **addFilter** (*mixed* $filter) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Adds a filter to current list of filters

public *mixed* **getFilters** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the element filters

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge]) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Adds a group of validators

public **addValidator** ([Phalcon\Validation\ValidatorInterface](/4.0/en/api/Phalcon_Validation_ValidatorInterface) $validator) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Adds a validator to the element

public **getValidators** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the validators registered for the element

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked]) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets a default attribute for the element

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the value of an attribute if present

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets default attributes for the element

public **getAttributes** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the default attributes for the element

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets an option for the element

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the value of an option if present

public **setUserOptions** (*array* $options) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets options for the element

public **getUserOptions** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the options for the element

public **setLabel** (*mixed* $label) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets the element label

public **getLabel** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the element label

public **label** ([*array* $attributes]) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Generate the HTML to label the element

public [Phalcon\Forms\ElementInterface](/4.0/en/api/Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST

public **getDefault** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the default value assigned to the element

public **getValue** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the element value

public **getMessages** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Returns the messages that belongs to the element The element needs to be attached to a form

public **hasMessages** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Checks whether there are messages attached to the element

public **setMessages** ([Phalcon\Validation\Message\Group](/4.0/en/api/Phalcon_Validation_Message_Group) $group) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Sets the validation messages related to the element

public **appendMessage** ([Phalcon\Validation\MessageInterface](/4.0/en/api/Phalcon_Validation_MessageInterface) $message) inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Appends a message to the internal message list

public **clear** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Clears every element in the form to its default value

public **__toString** () inherited from [Phalcon\Forms\Element](/4.0/en/api/Phalcon_Forms_Element)

Magic method __toString renders the widget without attributes