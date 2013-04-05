Class **Phalcon\\Forms\\Element\\Select**
=========================================

*extends* :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`

Component SELECT (choice) for forms


Methods
---------

public  **__construct** (*string* $name, [*object|array* $options], [*array* $attributes])

Phalcon\\Forms\\Element constructor



public :doc:`Phalcon\\Forms\\Element <Phalcon_Forms_Element>`  **setOptions** (*array|object* $options)

Set the choice's options



public *array|object*  **getOptions** ()

Returns the choices' options



public *$this;*  **addOption** (*array* $option)

Adds an option to the current options



public *string*  **render** ([*array* $attributes])

Renders the element widget



public *Phalcon\\Forms\\ElementInterface*  **setForm** (:doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>` $form) inherited from Phalcon\\Forms\\Element

Sets the parent form to the element



public *Phalcon\\Forms\\ElementInterface*  **getForm** () inherited from Phalcon\\Forms\\Element

Returns the parent form to the element



public *Phalcon\\Forms\\ElementInterface*  **setName** (*string* $name) inherited from Phalcon\\Forms\\Element

Sets the element's name



public *string*  **getName** () inherited from Phalcon\\Forms\\Element

Returns the element's name



public *Phalcon\\Forms\\ElementInterface*  **addValidators** (*unknown* $validators, [*unknown* $merge]) inherited from Phalcon\\Forms\\Element

Adds a group of validators



public *Phalcon\\Forms\\ElementInterface*  **addValidator** (*unknown* $validator) inherited from Phalcon\\Forms\\Element

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** () inherited from Phalcon\\Forms\\Element

Returns the validators registered for the element



public *array*  **prepareAttributes** (*array* $attributes) inherited from Phalcon\\Forms\\Element

Returns an array of attributes for Phalcon\\Tag helpers prepared according to the element's parameters



public *Phalcon\\Forms\\ElementInterface*  **setAttribute** (*string* $attribute, *mixed* $value) inherited from Phalcon\\Forms\\Element

Sets a default attribute for the element



public *Phalcon\\Forms\\ElementInterface*  **setAttributes** (*array* $attributes) inherited from Phalcon\\Forms\\Element

Sets default attributes for the element



public *array*  **getAttributes** () inherited from Phalcon\\Forms\\Element

Returns the default attributes for the element



public *Phalcon\\Forms\\ElementInterface*  **setLabel** (*string* $label) inherited from Phalcon\\Forms\\Element

Sets the element label



public *string*  **getLabel** () inherited from Phalcon\\Forms\\Element

Returns the element's label



public *string*  **__toString** () inherited from Phalcon\\Forms\\Element

Magic method __toString renders the widget without atttributes



