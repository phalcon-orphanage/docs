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





public *stdClass*  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



public :doc:`Phalcon\\Paginator\\Adapter\\QueryBuilder <Phalcon_Paginator_Adapter_QueryBuilder>`  $this Fluent interface **setLimit** (*int* $limit)

Set current rows limit



public *int $limit*  **getLimit** ()

Get current rows limit



public  **setCurrentPage** (*int* $page)

Set current page number



public  **getCurrentPage** ()

Get current page number



public :doc:`Phalcon\\Paginator\\Adapter\\QueryBuilder <Phalcon_Paginator_Adapter_QueryBuilder>`  $this Fluent interface **setQueryBuilder** (*unknown* $queryBuilder)

Set query builder object



public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  $builder **getQueryBuilder** ()

Get query builder object



