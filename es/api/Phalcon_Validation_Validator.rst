Abstract class **Phalcon\\Validation\\Validator**
=================================================

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

This is a base class for validators


Methods
-------

public  **__construct** ([*array* $options])

Phalcon\\Validation\\Validator constructor



public *mixed*  **isSetOption** (*string* $key)

Checks if an option is defined



public *mixed*  **getOption** (*string* $key)

Returns an option in the validator's options Returns null if the option hasn't been set



public  **setOption** (*string* $key, *mixed* $value)

Sets an option in the validator



abstract public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **validate** (*Phalcon\\Validation* $validator, *string* $attribute) inherited from Phalcon\\Validation\\ValidatorInterface

Executes the validation



