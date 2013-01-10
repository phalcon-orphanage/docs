<?php

namespace Phalcon\Cache\Backend;

/**
 * Phalcon\Cache\Backend\Memcache
 *
 * Allows to cache output fragments, PHP data or raw data to a memcache backend
 *
 * This adapter uses the special memcached key "_PHCM" to store all the keys internally used by the adapter
 *
 *<code>
 *
 * // Cache data for 2 days
 * $frontCache = new Phalcon\Cache\Frontend\Data(array(
 *    "lifetime" => 172800
 * ));
 *
 * //Create the Cache setting memcached connection options
 * $cache = new Phalcon\Cache\Backend\File($frontCache, array(
 *		'host' => 'localhost',
 *		'port' => 11211,
 *  	'persistent' => false
 * ));
 *
 * //Cache arbitrary data
 * $cache->store('my-data', array(1, 2, 3, 4, 5));
 *
 * //Get data
 * $data = $cache->get('my-data');
 *
 *</code>
 */
class Memcache extends Phalcon\Cache\Backend implements Phalcon\Cache\BackendInterface
{
/**
 * Phalcon\Cache\Backend\Memcache constructor
 *
 * @param Phalcon\Cache\FrontendInterface $frontend
 * @param array $options
 */
public function __construct($frontend, $options) {}

/**
 * Create internal connection to memcached
 */
protected function _connect() {}

/**
 * Returns a cached content
 *
 * @param int|string $keyName
 * @param   long $lifetime
 * @return  mixed
 */
public function get($keyName, $lifetime) {}

/**
 * Stores cached content into the Memcached backend and stops the frontend
 *
 * @param int|string $keyName
 * @param string $content
 * @param long $lifetime
 * @param boolean $stopBuffer
 */
public function save($keyName, $content, $lifetime, $stopBuffer) {}

/**
 * Deletes a value from the cache by its key
 *
 * @param int|string $keyName
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
 * Destructs the backend closing the memcached connection
 */
public function __destruct() {}

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