Class **Phalcon\\Db\\Result\\Pdo**
==================================

Encapsulates the resultset internals  

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while($robot = $result->fetchArray()){
    	print_r($robot);
    }



Methods
---------

public **__construct** (*PDOStatement* $result)

Phalcon\\Db\\Result\\Pdo constructor



*boolean* public **fetchArray** ()

Returns an array of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while($robot = $result->fetchArray()){
      print_r($robot);
    }




*int* public **numRows** ()

Gets number of rows returned by a resulset 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    echo 'There are ', $result->numRows(), ' rows in the resulset';




public **dataSeek** (*int* $number)

Moves internal resulset cursor to another position letting us to fetch a certain row 

.. code-block:: php

    <?php

    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->dataSeek(2); // Move to third row on result
    $row = $result->fetchArray(); // Fetch third row




public **setFetchMode** (*int* $fetchMode)

Changes the fetching mode affecting Phalcon\\Db\\Result\\Pdo::fetchArray 

.. code-block:: php

    <?php

     /Return array with integer indexes
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    
     /Return associative array without integer indexes
    $result->setFetchMode(Phalcon\Db::FETCH_ASSOC);
    
     /Return associative array together with integer indexes
    $result->setFetchMode(Phalcon\Db::FETCH_BOTH);




*PDOStatement* public **getInternalResult** ()

Gets the internal PDO result object



