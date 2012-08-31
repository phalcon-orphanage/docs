Class **Phalcon\\Db\\Column**
=============================

Phalcon\\Db\\Column   Allows to define columns to be used on create or alter table operations  

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

**__construct** (*string* **$columnName**, *array* **$definition**)

*string* **getSchemaName** ()

*string* **getName** ()

*int* **getType** ()

*int* **getSize** ()

*int* **getScale** ()

*boolean* **isUnsigned** ()

*boolean* **isNotNull** ()

*boolean* **isPrimary** ()

*boolean* **isAutoIncrement** ()

*boolean* **isNumeric** ()

*boolean* **isFirst** ()

*string* **getAfterPosition** ()

**__set_state** (*unknown* **$data**)

