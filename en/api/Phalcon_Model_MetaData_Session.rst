Class **Phalcon_Model_MetaData_Session**
========================================

Stores model meta-data in session. Data will erase when the session finishes. Meta-data is persistent while the session is active. You can query the meta-data by printing $_SESSION['$PMM$'].

.. code-block:: php

    <?php
    
    $modelManager = new Phalcon_Model_Manager();

    $metaData = new Phalcon_Model_Metadata(
        'Session', 
        array('suffix' => 'my-app-id')
    );
    $modelManager->setMetaData($metaData);

Methods
---------

**__construct** (Phalcon_Config|stdClass $options)

Phalcon_Model_MetaData_Session constructor

**array** **read** ()

Reads meta-data from $_SESSION

**write** (array $data)

Writes the meta-data to $_SESSION

