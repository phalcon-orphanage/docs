Class **Phalcon\\Validation\\Validator\\Uniqueness**
====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\CombinedFieldsValidator <Phalcon_Validation_CombinedFieldsValidator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/uniqueness.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Check that a field is unique in the related table

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

    $validator->add(
        "username",
        new UniquenessValidator(
            [
                "model"   => new Users(),
                "message" => ":field must be unique",
            ]
        )
    );

Different attribute from the field:

.. code-block:: php

    <?php

    $validator->add(
        "username",
        new UniquenessValidator(
            [
                "model"     => new Users(),
                "attribute" => "nick",
            ]
        )
    );

In model:

.. code-block:: php

    <?php

    $validator->add(
        "username",
        new UniquenessValidator()
    );

Combination of fields in model:

.. code-block:: php

    <?php

    $validator->add(
        [
            "firstName",
            "lastName",
        ],
        new UniquenessValidator()
    );

It is possible to convert values before validation. This is useful in
situations where values need to be converted to do the database lookup:

.. code-block:: php

    <?php

    $validator->add(
        "username",
        new UniquenessValidator(
            [
                "convert" => function (array $values) {
                    $values["username"] = strtolower($values["username"]);

                    return $values;
                }
            ]
        )
    );



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



protected  **isUniqueness** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

...


protected  **getColumnNameReal** (*mixed* $record, *mixed* $field)

The column map is used in the case to get real column name



protected  **isUniquenessModel** (*mixed* $record, *array* $field, *array* $values)

Uniqueness method used for model



protected  **isUniquenessCollection** (*mixed* $record, *array* $field, *array* $values)

Uniqueness method used for collection



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



