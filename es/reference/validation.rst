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

Sólo necesitas inizializar y usar tu propio validador:

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
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` tiene un subsistema que provee una forma flexible de salida o de almacenar los mensajes de validación generados durante el proceso.

Cada mensaje consiste en una instancia de la clase :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`. El conjunto de mensajes generados puede ser recibido con el método getMessages(). Cada mensaje provee información extendida como el atributo que lo generó o el tipo de mensaje:

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

El método getMessages() puede ser sobrescrito en una clase para reemplazar o traducir los mensajes por defecto de los validators:

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

O puedes pasar un parámetro 'message' para cambiar el mensaje por defecto de cada validator: 

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

Por defecto, 'getMessages' devuelve todos los mensajes generados durante la validación. Puedes filtrar los mensajes por un campo específico usando el método 'filter':

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        // Filter only the messages generated for the field 'name'
        foreach ($validation->getMessages()->filter('name') as $message) {
            echo $message;
        }
    }

Filtrado de Datos
-----------------
Los datos pueden ser filtrados antes de la validación para asegurar que los datos maliciosos o incorrectos no son válidos.

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


El filtrado (filtering) y desinfección (sanitizing) es ejecutado usando el componente :doc:`filter <filter>`:. Se puede añadir más filtros a este componente o usar uno ya construido.

Eventos de Validación
---------------------
Cuando las validaciones son organizadas en clases, se puede implementar los métodos 'beforeValidation' y 'afterValidation' para ejecutar chequeos adicionales, filtros, limpiezas, etc. Si el método 'beforeValidation' devuelve false la validación es cancelada automáticamente:

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

Cancelando las Validaciones
---------------------------
Por defecto todos los validators asignados a un campo son testeados regularmente por si uno de ellos ha fallado o no. Se puede cambiar este comportamiento diciéndole al componente que validator podría parar la validación:

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

El primer validador tiene la opción 'cancelOnFail' con un valor a true, por tanto si el validator falla el resto de validadores del código no son ejecutados.

Si creas validators personalizados puedes parar dinámicamente la ejecución con la opción 'cancelOnFail':

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

Evita validar campos vacios
---------------------------
Se puede pasar la opción 'allowEmpty' a todos los validators para evitar que la validación sea ejecutada si un valor vacío es pasado:

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
