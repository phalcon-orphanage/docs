Interface **Phalcon\\Mvc\\Model\\QueryInterface**
=================================================

Phalcon\\Mvc\\Model\\QueryInterface initializer


Methods
---------

abstract public  **__construct** (*string* $phql)

Phalcon\\Mvc\\Model\\Query constructor



abstract public *array*  **parse** (:doc:`Phalcon\\Mvc\\Model\\ManagerInterface <Phalcon_Mvc_Model_ManagerInterface>` $manager)

Parses the intermediate code produced by Phalcon\\Mvc\\Model\\Query\\Lang generating another intermediate representation that could be executed by Phalcon\\Mvc\\Model\\Query



abstract public *mixed*  **execute** (*array* $placeholders)

Executes a parsed PHQL statement



