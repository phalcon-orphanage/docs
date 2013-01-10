<?php

namespace Phalcon\Mvc\Model\Resultset;

/**
 * Phalcon\Mvc\Model\Resultset\Simple
 *
 * Simple resultsets only contains a complete object.
 * This class builds every complete object as it's required
 *
 */
class Simple extends Phalcon\Mvc\Model\Resultset implements Serializable, ArrayAccess, Countable, SeekableIterator, Traversable, Iterator, Phalcon\Mvc\Model\ResultsetInterface
{
/**
 * Phalcon\Mvc\Model\Resultset\Simple constructor
 *
 * @param array $columnsMap
 * @param Phalcon\Mvc\Model $model
 * @param Phalcon\Db\Result\Pdo $result
 * @param Phalcon\Cache\Backend $cache
 */
public function __construct($columnMap, $model, $result, $cache) {}

/**
 * Check whether internal resource has rows to fetch
 *
 * @return boolean
 */
public function valid() {}

/**
 * Serializing a resultset will dump all related rows into a big array
 *
 * @return string
 */
public function serialize() {}

/**
 * Unserializing a resultset will allow to only works on the rows present in the saved state
 *
 * @param string $data
 */
public function unserialize($data) {}

/**
 * Moves cursor to next row in the resultset
 *
 */
public function next() {}

/**
 * Gets pointer number of active row in the resultset
 *
 * @return int
 */
public function key() {}

/**
 * Rewinds resultset to its beginning
 *
 */
public function rewind() {}

/**
 * Changes internal pointer to a specific position in the resultset
 *
 * @param int $position
 */
public function seek($position) {}

/**
 * Counts how many rows are in the resultset
 *
 * @return int
 */
public function count() {}

/**
 * Checks whether offset exists in the resultset
 *
 * @param int $index
 * @return boolean
 */
public function offsetExists($index) {}

/**
 * Gets row in a specific position of the resultset
 *
 * @param int $index
 * @return Phalcon\Mvc\Model
 */
public function offsetGet($index) {}

/**
 * Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface
 *
 * @param int $index
 * @param Phalcon\Mvc\Model $value
 */
public function offsetSet($index, $value) {}

/**
 * Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface
 *
 * @param int $offset
 */
public function offsetUnset($offset) {}

/**
 * Get first row in the resultset
 *
 * @return Phalcon\Mvc\Model
 */
public function getFirst() {}

/**
 * Get last row in the resultset
 *
 * @return Phalcon\Mvc\Model
 */
public function getLast() {}

/**
 * Set if the resultset is fresh or an old one cached
 *
 * @param boolean $isFresh
 */
public function setIsFresh($isFresh) {}

/**
 * Tell if the resultset if fresh or an old one cached
 *
 * @return boolean
 */
public function isFresh() {}

/**
 * Returns the associated cache for the resultset
 *
 * @return Phalcon\Cache\Backend
 */
public function getCache() {}

/**
 * Returns current row in the resultset
 *
 * @return object
 */
public function current() {}

}