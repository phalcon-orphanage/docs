Class **Phalcon\\Validation\\Validator\\Numericality**
======================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/numericality.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Check for a valid numeric value

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Numericality;

    $validator->add(
        "price",
        new Numericality(
            [
                "message" => ":field is not numeric",
            ]
        )
    );

    $validator->add(
        [
            "price",
            "amount",
        ],
        new Numericality(
            [
                "message" => [
                    "price"  => "price is not numeric",
                    "amount" => "amount is not numeric",
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



