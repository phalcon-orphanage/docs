Class **Phalcon\\Validation\\Validator\\StringLength**
======================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/stringlength.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Validates that a string has the specified maximum and minimum constraints The test is passed if for a string's length L, min<=L<=max, i.e. L must be at least min, and at most max.  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\StringLength as StringLength;
    
    $validation->add('name_last', new StringLength(array(
          'max' => 50,
          'min' => 2,
          'messageMaximum' => 'We don\'t like really long names',
          'messageMinimum' => 'We want more than just their initials'
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



