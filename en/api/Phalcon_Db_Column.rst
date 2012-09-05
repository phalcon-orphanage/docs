Class **Phalcon\\Db\\Column**
=============================

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

integer **TYPE_INTEGER**

integer **TYPE_DATE**

integer **TYPE_VARCHAR**

integer **TYPE_DECIMAL**

integer **TYPE_DATETIME**

integer **TYPE_CHAR**

integer **TYPE_TEXT**

integer **TYPE_FLOAT**

Methods
---------

public **__construct** (*string* $columnName, *array* $definition)

Phalcon\\Db\\Column constructor



*string* public **getSchemaName** ()

Returns schema's table related to column



*string* public **getName** ()

Returns column name



*int* public **getType** ()

Returns column type



*int* public **getSize** ()

Returns column size



*int* public **getScale** ()

Returns column scale



*boolean* public **isUnsigned** ()

Returns true if number column is unsigned



*boolean* public **isNotNull** ()

Not null



*boolean* public **isPrimary** ()

Column is part of the primary key?



*boolean* public **isAutoIncrement** ()

Auto-Increment



*boolean* public **isNumeric** ()

Check whether column have an numeric type



*boolean* public **isFirst** ()

Check whether column have first position in table



*string* public **getAfterPosition** ()

Check whether field absolute to position in table



public static **__set_state** (*unknown* $data)

