Class **Phalcon\\Validation\\Validator\\CreditCard**
====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/creditcard.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Checks if a value has a valid creditcard number  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\CreditCard as CreditCardValidator;
    
    $validator->add('creditcard', new CreditCardValidator(array(
       'message' => 'The credit card number is not valid'
    )));



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *unknown* $field)

Executes the validation



private *boolean*  **verifyByLuhnAlgorithm** (*string* $number)

is a simple checksum formula used to validate a variety of identification numbers



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



