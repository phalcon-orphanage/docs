Class **Phalcon\\Paginator\\Adapter\\Model**
============================================

*implements* :doc:`Phalcon\\Paginator\\AdapterInterface <Phalcon_Paginator_AdapterInterface>`

This adapter allows to paginate data using a Phalcon\\Mvc\\Model resultset as base


Methods
-------

public  **__construct** (*array* $config)

Phalcon\\Paginator\\Adapter\\Model constructor



public  **setCurrentPage** (*int* $page)

Set the current page number



public *stdClass*  **getPaginate** ()

Returns a slice of the resultset to show in the pagination



