Class **Phalcon\\Db\\Reference**
================================

Phalcon\\Db\\Reference   Allows to define reference constraints on tables  

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

**__construct** (*string* **$referenceName**, *array* **$definition**)

*string* **getName** ()

*string* **getSchemaName** ()

*string* **getReferencedSchema** ()

*array* **getColumns** ()

*string* **getReferencedTable** ()

*array* **getReferencedColumns** ()

:doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` **__set_state** (*array* **$data**)

