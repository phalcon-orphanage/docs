Class **Phalcon\\Validation\\Validator\\InclusionIn**
=====================================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/inclusionin.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Check if a value is included into a list of values  

.. code-block:: php

    <?php

     use Phalcon\Validation\Validator\InclusionIn;
    
     $validator->add('status', new InclusionIn([
         'message' => 'The status must be A or B',
         'domain' => array('A', 'B')
     ]));
    
     $validator->add(['status', 'type'], new InclusionIn([
         'message' => [
             'status' => 'The status must be A or B',
             'type' => 'The status must be 1 or 2'
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



public  **__construct** ([*array* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option has been defined



public  **hasOption** (*mixed* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



