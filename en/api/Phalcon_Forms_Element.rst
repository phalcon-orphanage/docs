Class **Phalcon\\Forms\\Element**
=================================

This is a base class for form elements


Methods
---------

public  **__construct** (*string* $name, [*array* $attributes])

Phalcon\\Forms\\Element constructor



public *Phalcon\\Forms\\ElementInterface*  **setForm** (:doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>` $form)

Sets the parent form to the element



public *Phalcon\\Forms\\ElementInterface*  **getForm** ()

Returns the parent form to the element



public *Phalcon\\Forms\\ElementInterface*  **setName** (*string* $name)

Sets the element's name



public *string*  **getName** ()

Returns the element's name



public *Phalcon\\Forms\\ElementInterface*  **setFilters** (*array|string* $filters)

Sets the element's filters



public *mixed*  **getFilters** ()

Returns the element's filters



public *Phalcon\\Forms\\ElementInterface*  **addValidators** (*unknown* $validators, [*unknown* $merge])

Adds a group of validators



public *Phalcon\\Forms\\ElementInterface*  **addValidator** (*unknown* $validator)

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** ()

Returns the validators registered for the element



public *array*  **prepareAttributes** ([*array* $attributes])

Returns an array of attributes for  prepared attributes for Phalcon\\Tag helpers according to the element's parameters



public *Phalcon\\Forms\\ElementInterface*  **setAttribute** (*string* $attribute, *mixed* $value)

Sets a default attribute for the element



public *mixed*  **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

Returns the value of an attribute if present



public *Phalcon\\Forms\\ElementInterface*  **setAttributes** (*array* $attributes)

Sets default attributes for the element



public *array*  **getAttributes** ()

Returns the default attributes for the element



public *Phalcon\\Forms\\ElementInterface*  **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the element



public *mixed*  **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present



public *Phalcon\\Forms\\ElementInterface*  **setUserOptions** (*array* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public *Phalcon\\Forms\\ElementInterface*  **setLabel** (*string* $label)

Sets the element label



public *string*  **getLabel** ()

Returns the element's label



public *string*  **label** ()

Generate the HTML to label the element



public *Phalcon\\Forms\\ElementInterface*  **setDefault** (*mixed* $value)

Sets a default value in case the form does not use an entity or there is no value available for the element in $_POST



public *mixed*  **getDefault** ()

Returns the default value assigned to the element



public *mixed*  **getValue** ()

Returns the element's value



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ()

Returns the messages that belongs to the element The element needs to be attached to a form



public *boolean*  **hasMessages** ()

Returns the messages that belongs to the element The element needs to be attached to a form



public *string*  **__toString** ()

Magic method __toString renders the widget without atttributes



