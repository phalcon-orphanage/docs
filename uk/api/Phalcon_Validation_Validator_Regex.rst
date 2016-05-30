Class **Phalcon\\Validation\\Validator\\Regex**
===============================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/regex.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows validate if the value of a field matches a regular expression  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Regex as RegexValidator;
    
    $validator->add('created_at', new RegexValidator(array(
       'pattern' => '/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/',
       'message' => 'The creation date is invalid'
    )));



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *unknown* $field)

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



