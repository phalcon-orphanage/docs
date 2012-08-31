Class **Phalcon_Model_Query**
=============================

Phalcon_Model_Query is designed to simplify building of search on models. It provides a set of helpers to generate searches in a dynamic way to support different databases.   

.. code-block:: php

    <?php
    
    $query = new Phalcon_Model_Query();
    $query->setManager($manager);
    $query->from('Robots');
    $query->where('id = ?0');
    $query->where('name LIKE ?1');
    $query->setParameters(array(0 => '10', 1 => '%Astro%'));
    
    foreach ($query->getResultset() as $robot) {
        echo $robot->name, "\n";
    }

Methods
---------

**setManager** (Phalcon_Model_Manager $manager)

Set the Phalcon_Model_Manager instance to use in a query  

.. code-block:: php

    <?php
    
    $controllerFront = Phalcon_Controller_Front::getInstance();
    $modelManager    = $controllerFront->getModelComponent();
    $query           = new Phalcon_Model_Query();
    $query->setManager($manager);
     
**from** (string $model)

Add models to use in query

**where** (string $condition)

Add conditions to use in query

**setParameters** (string $parameter)

Set parameter in query to different database adapters.

**setInputData** (array $data)

Set the data to use to make the conditions in query

**setLimit** (int $limit)

Set the limit of rows to show

**getResultset** ()

**string $query** **getConditions** ()

Get the conditions of query

**Phalcon_Model_Query** **fromInput** (string $modelName, array $data)

Get instance of model query

