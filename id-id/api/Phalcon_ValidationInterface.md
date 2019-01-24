---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\ValidationInterface'
---
# Interface **Phalcon\ValidationInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validationinterface.zep)

## Metode

abstrak publik **validasi** ([*campuran* $data], [*campuran* $entity])

...

abstract public **add** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

...

abstract public **rule** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

...

abstrak publik **aturan** (*campuran* $field, *array* $validators)

...

abstrak publik **setFilters** (*campuran* $field, *campuran* $filters)

...

abstrak publik **getFilters** ([*campuran* $field])

...

publik abstrak **getValidators** ()

...

abstrak publik **getEntity** ()

...

abstrak publik **setDefaultMessages** ([*array* $messages])

...

abstrak publik **getDefaultMessage** (*campuran* $type)

...

abstrak publik **getMessages** ()

...

abstrak publik **setLabels** (*array* $labels)

...

abstrak publik **getLabel** (*campuran* $field)

...

abstract public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

...

abstract public **bind** (*mixed* $entity, *mixed* $data)

...

abstract public **getValue** (*mixed* $field)

...