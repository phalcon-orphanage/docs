Class **Phalcon\\Paginator\\Adapter\\QueryBuilder**
===================================================

*extends* abstract class :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

*implements* :doc:`Phalcon\\Paginator\\AdapterInterface <Phalcon_Paginator_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/paginator/adapter/querybuilder.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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

public  **__construct** (*unknown* $config)





public  **getCurrentPage** ()

Get the current page number



public  **setQueryBuilder** (*unknown* $builder)

Set query builder object



public  **getQueryBuilder** ()

Get query builder object



public  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



public  **setCurrentPage** (*unknown* $page) inherited from Phalcon\\Paginator\\Adapter

Set the current page number



public  **setLimit** (*unknown* $limitRows) inherited from Phalcon\\Paginator\\Adapter

Set current rows limit



public  **getLimit** () inherited from Phalcon\\Paginator\\Adapter

Get current rows limit



