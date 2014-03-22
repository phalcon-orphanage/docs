Interface **Phalcon\\Mvc\\Model\\QueryInterface**
=================================================

Phalcon\\Mvc\\Model\\QueryInterface initializer


Methods
-------

abstract public *array*  **parse** ()

Parses the intermediate code produced by Phalcon\\Mvc\\Model\\Query\\Lang generating another intermediate representation that could be executed by Phalcon\\Mvc\\Model\\Query



abstract public *mixed*  **execute** ([*array* $bindParams], [*array* $bindTypes])

Executes a parsed PHQL statement



