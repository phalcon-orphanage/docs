<?php

namespace Phalcon\Cache\Backend;

/**
 * Phalcon\Cache\Backend\File
 *
 * Allows to cache output fragments using a file backend
 *
 *<code>
 *	//Cache the file for 2 days
 *	$frontendOptions = array(
 *		'lifetime' => 172800
 *	);
 *
 *	//Set the cache directory
 *	$backendOptions = array(
 *		'cacheDir' => '../app/cache/'
 *	);
 *
 *	$cache = Phalcon_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
 *
 *	$content = $cache->start('my-cache');
 *	if($content===null){
 *  	echo '<h1>', time(), '</h1>';
 *  	$cache->save();
 *	} else {
 *		echo $content;
 *	}
 *</code>
 */
class File extends Phalcon\Cache\Backend implements Phalcon\Cache\BackendInterface
{
/**
 * Phalcon\Cache\Backend\File constructor
 *
 * @param Phalcon\Cache\FrontendInterface $frontend
 * @param array $options
 */
public function __construct($frontend, $options) {}

/**
 * Returns a cached content
 *
 * @param int|string $keyName
 * @param   long $lifetime
 * @return  mixed
 */
public function get($keyName, $lifetime) {}

/**
 * Stores cached content into the file backend and stops the frontend
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
 * Checks if cache exists and it isn't expired
 *
 * @param string $keyName
 * @param   long $lifetime
 * @return boolean
 */
public function exists($keyName, $lifetime) {}

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