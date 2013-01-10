<?php

namespace Phalcon\Translate;

/**
 * Phalcon\Translate\AdapterInterface initializer
 */
interface AdapterInterface {
/**
 * Phalcon\Translate\Adapter\NativeArray constructor
 *
 * @param array $data
 */
public function __construct($options);

/**
 * Returns the translation string of the given key
 *
 * @param string $translateKey
 * @param array $placeholders
 * @return string
 */
public function _($translateKey, $placeholders);

/**
 * Returns the translation related to the given key
 *
 * @param string $index
 * @param array $placeholders
 * @return string
 */
public function query($index, $placeholders);

/**
 * Check whether is defined a translation key in the internal array
 *
 * @param 	string $index
 * @return bool
 */
public function exists($index);

}