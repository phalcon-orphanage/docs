Abstract class **Phalcon\\Forms\\Element**
==========================================

*implements* :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/forms/element.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is a base class for form elements


Methods
-------

public  **__construct** (*string* $name, [*array* $attributes])

Phalcon\\Forms\\Element constructor



public  **setForm** (*unknown* $form)

Sets the parent form to the element



public  **getForm** ()

Returns the parent form to the element



public  **setName** (*unknown* $name)

Sets the element name



public  **getName** ()

Returns the element name



public *\Phalcon\Forms\ElementInterface*  **setFilters** (*array|string* $filters)

Sets the element filters



public  **addFilter** (*unknown* $filter)

Adds a filter to current list of filters



public *mixed*  **getFilters** ()

Returns the element filters



public *\Phalcon\Forms\ElementInterface*  **addValidators** (*unknown* $validators, [*unknown* $merge])

Adds a group of validators



public  **addValidator** (*unknown* $validator)

Adds a validator to the element



public  **getValidators** ()

Returns the validators registered for the element



public *array*  **prepareAttributes** ([*array* $attributes], [*boolean* $useChecked])

Returns an array of prepared attributes for Phalcon\\Tag helpers according to the element parameters



public *\Phalcon\Forms\ElementInterface*  **setAttribute** (*string* $attribute, *mixed* $value)

Sets a default attribute for the element



public *mixed*  **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

Returns the value of an attribute if present



public  **setAttributes** (*unknown* $attributes)

Sets default attributes for the element



public  **getAttributes** ()

Returns the default attributes for the element



public *\Phalcon\Forms\ElementInterface*  **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the element



public *mixed*  **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present



public *\Phalcon\Forms\ElementInterface*  **setUserOptions** (*array* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public  **setLabel** (*unknown* $label)

Sets the element label



public  **getLabel** ()

Returns the element label



public *string*  **label** ([*array* $attributes])

Generate the HTML to label the element



public *\Phalcon\Forms\ElementInterface*  **setDefault** (*mixed* $value)

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST



public *mixed*  **getDefault** ()

Returns the default value assigned to the element



public *mixed*  **getValue** ()

Returns the element value



public  **getMessages** ()

Returns the messages that belongs to the element The element needs to be attached to a form



public  **hasMessages** ()

Checks whether there are messages attached to the element



public  **setMessages** (*unknown* $group)

Sets the validation messages related to the element



public  **appendMessage** (*unknown* $message)

Appends a message to the internal message list



public  **clear** ()

Clears every element in the form to its default value



public  **__toString** ()

Magic method __toString renders the widget without atttributes



abstract public  **render** ([*unknown* $attributes]) inherited from Phalcon\\Forms\\ElementInterface

...


