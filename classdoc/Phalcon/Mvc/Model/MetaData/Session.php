<?php

namespace Phalcon\Mvc\Model\MetaData;

/**
 * Phalcon\Mvc\Model\MetaData\Session
 *
 * Stores model meta-data in session. Data will erased when the session finishes.
 * Meta-data are permanent while the session is active.
 *
 * You can query the meta-data by printing $_SESSION['$PMM$']
 *
 *<code>
 * $metaData = new Phalcon\Mvc\Model\Metadata\Session(array(
 *    'suffix' => 'my-app-id'
 * ));
 *</code>
 */
class Session extends Phalcon\Mvc\Model\MetaData implements Phalcon\Mvc\Model\MetaDataInterface
{
/** @type integer */
const MODELS_ATTRIBUTES = 0;

/** @type integer */
const MODELS_PRIMARY_KEY = 1;

/** @type integer */
const MODELS_NON_PRIMARY_KEY = 2;

/** @type integer */
const MODELS_NOT_NULL = 3;

/** @type integer */
const MODELS_DATA_TYPES = 4;

/** @type integer */
const MODELS_DATA_TYPES_NUMERIC = 5;

/** @type integer */
const MODELS_DATE_AT = 6;

/** @type integer */
const MODELS_DATE_IN = 7;

/** @type integer */
const MODELS_IDENTITY_COLUMN = 8;

/** @type integer */
const MODELS_DATA_TYPES_BIND = 9;

/** @type integer */
const MODELS_AUTOMATIC_DEFAULT_INSERT = 10;

/** @type integer */
const MODELS_AUTOMATIC_DEFAULT_UPDATE = 11;

/** @type integer */
const MODELS_COLUMN_MAP = 0;

/** @type integer */
const MODELS_REVERSE_COLUMN_MAP = 1;

/**
 * Phalcon\Mvc\Model\MetaData\Session constructor
 *
 * @param array $options
 */
public function __construct($options) {}

/**
 * Reads meta-data from $_SESSION
 *
 * @return array
 */
public function read($key) {}

/**
 * Writes the meta-data to $_SESSION
 *
 * @param string $key
 * @param array $data
 */
public function write($key, $data) {}

/**
 * Initialize the metadata for certain table
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @param string $key
 * @param string $table
 * @param string $schema
 */
protected function _initialize() {}

/**
 * Reads meta-data for certain model
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function readMetaData($model) {}

/**
 * Reads meta-data for certain model using a MODEL_* constant
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @param int $index
 */
public function readMetaDataIndex($model, $index) {}

/**
 * Writes meta-data for certain model using a MODEL_* constant
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @param int $index
 * @param mixed $data
 */
public function writeMetaDataIndex($model, $index, $data) {}

/**
 * Reads the ordered/reversed column map for certain model
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function readColumnMap($model) {}

/**
 * Reads column-map information for certain model using a MODEL_* constant
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @param int $index
 */
public function readColumnMapIndex($model, $index) {}

/**
 * Returns table attributes names (fields)
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return 	array
 */
public function getAttributes($model) {}

/**
 * Returns an array of fields which are part of the primary key
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getPrimaryKeyAttributes($model) {}

/**
 * Returns an arrau of fields which are not part of the primary key
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return 	array
 */
public function getNonPrimaryKeyAttributes($model) {}

/**
 * Returns an array of not null attributes
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getNotNullAttributes($model) {}

/**
 * Returns attributes and their data types
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getDataTypes($model) {}

/**
 * Returns attributes which types are numerical
 *
 * @param  Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getDataTypesNumeric($model) {}

/**
 * Returns the name of identity field (if one is present)
 *
 * @param  Phalcon\Mvc\ModelInterface $model
 * @return string
 */
public function getIdentityField($model) {}

/**
 * Returns attributes and their bind data types
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getBindTypes($model) {}

/**
 * Returns attributes that must be ignored from the INSERT SQL generation
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getAutomaticCreateAttributes($model) {}

/**
 * Returns attributes that must be ignored from the UPDATE SQL generation
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getAutomaticUpdateAttributes($model) {}

/**
 * Set the attributes that must be ignored from the INSERT SQL generation
 *
 * @param  Phalcon\Mvc\ModelInterface $model
 * @param  array $attributes
 */
public function setAutomaticCreateAttributes($model, $attributes) {}

/**
 * Set the attributes that must be ignored from the UPDATE SQL generation
 *
 * @param  Phalcon\Mvc\ModelInterface $model
 * @param  array $attributes
 */
public function setAutomaticUpdateAttributes($model, $attributes) {}

/**
 * Returns the column map if any
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getColumnMap($model) {}

/**
 * Returns the reverse column map if any
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return array
 */
public function getReverseColumnMap($model) {}

/**
 * Check if a model has certain attribute
 *
 * @param Phalcon\Mvc\ModelInterface $model
 * @return boolean
 */
public function hasAttribute($model, $attribute) {}

/**
 * Checks if the internal meta-data container is empty
 *
 * @return boolean
 */
public function isEmpty() {}

/**
 * Resets internal meta-data in order to regenerate it
 */
public function reset() {}

}