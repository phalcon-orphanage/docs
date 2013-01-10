<?php

namespace Phalcon\Mvc\Model\Validator;

/**
 * Phalcon\Mvc\Model\Validator\InclusionIn
 *
 * Check if a value is included into a list of values
 *
 *<code>
 *	use Phalcon\Mvc\Model\Validator\InclusionIn as InclusionInValidator;
 *
 *	class Subscriptors extends Phalcon\Mvc\Model
 *	{
 *
 *		public function validation()
 *		{
 *			$this->validate(new InclusionInValidator(array(
 *				'field' => 'status',
 *				'domain' => array('A', 'I')
 *			)));
 *			if ($this->validationHasFailed() == true) {
 *				return false;
 *			}
 *		}
 *
 *	}
 *</code>
 */
class Inclusionin extends Phalcon\Mvc\Model\Validator implements Phalcon\Mvc\Model\ValidatorInterface
{
/**
 * Executes validator
 *
 * @param Phalcon\Mvc\ModelInterface $record
 * @return boolean
 */
public function validate($record) {}

/**
 * Phalcon\Mvc\Model\Validator constructor
 *
 * @param array $options
 */
public function __construct($options) {}

/**
 * Appends a message to the validator
 *
 * @param string $message
 * @param string $field
 * @param string $type
 */
protected function appendMessage() {}

/**
 * Returns messages generated by the validator
 *
 * @return array
 */
public function getMessages() {}

/**
 * Returns all the options from the validator
 *
 * @return array
 */
protected function getOptions() {}

/**
 * Returns an option
 *
 * @param string $option
 * @return mixed
 */
protected function getOption() {}

/**
 * Check whether a option has been defined in the validator options
 *
 * @param string $option
 * @return boolean
 */
protected function isSetOption() {}

}