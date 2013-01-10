<?php

namespace Phalcon\CLI;

/**
 * Phalcon\CLI\Dispatcher
 *
 * Dispatching is the process of taking the command-line arguments, extracting the module name,
 * task name, action name, and optional parameters contained in it, and then
 * instantiating a task and calling an action on it.
 *
 *<code>
 *
 *	$di = new Phalcon\DI();
 *
 *	$dispatcher = new Phalcon\CLI\Dispatcher();
 *
 *  $dispatcher->setDI($di);
 *
 *	$dispatcher->setTaskName('posts');
 *	$dispatcher->setActionName('index');
 *	$dispatcher->setParams(array());
 *
 *	$handle = $dispatcher->dispatch();
 *
 *</code>
 */
class Dispatcher extends Phalcon\Dispatcher implements Phalcon\Events\EventsAwareInterface, Phalcon\DI\InjectionAwareInterface, Phalcon\DispatcherInterface
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
 * Sets the default task suffix
 *
 * @param string $taskSuffix
 */
public function setTaskSuffix($taskSuffix) {}

/**
 * Sets the default task name
 *
 * @param string $taskName
 */
public function setDefaultTask($taskName) {}

/**
 * Sets the task name to be dispatched
 *
 * @param string $taskName
 */
public function setTaskName($taskName) {}

/**
 * Gets last dispatched task name
 *
 * @return string
 */
public function getTaskName() {}

/**
 * Throws an internal exception
 *
 * @param string $message
 * @param int $exceptionCode
 */
protected function _throwDispatchException() {}

/**
 * Returns the lastest dispatched controller
 *
 * @return Phalcon\CLI\Task
 */
public function getLastTask() {}

/**
 * Returns the active task in the dispatcher
 *
 * @return Phalcon\CLI\Task
 */
public function getActiveTask() {}

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