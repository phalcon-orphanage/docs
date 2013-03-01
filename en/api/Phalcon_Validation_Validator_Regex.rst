Class **Phalcon\\Validation\\Validator\\Regex**
===============================================

*extends* :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Allows validate if the value of a field matches a regular expression  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Regex as RegexValidator;
    
    $validator->add('created_at', new RegexValidator(array(
       'pattern' => '/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/'
    )));



Methods
---------

public  **validate** (*Phalcon\\Validator* $validator, *string* $attribute)

Executes the validation



public  **__construct** ([*array* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public *mixed*  **getOption** (*string* $key) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's option Returns null if the option hasn't been passed



