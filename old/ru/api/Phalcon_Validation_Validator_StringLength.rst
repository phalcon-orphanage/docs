Class **Phalcon\\Validation\\Validator\\StringLength**
======================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/stringlength.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Validates that a string has the specified maximum and minimum constraints
The test is passed if for a string's length L, min<=L<=max, i.e. L must
be at least min, and at most max.

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\StringLength as StringLength;

    $validation->add(
        "name_last",
        new StringLength(
            [
                "max"            => 50,
                "min"            => 2,
                "messageMaximum" => "We don't like really long names",
                "messageMinimum" => "We want more than just their initials",
            ]
        )
    );

    $validation->add(
        [
            "name_last",
            "name_first",
        ],
        new StringLength(
            [
                "max" => [
                    "name_last"  => 50,
                    "name_first" => 40,
                ],
                "min" => [
                    "name_last"  => 2,
                    "name_first" => 4,
                ],
                "messageMaximum" => [
                    "name_last"  => "We don't like really long last names",
                    "name_first" => "We don't like really long first names",
                ],
                "messageMinimum" => [
                    "name_last"  => "We don't like too short last names",
                    "name_first" => "We don't like too short first names",
                ]
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



