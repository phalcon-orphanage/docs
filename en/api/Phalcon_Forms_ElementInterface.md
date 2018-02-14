# Interface **Phalcon\\Forms\\ElementInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/forms/elementinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **setForm** ([Phalcon\Forms\Form](/en/3.1.2/api/Phalcon_Forms_Form) $form)

...

abstract public  **getForm** ()

...

abstract public  **setName** (*mixed* $name)

...

abstract public  **getName** ()

...

abstract public  **setFilters** (*mixed* $filters)

...

abstract public  **addFilter** (*mixed* $filter)

...

abstract public  **getFilters** ()

...

abstract public  **addValidators** (*array* $validators, [*mixed* $merge])

...

abstract public  **addValidator** ([Phalcon\Validation\ValidatorInterface](/en/3.1.2/api/Phalcon_Validation_ValidatorInterface) $validator)

...

abstract public  **getValidators** ()

...

abstract public  **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked])

...

abstract public  **setAttribute** (*mixed* $attribute, *mixed* $value)

...

abstract public  **getAttribute** (*mixed* $attribute, [*mixed* $defaultValue])

...

abstract public  **setAttributes** (*array* $attributes)

...

abstract public  **getAttributes** ()

...

abstract public  **setUserOption** (*mixed* $option, *mixed* $value)

...

abstract public  **getUserOption** (*mixed* $option, [*mixed* $defaultValue])

...

abstract public  **setUserOptions** (*array* $options)

...

abstract public  **getUserOptions** ()

...

abstract public  **setLabel** (*mixed* $label)

...

abstract public  **getLabel** ()

...

abstract public  **label** ()

...

abstract public  **setDefault** (*mixed* $value)

...

abstract public  **getDefault** ()

...

abstract public  **getValue** ()

...

abstract public  **getMessages** ()

...

abstract public  **hasMessages** ()

...

abstract public  **setMessages** ([Phalcon\Validation\Message\Group](/en/3.1.2/api/Phalcon_Validation_Message_Group) $group)

...

abstract public  **appendMessage** ([Phalcon\Validation\MessageInterface](/en/3.1.2/api/Phalcon_Validation_MessageInterface) $message)

...

abstract public  **clear** ()

...

abstract public  **render** ([*mixed* $attributes])

...

