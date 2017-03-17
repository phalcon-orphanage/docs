Abstract class **Phalcon\\Validation\\Validator**
=================================================

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is a base class for validators


Methods
-------

public  **__construct** ([*array* $options])

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key)

Checks if an option has been defined



public  **hasOption** (*mixed* $key)

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue])

Returns an option in the validator's options
Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value)

Sets an option in the validator



abstract public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $attribute)

Executes the validation



