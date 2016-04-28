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

Em seguida, inicializar e usar seu próprio validador:

.. code-block:: php

    <?php

    $validation = new MyValidation();

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

Validadores
-----------
Phalcon fornece um conjunto de validadores para este componente:

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Nome         | Explicação                                                                                                                                                       | Exemplo                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Valida que o valor de um campo não é nulo ou vazio                                                                                                               | :doc:`Example <../api/Phalcon_Validation_Validator_PresenceOf>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Identical    | Valida que o valor de um campo é o mesmo que o especificado                                                                                                      | :doc:`Example <../api/Phalcon_Validation_Validator_Identical>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Email        | Valida que o valor de um campo contém um email no formato válido                                                                                                 | :doc:`Example <../api/Phalcon_Validation_Validator_Email>`        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Valida que um valor não está dentro de uma lista de valores possíveis                                                                                            | :doc:`Example <../api/Phalcon_Validation_Validator_ExclusionIn>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Valida que um valor está dentro de uma lista de valores possíveis                                                                                                | :doc:`Example <../api/Phalcon_Validation_Validator_InclusionIn>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Valida que o valor de um campo corresponde a expressão regular                                                                                                   | :doc:`Example <../api/Phalcon_Validation_Validator_Regex>`        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Valida o tamanho da string                                                                                                                                       | :doc:`Example <../api/Phalcon_Validation_Validator_StringLength>` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Between      | Valida que o valor está entre dois valores                                                                                                                       | :doc:`Example <../api/Phalcon_Validation_Validator_Between>`      |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Confirmation | Valida que um valor é o mesmo que outro presente nos dados                                                                                                       | :doc:`Example <../api/Phalcon_Validation_Validator_Confirmation>` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Url          | Valida que o valor de um campo seja uma Url válida                                                                                                               | :doc:`Example <../api/Phalcon_Validation_Validator_Url>`          |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| CreditCard   | Valida que o valor de um campo seja um número de cartão de crédito válido                                                                                        | :doc:`Example <../api/Phalcon_Validation_Validator_CreditCard>`   |
+--------------+-------------------------------------------+----------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

O exemplo abaixo explica como criar um validador adicional para este componente:

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

É importante que os validadores retornem um valor booleano válido indicando se a validação foi bem sucedida ou não.

Mensagens de Validação
----------------------
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` tem um subsistema de mensagens que fornece uma maneira flexível de exibição ou
armazenamento de mensagens de validação gerada durante os processos de validação.

Cada mensagem consiste em uma instancia da classe :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`.
O conjunto de mensagens geradas podem ser recuperadas com o método getMessages(). Cada mensagem fornece informações detalhadas como
o atributo que gerou a mensagem ou o tipo de mensagem:

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

O método getMessages() pode ser sobrescrito em uma classe de validação para trocar/traduzir as mensagens padrões geradas pelos validadodes:

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

Ou pode passar o parametro 'message' para alterar a mensagem padrão em cada validador:

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

Por padrão, 'getMessages' retorna todas as mensagens geradas durante a validação. Você pode filtrar as mensagens
por um campo específico usando o método 'filter':

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        // Filter only the messages generated for the field 'name'
        foreach ($validation->getMessages()->filter('name') as $message) {
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

Filtragem e sanatização é realizada usando o componente :doc:`filter <filter>`:. Você pode adicionar mais filtros nesse
componente ou usar os imbutidos.

Eventos de Validação
--------------------
Quando validações são organizadas em classes, você pode implementar os métodos 'beforeValidation' e 'afterValidation' para dispor de mais verificações, filtros, etc. Se o método 'beforeValidation' retornar false, a validação é automaticamente
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

Cancelando Validações
----------------------
Por padrão todos os validadores atribuídos aos campos são testados independentemente, mesmo se um deles falhar ou não. Você pode
mudar este comportamente dizendo ao componente de validação qual validador pode parar a validação:

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

O primeiro validador possui a opção 'cancelOnFail' com o valor true, portanto se este validador falhar o restante dos validadores na cadeia
não são executados.

Se você está criando validadores próprios você pode parar a cadeia de validação dinamicamente configurando a opção 'cancelOnFail':

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

Evitar validar valores vazios
-----------------------------
Você pode passar a opção 'allowEmpty' para todos os validadores imbutidos para evitar que a validação seja executada caso um valor vazio é passado:

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
