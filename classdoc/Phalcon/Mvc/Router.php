<?php

namespace Phalcon\Mvc;

/**
 * Phalcon\Mvc\Router
 *
 * <p>Phalcon\Mvc\Router is the standard framework router. Routing is the
 * process of taking a URI endpoint (that part of the URI which comes after the base URL) and
 * decomposing it into parameters to determine which module, controller, and
 * action of that controller should receive the request</p>
 *
 *<code>
 *	$router = new Phalcon\Mvc\Router();
 *	$router->handle();
 *	echo $router->getControllerName();
 *</code>
 *
 */
class Router implements Phalcon\Mvc\RouterInterface, Phalcon\DI\InjectionAwareInterface
{
/**
 * Phalcon\Mvc\Router constructor
 *
 * @param boolean $defaultRoutes
 */
public function __construct($defaultRoutes) {}

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
 * Get rewrite info
 *
 * @return string
 */
protected function _getRewriteUri() {}

/**
 * Sets the name of the default namespace
 *
 * @param string $namespaceName
 */
public function setDefaultNamespace($namespaceName) {}

/**
 * Sets the name of the default module
 *
 * @param string $moduleName
 */
public function setDefaultModule($moduleName) {}

/**
 * Sets the default controller name
 *
 * @param string $controllerName
 */
public function setDefaultController($controllerName) {}

/**
 * Sets the default action name
 *
 * @param string $actionName
 */
public function setDefaultAction($actionName) {}

/**
 * Sets an array of default paths
 *
 * @param array $defaults
 */
public function setDefaults($defaults) {}

/**
 * Handles routing information received from the rewrite engine
 *
 * @param string $uri
 */
public function handle($uri) {}

/**
 * Adds a route to the router on any HTTP method
 *
 * @param string $pattern
 * @param string/array $paths
 * @param string $httpMethods
 * @return Phalcon\Mvc\Router\Route
 */
public function add($pattern, $paths, $httpMethods) {}

/**
 * Adds a route to the router that only match if the HTTP method is GET
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\Route
 */
public function addGet($pattern, $paths) {}

/**
 * Adds a route to the router that only match if the HTTP method is POST
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\Route
 */
public function addPost($pattern, $paths) {}

/**
 * Adds a route to the router that only match if the HTTP method is PUT
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\Route
 */
public function addPut($pattern, $paths) {}

/**
 * Adds a route to the router that only match if the HTTP method is DELETE
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\Route
 */
public function addDelete($pattern, $paths) {}

/**
 * Add a route to the router that only match if the HTTP method is OPTIONS
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\Route
 */
public function addOptions($pattern, $paths) {}

/**
 * Adds a route to the router that only match if the HTTP method is HEAD
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\Route
 */
public function addHead($pattern, $paths) {}

/**
 * Removes all the pre-defined routes
 */
public function clear() {}

/**
 * Returns processed namespace name
 *
 * @return string
 */
public function getNamespaceName() {}

/**
 * Returns processed module name
 *
 * @return string
 */
public function getModuleName() {}

/**
 * Returns processed controller name
 *
 * @return string
 */
public function getControllerName() {}

/**
 * Returns processed action name
 *
 * @return string
 */
public function getActionName() {}

/**
 * Returns processed extra params
 *
 * @return array
 */
public function getParams() {}

/**
 * Returns the route that matchs the handled URI
 *
 * @return Phalcon\Mvc\Router\Route
 */
public function getMatchedRoute() {}

/**
 * Return the sub expressions in the regular expression matched
 *
 * @return array
 */
public function getMatches() {}

/**
 * Check if the router macthes any of the defined routes
 *
 * @return bool
 */
public function wasMatched() {}

/**
 * Return all the routes defined in the router
 *
 * @return Phalcon\Mvc\Router\Route[]
 */
public function getRoutes() {}

/**
 * Returns a route object by its id
 *
 * @return Phalcon\Mvc\Router\Route
 */
public function getRouteById($id) {}

/**
 * Returns a route object by its name
 *
 * @return Phalcon\Mvc\Router\Route
 */
public function getRouteByName($name) {}

}