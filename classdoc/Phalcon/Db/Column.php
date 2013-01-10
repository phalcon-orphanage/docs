<?php

namespace Phalcon\Db;

/**
 * Phalcon\Db\Column
 *
 * Allows to define columns to be used on create or alter table operations
 *
 *<code>
 *	use Phalcon\Db\Column as Column;
 *
 * //column definition
 * $column = new Column("id", array(
 *   "type" => Column::TYPE_INTEGER,
 *   "size" => 10,
 *   "unsigned" => true,
 *   "notNull" => true,
 *   "autoIncrement" => true,
 *   "first" => true
 * ));
 *
 * //add column to existing table
 * $connection->addColumn("robots", null, $column);
 *</code>
 *
 */
class Column implements Phalcon\Db\ColumnInterface
{
/** @type integer */
const TYPE_INTEGER = 0;

/** @type integer */
const TYPE_DATE = 1;

/** @type integer */
const TYPE_VARCHAR = 2;

/** @type integer */
const TYPE_DECIMAL = 3;

/** @type integer */
const TYPE_DATETIME = 4;

/** @type integer */
const TYPE_CHAR = 5;

/** @type integer */
const TYPE_TEXT = 6;

/** @type integer */
const TYPE_FLOAT = 7;

/** @type integer */
const BIND_PARAM_NULL = 0;

/** @type integer */
const BIND_PARAM_INT = 1;

/** @type integer */
const BIND_PARAM_STR = 2;

/** @type integer */
const BIND_PARAM_DECIMAL = 32;

/** @type integer */
const BIND_SKIP = 1024;

/**
 * Phalcon\Db\Column constructor
 *
 * @param string $columnName
 * @param array $definition
 */
public function __construct($columnName, $definition) {}

/**
 * Returns schema's table related to column
 *
 * @return string
 */
public function getSchemaName() {}

/**
 * Returns column name
 *
 * @return string
 */
public function getName() {}

/**
 * Returns column type
 *
 * @return int
 */
public function getType() {}

/**
 * Returns column size
 *
 * @return int
 */
public function getSize() {}

/**
 * Returns column scale
 *
 * @return int
 */
public function getScale() {}

/**
 * Returns true if number column is unsigned
 *
 * @return boolean
 */
public function isUnsigned() {}

/**
 * Not null
 *
 * @return boolean
 */
public function isNotNull() {}

/**
 * Column is part of the primary key?
 *
 * @return boolean
 */
public function isPrimary() {}

/**
 * Auto-Increment
 *
 * @return boolean
 */
public function isAutoIncrement() {}

/**
 * Check whether column have an numeric type
 *
 * @return boolean
 */
public function isNumeric() {}

/**
 * Check whether column have first position in table
 *
 * @return boolean
 */
public function isFirst() {}

/**
 * Check whether field absolute to position in table
 *
 * @return string
 */
public function getAfterPosition() {}

/**
 * Returns the type of bind handling
 *
 * @return int
 */
public function getBindType() {}

/**
 * Restores the internal state of a Phalcon\Db\Column object
 *
 * @param array $data
 * @return \Phalcon\Db\Column
 */
public static function __set_state($data) {}

}