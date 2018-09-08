# Abstract class **Phalcon\\Validation\\Validator**

*implements* [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is a base class for validators

## Methods

public **__construct** ([*array* $options])

Phalcon\\Validation\\Validator constructor

public **isSetOption** (*mixed* $key)

Checks if an option has been defined

public **hasOption** (*mixed* $key)

Checks if an option is defined

public **getOption** (*mixed* $key, [*mixed* $defaultValue])

Returns an option in the validator's options Returns null if the option hasn't set

public **setOption** (*mixed* $key, *mixed* $value)

Sets an option in the validator

abstract public **validate** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $attribute)

Executes the validation

protected **prepareLabel** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field)

Prepares a label for the field.

protected **prepareMessage** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option])

Prepares a validation message.

protected **prepareCode** (*mixed* $field)

Prepares a validation code.