---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\Adapter\Memory'
---
# Class **Phalcon\Acl\Adapter\Memory**

*extends* abstract class [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Manages ACL lists in memory

```php
<?php

$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// Register operations
$operations = [
    "users"  => new \Phalcon\Acl\Operation("Users"),
    "guests" => new \Phalcon\Acl\Operation("Guests"),
];
foreach ($operations as $operation) {
    $acl->addOperation($operation);
}

// Private area subjects
$privateSubjects = [
    "companies" => ["index", "search", "new", "edit", "save", "create", "delete"],
    "products"  => ["index", "search", "new", "edit", "save", "create", "delete"],
    "invoices"  => ["index", "profile"],
];

foreach ($privateSubjects as $subjectName => $actions) {
    $acl->addSubject(
        new \Phalcon\Acl\Subject($subjectName),
        $actions
    );
}

// Public area subjects
$publicSubjects = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicSubjects as $subjectName => $actions) {
    $acl->addSubject(
        new \Phalcon\Acl\Subject($subjectName),
        $actions
    );
}

// Grant access to public areas to both users and guests
foreach ($operations as $operation){
    foreach ($publicSubjects as $subject => $actions) {
        $acl->allow($operation->getName(), $subject, "*");
    }
}

// Grant access to private area to operation Users
foreach ($privateSubjects as $subject => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $subject, $action);
    }
}

```

## Metody

public **__construct** ()

Phalcon\Acl\Adapter\Memory constructor

public **addOperation** (*OperationInterface* | *string* $operation, [*array* | *string* $accessInherits])

Adds a operation to the ACL list. Second parameter allows inheriting access data from other existing operation Example:

```php
<?php

$acl->addOperation(
    new Phalcon\Acl\Operation("administrator"),
    "consultant"
);

$acl->addOperation("administrator", "consultant");

```

public **addInherit** (*mixed* $operationName, *mixed* $operationToInherit)

Do a operation inherit from another existing operation

public **isOperation** (*mixed* $operationName)

Check whether operation exist in the operations list

public **isSubject** (*mixed* $subjectName)

Check whether subject exist in the subjects list

public **addSubject** ([Phalcon\Acl\Subject](Phalcon_Acl_Subject) | *string* $subjectValue, *array* | *string* $accessList)

Adds a subject to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them Example:

```php
<?php

// Add a subject to the the list allowing access to an action
$acl->addSubject(
    new Phalcon\Acl\Subject("customers"),
    "search"
);

$acl->addSubject("customers", "search");

// Add a subject  with an access list
$acl->addSubject(
    new Phalcon\Acl\Subject("customers"),
    [
        "create",
        "search",
    ]
);

$acl->addSubject(
    "customers",
    [
        "create",
        "search",
    ]
);

```

public **addSubjectAccess** (*mixed* $subjectName, *array* | *string* $accessList)

Adds access to subjects

public **dropSubjectAccess** (*mixed* $subjectName, *array* | *string* $accessList)

Removes an access from a subject

protected **_allowOrDeny** (*mixed* $operationName, *mixed* $subjectName, *mixed* $access, *mixed* $action, [*mixed* $func])

Checks if a operation has access to a subject

public **allow** (*mixed* $operationName, *mixed* $subjectName, *mixed* $access, [*mixed* $func])

Allow access to a operation on a subject You can use '*' as wildcard Example:

```php
<?php

//Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

//Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

//Allow access to any operation to browse on products
$acl->allow("*", "products", "browse");

//Allow access to any operation to browse on any subject
$acl->allow("*", "*", "browse");

```

public **deny** (*mixed* $operationName, *mixed* $subjectName, *mixed* $access, [*mixed* $func])

Deny access to a operation on a subject You can use '*' as wildcard Example:

```php
<?php

//Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

//Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

//Deny access to any operation to browse on products
$acl->deny("*", "products", "browse");

//Deny access to any operation to browse on any subject
$acl->deny("*", "*", "browse");

```

public **isAllowed** (*OperationInterface* | *OperationAware* | *string* $operationName, *SubjectInterface* | *SubjectAware* | *string* $subjectName, *mixed* $access, [*array* $parameters])

Check whether a operation is allowed to access an action from a subject

```php
<?php

//Does andres have access to the customers subject to create?
$acl->isAllowed("andres", "Products", "create");

//Do guests have access to any subject to edit?
$acl->isAllowed("guests", "*", "edit");

```

public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY) for no arguments provided in isAllowed action if there exists func for accessKey

public **getNoArgumentsDefaultAction** ()

Returns the default ACL access level for no arguments provided in isAllowed action if there exists func for accessKey

public **getOperations** ()

Return an array with every operation registered in the list

public **getSubjects** ()

Return an array with every subject registered in the list

public **getActiveOperation** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Operation which the list is checking if it's allowed to certain subject/access

public **getActiveSubject** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Subject which the list is checking if some operation can access it

public **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Active access which the list is checking if some operation can access it

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Sets the events manager

public **getEventsManager** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Returns the internal event manager

public **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

public **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

Returns the default ACL access level