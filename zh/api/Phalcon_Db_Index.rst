Class **Phalcon\\Db\\Index**
============================

Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without an index. 

.. code-block:: php

    <?php



Methods
---------

public  **__construct** (*string* $indexName, *array* $columns)

Phalcon\\Db\\Index constructor



public *string*  **getName** ()

Gets the index name



public *array*  **getColumns** ()

Gets the columns that comprends the index



public static :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>`  **__set_state** (*array* $data)

Restore a Phalcon\\Db\\Index object from export



