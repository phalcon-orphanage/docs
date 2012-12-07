Class **Phalcon\\Db\\Index**
============================

<<<<<<< HEAD
Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without an index. 

.. code-block:: php

    <?php

=======
*implements* :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>`

Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without an index.
>>>>>>> 0.7.0


Methods
---------

public  **__construct** (*string* $indexName, *array* $columns)

Phalcon\\Db\\Index constructor



public *string*  **getName** ()

Gets the index name



public *array*  **getColumns** ()

Gets the columns that comprends the index



<<<<<<< HEAD
public static :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>`  **__set_state** (*array* $data)
=======
public static :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>`  **__set_state** (*array* $data)
>>>>>>> 0.7.0

Restore a Phalcon\\Db\\Index object from export



