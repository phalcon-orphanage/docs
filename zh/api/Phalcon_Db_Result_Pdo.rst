Class **Phalcon\\Db\\Result\\Pdo**
==================================

<<<<<<< HEAD
Encapsulates the resultset internals 
=======
Encapsulates the resultset internals  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while($robot = $result->fetchArray()){
    	print_r($robot);
    }



Methods
---------

<<<<<<< HEAD
public  **__construct** (:doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>` $connection, *PDOStatement* $result, *string* $sqlStatement, *array* $bindParams, *array* $bindTypes)
=======
public  **__construct** (:doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, *\PDOStatement* $result, *string* $sqlStatement, *array* $bindParams, *array* $bindTypes)
>>>>>>> 0.7.0

Phalcon\\Db\\Result\\Pdo constructor



public *boolean*  **execute** ()

Allows to executes the statement again. Some database systems don't support scrollable cursors, So, as cursors are forward only, we need to execute the cursor again to fetch rows from the begining



<<<<<<< HEAD
public *boolean*  **fetchArray** ()
=======
public *mixed*  **fetch** ()

Fetches an array/object of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::FETCH_OBJ);
    while($robot = $result->fetch()){
    	echo $robot->name;
    }




public *mixed*  **fetchArray** ()
>>>>>>> 0.7.0

Returns an array of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while($robot = $result->fetchArray()){
    	print_r($robot);
    }




public *array*  **fetchAll** ()

Returns an array of arrays containing all the records in the result This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $robots = $result->fetchAll();




public *int*  **numRows** ()

Gets number of rows returned by a resulset 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    echo 'There are ', $result->numRows(), ' rows in the resulset';




public  **dataSeek** (*int* $number)

Moves internal resulset cursor to another position letting us to fetch a certain row 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->dataSeek(2); // Move to third row on result
<<<<<<< HEAD
    $row = $result->fetchArray(); // Fetch third row
=======
    $row = $result->fetch(); // Fetch third row
>>>>>>> 0.7.0




public  **setFetchMode** (*int* $fetchMode)

<<<<<<< HEAD
Changes the fetching mode affecting Phalcon\\Db\\Result\\Pdo::fetchArray 
=======
Changes the fetching mode affecting Phalcon\\Db\\Result\\Pdo::fetch() 
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    //Return array with integer indexes
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    
    //Return associative array without integer indexes
    $result->setFetchMode(Phalcon\Db::FETCH_ASSOC);
    
    //Return associative array together with integer indexes
    $result->setFetchMode(Phalcon\Db::FETCH_BOTH);
<<<<<<< HEAD
=======
    
    //Return an object
    $result->setFetchMode(Phalcon\Db::FETCH_OBJ);
>>>>>>> 0.7.0




<<<<<<< HEAD
public *PDOStatement*  **getInternalResult** ()
=======
public *\PDOStatement*  **getInternalResult** ()
>>>>>>> 0.7.0

Gets the internal PDO result object



