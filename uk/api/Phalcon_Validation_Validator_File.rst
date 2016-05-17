Class **Phalcon\\Validation\\Validator\\File**
==============================================

*extends* abstract class :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

*implements* :doc:`Phalcon\\Validation\\ValidatorInterface <Phalcon_Validation_ValidatorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/file.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Checks if a value has a correct file  

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\File as FileValidator;
    
    $validator->add('file', new FileValidator(array(
       'maxSize' => '2M',
       'messageSize' => ':field exceeds the max filesize (:max)',
       'allowedTypes' => array('image/jpeg', 'image/png'),
       'messageType' => 'Allowed file types are :types',
       'maxResolution' => '800x600',
       'messageMaxResolution' => 'Max resolution of :field is :max'
    )));



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *unknown* $field)

Executes the validation



public  **__construct** ([*unknown* $options]) inherited from Phalcon\\Validation\\Validator

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **hasOption** (*unknown* $key) inherited from Phalcon\\Validation\\Validator

Checks if an option is defined



public  **getOption** (*unknown* $key, [*unknown* $defaultValue]) inherited from Phalcon\\Validation\\Validator

Returns an option in the validator's options Returns null if the option hasn't set



public  **setOption** (*unknown* $key, *unknown* $value) inherited from Phalcon\\Validation\\Validator

Sets an option in the validator



