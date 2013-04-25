Class **Phalcon\\Validation\\Validator\\Confirmation**
======================================================

*extends* :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Checks that two values have the same value  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Confirmation;
    
    $validator->add('password', new Confirmation(array(
       'message' => 'Password doesn\'t match confirmation',
       'with' => 'confirmPassword'
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



