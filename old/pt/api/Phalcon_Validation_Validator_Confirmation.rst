Class **Phalcon\\Validation\\Validator\\Confirmation**
======================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/confirmation.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Checks that two values have the same value

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Confirmation;

    $validator->add(
        "password",
        new Confirmation(
            [
                "message" => "Password doesn't match confirmation",
                "with"    => "confirmPassword",
            ]
        )
    );

    $validator->add(
        [
            "password",
            "email",
        ],
        new Confirmation(
            [
                "message" => [
                    "password" => "Password doesn't match confirmation",
                    "email"    => "Email doesn't match confirmation",
                ],
                "with" => [
                    "password" => "confirmPassword",
                    "email"    => "confirmEmail",
                ],
            ]
        )
    );



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



final protected  **compare** (*mixed* $a, *mixed* $b)

Compare strings



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



