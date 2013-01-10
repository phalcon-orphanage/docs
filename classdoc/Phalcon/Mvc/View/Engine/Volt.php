<?php

namespace Phalcon\Mvc\View\Engine;

/**
 * Phalcon\Mvc\View\Engine\Volt
 *
 * Designer friendly and fast template engine for PHP written in C
 */
class Volt extends Phalcon\Mvc\View\Engine implements Phalcon\DI\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Mvc\View\EngineInterface
{
/**
 * Sets the dependency injection container
 *
 * @param Phalcon\DiInterface $dependencyInjector
 */
public function setDI($dependencyInjector) {}

/**
 * Returns the dependency injection container
 *
 * @return Phalcon\DiInterface
 */
public function getDI() {}

/**
 * Set Volt's options
 *
 * @param array $options
 */
public function setOptions($options) {}

/**
 * Return Volt's options
 *
 * @return array
 */
public function getOptions() {}

/**
 * Renders a view using the template engine
 *
 * @param string $templatePath
 * @param array $params
 * @param boolean $mustClean
 */
public function render($templatePath, $params, $mustClean) {}

/**
 * Length filter
 *
 * @param mixed $item
 * @return int
 */
public function length($item) {}

/**
 * Phalcon\Mvc\View\Engine constructor
 *
 * @param Phalcon\Mvc\ViewInterface $view
 * @param Phalcon\DiInterface $dependencyInjector
 */
public function __construct($view, $dependencyInjector) {}

/**
 * Returns cached ouput on another view stage
 *
 * @return array
 */
public function getContent() {}

/**
 * Renders a partial inside another view
 *
 * @param string $partialPath
 * @return string
 */
public function partial($partialPath) {}

/**
 * Sets the event manager
 *
 * @param Phalcon\Events\ManagerInterface $eventsManager
 */
public function setEventsManager($eventsManager) {}

/**
 * Returns the internal event manager
 *
 * @return Phalcon\Events\ManagerInterface
 */
public function getEventsManager() {}

/**
 * Magic method __get
 *
 * @param string $propertyName
 */
public function __get($propertyName) {}

}