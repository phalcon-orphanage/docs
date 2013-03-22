Validation
==========
Phalcon\Validation is an independent validation component to validate an arbitrary set of data.
This component can be used to implement validation rules that does not belong to a model or collection.

The following example shows its basic usage:

.. code-block:: php

	use Phalcon\Validation\Validator\PresenceOf,
		Phalcon\Validation\Validator\Email;

	$validation = new Phalcon\Validation();

	$validation->add('name', new PresenceOf(
		'message' => 'The name is required'
	));

	$validation->add('email', new PresenceOf(
		'message' => 'The e-mail is required'
	));

	$validation->add('email', new Email(
		'message' => 'The e-mail is not valid'
	));

	$messages = $validation->validate($_POST);
	if (count($messages)) {
		foreach ($messages as $message) {
			echo $message, '<br>;
		}
	}

Validators
----------
Phalcon exposes a set of built-in validators for this component:

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Name         | Explanation                                                                                                                                                      | Example                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Validates that a field's value isn't null or empty string.                                                                                                       | :doc:`Example <../api/Phalcon_Validation_Validator_PresenceOf>`   |
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

Additional validators can be created by the developer. The following class explains how to create a validator for this component:

.. code-block:: php

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

			if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))) {

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

Validation Messages
-------------------
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the validation processes.

Each message consists of an instance of the class :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the method getMessages(). Each message provides extended information like the attribute that
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


The method getMessages() can be overriden in a validation class to replace/translate the default messages generated automatically by the validators:

.. code-block:: php

    <?php

    class MyValidation extends Phalcon\Validation
    {
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

Or you can pass a parameter 'message' to change the default message in each validator:

.. code-block:: php

	$validation->add('email', new Phalcon\Validation\Validator\Email(
		'message' => 'The e-mail is not valid'
	));

