Class **Phalcon\\Db\\Reference**
================================

Allows to define reference constraints on tables 

.. code-block:: php

    <?php

    $reference = new Phalcon\Db\Reference("field_fk", array(
    	'referencedSchema' => "invoicing",
    	'referencedTable' => "products",
    	'columns' => array("product_type", "product_code"),
    	'referencedColumns' => array("type", "code")
    ));



Methods
---------

public **__construct** (*string* $referenceName, *array* $definition)

Phalcon\\Db\\Reference constructor



*string* public **getName** ()

Gets the index name



*string* public **getSchemaName** ()

Gets the schema where referenced table is



*string* public **getReferencedSchema** ()

Gets the schema where referenced table is



*array* public **getColumns** ()

Gets local columns which reference is based



*string* public **getReferencedTable** ()

Gets the referenced table



*array* public **getReferencedColumns** ()

Gets referenced columns



:doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` public static **__set_state** (*array* $data)

Restore a Phalcon\\Db\\Reference object from export



