Class **Phalcon\\Paginator\\Adapter\\Model**
============================================

*extends* abstract class :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

*implements* :doc:`Phalcon\\Paginator\\AdapterInterface <Phalcon_Paginator_AdapterInterface>`

This adapter allows to paginate data using a Phalcon\\Mvc\\Model resultset as a base 

.. code-block:: php

    <?php

    $paginator = new \Phalcon\Paginator\Adapter\Model(
    	array(
    		"data"  => Robots::find(),
    		"limit" => 25,
    		"page"  => $currentPage
    	)
    );
    
      $paginate = $paginator->getPaginate();



Methods
-------

public  **__construct** (*unknown* $config)

Phalcon\\Paginator\\Adapter\\Model constructor



public  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



public  **setCurrentPage** (*unknown* $page) inherited from Phalcon\\Paginator\\Adapter

Set the current page number



public  **setLimit** (*unknown* $limitRows) inherited from Phalcon\\Paginator\\Adapter

Set current rows limit



public  **getLimit** () inherited from Phalcon\\Paginator\\Adapter

Get current rows limit



