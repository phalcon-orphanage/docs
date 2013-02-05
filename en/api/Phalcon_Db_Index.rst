Class **Phalcon\\Db\\Index**
============================

*implements* :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>`

Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without an index


Methods
---------

public  **__construct** (*string* $indexName, *array* $columns)

Phalcon\\Db\\Index constructor



public *string*  **getName** ()

Gets the index name



public *array*  **getColumns** ()

Gets the columns that comprends the index



public static :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>`  **__set_state** (*array* $data)

Restore a Phalcon\\Db\\Index object from export



