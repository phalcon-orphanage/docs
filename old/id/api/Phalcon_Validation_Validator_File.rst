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

    $validator->add(
        "file",
        new FileValidator(
            [
                "maxSize"              => "2M",
                "messageSize"          => ":field exceeds the max filesize (:max)",
                "allowedTypes"         => [
                    "image/jpeg",
                    "image/png",
                ],
                "messageType"          => "Allowed file types are :types",
                "maxResolution"        => "800x600",
                "messageMaxResolution" => "Max resolution of :field is :max",
            ]
        )
    );

    $validator->add(
        [
            "file",
            "anotherFile",
        ],
        new FileValidator(
            [
                "maxSize" => [
                    "file"        => "2M",
                    "anotherFile" => "4M",
                ],
                "messageSize" => [
                    "file"        => "file exceeds the max filesize 2M",
                    "anotherFile" => "anotherFile exceeds the max filesize 4M",
                "allowedTypes" => [
                    "file"        => [
                        "image/jpeg",
                        "image/png",
                    ],
                    "anotherFile" => [
                        "image/gif",
                        "image/bmp",
                    ],
                ],
                "messageType" => [
                    "file"        => "Allowed file types are image/jpeg and image/png",
                    "anotherFile" => "Allowed file types are image/gif and image/bmp",
                ],
                "maxResolution" => [
                    "file"        => "800x600",
                    "anotherFile" => "1024x768",
                ],
                "messageMaxResolution" => [
                    "file"        => "Max resolution of file is 800x600",
                    "anotherFile" => "Max resolution of file is 1024x768",
                ],
            ]
        )
    );



Methods
-------

public  **validate** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Executes the validation



public  **isAllowEmpty** (:doc:`Phalcon\\Validation <Phalcon_Validation>` $validation, *mixed* $field)

Check on empty



public  **__construct** ([*array* $options]) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Checks if an option has been defined



public  **hasOption** (*mixed* $key) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Returns an option in the validator's options
Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from :doc:`Phalcon\\Validation\\Validator <Phalcon_Validation_Validator>`

Sets an option in the validator



