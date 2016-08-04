Validation
==========

:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` es un componente independiente que valida un conjunto de datos.
Este componente puede ser usado para implementar reglas de validación en datos de objetos que no pertenecen a un model o collection

El siguiente es un ejemplo básico de uso:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Email;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation->add(
        'name',
        new PresenceOf(
            array(
                'message' => 'The name is required'
            )
        )
    );

    $validation->add(
        'email',
        new PresenceOf(
            array(
                'message' => 'The e-mail is required'
            )
        )
    );

    $validation->add(
        'email',
        new Email(
            array(
                'message' => 'The e-mail is not valid'
            )
        )
    );

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

El diseño flexible de este componente le permite crear sus propias validaciones junto con los proporcionados por el framework.

Inicialización Validation
-------------------------
La cadena de validación puede ser inicializada directamente con sólo añadir validators al objeto  :doc:`Phalcon\\Validation <../api/Phalcon_Validation>`.
Puedes poner tus validaciones en un fichero a parte para mejorar la reutilización de codigo y la organización:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Email;
    use Phalcon\Validation\Validator\PresenceOf;

    class MyValidation extends Validation
    {
        public function initialize()
        {
            $this->add(
                'name',
                new PresenceOf(
                    array(
                        'message' => 'The name is required'
                    )
                )
            );

            $this->add(
                'email',
                new PresenceOf(
                    array(
                        'message' => 'The e-mail is required'
                    )
                )
            );

            $this->add(
                'email',
                new Email(
                    array(
                        'message' => 'The e-mail is not valid'
                    )
                )
            );
        }
    }

Then initialize and use your own validator:

.. code-block:: php

    <?php

    $validation = new MyValidation();

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

Validators
----------
Phalcon da un conjunto de validators ya creados:

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Nombre         | Explicación                                                                                                                                                      | Ejemplo                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Valida que el valor de un campo no es nulo o vacio.                                                                                                      | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_PresenceOf>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Identical    | Valida que el valor de un campo es igual a un valor especificado                                                                                                  | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_Identical>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Email        | Valida que el campo contiene un email válido                                                                                                               | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_Email>`        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Valida que el valor no coincide con una lista de valores                                                                                                   | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_ExclusionIn>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Valida que el valor está dentro de una lista de valores posibles/permitidos                                                                                                   | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_InclusionIn>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Valida que el valor de un campo coincide con una expresión regular                                                                                                 | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_Regex>`        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Valida la longitud de una cadena                                                                                                                                 | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_StringLength>` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Between      | Valida que el valor está entre dos valores                                                                                                                     | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_Between>`      |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Confirmation | Valida que el valro es el mismo a otro dado en los datos                                                                                                | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_Confirmation>` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Url          | Valida que el campo tiene una URL válida                                                                                                                        | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_Url>`          |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| CreditCard   | Valida el número de tarjeta de crédito/débito                                                                                                                                   | :doc:`Ejemplo <../api/Phalcon_Validation_Validator_CreditCard>`   |
+--------------+-------------------------------------------+----------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

El siguiente ejemplo explica como crear un nuevo validator para este componente:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;
    use Phalcon\Validation\ValidatorInterface;

    class IpValidator extends Validator implements ValidatorInterface
    {
        /**
         * Executes the validation
         *
         * @param Phalcon\Validation $validator
         * @param string $attribute
         * @return boolean
         */
        public function validate(Validation $validator, $attribute)
        {
            $value = $validator->getValue($attribute);

            if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {

                $message = $this->getOption('message');
                if (!$message) {
                    $message = 'The IP is not valid';
                }

                $validator->appendMessage(new Message($message, $attribute, 'Ip'));

                return false;
            }

            return true;
        }
    }

Es importante que los validators devuelvan un valor booleano correcto indicando si la validación fue pasada con éxito o no.

Mensajes de validación
----------------------
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the validation processes.

Each message consists of an instance of the class :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the getMessages() method. Each message provides extended information like the attribute that
generated the message or the message type:

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        foreach ($validation->getMessages() as $message) {
            echo "Message: ", $message->getMessage(), "\n";
            echo "Field: ", $message->getField(), "\n";
            echo "Type: ", $message->getType(), "\n";
        }
    }

The getMessages() method can be overridden in a validation class to replace/translate the default messages generated by the validators:

.. code-block:: php

    <?php

    use Phalcon\Validation;

    class MyValidation extends Validation
    {
        public function initialize()
        {
            // ...
        }

        public function getMessages()
        {
            $messages = array();
            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case 'PresenceOf':
                        $messages[] = 'The field ' . $message->getField() . ' is mandatory';
                        break;
                }
            }

            return $messages;
        }
    }

Or you can pass a 'message' parameter to change the default message in each validator:

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Email;

    $validation->add(
        'email',
        new Email(
            array(
                'message' => 'The e-mail is not valid'
            )
        )
    );

By default, 'getMessages' returns all the messages generated during validation. You can filter messages
for a specific field using the 'filter' method:

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        // Filter only the messages generated for the field 'name'
        foreach ($validation->getMessages()->filter('name') as $message) {
            echo $message;
        }
    }

Filtering of Data
-----------------
Data can be filtered prior to the validation ensuring that malicious or incorrect data is not validated.

.. code-block:: php

    <?php

    use Phalcon\Validation;

    $validation = new Validation();

    $validation
        ->add('name', new PresenceOf(array(
            'message' => 'The name is required'
        )))
        ->add('email', new PresenceOf(array(
            'message' => 'The email is required'
        )));

    // Filter any extra space
    $validation->setFilters('name', 'trim');
    $validation->setFilters('email', 'trim');

Filtering and sanitizing is performed using the :doc:`filter <filter>`: component. You can add more filters to this
component or use the built-in ones.

Validation Events
-----------------
When validations are organized in classes, you can implement the 'beforeValidation' and 'afterValidation' methods to perform additional checks, filters, clean-up, etc. If the 'beforeValidation' method returns false the validation is automatically
cancelled:

.. code-block:: php

    <?php

    use Phalcon\Validation;

    class LoginValidation extends Validation
    {
        public function initialize()
        {
            // ...
        }

        /**
         * Executed before validation
         *
         * @param array $data
         * @param object $entity
         * @param Phalcon\Validation\Message\Group $messages
         * @return bool
         */
        public function beforeValidation($data, $entity, $messages)
        {
            if ($this->request->getHttpHost() != 'admin.mydomain.com') {
                $messages->appendMessage(new Message('Only users can log on in the administration domain'));

                return false;
            }

            return true;
        }

        /**
         * Executed after validation
         *
         * @param array $data
         * @param object $entity
         * @param Phalcon\Validation\Message\Group $messages
         */
        public function afterValidation($data, $entity, $messages)
        {
            // ... Add additional messages or perform more validations
        }
    }

Cancelling Validations
----------------------
By default all validators assigned to a field are tested regardless if one of them have failed or not. You can change
this behavior by telling the validation component which validator may stop the validation:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation
        ->add('telephone', new PresenceOf(array(
            'message'      => 'The telephone is required',
            'cancelOnFail' => true
        )))
        ->add('telephone', new Regex(array(
            'message' => 'The telephone is required',
            'pattern' => '/\+44 [0-9]+/'
        )))
        ->add('telephone', new StringLength(array(
            'messageMinimum' => 'The telephone is too short',
            'min'            => 2
        )));

The first validator has the option 'cancelOnFail' with a value of true, therefore if that validator fails the remaining
validators in the chain are not executed.

If you are creating custom validators you can dynamically stop the validation chain by setting the 'cancelOnFail' option:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;
    use Phalcon\Validation\ValidatorInterface;

    class MyValidator extends Validator implements ValidatorInterface
    {
        /**
         * Executes the validation
         *
         * @param Phalcon\Validation $validator
         * @param string $attribute
         * @return boolean
         */
        public function validate(Validation $validator, $attribute)
        {
            // If the attribute value is name we must stop the chain
            if ($attribute == 'name') {
                $validator->setOption('cancelOnFail', true);
            }

            // ...
        }
    }

Avoid validate empty values
---------------------------
You can pass the option 'allowEmpty' to all the built-in validators to avoid the validation to be performed if an empty value is passed:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;

    $validation = new Validation();

    $validation
        ->add('telephone', new Regex(array(
            'message'    => 'The telephone is required',
            'pattern'    => '/\+44 [0-9]+/',
            'allowEmpty' => true
        )));
