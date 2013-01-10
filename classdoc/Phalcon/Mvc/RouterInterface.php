<?php

namespace Phalcon\Mvc;

/**
 * Phalcon\Mvc\RouterInterface initializer
 */
interface RouterInterface {
/**
 * Sets the name of the default module
 *
 * @param string $moduleName
 */
public function setDefaultModule($moduleName);

/**
 * Sets the default controller name
 *
 * @param string $controllerName
 */
public function setDefaultController($controllerName);

/**
 * Sets the default action name
 *
 * @param string $actionName
 */
public function setDefaultAction($actionName);

/**
 * Sets an array of default paths
 *
 * @param array $defaults
 */
public function setDefaults($defaults);

/**
 * Handles routing information received from the rewrite engine
 *
 * @param string $uri
 */
public function handle($uri);

/**
 * Adds a route to the router on any HTTP method
 *
 * @param string $pattern
 * @param string/array $paths
 * @param string $httpMethods
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function add($pattern, $paths, $httpMethods);

/**
 * Adds a route to the router that only match if the HTTP method is GET
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function addGet($pattern, $paths);

/**
 * Adds a route to the router that only match if the HTTP method is POST
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function addPost($pattern, $paths);

/**
 * Adds a route to the router that only match if the HTTP method is PUT
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function addPut($pattern, $paths);

/**
 * Adds a route to the router that only match if the HTTP method is DELETE
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function addDelete($pattern, $paths);

/**
 * Add a route to the router that only match if the HTTP method is OPTIONS
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function addOptions($pattern, $paths);

/**
 * Adds a route to the router that only match if the HTTP method is HEAD
 *
 * @param string $pattern
 * @param string/array $paths
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function addHead($pattern, $paths);

/**
 * Removes all the defined routes
 */
public function clear();

/**
 * Returns processed module name
 *
 * @return string
 */
public function getModuleName();

/**
 * Returns processed controller name
 *
 * @return string
 */
public function getControllerName();

/**
 * Returns processed action name
 *
 * @return string
 */
public function getActionName();

/**
 * Returns processed extra params
 *
 * @return array
 */
public function getParams();

/**
 * Returns the route that matchs the handled URI
 *
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function getMatchedRoute();

/**
 * Return the sub expressions in the regular expression matched
 *
 * @return array
 */
public function getMatches();

/**
 * Check if the router macthes any of the defined routes
 *
 * @return bool
 */
public function wasMatched();

/**
 * Return all the routes defined in the router
 *
 * @return Phalcon\Mvc\Router\RouteInterface[]
 */
public function getRoutes();

/**
 * Returns a route object by its id
 *
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function getRouteById($id);

/**
 * Returns a route object by its name
 *
 * @return Phalcon\Mvc\Router\RouteInterface
 */
public function getRouteByName($name);

}