* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\ValidationInterface'

* * *

# Interface **Phalcon\ValidationInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/validationinterface.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

abstract public **validate** ([*mixed* $data], [*mixed* $entity])

...

abstract public **add** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

...

abstract public **rule** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

...

abstract public **rules** (*mixed* $field, *array* $validators)

...

abstract public **setFilters** (*mixed* $field, *mixed* $filters)

...

abstract public **getFilters** ([*mixed* $field])

...

abstract public **getValidators** ()

...

abstract public **getEntity** ()

...

abstract public **setDefaultMessages** ([*array* $messages])

...

abstract public **getDefaultMessage** (*mixed* $type)

...

abstract public **getMessages** ()

...

abstract public **setLabels** (*array* $labels)

...

abstract public **getLabel** (*mixed* $field)

...

abstract public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

...

abstract public **bind** (*mixed* $entity, *mixed* $data)

...

abstract public **getValue** (*mixed* $field)

...