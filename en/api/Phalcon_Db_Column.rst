Class **Phalcon_Db_Column**
===========================

Allows to define columns to be used on create or alter table operations  

.. code-block:: php

    <?php

     use Phalcon_Db_Column as Column;
    
    // Column definition
     $column = new Column(
        "id", array(
            "type"          => Column::TYPE_INTEGER,
            "size"          => 10,
            "unsigned"      => true,
            "notNull"       => true,
            "autoIncrement" => true,
            "first"         => true,
        )
     );
    
    // Add column to existing table
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

Methods
---------

**__construct** (string $columnName, array $definition)

Phalcon_Db_Column constructor

**string** **getSchemaName** ()

Returns schema's table related to column

**string** **getName** ()

Returns column name

**int** **getType** ()

Returns column type

**int** **getSize** ()

Returns column size

**int** **getScale** ()

Returns column scale

**boolean** **isUnsigned** ()

Returns true if number column is unsigned

**boolean** **isNotNull** ()

Not null

**boolean** **isAutoIncrement** ()

Auto-Increment

**boolean** **isFirst** ()

Check whether column have first position in table

**string** **getAfterPosition** ()

Check whether field absolute to position in table

