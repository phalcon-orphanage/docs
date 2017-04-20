Class **Phalcon\\Validation\\Validator\\PresenceOf**
====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/presenceof.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Validates that a value is not null or empty string

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\PresenceOf;

    $validator->add(
        "name",
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $validator->add(
        [
            "name",
            "email",
        ],
        new PresenceOf(
            [
                "message" => [
                    "name"  => "The name is required",
                    "email" => "The email is required",
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



