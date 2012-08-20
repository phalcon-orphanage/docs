Class **Phalcon_Db**
====================

Phalcon_Db and its related classes provide a simple SQL database interface for Phalcon Framework. The Phalcon_Db is the base class developers can use to connect a PHP application to an RDBMS. There is a different adapter class for each flavor of RDBMS. This component is intended to allow low level database operations. If there is a need for high level abstraction for database operations, developers can use Phalcon_Model. Phalcon_Db is an abstract class. It can be used with a database adapter such as Phalcon_Db_Adapter_Mysql  

.. code-block:: php

    <?php

    $config           = new stdClass();
    $config->host     = 'localhost';
    $config->username = 'machine';
    $config->password = 'sigma';
    $config->name     = 'swarm';
    
    try {
    
      $connection = Phalcon\Db::factory('Mysql', $config);
    
      $result = $connection->query("SELECT * FROM robots LIMIT 5");
      $result->setFetchMode(Phalcon\Db::DB_NUM);
      while($robot = $result->fetchArray()) {
        print_r($robot);
      }
    
    } catch(Phalcon_Db_Exception $e) {
    	echo $e->getMessage(), PHP_EOL;
    }

Constants
---------

integer **DB_ASSOC**

integer **DB_BOTH**

integer **DB_NUM**

Methods
---------

**__construct** (stdClass $descriptor)

Phalcon_Db constructor, this method should not be called directly. Use Phalcon_Db::factory instead

**setLogger** (Phalcon\Logger $logger)

Sets a logger class to log all SQL operations sent to the RDBMS

**Phalcon\Logger** **getLogger** ()

Returns the active logger

**log** (string $sqlStatement, int $type)

Sends arbitrary text to an instantiated logger

**setProfiler** (Phalcon\Db\Profiler $profiler)

Sets a database profiler to the connection

**array** **fetchOne** (string $sqlQuery, int $fetchMode)

Returns the first row in a SQL query result  

.. code-block:: php

    <?php

    // Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon_Db_Result::DB_ASSOC);
    print_r($robot);
     
**array** **fetchAll** (string $sqlQuery, int $fetchMode)

Dumps the complete result of a query into an array  

.. code-block:: php

    <?php

    // Getting all robots
    $robots = $connection->fetchAll("SELECT * FROM robots");
    foreach ($robots as $robot) {
        print_r($robot);
    }
    // Getting all robots with associative indexes only
    $robots = $connection->fetchAll("SELECT * FROM robots", Phalcon_Db_Result::DB_ASSOC);
    foreach ($robots as $robot) {
        print_r($robot);
    }

**boolean** **insert** (string $table, array $values, array $fields, boolean $automaticQuotes)

Inserts data into a table using custom RBDM SQL syntax  

.. code-block:: php

    <?php

    // Inserting a new robot
    $success = $connection->insert(
        "robots",
        array("Astro Boy", 1952),
        array("name", "year")
    );
    
    // SQL statement sent to the database system
    // INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

**boolean** **update** (string $table, array $fields, array $values, string $whereCondition, boolean $automaticQuotes)

Updates data on a table using custom RBDM SQL syntax  

.. code-block:: php

    <?php
    
    // Updating existing robot
    $success = $connection->update(
        "robots",
        array("name")
        array("New Astro Boy"),
        "id = 101"
    );
    
    // SQL statement sent to the database system
    // UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

**boolean** **delete** (string $table, string $whereCondition)

Deletes data from a table using custom RBDM SQL syntax  

.. code-block:: php

    <?php
    
    // Deleting existing robot
    $success = $connection->delete(
        "robots",
        "id = 101"
    );
    
    // SQL statement sent to the database system
    // DELETE FROM `robots` WHERE id = 101
     
**boolean** **begin** ()

Starts a transaction in the connection

**boolean** **rollback** ()

Rollbacks the active transaction in the connection

**boolean** **commit** ()

Commits the active transaction in the connection

**setUnderTransaction** (boolean $underTransaction)

Manually sets a "under transaction" state for the connection

**boolean** **isUnderTransaction** ()

Checks whether connection is under database transaction

**boolean** **getHaveAutoCommit** ()

Checks whether connection have auto commit

**string** **getDatabaseName** ()

Returns database name in the internal connection

**string** **getDefaultSchema** ()

Returns active schema name in the internal connection

**string** **getUsername** ()

Returns the username which has connected to the database

**string** **getHostName** ()

Returns the username which has connected to the database

**_beforeQuery** (string $sqlStatement)

This method is executed before every SQL statement sent to the database system

**_afterQuery** (string $sqlStatement)

This method is executed after every SQL statement sent to the database system

**Phalcon_Db_Adapter** **factory** (string $adapterName, stdClass $options)

Instantiates Phalcon_Db adapter using given parameters

