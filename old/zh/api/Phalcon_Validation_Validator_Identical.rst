Class **Phalcon\\Validation\\Validator\\Identical**
===================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/identical.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Checks if a value is identical to other

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Identical;

    $validator->add(
        "terms",
        new Identical(
            [
                "accepted" => "yes",
                "message" => "Terms and conditions must be accepted",
            ]
        )
    );

    $validator->add(
        [
            "terms",
            "anotherTerms",
        ],
        new Identical(
            [
                "accepted" => [
                    "terms"        => "yes",
                    "anotherTerms" => "yes",
                ],
                "message" => [
                    "terms"        => "Terms and conditions must be accepted",
                    "anotherTerms" => "Another terms  must be accepted",
                ],
            ]
        )
    );



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



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



