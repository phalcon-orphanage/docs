%{validation_c81f893f5539efed7a6b2aae2d783e35}%
==========
%{validation_df9655796647575843a59b2aaa288feb}%

%{validation_09046bd05925c7ff83bddee4094d745a}%

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\PresenceOf,
        Phalcon\Validation\Validator\Email;

    $validation = new Phalcon\Validation();

    $validation->add('name', new PresenceOf(array(
        'message' => 'The name is required'
    )));

    $validation->add('email', new PresenceOf(array(
        'message' => 'The e-mail is required'
    )));

    $validation->add('email', new Email(array(
        'message' => 'The e-mail is not valid'
    )));

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

%{validation_8119eaef07bf942b708b8da28ae405ac}%

%{validation_3093b0011464d4bd39869dbdc5a8689c}%
-----------------------
%{validation_d086513db60a7c3e4d84f23a05e52c24}%

.. code-block:: php

    <?php

    use Phalcon\Validation,
        Phalcon\Validation\Validator\PresenceOf,
        Phalcon\Validation\Validator\Email;

    class MyValidation extends Validation
    {
        public function initialize()
        {
            $this->add('name', new PresenceOf(array(
                'message' => 'The name is required'
            )));

            $this->add('email', new PresenceOf(array(
                'message' => 'The e-mail is required'
            )));

            $this->add('email', new Email(array(
                'message' => 'The e-mail is not valid'
            )));
        }
    }

.. code-block:: php

    <?php

    $validation = new MyValidation();

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

%{validation_533a67e85a7f17b61b21cb88a9e1f07c}%
----------
%{validation_1b1888abf001898488a01251b441c267}%

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Name         | Explanation                                                                                                                                                      | Example                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Validates that a field's value is not null or empty string.                                                                                                      | :doc:`Example <../api/Phalcon_Validation_Validator_PresenceOf>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Identical    | Validates that a field's value is the same as a specified value                                                                                                  | :doc:`Example <../api/Phalcon_Validation_Validator_Identical>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Email        | Validates that field contains a valid email format                                                                                                               | :doc:`Example <../api/Phalcon_Validation_Validator_Email>`        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                                                   | :doc:`Example <../api/Phalcon_Validation_Validator_ExclusionIn>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Validates that a value is within a list of possible values                                                                                                       | :doc:`Example <../api/Phalcon_Validation_Validator_InclusionIn>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Validates that the value of a field matches a regular expression                                                                                                 | :doc:`Example <../api/Phalcon_Validation_Validator_Regex>`        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Validates the length of a string                                                                                                                                 | :doc:`Example <../api/Phalcon_Validation_Validator_StringLength>` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Between      | Validates that a value is between two values                                                                                                                     | :doc:`Example <../api/Phalcon_Validation_Validator_Between>`      |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Confirmation | Validates that a value is the same as another present in the data                                                                                                | :doc:`Example <../api/Phalcon_Validation_Validator_Confirmation>` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

%{validation_fd4983df29ddaf7800070ffeec35afe0}%

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator,
        Phalcon\Validation\ValidatorInterface,
        Phalcon\Validation\Message;

    class IpValidator extends Validator implements ValidatorInterface
    {

        /**
         * Executes the validation
         *
         * @param Phalcon\Validation $validator
         * @param string $attribute
         * @return boolean
         */
        public function validate($validator, $attribute)
        {
            $value = $validator->getValue($attribute);

            if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {

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

%{validation_6fbfb65077407a190ad22e8e77664ac2}%

%{validation_39d425478bbbd8c190c1571d56968719}%
-------------------
%{validation_025092c74cf3eac36210de122720cf4b}%

%{validation_c2207d0096c2817a5a69f0dfb16f314f}%

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

%{validation_aa193b670cd59296d6003822c817edba}%

.. code-block:: php

    <?php

    class MyValidation extends Phalcon\Validation
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

%{validation_8a7d25a8a7f1e5b02b927a37b57351d9}%

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Email;

    $validation->add('email', new Email(array(
        'message' => 'The e-mail is not valid'
    )));

%{validation_052c3afa0415b025bc6d86d5f3490223}%

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        //{%validation_d260a18b544978c7f97b844025954db4%}
        foreach ($validation->getMessages()->filter('name') as $message) {
            echo $message;
        }
    }

%{validation_3d8f66bb7ca87432cb0e3125363aa301}%
-----------------
%{validation_507eaf899079c0b1f652ad21b5e36385}%

.. code-block:: php

    <?php

    $validation = new Phalcon\Validation();

    $validation
        ->add('name', new PresenceOf(array(
            'message' => 'The name is required'
        )))
        ->add('email', new PresenceOf(array(
            'message' => 'The email is required'
        )));

    //{%validation_35fa191bb4e9b7e286f1b860019edaa7%}
    $validation->setFilters('name', 'trim');
    $validation->setFilters('email', 'trim');

%{validation_839737867781eaea4b36c49d0d1641e7}%

%{validation_ff1d08a3b2570996565ef460daea6026}%
-----------------
%{validation_b1f211a73fad538fa52a2eabf8250f3b}%

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
            //{%validation_cde6f56c01569b440032e464aad1e292%}
        }

    }

%{validation_54e3ab73caaa54617147ed87e52d7d39}%
----------------------
%{validation_9880d3237fc267dac86acd10f9425f79}%

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\PresenceOf,
        Phalcon\Validation\Validator\Regex;

    $validation = new Phalcon\Validation();

    $validation
        ->add('telephone', new PresenceOf(array(
            'message' => 'The telephone is required',
            'cancelOnFail' => true
        )))
        ->add('telephone', new Regex(array(
            'message' => 'The telephone is required',
            'pattern' => '/\+44 [0-9]+/'
        )))
        ->add('telephone', new StringLength(array(
            'minimumMessage' => 'The telephone is too short',
            'min' => 2
        )));

%{validation_467ddfc7beb4e277ae522fc4663aab79}%

%{validation_c9189a5d2d769d96466c62617e4f90d0}%

