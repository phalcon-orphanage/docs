Class **Phalcon\\Paginator\\Adapter\\Model**
============================================

*extends* abstract class :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

*implements* :doc:`Phalcon\\Paginator\\AdapterInterface <Phalcon_Paginator_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/paginator/adapter/model.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This adapter allows to paginate data using a Phalcon\\Mvc\\Model resultset as a base.

.. code-block:: php

    <?php

    use Phalcon\Paginator\Adapter\Model;

    $paginator = new Model(
        [
            "data"  => Robots::find(),
            "limit" => 25,
            "page"  => $currentPage,
        ]
    );

    $paginate = $paginator->getPaginate();



Methods
-------

public  **__construct** (*array* $config)

Phalcon\\Paginator\\Adapter\\Model constructor



public  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



public  **setCurrentPage** (*mixed* $page) inherited from :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

Set the current page number



public  **setLimit** (*mixed* $limitRows) inherited from :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

Set current rows limit



public  **getLimit** () inherited from :doc:`Phalcon\\Paginator\\Adapter <Phalcon_Paginator_Adapter>`

Get current rows limit



