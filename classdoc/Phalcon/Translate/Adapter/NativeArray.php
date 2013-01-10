<?php

namespace Phalcon\Translate\Adapter;

/**
 * Phalcon\Translate\Adapter\NativeArray
 *
 * Allows to define translation lists using PHP arrays
 *
 */
class NativeArray extends Phalcon\Translate\Adapter implements ArrayAccess, Phalcon\Translate\AdapterInterface
{
/**
 * Phalcon\Translate\Adapter\NativeArray constructor
 *
 * @param array $options
 */
public function __construct($options) {}

/**
 * Returns the translation related to the given key
 *
 * @param string $index
 * @param array $placeholders
 * @return string
 */
public function query($index, $placeholders) {}

/**
 * Check whether is defined a translation key in the internal array
 *
 * @param 	string $index
 * @return bool
 */
public function exists($index) {}

/**
 * Returns the translation string of the given key
 *
 * @param string $translateKey
 * @param array $placeholders
 * @return string
 */
public function _($translateKey, $placeholders) {}

/**
 * Sets a translation value
 *
 * @param 	string $offset
 * @param 	string $value
 */
public function offsetSet($offset, $value) {}

/**
 * Check whether a translation key exists
 *
 * @param string $translateKey
 * @return boolean
 */
public function offsetExists($translateKey) {}

/**
 * Elimina un indice del diccionario
 *
 * @param string $offset
 */
public function offsetUnset($offset) {}

/**
 * Returns the translation related to the given key
 *
 * @param string $traslateKey
 * @return string
 */
public function offsetGet($traslateKey) {}

}