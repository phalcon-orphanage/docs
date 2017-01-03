Class **Phalcon\\Db\\Index**
============================

*implements* :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/index.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without an index


Methods
-------

public  **getName** ()

Index name



public  **getColumns** ()

Index columns



public  **getType** ()

Index type



public  **__construct** (*mixed* $name, *array* $columns, [*mixed* $type])

Phalcon\\Db\\Index constructor



public static  **__set_state** (*array* $data)

Restore a Phalcon\\Db\\Index object from export



