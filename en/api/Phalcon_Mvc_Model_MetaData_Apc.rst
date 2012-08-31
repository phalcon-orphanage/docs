Class **Phalcon_Model_MetaData_Apc**
====================================

Stores model meta-data in the APC cache. Data will erased if the web server is restarted. By default meta-data is stored 48 hours (172800 seconds) You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-local-app').

.. code-block:: php

    <?php
    
    $modelManager = new Phalcon_Model_Manager();

    $metaData = new Phalcon_Model_Metadata(
        'Apc', 
        array(
            'suffix'   => 'my-app-id',
            'lifetime' => 86400,
        )
    );
    $modelManager->setMetaData($metaData);

Methods
---------

**__construct** (Phalcon_Config|stdClass $options)

Phalcon_Model_MetaData_Apc constructor

**array** **read** ()

Reads meta-data from APC

**write** (array $data)

Writes the meta-data to APC

