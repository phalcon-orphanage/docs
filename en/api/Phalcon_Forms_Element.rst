Class **Phalcon\\Forms\\Element**
=================================

This is a base class for form elements


Methods
---------

public  **__construct** (*string* $name)

Phalcon\\Forms\\Element constructor



public  **setName** (*unknown* $name)

...


public  **getName** ()

...


public  **addValidators** (*unknown* $validators)

Adds a group of validators



public  **addValidator** (*unknown* $validator)

Adds a validator to the element



public :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` [] **getValidators** ()

Returns the validators registered for the element



public *string*  **__toString** ()

Magic method __toString renders the widget without atttributes



