Interface **Phalcon\\Validation\\ValidatorInterface**
=====================================================

Phalcon\\Validation\\ValidatorInterface initializer


Methods
---------

abstract public *mixed*  **isSetOption** (*string* $key)

Checks if an option is defined



abstract public *mixed*  **getOption** (*string* $key)

Returns an option in the validator's options Returns null if the option hasn't been set



abstract public  **validate** (*Phalcon\\Validator* $validator, *string* $attribute)

Executes the validation



