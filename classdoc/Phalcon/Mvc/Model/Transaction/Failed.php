<?php

namespace Phalcon\Mvc\Model\Transaction;

/**
 * Phalcon\Mvc\Model\Transaction\Failed
 *
 * Phalcon\Mvc\Model\Transaction\Failed will be thrown to exit a try/catch block for transactions
 *
 */
class Failed extends Exception {
/**
 * Phalcon\Mvc\Model\Transaction\Failed constructor
 *
 * @param string $message
 * @param Phalcon\Mvc\ModelInterface $record
 */
public function __construct($message, $record) {}

/**
 * Returns validation record messages which stop the transaction
 *
 * @return Phalcon\Mvc\Model\MessageInterface[]
 */
public function getRecordMessages() {}

/**
 * Returns validation record messages which stop the transaction
 *
 * @return Phalcon\Mvc\ModelInterface
 */
public function getRecord() {}

/**
             * Clone the exception
             *
             * @return Exception
            */
final private function __clone() {}

/**
             * Gets the Exception message
             *
             * @return string
            */
final public function getMessage() {}

/**
             * Gets the Exception code
             *
             * @return int
            */
final public function getCode() {}

/**
             * Gets the file in which the exception occurred
             *
             * @return string
            */
final public function getFile() {}

/**
             * Gets the line in which the exception occurred
             *
             * @return int
            */
final public function getLine() {}

/**
             * Gets the stack trace
             *
             * @return array
            */
final public function getTrace() {}

/**
             * Returns previous Exception
             *
             * @return Exception
            */
final public function getPrevious() {}

/**
             * Gets the stack trace as a string
             *
             * @return Exception
            */
final public function getTraceAsString() {}

/**
             * String representation of the exception
             *
             * @return string
            */
public function __toString() {}

}