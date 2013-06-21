Class **Phalcon\\Validation\\Validator\\Between**
=================================================

*extends* :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Validates that a value is between a range of two values  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Between;
    
    $validator->add('name', new Between(array(
       'minimum' => 0,
       'maximum' => 100,
       'message' => 'The price must be between 0 and 100'
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



