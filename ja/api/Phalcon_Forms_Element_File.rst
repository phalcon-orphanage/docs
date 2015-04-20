Class **Phalcon\\Forms\\Element\\File**
=======================================

*extends* abstract class :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`

*implements* :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`

Component INPUT[type=file] for forms


Methods
-------

public *string*  **render** ([*unknown* $attributes])

Renders the element widget returning html



public  **__construct** (*unknown* $name, [*unknown* $attributes]) inherited from Phalcon\\Forms\\Element

Phalcon\\Forms\\Element constructor



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setForm** (*unknown* $form) inherited from Phalcon\\Forms\\Element

Sets the parent form to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **getForm** () inherited from Phalcon\\Forms\\Element

Returns the parent form to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setName** (*unknown* $name) inherited from Phalcon\\Forms\\Element

Sets the element name



public *string*  **getName** () inherited from Phalcon\\Forms\\Element

Returns the element name



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setFilters** (*unknown* $filters) inherited from Phalcon\\Forms\\Element

Sets the element filters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addFilter** (*unknown* $filter) inherited from Phalcon\\Forms\\Element

Adds a filter to current list of filters



public *mixed*  **getFilters** () inherited from Phalcon\\Forms\\Element

Returns the element filters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addValidators** (*unknown* $validators, [*unknown* $merge]) inherited from Phalcon\\Forms\\Element

Adds a group of validators



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **addValidator** (*unknown* $validator) inherited from Phalcon\\Forms\\Element

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** () inherited from Phalcon\\Forms\\Element

Returns the validators registered for the element



public *array*  **prepareAttributes** ([*unknown* $attributes], [*unknown* $useChecked]) inherited from Phalcon\\Forms\\Element

Returns an array of prepared attributes for Phalcon\\Tag helpers according to the element parameters



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setAttribute** (*unknown* $attribute, *unknown* $value) inherited from Phalcon\\Forms\\Element

Sets a default attribute for the element



public *mixed*  **getAttribute** (*unknown* $attribute, [*unknown* $defaultValue]) inherited from Phalcon\\Forms\\Element

Returns the value of an attribute if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setAttributes** (*unknown* $attributes) inherited from Phalcon\\Forms\\Element

Sets default attributes for the element



public *array*  **getAttributes** () inherited from Phalcon\\Forms\\Element

Returns the default attributes for the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOption** (*unknown* $option, *unknown* $value) inherited from Phalcon\\Forms\\Element

Sets an option for the element



public *mixed*  **getUserOption** (*unknown* $option, [*unknown* $defaultValue]) inherited from Phalcon\\Forms\\Element

Returns the value of an option if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOptions** (*unknown* $options) inherited from Phalcon\\Forms\\Element

Sets options for the element



public *array*  **getUserOptions** () inherited from Phalcon\\Forms\\Element

Returns the options for the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setLabel** (*unknown* $label) inherited from Phalcon\\Forms\\Element

Sets the element label



public *string*  **getLabel** () inherited from Phalcon\\Forms\\Element

Returns the element label



public *string*  **label** ([*unknown* $attributes]) inherited from Phalcon\\Forms\\Element

Generate the HTML to label the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setDefault** (*unknown* $value) inherited from Phalcon\\Forms\\Element

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST



public *mixed*  **getDefault** () inherited from Phalcon\\Forms\\Element

Returns the default value assigned to the element



public *mixed*  **getValue** () inherited from Phalcon\\Forms\\Element

Returns the element value



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** () inherited from Phalcon\\Forms\\Element

Returns the messages that belongs to the element The element needs to be attached to a form



public *boolean*  **hasMessages** () inherited from Phalcon\\Forms\\Element

Checks whether there are messages attached to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setMessages** (*unknown* $group) inherited from Phalcon\\Forms\\Element

Sets the validation messages related to the element



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **appendMessage** (*unknown* $message) inherited from Phalcon\\Forms\\Element

Appends a message to the internal message list



public :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`  **clear** () inherited from Phalcon\\Forms\\Element

Clears every element in the form to its default value



public *string*  **__toString** () inherited from Phalcon\\Forms\\Element

Magic method __toString renders the widget without atttributes



