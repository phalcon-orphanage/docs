Class **Phalcon\\Db\\Reference**
================================

*implements* :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>`

Allows to define reference constraints on tables  

.. code-block:: php

    <?php

    $reference = new \Phalcon\Db\Reference("field_fk", array(
    	'referencedSchema' => "invoicing",
    	'referencedTable' => "products",
    	'columns' => array("product_type", "product_code"),
    	'referencedColumns' => array("type", "code")
    ));



Methods
-------

public  **getName** ()

Constraint name



public  **getSchemaName** ()

...


public  **getReferencedSchema** ()

...


public  **getReferencedTable** ()

Referenced Table



public  **getColumns** ()

Local reference columns



public  **getReferencedColumns** ()

Referenced Columns



public  **getOnDelete** ()

ON DELETE



public  **getOnUpdate** ()

ON UPDATE



public  **__construct** (*unknown* $name, *unknown* $definition)

Phalcon\\Db\\Reference constructor



public static :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>`  **__set_state** (*unknown* $data)

Restore a Phalcon\\Db\\Reference object from export



