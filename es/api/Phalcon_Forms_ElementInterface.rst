Interface **Phalcon\\Forms\\ElementInterface**
==============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/forms/elementinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setForm** (:doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>` $form)

...


abstract public  **getForm** ()

...


abstract public  **setName** (*unknown* $name)

...


abstract public  **getName** ()

...


abstract public  **setFilters** (*unknown* $filters)

...


abstract public  **addFilter** (*unknown* $filter)

...


abstract public  **getFilters** ()

...


abstract public  **addValidators** (*array* $validators, [*unknown* $merge])

...


abstract public  **addValidator** (:doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>` $validator)

...


abstract public  **getValidators** ()

...


abstract public  **prepareAttributes** ([*unknown* $attributes], [*unknown* $useChecked])

...


abstract public  **setAttribute** (*unknown* $attribute, *unknown* $value)

...


abstract public  **getAttribute** (*unknown* $attribute, [*unknown* $defaultValue])

...


abstract public  **setAttributes** (*array* $attributes)

...


abstract public  **getAttributes** ()

...


abstract public  **setUserOption** (*unknown* $option, *unknown* $value)

...


abstract public  **getUserOption** (*unknown* $option, [*unknown* $defaultValue])

...


abstract public  **setUserOptions** (*unknown* $options)

...


abstract public  **getUserOptions** ()

...


abstract public  **setLabel** (*unknown* $label)

...


abstract public  **getLabel** ()

...


abstract public  **label** ()

...


abstract public  **setDefault** (*unknown* $value)

...


abstract public  **getDefault** ()

...


abstract public  **getValue** ()

...


abstract public  **getMessages** ()

...


abstract public  **hasMessages** ()

...


abstract public  **setMessages** (:doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>` $group)

...


abstract public  **appendMessage** (:doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>` $message)

...


abstract public  **clear** ()

...


abstract public  **render** ([*unknown* $attributes])

...


