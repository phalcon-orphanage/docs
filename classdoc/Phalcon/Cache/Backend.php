<?php

namespace Phalcon\Cache;

/**
 * Phalcon\Cache\Backend
 *
 * This class implements common functionality for backend adapters. All the backend cache adapter must
 * extend this class
 */
abstract class Backend {
/**
 * Phalcon\Cache\Backend constructor
 *
 * @param Phalcon\Cache\FrontendInterface $frontend
 * @param array $options
 */
public function __construct($frontend, $options) {}

/**
 * Starts a cache. The $keyname allows to identify the created fragment
 *
 * @param int|string $keyName
 * @return  mixed
 */
public function start($keyName) {}

/**
 * Stops the frontend without store any cached content
 *
 * @param boolean $stopBuffer
 */
public function stop($stopBuffer) {}

/**
 * Returns front-end instance adapter related to the back-end
 *
 * @return mixed
 */
public function getFrontend() {}

/**
 * Returns the backend options
 *
 * @return array
 */
public function getOptions() {}

/**
 * Checks whether the last cache is fresh or cached
 *
 * @return boolean
 */
public function isFresh() {}

/**
 * Checks whether the cache has starting buffering or not
 *
 * @return boolean
 */
public function isStarted() {}

/**
 * Sets the last key used in the cache
 *
 * @param string $lastKey
 */
public function setLastKey($lastKey) {}

/**
 * Gets the last key stored by the cache
 *
 * @return string
 */
public function getLastKey() {}

}