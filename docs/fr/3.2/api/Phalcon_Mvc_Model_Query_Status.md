# Class **Phalcon\\Mvc\\Model\\Query\\Status**

*implements* [Phalcon\Mvc\Model\Query\StatusInterface](/en/3.1.2/api/Phalcon_Mvc_Model_Query_StatusInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/query/status.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class represents the status returned by a PHQL statement like INSERT, UPDATE or DELETE. It offers context information and the related messages produced by the model which finally executes the operations when it fails

```php
<?php

$phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";

$status = $app->modelsManager->executeQuery(
    $phql,
    [
        "id"   => 100,
        "name" => "Astroy Boy",
        "type" => "mechanical",
        "year" => 1959,
    ]
);

// Check if the update was successful
if ($status->success() === true) {
    echo "OK";
}

```

## Methods

public **__construct** (*mixed* $success, [[Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model])

public **getModel** ()

Returns the model that executed the action

public **getMessages** ()

Returns the messages produced because of a failed operation

public **success** ()

Allows to check if the executed operation was successful