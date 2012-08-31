Class **Phalcon\\Mvc\\Model\\Resultset\\Complex**
=================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`

*implements* Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

Methods
---------

**__construct** (*array* **$columnsTypes**, *Phalcon\Db\Result* **$result**, *Phalcon\Cache\Backend* **$cache**)

*boolean* **valid** ()

*string* **serialize** ()

**unserialize** (*string* **$data**)

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **current** ()

**next** ()

**key** ()

**rewind** ()

**seek** (*unknown* **$position**)

**count** ()

**offsetExists** (*unknown* **$index**)

**offsetGet** (*unknown* **$index**)

**offsetSet** (*unknown* **$index**, *unknown* **$value**)

**offsetUnset** (*unknown* **$offset**)

**getFirst** ()

**getLast** ()

**isFresh** ()

**getCache** ()

