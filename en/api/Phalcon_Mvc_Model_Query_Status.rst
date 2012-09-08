Class **Phalcon\\Mvc\\Model\\Query\\Status**
============================================

This class represents the status returned by a PHQL statement like INSERT, UPDATE or DELETE. It offers context information and the related messages produced by the model which finally executes the operations when it fails


Methods
---------

public **__construct** (*boolean* $success, *Phalcon\Mvc\Model* $model)





:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` public **getModel** ()

Returns the model which executed the action



:doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>` public **getMessages** ()

Returns the messages produced by a operation failed



*boolean* public **success** ()

Allows to check if the executed operation was successfull



