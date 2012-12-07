Class **Phalcon\\Mvc\\Model\\Query\\Status**
============================================

<<<<<<< HEAD
This class represents the status returned by a PHQL statement like INSERT, UPDATE or DELETE. It offers context information and the related messages produced by the model which finally executes the operations when it fails 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`

This class represents the status returned by a PHQL statement like INSERT, UPDATE or DELETE. It offers context information and the related messages produced by the model which finally executes the operations when it fails  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";
    $status = $app->modelsManager->executeQuery($phql, array(
       'id' => 100,
       'name' => 'Astroy Boy',
       'type' => 'mechanical',
       'year' => 1959
    ));
    
    \//Check if the update was successful
    if($status->success()==true){
       echo 'OK';
    }



Methods
---------

<<<<<<< HEAD
public  **__construct** (*boolean* $success, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model)
=======
public  **__construct** (*boolean* $success, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)
>>>>>>> 0.7.0





<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getModel** ()
=======
public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getModel** ()
>>>>>>> 0.7.0

Returns the model which executed the action



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>` [] **getMessages** ()

Returns the messages produced by a operation failed



public *boolean*  **success** ()

Allows to check if the executed operation was successful



