<?php

namespace Phalcon\Mvc;

/**
 * Phalcon\Mvc\DispatcherInterface initializer
 */
interface DispatcherInterface extends Phalcon\DispatcherInterface {
/**
 * Sets the default controller suffix
 *
 * @param string $controllerSuffix
 */
public function setControllerSuffix($controllerSuffix);

/**
 * Sets the default controller name
 *
 * @param string $controllerName
 */
public function setDefaultController($controllerName);

/**
 * Sets the controller name to be dispatched
 *
 * @param string $controllerName
 */
public function setControllerName($controllerName);

/**
 * Gets last dispatched controller name
 *
 * @return string
 */
public function getControllerName();

/**
 * Returns the lastest dispatched controller
 *
 * @return Phalcon\Mvc\ControllerInterface
 */
public function getLastController();

/**
 * Returns the active controller in the dispatcher
 *
 * @return Phalcon\Mvc\ControllerInterface
 */
public function getActiveController();

/**
 * Sets the default action suffix
 *
 * @param string $actionSuffix
 */
public function setActionSuffix($actionSuffix);

/**
 * Sets the default namespace
 *
 * @param string $namespace
 */
public function setDefaultNamespace($namespace);

/**
 * Sets the default action name
 *
 * @param string $actionName
 */
public function setDefaultAction($actionName);

/**
 * Sets the action name to be dispatched
 *
 * @param string $actionName
 */
public function setActionName($actionName);

/**
 * Gets last dispatched action name
 *
 * @return string
 */
public function getActionName();

/**
 * Sets action params to be dispatched
 *
 * @param array $params
 */
public function setParams($params);

/**
 * Gets action params
 *
 * @return array
 */
public function getParams();

/**
 * Set a param by its name or numeric index
 *
 * @param  mixed $param
 * @param  mixed $value
 */
public function setParam($param, $value);

/**
 * Gets a param by its name or numeric index
 *
 * @param  mixed $param
 * @param  string|array $filters
 * @return mixed
 */
public function getParam($param, $filters);

/**
 * Checks if the dispatch loop is finished or has more pendent controllers/tasks to disptach
 *
 * @return boolean
 */
public function isFinished();

/**
 * Returns value returned by the lastest dispatched action
 *
 * @return mixed
 */
public function getReturnedValue();

/**
 * Dispatches a handle action taking into account the routing parameters
 *
 * @return object
 */
public function dispatch();

/**
 * Forwards the execution flow to another controller/action
 *
 * @param array $forward
 */
public function forward($forward);

}