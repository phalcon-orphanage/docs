Interface **Phalcon\\ValidationInterface**
==========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validationinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **validate** ([*mixed* $data], [*mixed* $entity])

...


abstract public  **add** (*mixed* $field, :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` $validator)

...


abstract public  **rule** (*mixed* $field, :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` $validator)

...


abstract public  **rules** (*mixed* $field, *array* $validators)

...


abstract public  **setFilters** (*mixed* $field, *mixed* $filters)

...


abstract public  **getFilters** ([*mixed* $field])

...


abstract public  **getValidators** ()

...


abstract public  **getEntity** ()

...


abstract public  **setDefaultMessages** ([*array* $messages])

...


abstract public  **getDefaultMessage** (*mixed* $type)

...


abstract public  **getMessages** ()

...


abstract public  **setLabels** (*array* $labels)

...


abstract public  **getLabel** (*mixed* $field)

...


abstract public  **appendMessage** (:doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>` $message)

...


abstract public  **bind** (*mixed* $entity, *mixed* $data)

...


abstract public  **getValue** (*mixed* $field)

...


