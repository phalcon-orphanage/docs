Class **Phalcon\\Validation\\Validator\\Uniqueness**
====================================================

*extends* class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Check that a field is unique in the related table  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
    
    $validator->add('username', new UniquenessValidator(array(
        'model' => 'Users',
        'message' => ':field must be unique'
    )));

  Different attribute from the field 

.. code-block:: php

    <?php

    $validator->add('username', new UniquenessValidator(array(
        'model' => 'Users',
        'attribute' => 'nick'
    )));



Methods
-------

public *boolean*  **validate** (*unknown* $validation, *unknown* $field)

Executes the validation



public  **__construct** ([*unknown* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public *mixed*  **isSetOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public *mixed*  **getOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*unknown* $key, *unknown* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



