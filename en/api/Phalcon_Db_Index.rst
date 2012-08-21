Class **Phalcon_Db_Index**
==========================

Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without it.   

.. code-block:: php

    <?php

    $index = new Phalcon_Db_Index('PRIMARY', array('id');

Methods
---------

**__construct** (string $indexName, array $columns)

Phalcon_Db_Index constructor

**string** **getName** ()

Gets the index name

**array** **getColumns** ()

Gets the columns that comprends the index

**Phalcon_Db_Index** **__set_state** (array $data)

Restore a Phalcon_Db_Index object from export

