# Abstract class **Phalcon\\Validation\\CombinedFieldsValidator**

*extends* abstract class [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/[[language]]/[[version]]/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/combinedfieldsvalidator.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

public **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Phalcon\\Validation\\Validator constructor

public **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Checks if an option has been defined

public **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Checks if an option is defined

public **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Returns an option in the validator's options Returns null if the option hasn't set

public **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Sets an option in the validator

abstract public **validate** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $attribute) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Executes the validation

protected **prepareLabel** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a label for the field.

protected **prepareMessage** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a validation message.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a validation code.