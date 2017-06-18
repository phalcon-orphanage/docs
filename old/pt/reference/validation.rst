Validação
==========

:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` É um componente de validação independente que valida um conjunto de dados. Esse componente pode ser usado para implementar regras de
validação em dados de objetos que não tem relação com um modelo ou uma coleção.

O exemplo a seguir mostra seu uso básico:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Email;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation->add(
        "name",
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $validation->add(
        "email",
        new PresenceOf(
            [
                "message" => "The e-mail is required",
            ]
        )
    );

    $validation->add(
        "email",
        new Email(
            [
                "message" => "The e-mail is not valid",
            ]
        )
    );

    $messages = $validation->validate($_POST);

    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

O design fracamente acoplado deste componente permite que você possa criar seus proprios validadores extendendo a estrutura fornecida pelo framework.

Inicializando Validação
-----------------------
Validation chains podem ser inicializados diretamente apenas adicionando validadores no objeto :doc:`Phalcon\\Validation <../api/Phalcon_Validation>`.
Você pode adicionar validações em um arquivo separado para melhor reutilização e organização:

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
                "name",
                new PresenceOf(
                    [
                        "message" => "The name is required",
                    ]
                )
            );

            $this->add(
                "email",
                new PresenceOf(
                    [
                        "message" => "The e-mail is required",
                    ]
                )
            );

            $this->add(
                "email",
                new Email(
                    [
                        "message" => "The e-mail is not valid",
                    ]
                )
            );
        }
    }

Em seguida, inicializar e usar seu próprio validador:

.. code-block:: php

    <?php

    $validation = new MyValidation();

    $messages = $validation->validate($_POST);

    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Validadores
-----------
Phalcon fornece um conjunto de validadores para este componente:

+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| Class                                                                                                  | Explicação                                                                |
+========================================================================================================+===========================================================================+
| :doc:`Phalcon\\Validation\\Validator\\Alnum <../api/Phalcon_Validation_Validator_Alnum>`               | Validates that a field's value is only alphanumeric character(s). |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Alpha <../api/Phalcon_Validation_Validator_Alpha>`               | Validates that a field's value is only alphabetic character(s).   |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Date <../api/Phalcon_Validation_Validator_Date>`                 | Validates that a field's value is a valid date.                   |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Digit <../api/Phalcon_Validation_Validator_Digit>`               | Validates that a field's value is only numeric character(s).      |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\File <../api/Phalcon_Validation_Validator_File>`                 | Validates that a field's value is a correct file.                 |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Uniqueness <../api/Phalcon_Validation_Validator_Uniqueness>`     | Validates that a field's value is unique in the related model.    |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Numericality <../api/Phalcon_Validation_Validator_Numericality>` | Validates that a field's value is a valid numeric value.          |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\PresenceOf <../api/Phalcon_Validation_Validator_PresenceOf>`     | Valida que o valor de um campo não é nulo ou vazio                        |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Identical <../api/Phalcon_Validation_Validator_Identical>`       | Valida que o valor de um campo é o mesmo que o especificado               |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Email <../api/Phalcon_Validation_Validator_Email>`               | Valida que o valor de um campo contém um email no formato válido          |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\ExclusionIn <../api/Phalcon_Validation_Validator_ExclusionIn>`   | Valida que um valor não está dentro de uma lista de valores possíveis     |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\InclusionIn <../api/Phalcon_Validation_Validator_InclusionIn>`   | Valida que um valor está dentro de uma lista de valores possíveis         |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Regex <../api/Phalcon_Validation_Validator_Regex>`               | Valida que o valor de um campo corresponde a expressão regular            |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\StringLength <../api/Phalcon_Validation_Validator_StringLength>` | Valida o tamanho da string                                                |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Between <../api/Phalcon_Validation_Validator_Between>`           | Valida que o valor está entre dois valores                                |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Confirmation <../api/Phalcon_Validation_Validator_Confirmation>` | Valida que um valor é o mesmo que outro presente nos dados                |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Url <../api/Phalcon_Validation_Validator_Url>`                   | Valida que o valor de um campo seja uma Url válida                        |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\CreditCard <../api/Phalcon_Validation_Validator_CreditCard>`     | Valida que o valor de um campo seja um número de cartão de crédito válido |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Callback <../api/Phalcon_Validation_Validator_Callback>`         | Validates using callback function                                  |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

O exemplo abaixo explica como criar um validador adicional para este componente:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;

    class IpValidator extends Validator
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
                $message = $this->getOption("message");

                if (!$message) {
                    $message = "The IP is not valid";
                }

                $validator->appendMessage(
                    new Message($message, $attribute, "Ip")
                );

                return false;
            }

            return true;
        }
    }

É importante que os validadores retornem um valor booleano válido indicando se a validação foi bem sucedida ou não.

Callback Validator
------------------
By using :doc:`Phalcon\\Validation\\Validator\\Callback <../api/Phalcon_Validation_Validator_Callback>` you can execute custom
function which must return boolean or new validator class which will be used to validate the same field. By returning :code:`true`
validation will be successful, returning :code:`false` will mean validation failed. When executing this validator Phalcon will pass
data depending what it is - if it's an entity then entity will be passed, otherwise data. There is example:

.. code-block:: php

    <?php

    use \Phalcon\Validation;
    use \Phalcon\Validation\Validator\Callback;
    use \Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();
    $validation->add(
        "amount",
        new Callback(
            [
                "callback" => function($data) {
                    return $data["amount"] % 2 == 0;
                },
                "message" => "Only even number of products are accepted"
            ]
        )
    );
    $validation->add(
        "amount",
        new Callback(
            [
                "callback" => function($data) {
                    if($data["amount"] % 2 == 0) {
                        return $data["amount"] != 2;
                    }

                    return true;
                },
                "message" => "You can't buy 2 products"
            ]
        )
    );
    $validation->add(
        "description",
        new Callback(
            [
                "callback" => function($data) {
                    if($data["amount"] >= 10) {
                        return new PresenceOf(
                            [
                                "message" => "You must write why you need so big amount."
                            ]
                        );
                    }

                    return true;
                }
            ]
        )
    );

    $messages = $validation->validate(["amount" => 1]); // will return message from first validator
    $messages = $validation->validate(["amount" => 2]); // will return message from second validator
    $messages = $validation->validate(["amount" => 10]); // will return message from validator returned by third validator

Mensagens de Validação
----------------------
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` tem um subsistema de mensagens que fornece uma maneira flexível de exibição ou
armazenamento de mensagens de validação gerada durante os processos de validação.

Cada mensagem consiste em uma instancia da classe :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`.
O conjunto de mensagens geradas podem ser recuperadas com o método :code:`getMessages()`. Cada mensagem fornece informações detalhadas como
o atributo que gerou a mensagem ou o tipo de mensagem:

.. code-block:: php

    <?php

    $messages = $validation->validate();

    if (count($messages)) {
        foreach ($messages as $message) {
            echo "Message: ", $message->getMessage(), "\n";
            echo "Field: ", $message->getField(), "\n";
            echo "Type: ", $message->getType(), "\n";
        }
    }

Pode passar o parametro 'message' para alterar a mensagem padrão em cada validador:

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Email;

    $validation->add(
        "email",
        new Email(
            [
                "message" => "The e-mail is not valid",
            ]
        )
    );

Por padrão, :code:`getMessages()` retorna todas as mensagens geradas durante a validação. Você pode filtrar as mensagens
por um campo específico usando o método :code:`filter()`:

.. code-block:: php

    <?php

    $messages = $validation->validate();

    if (count($messages)) {
        // Filter only the messages generated for the field 'name'
        $filteredMessages = $messages->filter("name");

        foreach ($filteredMessages as $message) {
            echo $message;
        }
    }

Filtragem de dados
------------------
Os dados podem ser filtrados antes da validação garantindo que os informações maliciosas ou incorretas não sejam validadas.

.. code-block:: php

    <?php

    use Phalcon\Validation;

    $validation = new Validation();

    $validation->add(
        "name",
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $validation->add(
        "email",
        new PresenceOf(
            [
                "message" => "The email is required",
            ]
        )
    );

    // Filter any extra space
    $validation->setFilters("name", "trim");
    $validation->setFilters("email", "trim");

Filtragem e sanatização é realizada usando o componente :doc:`filter <filter>`. Você pode adicionar mais filtros nesse
componente ou usar os imbutidos.

Eventos de Validação
--------------------
Quando validações são organizadas em classes, você pode implementar os métodos :code:`beforeValidation()` e :code:`afterValidation()` para dispor de mais verificações, filtros, etc. Se o método :code:`beforeValidation()` retornar false, a validação é automaticamente
cancelada:

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
            if ($this->request->getHttpHost() !== "admin.mydomain.com") {
                $messages->appendMessage(
                    new Message("Only users can log on in the administration domain")
                );

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

Cancelando Validações
---------------------
Por padrão todos os validadores atribuídos aos campos são testados independentemente, mesmo se um deles falhar ou não. Você pode
mudar este comportamente dizendo ao componente de validação qual validador pode parar a validação:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation->add(
        "telephone",
        new PresenceOf(
            [
                "message"      => "The telephone is required",
                "cancelOnFail" => true,
            ]
        )
    );

    $validation->add(
        "telephone",
        new Regex(
            [
                "message" => "The telephone is required",
                "pattern" => "/\+44 [0-9]+/",
            ]
        )
    );

    $validation->add(
        "telephone",
        new StringLength(
            [
                "messageMinimum" => "The telephone is too short",
                "min"            => 2,
            ]
        )
    );

O primeiro validador possui a opção 'cancelOnFail' com o valor true, portanto se este validador falhar o restante dos validadores na cadeia
não são executados.

Se você está criando validadores próprios você pode parar a cadeia de validação dinamicamente configurando a opção 'cancelOnFail':

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;

    class MyValidator extends Validator
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
            if ($attribute === "name") {
                $validator->setOption("cancelOnFail", true);
            }

            // ...
        }
    }

Evitar validar valores vazios
-----------------------------
Você pode passar a opção 'allowEmpty' para todos os validadores imbutidos para evitar que a validação seja executada caso um valor vazio é passado:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;

    $validation = new Validation();

    $validation->add(
        "telephone",
        new Regex(
            [
                "message"    => "The telephone is required",
                "pattern"    => "/\+44 [0-9]+/",
                "allowEmpty" => true,
            ]
        )
    );

Recursive Validation
--------------------
You can also run Validation instances within another via the :code:`afterValidation()` method. In this example, validating the CompanyValidation instance will also check the PhoneValidation instance:

.. code-block:: php

    <?php

    use Phalcon\Validation;

    class CompanyValidation extends Validation
    {
        /**
         * @var PhoneValidation
         */
        protected $phoneValidation;



        public function initialize()
        {
            $this->phoneValidation = new PhoneValidation();
        }



        public function afterValidation($data, $entity, $messages)
        {
            $phoneValidationMessages = $this->phoneValidation->validate(
                $data["phone"]
            );

            $messages->appendMessages(
                $phoneValidationMessages
            );
        }
    }
