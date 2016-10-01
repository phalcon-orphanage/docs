Validation
==========

:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` is an independent validation component that validates an arbitrary set of data.
This component can be used to implement validation rules on data objects that do not belong to a model or collection.

The following example shows its basic usage:

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

The loosely-coupled design of this component allows you to create your own validators along with the ones provided by the framework.

Initializing Validation
-----------------------
Validation chains can be initialized in a direct manner by just adding validators to the :doc:`Phalcon\\Validation <../api/Phalcon_Validation>` object.
You can put your validations in a separate file for better re-use code and organization:

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

Then initialize and use your own validator:

.. code-block:: php

    <?php

    $validation = new MyValidation();

    $messages = $validation->validate($_POST);

    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Validators
----------
Phalcon exposes a set of built-in validators for this component:

+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Class                                                                                                  | Explanation                                                       |
+========================================================================================================+===================================================================+
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
| :doc:`Phalcon\\Validation\\Validator\\PresenceOf <../api/Phalcon_Validation_Validator_PresenceOf>`     | Validates that a field's value is not null or empty string.       |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Identical <../api/Phalcon_Validation_Validator_Identical>`       | Validates that a field's value is the same as a specified value   |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Email <../api/Phalcon_Validation_Validator_Email>`               | Validates that field contains a valid email format                |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\ExclusionIn <../api/Phalcon_Validation_Validator_ExclusionIn>`   | Validates that a value is not within a list of possible values    |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\InclusionIn <../api/Phalcon_Validation_Validator_InclusionIn>`   | Validates that a value is within a list of possible values        |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Regex <../api/Phalcon_Validation_Validator_Regex>`               | Validates that the value of a field matches a regular expression  |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\StringLength <../api/Phalcon_Validation_Validator_StringLength>` | Validates the length of a string                                  |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Between <../api/Phalcon_Validation_Validator_Between>`           | Validates that a value is between two values                      |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Confirmation <../api/Phalcon_Validation_Validator_Confirmation>` | Validates that a value is the same as another present in the data |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Url <../api/Phalcon_Validation_Validator_Url>`                   | Validates that field contains a valid URL                         |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\CreditCard <../api/Phalcon_Validation_Validator_CreditCard>`     | Validates a credit card number                                    |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

The following example explains how to create additional validators for this component:

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

It is important that validators return a valid boolean value indicating if the validation was successful or not.

Validation Messages
-------------------
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the validation processes.

Each message consists of an instance of the class :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the :code:`getMessages()` method. Each message provides extended information like the attribute that
generated the message or the message type:

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

You can pass a 'message' parameter to change/translate the default message in each validator:

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

By default, the :code:`getMessages()` method returns all the messages generated during validation. You can filter messages
for a specific field using the :code:`filter()` method:

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

Filtering of Data
-----------------
Data can be filtered prior to the validation ensuring that malicious or incorrect data is not validated.

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

Filtering and sanitizing is performed using the :doc:`filter <filter>` component. You can add more filters to this
component or use the built-in ones.

Validation Events
-----------------
When validations are organized in classes, you can implement the :code:`beforeValidation()` and :code:`afterValidation()` methods to perform additional checks, filters, clean-up, etc. If the :code:`beforeValidation()` method returns false the validation is automatically
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

The first validator has the option 'cancelOnFail' with a value of true, therefore if that validator fails the remaining
validators in the chain are not executed.

If you are creating custom validators you can dynamically stop the validation chain by setting the 'cancelOnFail' option:

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

Avoid validate empty values
---------------------------
You can pass the option 'allowEmpty' to all the built-in validators to avoid the validation to be performed if an empty value is passed:

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
