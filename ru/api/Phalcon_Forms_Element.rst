Abstract class **Phalcon\\Forms\\Element**
==========================================

*implements* :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`

This is a base class for form elements


Methods
-------

public  **__construct** (*unknown* $name, [*unknown* $attributes])

Phalcon\\Forms\\Element constructor



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setForm** (*unknown* $form)

Sets the parent form to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **getForm** ()

Returns the parent form to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setName** (*unknown* $name)

Sets the element name



public *string*  **getName** ()

Returns the element name



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setFilters** (*unknown* $filters)

Sets the element filters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addFilter** (*unknown* $filter)

Adds a filter to current list of filters



public *mixed*  **getFilters** ()

Returns the element filters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addValidators** (*unknown* $validators, [*unknown* $merge])

Adds a group of validators



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addValidator** (*unknown* $validator)

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** ()

Returns the validators registered for the element



public *array*  **prepareAttributes** ([*unknown* $attributes], [*unknown* $useChecked])

Returns an array of prepared attributes for Phalcon\\Tag helpers according to the element parameters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setAttribute** (*unknown* $attribute, *unknown* $value)

Sets a default attribute for the element



public *mixed*  **getAttribute** (*unknown* $attribute, [*unknown* $defaultValue])

Returns the value of an attribute if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setAttributes** (*unknown* $attributes)

Sets default attributes for the element



public *array*  **getAttributes** ()

Returns the default attributes for the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOption** (*unknown* $option, *unknown* $value)

Sets an option for the element



public *mixed*  **getUserOption** (*unknown* $option, [*unknown* $defaultValue])

Returns the value of an option if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOptions** (*unknown* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setLabel** (*unknown* $label)

Sets the element label



public *string*  **getLabel** ()

Returns the element label



public *string*  **label** ([*unknown* $attributes])

Generate the HTML to label the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setDefault** (*unknown* $value)

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST



public *mixed*  **getDefault** ()

Returns the default value assigned to the element



public *mixed*  **getValue** ()

Returns the element value



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ()

Returns the messages that belongs to the element The element needs to be attached to a form



public *boolean*  **hasMessages** ()

Checks whether there are messages attached to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setMessages** (*unknown* $group)

Sets the validation messages related to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **appendMessage** (*unknown* $message)

Appends a message to the internal message list



public :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`  **clear** ()

Clears every element in the form to its default value



public *string*  **__toString** ()

Magic method __toString renders the widget without atttributes



abstract public  **render** ([*unknown* $attributes]) inherited from Phalcon\\Forms\\ElementInterface

...


