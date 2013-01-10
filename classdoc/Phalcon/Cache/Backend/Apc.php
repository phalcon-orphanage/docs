<?php

namespace Phalcon\Cache\Backend;

/**
 * Phalcon\Cache\Backend\Apc
 *
 * Allows to cache output fragments, PHP data and raw data using a memcache backend
 *
 *<code>
 *
 *	//Cache data for 2 days
 *	$frontendOptions = array(
 *		'lifetime' => 172800
 *	);
 *
 *	//Cache data for 2 days
 *	$frontCache = new Phalcon\Cache\Frontend\Data(array(
 *		'lifetime' => 172800
 *	));
 *
 *  $cache = new Phalcon\Cache\Backend\Apc($frontCache);
 *
 *	//Cache arbitrary data
 *	$cache->store('my-data', array(1, 2, 3, 4, 5));
 *
 *	//Get data
 *	$data = $cache->get('my-data');
 *
 *</code>
 */
class Apc extends Phalcon\Cache\Backend implements Phalcon\Cache\BackendInterface
{
/**
 * Returns a cached content
 *
 * @param 	string $keyName
 * @param   long $lifetime
 * @return  mixed
 */
public function get($keyName, $lifetime) {}

/**
 * Stores cached content into the APC backend and stops the frontend
 *
 * @param string $keyName
 * @param string $content
 * @param long $lifetime
 * @param boolean $stopBuffer
 */
public function save($keyName, $content, $lifetime, $stopBuffer) {}

/**
 * Deletes a value from the cache by its key
 *
 * @param string $keyName
 * @return boolean
 */
public function delete($keyName) {}

/**
 * Query the existing cached keys
 *
 * @param string $prefix
 * @return array
 */
public function queryKeys($prefix) {}

/**
 * Checks if cache exists and it hasn't expired
 *
 * @param  string $keyName
 * @param  long $lifetime
 * @return boolean
 */
public function exists($keyName, $lifetime) {}

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