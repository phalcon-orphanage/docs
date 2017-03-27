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

    use Phalcon\Paginator\Adapter\QueryBuilder;

    $builder = $this->modelsManager->createBuilder()
                    ->columns("id, name")
                    ->from("Robots")
                    ->orderBy("name");

    $paginator = new QueryBuilder(
        [
            "builder" => $builder,
            "limit"   => 20,
            "page"    => 1,
        ]
    );



Methods
-------

public  **__construct** (*array* $config)





public  **getCurrentPage** ()

Get the current page number



public  **setQueryBuilder** (:doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>` $builder)

Set query builder object



public  **getQueryBuilder** ()

Get query builder object



public  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



public  **setCurrentPage** (*mixed* $page) inherited from :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

Set the current page number



public  **setLimit** (*mixed* $limitRows) inherited from :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

Set current rows limit



public  **getLimit** () inherited from :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

Get current rows limit



