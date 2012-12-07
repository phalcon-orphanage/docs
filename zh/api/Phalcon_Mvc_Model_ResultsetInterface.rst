Interface **Phalcon\\Mvc\\Model\\ResultsetInterface**
=====================================================

Phalcon\\Mvc\\Model\\ResultsetInterface initializer


Methods
---------

abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getFirst** ()

Get first row in the resultset



abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLast** ()

Get last row in the resultset



abstract public  **setIsFresh** (*boolean* $isFresh)

Set if the resultset is fresh or an old one cached



abstract public *boolean*  **isFresh** ()

Tell if the resultset if fresh or an old one cached



abstract public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()

Returns the associated cache for the resultset



