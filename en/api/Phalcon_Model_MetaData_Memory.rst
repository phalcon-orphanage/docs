Class **Phalcon_Model_MetaData_Memory**
=======================================

Stores model meta-data in memory. Data will be erased when the request is completed.

.. code-block:: php

    <?php
    
    $modelManager = new Phalcon\Model\Manager();

    $metaData = new Phalcon\Model\Metadata('Memory');
    $modelManager->setMetaData($metaData);

Methods
---------

**array** **read** ()

Reads the meta-data from temporal memory

**write** (array $data)

Writes the meta-data to temporal memory

