Class **Phalcon_Model_Row**
===========================

This component allows to Phalcon_Model_Base returns grouped resultsets.

Methods
---------

**setConnection** (Phalcon_Db $connection)

Overwrites default connection

**Phalcon_Db** **getConnection** ()

Returns default connection

**Phalcon_Model $result** **dumpResult** (array $result)

Assigns values to a row from an array returning a new row 

.. code-block:: php

    <?php
    
    $row    = new Phalcon_Model_Row();
    $newRow = $row->dumpResult(
        array(
            'type' => 'mechanical',
            'name' => 'Astro Boy',
            'year' => 1952
        )
    );

**mixed** **readAttribute** (string $property)

Reads an attribute value by its name  

.. code-block:: php

    <?php 

    echo $robot->readAttribute('name');

**array** **sleep** ()

Magic method sleep

