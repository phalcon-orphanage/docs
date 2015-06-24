Class **Phalcon\\Validation\\Validator\\PresenceOf**
====================================================

*extends* class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Validates that a value is not null or empty string  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\PresenceOf;
    
    $validator->add('name', new PresenceOf(array(
       'message' => 'The name is required'
    )));



Methods
-------

public *boolean*  **validate** (*unknown* $validation, *unknown* $field)

Executes the validation



public  **__construct** ([*unknown* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public *boolean*  **isSetOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public *mixed*  **getOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*unknown* $key, *unknown* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



