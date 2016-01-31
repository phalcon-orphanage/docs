Class **Phalcon\\Validation\\Validator\\Uniqueness**
====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/uniqueness.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Check that a field is unique in the related table  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
    
    $validator->add('username', new UniquenessValidator(array(
        'model' => 'Users',
        'message' => ':field must be unique'
    )));

  Different attribute from the field 

.. code-block:: php

    <?php

    $validator->add('username', new UniquenessValidator(array(
        'model' => 'Users',
        'attribute' => 'nick'
    )));



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



protected  **isUniqueness** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

...


protected  **getColumnNameReal** (*mixed* $record, *mixed* $field)

The column map is used in the case to get real column name



public  **__construct** ([*mixed* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **hasOption** (*mixed* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



