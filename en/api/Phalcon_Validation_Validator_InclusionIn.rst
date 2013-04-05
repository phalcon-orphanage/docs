Class **Phalcon\\Validation\\Validator\\InclusionIn**
=====================================================

*extends* :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

Check if a value is included into a list of values  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\InclusionIn;
    
    $validator->add('status', new InclusionIn(array(
       'message' => 'The status must be A or B'
       'domain' => array('A', 'B')
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



