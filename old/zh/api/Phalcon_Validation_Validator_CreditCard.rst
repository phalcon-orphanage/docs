Class **Phalcon\\Validation\\Validator\\CreditCard**
====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/creditcard.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Checks if a value has a valid credit card number

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\CreditCard as CreditCardValidator;

    $validator->add(
        "creditCard",
        new CreditCardValidator(
            [
                "message" => "The credit card number is not valid",
            ]
        )
    );

    $validator->add(
        [
            "creditCard",
            "secondCreditCard",
        ],
        new CreditCardValidator(
            [
                "message" => [
                    "creditCard"       => "The credit card number is not valid",
                    "secondCreditCard" => "The second credit card number is not valid",
                ],
            ]
        )
    );



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



private *boolean* **verifyByLuhnAlgorithm** (*string* $number)

is a simple checksum formula used to validate a variety of identification numbers



public  **__construct** ([*array* $options]) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Checks if an option has been defined



public  **hasOption** (*mixed* $key) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Returns an option in the validator's options
Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Sets an option in the validator



