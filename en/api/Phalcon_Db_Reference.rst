Class **Phalcon_Db_Reference**
==============================

Allows to define reference constraints on tables  

.. code-block:: php

    <?php

    $reference = new Phalcon_Db_Reference(
        "field_fk", 
        array(
            'referencedSchema'  => "invoicing",
            'referencedTable'   => "products",
            'columns'           => array("product_type", "product_code"),
            'referencedColumns' => array("type", "code"),
        )
    );

Methods
---------

**__construct** (string $referenceName, array $definition)

Phalcon_Db_Reference constructor

**string** **getName** ()

Gets the index name

**string** **getSchemaName** ()

Gets the schema where referenced table is

**string** **getReferencedSchema** ()

Gets the schema where referenced table is

**array** **getColumns** ()

Gets local columns which reference is based

**string** **getReferencedTable** ()

Gets the referenced table

**array** **getReferencedColumns** ()

Gets referenced columns

**Phalcon_Db_Reference** **__set_state** (array $data)

Restore a Phalcon_Db_Reference object from export

