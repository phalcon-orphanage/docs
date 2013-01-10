<?php

namespace Phalcon\Db\Adapter\Pdo;

/**
 * Phalcon\Db\Adapter\Pdo\Sqlite
 *
 * Specific functions for the Sqlite database system
 * <code>
 *
 * $config = array(
 *  "dbname" => "/tmp/test.sqlite"
 * );
 *
 * $connection = new Phalcon\Db\Adapter\Pdo\Sqlite($config);
 *
 * </code>
 */
class Sqlite extends Phalcon\Db\Adapter\Pdo implements Phalcon\Events\EventsAwareInterface, Phalcon\Db\AdapterInterface
{
/**
 * This method is automatically called in Phalcon\Db\Adapter\Pdo constructor.
 * Call it when you need to restore a database connection.
 *
 * @param array $descriptor
 * @return boolean
 */
public function connect($descriptor) {}

/**
 * Returns an array of Phalcon\Db\Column objects describing a table
 *
 * <code>
 * print_r($connection->describeColumns("posts")); ?>
 * </code>
 *
 * @param string $table
 * @param string $schema
 * @return Phalcon\Db\Column[]
 */
public function describeColumns($table, $schema) {}

/**
 * Lists table indexes
 *
 * @param string $table
 * @param string $schema
 * @return Phalcon\Db\Index[]
 */
public function describeIndexes($table, $schema) {}

/**
 * Lists table references
 *
 * @param string $table
 * @param string $schema
 * @return Phalcon\Db\Reference[]
 */
public function describeReferences($table, $schema) {}

/**
 * Constructor for Phalcon\Db\Adapter\Pdo
 *
 * @param array $descriptor
 */
public function __construct($descriptor) {}

/**
 * Executes a prepared statement binding
 *
 * @param \PDOStatement $statement
 * @param array $placeholders
 * @param array $dataTypes
 * @return \PDOStatement
 */
public function executePrepared($statement, $placeholders, $dataTypes) {}

/**
 * Sends SQL statements to the database server returning the success state.
 * Use this method only when the SQL statement sent to the server is returning rows
 *
 *<code>
 *	//Querying data
 *	$resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'");</code>
 *	$resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));
 *</code>
 *
 * @param  string $sqlStatement
 * @param  array $bindParams
 * @param  array $bindTypes
 * @return Phalcon\Db\ResultInterface
 */
public function query($sqlStatement, $bindParams, $bindTypes) {}

/**
 * Sends SQL statements to the database server returning the success state.
 * Use this method only when the SQL statement sent to the server don't return any row
 *
 *<code>
 *	//Inserting data
 *	$success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
 *	$success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));
 *</code>
 *
 * @param  string $sqlStatement
 * @param  array $placeholders
 * @param  array $dataTypes
 * @return boolean
 */
public function execute($sqlStatement, $bindParams, $bindTypes) {}

/**
 * Returns the number of affected rows by the last INSERT/UPDATE/DELETE reported by the database system
 *
 *<code>
 *	$connection->query("DELETE FROM robots");
 *	echo $connection->affectedRows(), ' were deleted';
 *</code>
 *
 * @return int
 */
public function affectedRows() {}

/**
 * Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\Db\Pool
 *
 * @return boolean
 */
public function close() {}

/**
 * Escapes a column/table/schema name
 *
 * @param string $identifier
 * @return string
 */
public function escapeIdentifier($identifier) {}

/**
 * Escapes a value to avoid SQL injections
 *
 * @param string $str
 * @return string
 */
public function escapeString($str) {}

/**
 * Bind params to a SQL statement
 *
 * @param string $sql
 * @param array $params
 */
public function bindParams($sqlStatement, $params) {}

/**
 * Converts bound params such as :name: or ?1 into PDO bind params ?
 *
 * @param string $sql
 * @param array $params
 * @return array
 */
public function convertBoundParams($sql, $params) {}

/**
 * Returns insert id for the auto_increment column inserted in the last SQL statement
 *
 * @param string $sequenceName
 * @return int
 */
public function lastInsertId($sequenceName) {}

/**
 * Starts a transaction in the connection
 *
 * @return boolean
 */
public function begin() {}

/**
 * Rollbacks the active transaction in the connection
 *
 * @return boolean
 */
public function rollback() {}

/**
 * Commits the active transaction in the connection
 *
 * @return boolean
 */
public function commit() {}

/**
 * Checks whether connection is under database transaction
 *
 * @return boolean
 */
public function isUnderTransaction() {}

/**
 * Return internal PDO handler
 *
 * @return \PDO
 */
public function getInternalHandler() {}

/**
 * Gets creation options from a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @return array
 */
public function tableOptions($tableName, $schemaName) {}

/**
 * Return the default identity value to insert in an identity column
 *
 * @return Phalcon\Db\RawValue
 */
public function getDefaultIdValue() {}

/**
 * Check whether the database system requires a sequence to produce auto-numeric values
 *
 * @return boolean
 */
public function supportSequences() {}

/**
 * Sets the event manager
 *
 * @param Phalcon\Events\ManagerInterface $eventsManager
 */
public function setEventsManager($eventsManager) {}

/**
 * Returns the internal event manager
 *
 * @return Phalcon\Events\ManagerInterface
 */
public function getEventsManager() {}

/**
 * Returns the first row in a SQL query result
 *
 *<code>
 *	//Getting first robot
 *	$robot = $connection->fecthOne("SELECT * FROM robots");
 *	print_r($robot);
 *
 *	//Getting first robot with associative indexes only
 *	$robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
 *	print_r($robot);
 *</code>
 *
 * @param string $sqlQuery
 * @param int $fetchMode
 * @param array $bindParams
 * @param array $bindTypes
 * @return array
 */
public function fetchOne($sqlQuery, $fetchMode, $bindParams, $bindTypes) {}

/**
 * Dumps the complete result of a query into an array
 *
 *<code>
 *	//Getting all robots
 *	$robots = $connection->fetchAll("SELECT * FROM robots");
 *	foreach($robots as $robot){
 *		print_r($robot);
 *	}
 *
 *	//Getting all robots with associative indexes only
 *	$robots = $connection->fetchAll("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
 *	foreach($robots as $robot){
 *		print_r($robot);
 *	}
 *</code>
 *
 * @param string $sqlQuery
 * @param int $fetchMode
 * @param array $bindParams
 * @param array $bindTypes
 * @return array
 */
public function fetchAll($sqlQuery, $fetchMode, $bindParams, $bindTypes) {}

/**
 * Inserts data into a table using custom RBDM SQL syntax
 *
 * <code>
 * //Inserting a new robot
 * $success = $connection->insert(
 *     "robots",
 *     array("Astro Boy", 1952),
 *     array("name", "year")
 * );
 *
 * //Next SQL sentence is sent to the database system
 * INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);
 * </code>
 *
 * @param 	string $table
 * @param 	array $values
 * @param 	array $fields
 * @param 	array $dataTypes
 * @return 	boolean
 */
public function insert($table, $values, $fields, $dataTypes) {}

/**
 * Updates data on a table using custom RBDM SQL syntax
 *
 * <code>
 * //Updating existing robot
 * $success = $connection->update(
 *     "robots",
 *     array("name")
 *     array("New Astro Boy"),
 *     "id = 101"
 * );
 *
 * //Next SQL sentence is sent to the database system
 * UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101
 * </code>
 *
 * @param 	string $table
 * @param 	array $fields
 * @param 	array $values
 * @param 	string $whereCondition
 * @param 	array $dataTypes
 * @return 	boolean
 */
public function update($table, $fields, $values, $whereCondition, $dataTypes) {}

/**
 * Deletes data from a table using custom RBDM SQL syntax
 *
 * <code>
 * //Deleting existing robot
 * $success = $connection->delete(
 *     "robots",
 *     "id = 101"
 * );
 *
 * //Next SQL sentence is generated
 * DELETE FROM `robots` WHERE `id` = 101
 * </code>
 *
 * @param  string $table
 * @param  string $whereCondition
 * @param  array $placeholders
 * @param  array $dataTypes
 * @return boolean
 */
public function delete($table, $whereCondition, $placeholders, $dataTypes) {}

/**
 * Gets a list of columns
 *
 * @param array $columnList
 * @return string
 */
public function getColumnList($columnList) {}

/**
 * Appends a LIMIT clause to $sqlQuery argument
 *
 * <code>
 * $connection->limit("SELECT * FROM robots", 5);
 * </code>
 *
 * @param  	string $sqlQuery
 * @param 	int $number
 * @return 	string
 */
public function limit($sqlQuery, $number) {}

/**
 * Generates SQL checking for the existence of a schema.table
 *
 * <code>
 * $connection->tableExists("blog", "posts")
 * </code>
 *
 * @param string $tableName
 * @param string $schemaName
 * @return string
 */
public function tableExists($tableName, $schemaName) {}

/**
 * Generates SQL checking for the existence of a schema.view
 *
 *<code>
 * $connection->viewExists("active_users", "posts")
 *</code>
 *
 * @param string $viewName
 * @param string $schemaName
 * @return string
 */
public function viewExists($viewName, $schemaName) {}

/**
 * Returns a SQL modified with a FOR UPDATE clause
 *
 * @param string $sqlQuery
 * @return string
 */
public function forUpdate($sqlQuery) {}

/**
 * Returns a SQL modified with a LOCK IN SHARE MODE clause
 *
 * @param string $sqlQuery
 * @return string
 */
public function sharedLock($sqlQuery) {}

/**
 * Creates a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param array $definition
 * @return boolean
 */
public function createTable($tableName, $schemaName, $definition) {}

/**
 * Drops a table from a schema/database
 *
 * @param string $tableName
 * @param   string $schemaName
 * @param boolean $ifExists
 * @return boolean
 */
public function dropTable($tableName, $schemaName, $ifExists) {}

/**
 * Adds a column to a table
 *
 * @param string $tableName
 * @param 	string $schemaName
 * @param Phalcon\Db\ColumnInterface $column
 * @return boolean
 */
public function addColumn($tableName, $schemaName, $column) {}

/**
 * Modifies a table column based on a definition
 *
 * @param string $tableName
 * @param string $schemaName
 * @param Phalcon\Db\ColumnInterface $column
 * @return 	boolean
 */
public function modifyColumn($tableName, $schemaName, $column) {}

/**
 * Drops a column from a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param string $columnName
 * @return 	boolean
 */
public function dropColumn($tableName, $schemaName, $columnName) {}

/**
 * Adds an index to a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param Phalcon\Db\IndexInterface $index
 * @return 	boolean
 */
public function addIndex($tableName, $schemaName, $index) {}

/**
 * Drop an index from a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param string $indexName
 * @return 	boolean
 */
public function dropIndex($tableName, $schemaName, $indexName) {}

/**
 * Adds a primary key to a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param Phalcon\Db\IndexInterface $index
 * @return 	boolean
 */
public function addPrimaryKey($tableName, $schemaName, $index) {}

/**
 * Drops primary key from a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @return 	boolean
 */
public function dropPrimaryKey($tableName, $schemaName) {}

/**
 * Adds a foreign key to a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param Phalcon\Db\ReferenceInterface $reference
 * @return boolean true
 */
public function addForeignKey($tableName, $schemaName, $reference) {}

/**
 * Drops a foreign key from a table
 *
 * @param string $tableName
 * @param string $schemaName
 * @param string $referenceName
 * @return boolean true
 */
public function dropForeignKey($tableName, $schemaName, $referenceName) {}

/**
 * Returns the SQL column definition from a column
 *
 * @param Phalcon\Db\ColumnInterface $column
 * @return string
 */
public function getColumnDefinition($column) {}

/**
 * List all tables on a database
 *
 * <code> print_r($connection->listTables("blog") ?></code>
 *
 * @param string $schemaName
 * @return array
 */
public function listTables($schemaName) {}

/**
 * Return descriptor used to connect to the active database
 *
 * @return array
 */
public function getDescriptor() {}

/**
 * Gets the active connection unique identifier
 *
 * @return string
 */
public function getConnectionId() {}

/**
 * Active SQL statement in the object
 *
 * @return string
 */
public function getSQLStatement() {}

/**
 * Active SQL statement in the object without replace bound paramters
 *
 * @return string
 */
public function getRealSQLStatement() {}

/**
 * Active SQL statement in the object
 *
 * @return array
 */
public function getSQLVariables() {}

/**
 * Active SQL statement in the object
 *
 * @return array
 */
public function getSQLBindTypes() {}

/**
 * Returns type of database system the adapter is used for
 *
 * @return string
 */
public function getType() {}

/**
 * Returns the name of the dialect used
 *
 * @return string
 */
public function getDialectType() {}

/**
 * Returns internal dialect instance
 *
 * @return Phalcon\Db\DialectInterface
 */
public function getDialect() {}

}