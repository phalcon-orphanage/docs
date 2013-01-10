<?php

namespace Phalcon\Logger\Adapter;

/**
 * Phalcon\Logger\Adapter\File
 *
 * Adapter to store logs in plain text files
 *
 *<code>
 *$logger = new Phalcon\Logger\Adapter\File("app/logs/test.log");
 *$logger->log("This is a message");
 *$logger->log("This is an error", Phalcon\Logger::ERROR);
 *$logger->error("This is another error");
 *$logger->close();
 *</code>
 */
class File extends Phalcon\Logger\Adapter implements Phalcon\Logger\AdapterInterface
{
/**
 * Phalcon\Logger\Adapter\File constructor
 *
 * @param string $name
 * @param array $options
 */
public function __construct($name, $options) {}

/**
 * Sends/Writes messages to the file log
 *
 * @param string $message
 * @param int $type
 */
public function log($message, $type) {}

/**
  * Starts a transaction
  *
  */
public function begin() {}

/**
  * Commits the internal transaction
  *
  */
public function commit() {}

/**
  * Rollbacks the internal transaction
  *
  */
public function rollback() {}

/**
  * Closes the logger
  *
  * @return boolean
  */
public function close() {}

/**
 * Opens the internal file handler after unserialization
 *
 */
public function __wakeup() {}

/**
 * Set the log format
 *
 * @param string $format
 */
public function setFormat($format) {}

/**
 * Returns the log format
 *
 * @return format
 */
public function getFormat() {}

/**
 * Applies the internal format to the message
 *
 * @param  string $message
 * @param  int $type
 * @param  int $time
 * @return string
 */
protected function _applyFormat() {}

/**
 * Sets the internal date format
 *
 * @param string $date
 */
public function setDateFormat($date) {}

/**
 * Returns the internal date format
 *
 * @return string
 */
public function getDateFormat() {}

/**
 * Returns the string meaning of a logger constant
 *
 * @param  integer $type
 * @return string
 */
public function getTypeString($type) {}

/**
  * Sends/Writes a debug message to the log
  *
  * @param string $message
  * @param ing $type
  */
public function debug($message) {}

/**
  * Sends/Writes an error message to the log
  *
  * @param string $message
  * @param ing $type
  */
public function error($message) {}

/**
  * Sends/Writes an info message to the log
  *
  * @param string $message
  * @param ing $type
  */
public function info($message) {}

/**
  * Sends/Writes a notice message to the log
  *
  * @param string $message
  * @param ing $type
  */
public function notice($message) {}

/**
  * Sends/Writes a warning message to the log
  *
  * @param string $message
  * @param ing $type
  */
public function warning($message) {}

/**
  * Sends/Writes an alert message to the log
  *
  * @param string $message
  * @param ing $type
  */
public function alert($message) {}

}