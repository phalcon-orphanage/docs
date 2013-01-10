<?php

namespace Phalcon\Mvc;

/**
 * Phalcon\Mvc\ModelInterface initializer
 */
interface ModelInterface {
/**
 * Phalcon\Mvc\Model constructor
 *
 * @param Phalcon\DiInterface $dependencyInjector
 * @param string $managerService
 * @param string $dbService
 */
public function __construct($dependencyInjector, $managerService, $dbService);

/**
 * Sets a transaction related to the Model instance
 *
 * @param Phalcon\Mvc\Model\TransactionInterface $transaction
 * @return Phalcon\Mvc\ModelInterface
 */
public function setTransaction($transaction);

/**
 * Returns table name mapped in the model
 *
 * @return string
 */
public function getSource();

/**
 * Returns schema name where table mapped is located
 *
 * @return string
 */
public function getSchema();

/**
 * Sets the DependencyInjection connection service
 *
 * @param string $connectionService
 */
public function setConnectionService($connectionService);

/**
 * Returns DependencyInjection connection service
 *
 * @return string
 */
public function getConnectionService();

/**
 * Gets internal database connection
 *
 * @return Phalcon\Db\AdapterInterface
 */
public function getConnection();

/**
 * Assigns values to a model from an array returning a new model
 *
 * @param array $result
 * @param Phalcon\Mvc\ModelInterface $base
 * @return Phalcon\Mvc\ModelInterface $result
 */
public static function dumpResult($base, $result);

/**
 * Allows to query a set of records that match the specified conditions
 *
 * @param 	array $parameters
 * @return  Phalcon\Mvc\Model\ResultsetInterface
 */
public static function find($parameters);

/**
 * Allows to query the first record that match the specified conditions
 *
 * @param array $parameters
 * @return Phalcon\Mvc\ModelInterface
 */
public static function findFirst($parameters);

/**
 * Create a criteria for a especific model
 *
 * @return Phalcon\Mvc\Model\CriteriaInterface
 */
public static function query($dependencyInjector);

/**
 * Allows to count how many records match the specified conditions
 *
 * @param array $parameters
 * @return int
 */
public static function count($parameters);

/**
 * Allows to a calculate a summatory on a column that match the specified conditions
 *
 * @param array $parameters
 * @return double
 */
public static function sum($parameters);

/**
 * Allows to get the maximum value of a column that match the specified conditions
 *
 * @param array $parameters
 * @return mixed
 */
public static function maximum($parameters);

/**
 * Allows to get the minimum value of a column that match the specified conditions
 *
 * @param array $parameters
 * @return mixed
 */
public static function minimum($parameters);

/**
 * Allows to calculate the average value on a column matching the specified conditions
 *
 * @param array $parameters
 * @return double
 */
public static function average($parameters);

/**
 * Appends a customized message on the validation process
 *
 * @param Phalcon\Mvc\Model\MessageInterface $message
 */
public function appendMessage($message);

/**
 * Check whether validation process has generated any messages
 *
 * @return boolean
 */
public function validationHasFailed();

/**
 * Returns all the validation messages
 *
 * @return Phalcon\Mvc\Model\MessageInterface[]
 */
public function getMessages();

/**
 * Inserts or updates a model instance. Returning true on success or false otherwise.
 *
 * @param  array $data
 * @return boolean
 */
public function save($data);

/**
 * Inserts a model instance. If the instance already exists in the persistance it will throw an exception
 * Returning true on success or false otherwise.
 *
 * @param  array $data
 * @return boolean
 */
public function create($data);

/**
 * Updates a model instance. If the instance doesn't exist in the persistance it will throw an exception
 * Returning true on success or false otherwise.
 *
 * @param  array $data
 * @return boolean
 */
public function update($data);

/**
 * Deletes a model instance. Returning true on success or false otherwise.
 *
 * @return boolean
 */
public function delete();

/**
 * Returns the type of the latest operation performed by the ORM
 * Returns one of the OP_* class constants
 *
 * @return int
 */
public function getOperationMade();

/**
 * Reads an attribute value by its name
 *
 * @param string $attribute
 * @return mixed
 */
public function readAttribute($attribute);

/**
 * Writes an attribute value by its name
 *
 * @param string $attribute
 * @param mixed $value
 */
public function writeAttribute($attribute, $value);

/**
 * Returns related records based on defined relations
 *
 * @param string $modelName
 * @param array $arguments
 * @return Phalcon\Mvc\Model\ResultsetInterface
 */
public function getRelated($modelName, $arguments);

}