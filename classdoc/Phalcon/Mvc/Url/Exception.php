<?php

namespace Phalcon\Mvc\Url;

class Exception extends Phalcon\Exception {
/**
             * Clone the exception
             *
             * @return Exception
            */
final private function __clone() {}

/**
             * Exception constructor
             *
             * @param string $message
             * @param int $code
             * @param Exception $previous
            */
public function __construct($message, $code, $previous) {}

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