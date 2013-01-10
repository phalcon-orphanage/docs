<?php

namespace Phalcon\CLI;

/**
 * Phalcon\CLI\Console
 *
 * This component allows to create CLI applications using Phalcon
 */
class Console implements Phalcon\DI\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface
{
/**
 * Sets the DependencyInjector container
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
 * Register an array of modules present in the console
 *
 *<code>
 *	$this->registerModules(array(
 *		'frontend' => array(
 *			'className' => 'Multiple\Frontend\Module',
 *			'path' => '../apps/frontend/Module.php'
 *		),
 *		'backend' => array(
 *			'className' => 'Multiple\Backend\Module',
 *			'path' => '../apps/backend/Module.php'
 *		)
 *	));
 *</code>
 *
 * @param array $modules
 */
public function registerModules($modules) {}

/**
 * Merge modules with the existing ones
 *
 * @param array $modules
 */
public function addModules($modules) {}

/**
 * Return the modules registered in the console
 *
 * @return array
 */
public function getModules() {}

/**
 * Handle the whole command-line tasks
 *
 * @param array $arguments
 * @return mixed
 */
public function handle($arguments) {}

}