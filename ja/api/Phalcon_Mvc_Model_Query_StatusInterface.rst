Interface **Phalcon\\Mvc\\Model\\Query\\StatusInterface**
=========================================================

Phalcon\\Mvc\\Model\\Query\\StatusInterface initializer


Methods
---------

abstract public  **__construct** (*boolean* $success, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Phalcon\\Mvc\\Model\\Query\\Status



abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getModel** ()

Returns the model which executed the action



abstract public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** ()

Returns the messages produced by a operation failed



abstract public *boolean*  **success** ()

Allows to check if the executed operation was successful



