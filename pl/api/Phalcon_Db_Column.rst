Class **Phalcon\\Db\\Column**
=============================

*implements* :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>`

Allows to define columns to be used on create or alter table operations  

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;
    
     //column definition
     $column = new Column("id", array(
       "type" => Column::TYPE_INTEGER,
       "size" => 10,
       "unsigned" => true,
       "notNull" => true,
       "autoIncrement" => true,
       "first" => true
     ));
    
     //add column to existing table
     $connection->addColumn("robots", null, $column);



Constants
---------

*integer* **TYPE_INTEGER**

*integer* **TYPE_DATE**

*integer* **TYPE_VARCHAR**

*integer* **TYPE_DECIMAL**

*integer* **TYPE_DATETIME**

*integer* **TYPE_CHAR**

*integer* **TYPE_TEXT**

*integer* **TYPE_FLOAT**

*integer* **TYPE_BOOLEAN**

*integer* **BIND_PARAM_NULL**

*integer* **BIND_PARAM_INT**

*integer* **BIND_PARAM_STR**

*integer* **BIND_PARAM_BOOL**

*integer* **BIND_PARAM_DECIMAL**

*integer* **BIND_SKIP**

Methods
-------

public  **getName** ()

Column's name



public  **getSchemaName** ()

Schema which table related is



public  **getType** ()

Column data type



public  **getTypeReference** ()

Column data type reference



public  **getTypeValues** ()

Column data type values



public  **getSize** ()

Integer column size



public  **getScale** ()

Integer column number scale



public  **getDefault** ()

Default column value



public  **__construct** (*unknown* $name, *unknown* $definition)

Phalcon\\Db\\Column constructor



public *boolean*  **isUnsigned** ()

Returns true if number column is unsigned



public *boolean*  **isNotNull** ()

Not null



public *boolean*  **isPrimary** ()

Column is part of the primary key?



public *boolean*  **isAutoIncrement** ()

Auto-Increment



public *boolean*  **isNumeric** ()

Check whether column have an numeric type



public *boolean*  **isFirst** ()

Check whether column have first position in table



public *string*  **getAfterPosition** ()

Check whether field absolute to position in table



public *int*  **getBindType** ()

Returns the type of bind handling



public static *\Phalcon\Db\Column*  **__set_state** (*unknown* $data)

Restores the internal state of a Phalcon\\Db\\Column object



