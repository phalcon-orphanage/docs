Class **Phalcon\\Db\\Result\\Pdo**
==================================

Phalcon\\Db\\Result\\Pdo   Encapsulates the resultset internals   

.. code-block:: php

    <?php

    
    $result = $connection->query("SELECT * FROM robots ORDER BY name");
    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while($robot = $result->fetchArray()){
    	print_r($robot);
    }
     





Methods
---------

**__construct** (*PDOStatement* **$result**)

*boolean* **fetchArray** ()

*int* **numRows** ()

**dataSeek** (*int* **$number**)

**setFetchMode** (*int* **$fetchMode**)

*PDOStatement* **getInternalResult** ()

