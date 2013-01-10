<?php

namespace Phalcon\Logger;

/**
 * Phalcon\Logger\Item
 *
 * Represents each item in a logging transaction
 *
 */
class Item {
/**
 * Phalcon\Logger\Item constructor
 *
 * @param string $message
 * @param integer $type
 * @param integer $time
 */
public function __construct($message, $type, $time) {}

/**
 * Returns the message
 *
 * @return string
 */
public function getMessage() {}

/**
 * Returns the log type
 *
 * @return integer
 */
public function getType() {}

/**
 * Returns log timestamp
 *
 * @return integer
 */
public function getTime() {}

}