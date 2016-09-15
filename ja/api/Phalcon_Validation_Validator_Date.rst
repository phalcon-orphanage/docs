Class **Phalcon\\Validation\\Validator\\Date**
==============================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/date.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Checks if a value is a valid date  

.. code-block:: php

    <?php

     use Phalcon\Validation\Validator\Date as DateValidator;
    
     $validator->add('date', new DateValidator([
         'format' => 'd-m-Y',
         'message' => 'The date is invalid'
     ]));
    
     $validator->add(['date','anotherDate'], new DateValidator([
         'format' => [
             'date' => 'd-m-Y',
             'anotherDate' => 'Y-m-d'
         ],
         'message' => [
             'date' => 'The date is invalid',
             'anotherDate' => 'The another date is invalid'
         ]
     ]));



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



private  **checkDate** (*mixed* $value, *mixed* $format)

...


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



