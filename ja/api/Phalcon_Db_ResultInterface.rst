Interface **Phalcon\\Db\\ResultInterface**
==========================================

Phalcon\\Db\\ResultInterface initializer


Methods
-------

abstract public  **__construct** (:doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, *\PDOStatement* $result, [*string* $sqlStatement], [*array* $bindParams], [*array* $bindTypes])

Phalcon\\Db\\Result\\Pdo constructor



abstract public *boolean*  **execute** ()

Allows to executes the statement again. Some database systems don't support scrollable cursors, So, as cursors are forward only, we need to execute the cursor again to fetch rows from the begining



abstract public *mixed*  **fetch** ()

Fetches an array/object of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode



abstract public *mixed*  **fetchArray** ()

Returns an array of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode



abstract public *array*  **fetchAll** ()

Returns an array of arrays containing all the records in the result This method is affected by the active fetch flag set using Phalcon\\Db\\Result\\Pdo::setFetchMode



abstract public *int*  **numRows** ()

Gets number of rows returned by a resulset



abstract public  **dataSeek** (*int* $number)

Moves internal resulset cursor to another position letting us to fetch a certain row



abstract public  **setFetchMode** (*int* $fetchMode)

Changes the fetching mode affecting Phalcon\\Db\\Result\\Pdo::fetch()



abstract public *\PDOStatement*  **getInternalResult** ()

Gets the internal PDO result object



