Class **Phalcon\\Mvc\\Model\\Query\\Status**
============================================

*implements* :doc:`Phalcon\\Mvc\\Model\\Query\\StatusInterface <Phalcon_Mvc_Model_Query_StatusInterface>`

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
    if ($status->success() == true) {
       echo 'OK';
    }



Methods
-------

public  **__construct** (*unknown* $success, [*unknown* $model])





public  **getModel** ()

Returns the model that executed the action



public  **getMessages** ()

Returns the messages produced because of a failed operation



public  **success** ()

Allows to check if the executed operation was successful



