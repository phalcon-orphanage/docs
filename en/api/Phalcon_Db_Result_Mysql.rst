Class **Phalcon_Db_Result_Mysql**
=================================

Encapsulates a MySQL resultset

.. code-block:: php

    <?php
    
    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::DB_NUM);
    while ($robot = $result->fetchArray()) {
        print_r($robot);
    }

Methods
---------

**__construct** (object $result)

Phalcon_Db_Result_Mysql constructor

**boolean** **fetchArray** ()

Returns an array of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon_Db_Result_Mysql::setFetchMode()  

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon_Db::DB_NUM);
    while ($robot = $result->fetchArray()) {
        print_r($robot);
    }
     
**int** **numRows** ()

Gets number of rows returned by a resultset  

.. code-block:: php

    <?php
    
    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    echo 'There are ', $result->numRows(), ' rows in the resultset';
     
**int** **dataSeek** (int $number)

Moves internal resultset cursor to another position letting us to fetch a certain row  

.. code-block:: php

    <?php
    
    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->dataSeek(2); // Move to third row on result
    $row = $result->fetchArray(); // Fetch third row
     
**setFetchMode** (int $fetchMode)

Changes the fetching mode affecting Phalcon_Db_Mysql::fetchArray()

.. code-block:: php

    <?php
    
    //Return array with integer indexes
    $result->setFetchMode(Phalcon_Db::DB_NUM);
    
    //Return associative array without integer indexes
    $result->setFetchMode(Phalcon_Db::DB_ASSOC);
    
    //Return associative array together with integer indexes
    $result->setFetchMode(Phalcon_Db::DB_BOTH);
     
**mysqli_result** **getInternalResult** ()

Gets the internal MySQLi result object

