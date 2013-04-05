Class **Phalcon\\Forms\\Element**
=================================

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



public *Phalcon\\Forms\\ElementInterface*  **addValidators** (*unknown* $validators, [*unknown* $merge])

Adds a group of validators



public *Phalcon\\Forms\\ElementInterface*  **addValidator** (*unknown* $validator)

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** ()

Returns the validators registered for the element



public *array*  **prepareAttributes** (*array* $attributes)

Returns an array of attributes for Phalcon\\Tag helpers prepared according to the element's parameters



public *Phalcon\\Forms\\ElementInterface*  **setAttribute** (*string* $attribute, *mixed* $value)

Sets a default attribute for the element



public *Phalcon\\Forms\\ElementInterface*  **setAttributes** (*array* $attributes)

Sets default attributes for the element



public *array*  **getAttributes** ()

Returns the default attributes for the element



public *Phalcon\\Forms\\ElementInterface*  **setLabel** (*string* $label)

Sets the element label



public *string*  **getLabel** ()

Returns the element's label



public *string*  **__toString** ()

Magic method __toString renders the widget without atttributes



