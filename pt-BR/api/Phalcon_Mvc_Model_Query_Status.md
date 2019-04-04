---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query\Status'
---
# Class **Phalcon\Mvc\Model\Query\Status**

*implements* [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query/status.zep)

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

public **__construct** (*mixed* $success, [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model])

public **getModel** ()

Returns the model that executed the action

public **getMessages** ()

Returns the messages produced because of a failed operation

public **success** ()

Allows to check if the executed operation was successful