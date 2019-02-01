---
layout: article
language: 'fa-ir'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Objects as operation name and subject name

Phalcon allows developers to define their own operation and subject objects. These objects must implement the supplied interfaces:

* [Phalcon\Acl\OperationAware](api/Phalcon_Acl_OperationAware) for Operation
* [Phalcon\Acl\SubjectAware](api/Phalcon_Acl_SubjectAware) for Subject

### Operation

We can implement the [Phalcon\Acl\OperationAware](api/Phalcon_Acl_OperationAware) in our custom class with its own logic. The example below shows a new operation object called `ManagerOperation`:

```php
<?php

use Phalcon\Acl\OperationAware;

// Create our class which will be used as operationName
class ManagerOperation implements OperationAware
{
    protected $id;

    protected $operationName;

    public function __construct($id, $operationName)
    {
        $this->id       = $id;
        $this->operationName = $operationName;
    }

    public function getId()
    {
        return $this->id;
    }

    // Implemented function from OperationAware Interface
    public function getOperationName()
    {
        return $this->operationName;
    }
}
```

### Subject

We can implement the [Phalcon\Acl\SubjectAware](api/Phalcon_Acl_SubjectAware) in our custom class with its own logic. The example below shows a new operation object called `ReportsSubject`:

```php
<?php

use Phalcon\Acl\SubjectAware;

// Create our class which will be used as subjectName
class ReportsSubject implements SubjectAware
{
    protected $id;

    protected $subjectName;

    protected $userId;

    public function __construct($id, $subjectName, $userId)
    {
        $this->id          = $id;
        $this->subjectName = $subjectName;
        $this->userId      = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // Implemented function from SubjectAware Interface
    public function getSubjectName()
    {
        return $this->subjectName;
    }
}
```

### ACL

These objects can now be used in our ACL.

```php <?php

use ManagerOperation; use Phalcon\Acl; use Phalcon\Acl\Adapter\Memory as AclList; use Phalcon\Acl\Operation; use Phalcon\Acl\Subject; use ReportsSubject;

$acl = new AclList();

/** * Add the operations */ $acl->addOperation('manager');

/** * Add the Subjects */ $acl->addSubject('reports', ['list', 'add', 'view']);

/** * Now tie them all together with a custom function. The ManagerOperation and * ModelSbject parameters are necessary for the custom function to work */ $acl->allow( 'manager', 'reports', 'list', function (ManagerOperation $manager, ModelSubject $model) { return $manager->getId() === $model->getUserId(); } );

// Create the custom objects $levelOne = new ManagerOperation(1, 'manager-1'); $levelTwo = new ManagerOperation(2, 'manager'); $admin = new ManagerOperation(3, 'manager');

// id - name - userId $reports = new ModelSubject(2, 'reports', 2);

// Check whether our user objects have access // Returns false $acl->isAllowed($levelOne, $reports, 'list');

// Returns true $acl->isAllowed($levelTwo, $reports, 'list');

// Returns false $acl->isAllowed($admin, $reports, 'list'); ````

The second call for `$levelTwo` evaluates `true` since the `getUserId()` returns `2` which in turn is evaluated in our custom function. Also note that in the custom function for `allow()` the objects are automatically bound, providing all the data necessary for the custom function to work. The custom function can accept any number of additional parameters. The order of the parameters defined in the `function()` constructor does not matter, because the objects will be automatically discovered and bound.