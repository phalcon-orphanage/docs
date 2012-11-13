Class **Phalcon\\Mvc\\Model\\Query\\Status**
============================================

*implements* Phalcon\Mvc\Model\Query\StatusInterface

This class represents the status returned by a PHQL statement like INSERT, UPDATE or DELETE. It offers context information and the related messages produced by the model which finally executes the operations when it fails  

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

public  **__construct** (*boolean* $success, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)





public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getModel** ()

Returns the model which executed the action



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>` [] **getMessages** ()

Returns the messages produced by a operation failed



public *boolean*  **success** ()

Allows to check if the executed operation was successful



