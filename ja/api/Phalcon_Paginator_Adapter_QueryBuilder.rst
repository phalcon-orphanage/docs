Class **Phalcon\\Paginator\\Adapter\\QueryBuilder**
===================================================

*implements* :doc:`Phalcon\\Paginator\\AdapterInterface <Phalcon_Paginator_AdapterInterface>`

Pagination using a PHQL query builder as source of data  

.. code-block:: php

    <?php

      $builder = $this->modelsManager->createBuilder()
                       ->columns('id, name')
                       ->from('Robots')
                       ->orderBy('name');
    
      $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
          "builder" => $builder,
          "limit"=> 20,
          "page" => 1
      ));



Methods
-------

public  **__construct** (*array* $config)





public  **setCurrentPage** (*unknown* $currentPage)

Set the current page number



public *stdClass*  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



