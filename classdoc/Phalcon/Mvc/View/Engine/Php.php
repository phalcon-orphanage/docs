<?php

namespace Phalcon\Mvc\View\Engine;

/**
 * Phalcon\Mvc\View\Engine\Php
 *
 * Adapter to use PHP itself as templating engine
 */
class Php extends Phalcon\Mvc\View\Engine implements Phalcon\DI\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Mvc\View\EngineInterface
{
/**
 * Renders a view using the template engine
 *
 * @param string $path
 * @param array $params
 * @param boolean $mustClean
 */
public function render($path, $params, $mustClean) {}

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