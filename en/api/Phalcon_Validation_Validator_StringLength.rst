Class **Phalcon\\Validation\\Validator\\StringLength**
======================================================

*extends* :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Validates that a string has the specified maximum and minimum constraints  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\StringLength as StringLength;
    
    $validation->validate('name_last', new StringLength(array(
    'max' => 50,
    'min' => 2,
    'messageMaximum' => 'We don't like really long names',
    'messageMinimum' => 'We want more than just their initials'
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

Returns an option in the validator's options Returns null if the option hasn't been set



