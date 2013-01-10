<?php

namespace Phalcon\Flash;

/**
 * Phalcon\Flash\Direct
 *
 * This is a variant of the Phalcon\Flash that inmediately outputs any message passed to it
 */
class Direct extends Phalcon\Flash implements Phalcon\FlashInterface
{
/**
 * Outputs a message
 *
 * @param  string $type
 * @param  string $message
 * @return string
 */
public function message($type, $message) {}

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