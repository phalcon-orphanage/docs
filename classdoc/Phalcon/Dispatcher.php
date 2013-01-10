<?php

namespace Phalcon;

/**
 * Phalcon\Dispatcher
 *
 * This is the base class for Phalcon\Mvc\Dispatcher and Phalcon\CLI\Dispatcher.
 * This class can't be instantiated directly, you can use it to create your own dispatchers
 */
abstract class Dispatcher implements Phalcon\DispatcherInterface, Phalcon\DI\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface
{
/** @type integer */
const EXCEPTION_NO_DI = 0;

/** @type integer */
const EXCEPTION_CYCLIC_ROUTING = 1;

/** @type integer */
const EXCEPTION_HANDLER_NOT_FOUND = 2;

/** @type integer */
const EXCEPTION_INVALID_HANDLER = 3;

/** @type integer */
const EXCEPTION_INVALID_PARAMS = 4;

/** @type integer */
const EXCEPTION_ACTION_NOT_FOUND = 5;

/**
 * Phalcon\Dispatcher constructor
 */
public function __construct() {}

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
 * Sets the events manager
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
 * Sets the default action suffix
 *
 * @param string $actionSuffix
 */
public function setActionSuffix($actionSuffix) {}

/**
 * Sets a namespace to be prepended to the handler name
 *
 * @param string $namespaceName
 */
public function setNamespaceName($namespaceName) {}

/**
 * Gets a namespace to be prepended to the current handler name
 *
 * @return string
 */
public function getNamespaceName() {}

/**
 * Sets the default namespace
 *
 * @param string $namespace
 */
public function setDefaultNamespace($namespace) {}

/**
 * Returns the default namespace
 *
 * @return string
 */
public function getDefaultNamespace() {}

/**
 * Sets the default action name
 *
 * @param string $actionName
 */
public function setDefaultAction($actionName) {}

/**
 * Sets the action name to be dispatched
 *
 * @param string $actionName
 */
public function setActionName($actionName) {}

/**
 * Gets last dispatched action name
 *
 * @return string
 */
public function getActionName() {}

/**
 * Sets action params to be dispatched
 *
 * @param array $params
 */
public function setParams($params) {}

/**
 * Gets action params
 *
 * @return array
 */
public function getParams() {}

/**
 * Set a param by its name or numeric index
 *
 * @param  mixed $param
 * @param  mixed $value
 */
public function setParam($param, $value) {}

/**
 * Gets a param by its name or numeric index
 *
 * @param  mixed $param
 * @param  string|array $filters
 * @param  mixed $defaultValue
 * @return mixed
 */
public function getParam($param, $filters, $defaultValue) {}

/**
 * Checks if the dispatch loop is finished or has more pendent controllers/tasks to disptach
 *
 * @return boolean
 */
public function isFinished() {}

/**
 * Returns value returned by the lastest dispatched action
 *
 * @return mixed
 */
public function getReturnedValue() {}

/**
 * Dispatches a handle action taking into account the routing parameters
 *
 * @return object
 */
public function dispatch() {}

/**
 * Forwards the execution flow to another controller/action
 *
 * @param array $forward
 */
public function forward($forward) {}

}