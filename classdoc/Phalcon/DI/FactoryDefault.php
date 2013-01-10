<?php

namespace Phalcon\DI;

/**
 * Phalcon\DI\FactoryDefault
 *
 * This is a variant of the standard Phalcon\DI. By default it automatically
 * registers all the services provided by the framework. Thanks to this, the developer does not need
 * to register each service individually.
 */
class FactoryDefault extends Phalcon\DI implements Phalcon\DiInterface
{
/**
 * Phalcon\DI\FactoryDefault constructor
 */
public function __construct() {}

/**
 * Registers a service in the services container
 *
 * @param string $name
 * @param mixed $config
 * @param boolean $shared
 * @return Phalcon\Di\ServiceInterface
 */
public function set($name, $config, $shared) {}

/**
 * Registers an "always shared" service in the services container
 *
 * @param string $name
 * @param mixed $config
 * @return Phalcon\Di\ServiceInterface
 */
public function setShared($name, $config) {}

/**
 * Removes a service in the services container
 *
 * @param string $name
 */
public function remove($name) {}

/**
 * Attempts to register a service in the services container
 * Only is successful if a service hasn't been registered previously
 * with the same name
 *
 * @param string $name
 * @param mixed $config
 * @return Phalcon\Di\ServiceInterface
 */
public function attempt($name, $config, $shared) {}

/**
 * Returns a service definition without resolving
 *
 * @param string $name
 * @return mixed
 */
public function getRaw($name) {}

/**
 * Returns a Phalcon\Di\Service instance
 *
 * @return Phalcon\Di\ServiceInterface
 */
public function getService($name) {}

/**
 * Resolves the service based on its configuration
 *
 * @param string $name
 * @param array $parameters
 * @return mixed
 */
public function get($name, $parameters) {}

/**
 * Returns a shared service based on their configuration
 *
 * @param string $name
 * @param array $parameters
 * @return mixed
 */
public function getShared($name, $parameters) {}

/**
 * Check whether the DI contains a service by a name
 *
 * @param string $name
 * @return boolean
 */
public function has($name) {}

/**
 * Check whether the last service obtained via getShared produced a fresh instance or an existing one
 *
 * @return boolean
 */
public function wasFreshInstance() {}

/**
 * Return the services registered in the DI
 *
 * @return array
 */
public function getServices() {}

/**
 * Magic method to get or set services using setters/getters
 *
 * @param string $method
 * @param array $arguments
 * @return mixed
 */
public function __call($method, $arguments) {}

/**
 * Set a default dependency injection container to be obtained into static methods
 *
 * @param Phalcon\DiInterface $dependencyInjector
 */
public static function setDefault($dependencyInjector) {}

/**
 * Return the lastest DI created
 *
 * @return Phalcon\DiInterface
 */
public static function getDefault() {}

/**
 * Resets the internal default DI
 */
public static function reset() {}

}