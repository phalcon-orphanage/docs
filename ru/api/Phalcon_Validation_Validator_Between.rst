Class **Phalcon\\Validation\\Validator\\Between**
=================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/between.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Validates that a value is between an inclusive range of two values. For a value x, the test is passed if minimum<=x<=maximum.  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Between;
    
    validator->add('name', new Between(array(
       'minimum' => 0,
       'maximum' => 100,
       'message' => 'The price must be between 0 and 100'
    )));



Methods
-------

public  **validate** (*unknown* $validation, *unknown* $field)

Executes the validation



public  **__construct** ([*unknown* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **hasOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **getOption** (*unknown* $key, [*unknown* $defaultValue]) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*unknown* $key, *unknown* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



