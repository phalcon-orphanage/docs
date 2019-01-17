---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Validation\Validator'
---
# Abstract class **Phalcon\Validation\Validator**

*implements* [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/validator.zep)

This is a base class for validators

## Methods

public **__construct** ([*array* $options])

Phalcon\Validation\Validator constructor

public **isSetOption** (*mixed* $key)

Checks if an option has been defined

public **hasOption** (*mixed* $key)

Checks if an option is defined

public **getOption** (*mixed* $key, [*mixed* $defaultValue])

Returns an option in the validator's options Returns null if the option hasn't set

public **setOption** (*mixed* $key, *mixed* $value)

Sets an option in the validator

abstract public **validate** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $attribute)

Executes the validation

protected **prepareLabel** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field)

Prepares a label for the field.

protected **prepareMessage** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option])

Prepares a validation message.

protected **prepareCode** (*mixed* $field)

Prepares a validation code.