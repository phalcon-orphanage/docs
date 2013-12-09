Abstract class **Phalcon\\Forms\\Element**
==========================================

This is a base class for form elements


Methods
---------

public  **__construct** (*string* $name, [*array* $attributes])

Phalcon\\Forms\\Element constructor



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setForm** (:doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>` $form)

Sets the parent form to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **getForm** ()

Returns the parent form to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setName** (*string* $name)

Sets the element's name



public *string*  **getName** ()

Returns the element's name



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setFilters** (*array|string* $filters)

Sets the element's filters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addFilter** (*string* $filter)

Adds a filter to current list of filters



public *mixed*  **getFilters** ()

Returns the element's filters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addValidators** (*unknown* $validators, [*unknown* $merge])

Adds a group of validators



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addValidator** (*unknown* $validator)

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** ()

Returns the validators registered for the element



public *array*  **prepareAttributes** ([*array* $attributes], [*boolean* $useChecked])

Returns an array of prepared attributes for Phalcon\\Tag helpers according to the element's parameters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setAttribute** (*string* $attribute, *mixed* $value)

Sets a default attribute for the element



public *mixed*  **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

Returns the value of an attribute if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setAttributes** (*array* $attributes)

Sets default attributes for the element



public *array*  **getAttributes** ()

Returns the default attributes for the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the element



public *mixed*  **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOptions** (*array* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setLabel** ([*string* $label])

Sets the element label



public *string*  **getLabel** ()

Returns the element's label



public *string*  **label** (*unknown* $attributes)

Generate the HTML to label the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setDefault** (*mixed* $value)

Sets a default value in case the form does not use an entity or there is no value available for the element in $_POST



public *mixed*  **getDefault** ()

Returns the default value assigned to the element



public *mixed*  **getValue** ()

Returns the element's value



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ()

Returns the messages that belongs to the element The element needs to be attached to a form



public *boolean*  **hasMessages** ()

Checks whether there are messages attached to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setMessages** (:doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>` $group)

Sets the validation messages related to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **appendMessage** (:doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>` $message)

Appends a message to the internal message list



public :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`  **clear** ()

Clears every element in the form to its default value



public *string*  **__toString** ()

Magic method __toString renders the widget without attributes



