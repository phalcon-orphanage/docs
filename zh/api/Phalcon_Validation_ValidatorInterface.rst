Interface **Phalcon\\Validation\\ValidatorInterface**
=====================================================

Phalcon\\Validation\\ValidatorInterface initializer


Methods
-------

abstract public *mixed*  **isSetOption** (*string* $key)

Checks if an option is defined



abstract public *mixed*  **getOption** (*string* $key)

Returns an option in the validator's options Returns null if the option hasn't been set



abstract public  **setOption** (*string* $key, *mixed* $value)

Sets the validator's option



abstract public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **validate** (*Phalcon\\Validation* $validator, *string* $attribute)

Executes the validation



