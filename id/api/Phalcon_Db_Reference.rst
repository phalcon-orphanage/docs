Class **Phalcon\\Db\\Reference**
================================

*implements* :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/reference.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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



public  **__construct** (*mixed* $name, *array* $definition)

Phalcon\\Db\\Reference constructor



public static  **__set_state** (*array* $data)

Restore a Phalcon\\Db\\Reference object from export



