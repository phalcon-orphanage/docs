Class **Phalcon\\Paginator\\Adapter\\NativeArray**
==================================================

*implements* :doc:`Phalcon\\Paginator\\AdapterInterface <Phalcon_Paginator_AdapterInterface>`

Pagination using a PHP array as source of data  

.. code-block:: php

    <?php

    $paginator = new \Phalcon\Paginator\Adapter\Model(
    	array(
    		"data"  => array(
    			array('id' => 1, 'name' => 'Artichoke'),
    			array('id' => 2, 'name' => 'Carrots'),
    			array('id' => 3, 'name' => 'Beet'),
    			array('id' => 4, 'name' => 'Lettuce'),
    			array('id' => 5, 'name' => '')
    		),
    		"limit" => 2,
    		"page"  => $currentPage
    	)
    );



Methods
-------

public  **__construct** (*unknown* $config)

Phalcon\\Paginator\\Adapter\\NativeArray constructor



public  **setCurrentPage** (*unknown* $page)

Set the current page number



public  **setLimit** (*unknown* $limitRows)

Set current rows limit



public  **getLimit** ()

Get current rows limit



public  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



