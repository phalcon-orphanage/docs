Class **Phalcon\\Validation\\Validator\\PresenceOf**
====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Validates that a value is not null or empty string  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\PresenceOf;
    
    $validator->add('name', new PresenceOf(array(
       'message' => 'The name is required'
    )));



Methods
---------

public *boolean*  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validator, *string* $attribute)

Executes the validation



public  **__construct** ([*array* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public *mixed*  **isSetOption** (*string* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public *mixed*  **getOption** (*string* $key) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't been set



public  **setOption** (*string* $key, *mixed* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



