<?php

namespace Phalcon\Flash;

/**
 * Phalcon\Flash\Session
 *
 * Temporarily stores the messages in session, then messages can be printed in the next request
 */
class Session extends Phalcon\Flash implements Phalcon\FlashInterface, Phalcon\DI\InjectionAwareInterface
{
/**
 * Sets the dependency injector
 *
 * @param Phalcon\DiInterface $dependencyInjector
 */
public function setDI($dependencyInjector) {}

/**
 * Returns the internal dependency injector
 *
 * @return Phalcon\DiInterface
 */
public function getDI() {}

/**
 * Returns the messages stored in session
 *
 * @param boolean $remove
 * @return array
 */
protected function _getSessionMessages() {}

/**
 * Stores the messages in session
 *
 * @param array $messages
 */
protected function _setSessionMessages() {}

/**
 * Adds a message to the session flasher
 *
 * @param string $type
 * @param string $message
 */
public function message($type, $message) {}

/**
 * Returns the messages in the session flasher
 *
 * @param string $type
 * @param boolean $remove
 * @return array
 */
public function getMessages($type, $remove) {}

/**
 * Prints the messages in the session flasher
 *
 * @param string $type
 * @param boolean $remove
 */
public function output($remove) {}

/**
 * Phalcon\Flash constructor
 *
 * @param array $cssClasses
 */
public function __construct($cssClasses) {}

/**
 * Set the if the output must be implictly flushed to the output or returned as string
 *
 * @param boolean $implicitFlash
 */
public function setImplicitFlush($implicitFlush) {}

/**
 * Set the if the output must be implictly formatted with HTML
 *
 * @param boolean $automaticHtml
 */
public function setAutomaticHtml($automaticHtml) {}

/**
 * Set an array with CSS classes to format the messages
 *
 * @param array $cssClasses
 */
public function setCssClasses($cssClasses) {}

/**
 * Shows a HTML error message
 *
 *<code>
 * $flash->error('This is an error');
 *</code>
 *
 * @param string $message
 * @return string
 */
public function error($message) {}

/**
 * Shows a HTML notice/information message
 *
 *<code>
 * $flash->notice('This is an information');
 *</code>
 *
 * @param string $message
 * @return string
 */
public function notice($message) {}

/**
 * Shows a HTML success message
 *
 *<code>
 * $flash->success('The process was finished successfully');
 *</code>
 *
 * @param string $message
 * @return string
 */
public function success($message) {}

/**
 * Shows a HTML warning message
 *
 *<code>
 * $flash->warning('Hey, this is important');
 *</code>
 *
 * @param string $message
 * @return string
 */
public function warning($message) {}

/**
 * Outputs a message formatting it with HTML
 *
 * @param string $type
 * @param string $message
 */
public function outputMessage($type, $message) {}

}