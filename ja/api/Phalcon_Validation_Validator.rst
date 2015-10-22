Abstract class **Phalcon\\Validation\\Validator**
=================================================

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is a base class for validators


Methods
-------

public  **__construct** ([*unknown* $options])

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*unknown* $key)

Checks if an option is defined



public  **hasOption** (*unknown* $key)

Checks if an option is defined



public  **getOption** (*unknown* $key, [*unknown* $defaultValue])

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*unknown* $key, *unknown* $value)

Sets an option in the validator



abstract public  **validate** (*unknown* $validation, *unknown* $attribute)

Executes the validation



