Class **Phalcon\\Mvc\\Model\\Query\\Status**
============================================

This class represents the status returned by a PHQL statement like INSERT, UPDATE or DELETE. It offers context information and the related messages produced by the model which finally executes the operations when it fails


Methods
---------

public  **__construct** (*boolean* $success, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)





public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getModel** ()

Returns the model which executed the action



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>` [] **getMessages** ()

Returns the messages produced by a operation failed



public *boolean*  **success** ()

Allows to check if the executed operation was successfull



