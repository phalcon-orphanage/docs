Class **Phalcon\\Forms\\Element\\Date**
=======================================

*extends* :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`

Component INPUT[type=date] for forms


Methods
---------

public *string*  **render** ([*array* $attributes])

Renders the element widget returning html



public  **__construct** (*string* $name, [*array* $attributes]) inherited from Phalcon\\Forms\\Element

Phalcon\\Forms\\Element constructor



public *Phalcon\\Forms\\ElementInterface*  **setForm** (:doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>` $form) inherited from Phalcon\\Forms\\Element

Sets the parent form to the element



public *Phalcon\\Forms\\ElementInterface*  **getForm** () inherited from Phalcon\\Forms\\Element

Returns the parent form to the element



public *Phalcon\\Forms\\ElementInterface*  **setName** (*string* $name) inherited from Phalcon\\Forms\\Element

Sets the element's name



public *string*  **getName** () inherited from Phalcon\\Forms\\Element

Returns the element's name



public *Phalcon\\Forms\\ElementInterface*  **setFilters** (*array|string* $filters) inherited from Phalcon\\Forms\\Element

Sets the element's filters



public *mixed*  **getFilters** () inherited from Phalcon\\Forms\\Element

Returns the element's filters



public *Phalcon\\Forms\\ElementInterface*  **addValidators** (*unknown* $validators, [*unknown* $merge]) inherited from Phalcon\\Forms\\Element

Adds a group of validators



public *Phalcon\\Forms\\ElementInterface*  **addValidator** (*unknown* $validator) inherited from Phalcon\\Forms\\Element

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** () inherited from Phalcon\\Forms\\Element

Returns the validators registered for the element



public *array*  **prepareAttributes** ([*array* $attributes]) inherited from Phalcon\\Forms\\Element

Returns an array of attributes for  prepared attributes for Phalcon\\Tag helpers according to the element's parameters



public *Phalcon\\Forms\\ElementInterface*  **setAttribute** (*string* $attribute, *mixed* $value) inherited from Phalcon\\Forms\\Element

Sets a default attribute for the element



public *mixed*  **getAttribute** (*string* $attribute, [*mixed* $defaultValue]) inherited from Phalcon\\Forms\\Element

Returns the value of an attribute if present



public *Phalcon\\Forms\\ElementInterface*  **setAttributes** (*array* $attributes) inherited from Phalcon\\Forms\\Element

Sets default attributes for the element



public *array*  **getAttributes** () inherited from Phalcon\\Forms\\Element

Returns the default attributes for the element



public *Phalcon\\Forms\\ElementInterface*  **setUserOption** (*string* $option, *mixed* $value) inherited from Phalcon\\Forms\\Element

Sets an option for the element



public *mixed*  **getUserOption** (*string* $option, [*mixed* $defaultValue]) inherited from Phalcon\\Forms\\Element

Returns the value of an option if present



public *Phalcon\\Forms\\ElementInterface*  **setUserOptions** (*array* $options) inherited from Phalcon\\Forms\\Element

Sets options for the element



public *array*  **getUserOptions** () inherited from Phalcon\\Forms\\Element

Returns the options for the element



public *Phalcon\\Forms\\ElementInterface*  **setLabel** (*string* $label) inherited from Phalcon\\Forms\\Element

Sets the element label



public *string*  **getLabel** () inherited from Phalcon\\Forms\\Element

Returns the element's label



public *string*  **label** () inherited from Phalcon\\Forms\\Element

Generate the HTML to label the element



public *Phalcon\\Forms\\ElementInterface*  **setDefault** (*mixed* $value) inherited from Phalcon\\Forms\\Element

Sets a default value in case the form does not use an entity or there is no value available for the element in $_POST



public *mixed*  **getDefault** () inherited from Phalcon\\Forms\\Element

Returns the default value assigned to the element



public *mixed*  **getValue** () inherited from Phalcon\\Forms\\Element

Returns the element's value



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** () inherited from Phalcon\\Forms\\Element

Returns the messages that belongs to the element The element needs to be attached to a form



public *boolean*  **hasMessages** () inherited from Phalcon\\Forms\\Element

Returns the messages that belongs to the element The element needs to be attached to a form



public *string*  **__toString** () inherited from Phalcon\\Forms\\Element

Magic method __toString renders the widget without atttributes



