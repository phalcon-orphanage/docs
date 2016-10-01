Validating Models
=================

データ整合性の検証
-------------------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides several events to validate data and implement business rules. The special "validation"
event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.

The following example shows how to use it:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Uniqueness;
    use Phalcon\Validation\Validator\InclusionIn;

    class Robots extends Model
    {
        public function validation()
        {
            $validator = new Validation();

            $validator->add(
                "type",
                new InclusionIn(
                    [
                        "domain" => [
                            "Mechanical",
                            "Virtual",
                        ]
                    ]
                )
            );

            $validator->add(
                "name",
                new Uniqueness(
                    [
                        "message" => "The robot name must be unique",
                    ]
                )
            );

            return $this->validate($validator);
        }
    }

The above example performs a validation using the built-in validator "InclusionIn". It checks the value of the field "type" in a domain list. If
the value is not included in the method then the validator will fail and return false.

.. highlights::

    For more information on validators, see the :doc:`Validation documentation <validation>`.

The idea of creating validators is make them reusable between several models. A validator can also be as simple as:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Message;

    class Robots extends Model
    {
        public function validation()
        {
            if ($this->type === "Old") {
                $message = new Message(
                    "Sorry, old robots are not allowed anymore",
                    "type",
                    "MyType"
                );

                $this->appendMessage($message);

                return false;
            }

            return true;
        }
    }

バリデーション・メッセージ
--------------------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the insert/update processes.

Each message is an instance of :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>` and the set of
messages generated can be retrieved with the :code:`getMessages()` method. Each message provides extended information like the field name that
generated the message or the message type:

.. code-block:: php

    <?php

    if ($robot->save() === false) {
        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` can generate the following types of validation messages:

+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                 | Description                                                                                                                        |
+======================+====================================================================================================================================+
| PresenceOf           | Generated when a field with a non-null attribute on the database is trying to insert/update a null value                           |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation  | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidValue         | Generated when a validator failed because of an invalid value                                                                      |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidCreateAttempt | Produced when a record is attempted to be created but it already exists                                                            |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidUpdateAttempt | Produced when a record is attempted to be updated but it doesn't exist                                                             |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+

The :code:`getMessages()` method can be overridden in a model to replace/translate the default messages generated automatically by the ORM:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function getMessages()
        {
            $messages = [];

            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case "InvalidCreateAttempt":
                        $messages[] = "The record cannot be created because it already exists";
                        break;

                    case "InvalidUpdateAttempt":
                        $messages[] = "The record cannot be updated because it doesn't exist";
                        break;

                    case "PresenceOf":
                        $messages[] = "The field " . $message->getField() . " is mandatory";
                        break;
                }
            }

            return $messages;
        }
    }

バリデーション失敗のイベント
----------------------------
Another type of events are available when the data validation process finds any inconsistency:

+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSaved           | Triggered when the INSERT or UPDATE operation fails for any reason |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+
