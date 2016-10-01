Class **Phalcon\\Validation\\Validator\\ExclusionIn**
=====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/exclusionin.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Check if a value is not included into a list of values  

.. code-block:: php

    <?php

     use Phalcon\Validation\Validator\ExclusionIn;
    
     $validator->add('status', new ExclusionIn([
         'message' => 'The status must not be A or B',
         'domain' => ['A', 'B']
     ]));
    
     $validator->add(['status', 'type'], new ExclusionIn([
         'message' => [
             'status' => 'The status must not be A or B',
             'type' => 'The type must not be 1 or 2'
         ],
         'domain' => [
             'status' => ['A', 'B'],
             'type' => [1, 2]
         ]
     ]));



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



public  **__construct** ([*array* $options]) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Checks if an option has been defined



public  **hasOption** (*mixed* $key) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Sets an option in the validator



