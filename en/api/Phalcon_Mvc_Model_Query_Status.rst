Class **Phalcon\\Mvc\\Model\\Query\\Status**
============================================

*implements* :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`

Methods
---------

public  **__construct** (*boolean* $success, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)





public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getModel** ()

Returns the model that executed the action



public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** ()

Returns the messages produced by a failed operation



public *boolean*  **success** ()

Allows to check if the executed operation was successful



