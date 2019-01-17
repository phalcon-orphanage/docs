---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\Adapter\Memory'
---
# Class **Phalcon\Acl\Adapter\Memory**

*extends* abstract class [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapter/memory.zep)

メモリ上のアクセス制御リストを管理します

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

## メソッド

```php
public **__construct** ()
```

Phalcon\Acl\Adapter\Memory constructor

* * *

```php
public addOperation( [Phalcon\Acl\OperationInterface](Phalcon_Acl_OperationInterface) | string $operation [, array | string $accessInherits] )
```

Adds a operation to the ACL list. Second parameter allows inheriting access data from other existing operation

```php
<?php

$acl->addOperation(
    new Phalcon\Acl\Operation("administrator"),
    "consultant"
);

$acl->addOperation("administrator", "consultant");

```

```php
public addInherit( mixed $operationName, mixed $operationToInherit )
```

Do a operation inherit from another existing operation

* * *

```php
public isOperation( mixed $operationName ): bool
```

Check whether operation exist in the operations list

* * *

```php
public isSubject( mixed $subjectName )
```

Check whether subject exist in the subjects list

* * *

```php
public addSubject( [Phalcon\Acl\Subject](Phalcon_Acl_Subject) | string $subjectValue, array | string $accessList )
```

Adds a subject to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them

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

* * *

```php
public addSubjectAccess( mixed $subjectName, array | string $accessList )
```

Adds access to subjects

* * *

```php
public dropSubjectAccess( mixed $subjectName, array | string $accessList )
```

Removes an access from a subject

* * *

```php
protected  _allowOrDeny( mixed $operationName, mixed $subjectName, mixed $access, mixed $action [ mixed $func] )
```

Checks if a operation has access to a subject

* * *

```php
public allow( mixed $operationName, mixed $subjectName, mixed $access [, mixed $func] )
```

Allow access to a operation on a subject You can use '*' as wildcard

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

* * *

```php
public deny( mixed $operationName, mixed $subjectName, mixed $access [, mixed $func] )
```

Deny access to a operation on a subject You can use '*' as wildcard

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

* * *

```php
public isAllowed( [Phalcon\Acl\OperationInterface](Phalcon_Acl_OperationInterface) | [Phalcon\Acl\OperationAware](Phalcon_Acl_OperationAware) | string $operationName, [Phalcon\Acl\SubjectInterface](Phalcon_Acl_SubjectInterface) | [Phalcon\Acl\SubjectAware](Phalcon_Acl_SubjectAware) | string $subjectName, mixed $access [, array $parameters]): bool
```

Check whether a operation is allowed to access an action from a subject

```php
<?php

//Does andres have access to the customers subject to create?
$acl->isAllowed("andres", "Products", "create");

//Do guests have access to any subject to edit?
$acl->isAllowed("guests", "*", "edit");

```

* * *

```php
public setNoArgumentsDefaultAction( mixed $defaultAccess )
```

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY) for no arguments provided in `isAllowed()` method if there exists func for accessKey

* * *

```php
public **getNoArgumentsDefaultAction** ()
```

isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベルを返します。ただしaccessKeyのfuncは存在しているものとします。

* * *

```php
public **getOperations** ()
```

Return an array with every operation registered in the list

* * *

```php
public **getSubjects** ()
```

Return an array with every subject registered in the list

* * *

```php
public **getActiveOperation** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

Operation which the list is checking if it's allowed to certain subject/access

* * *

```php
public **getActiveSubject** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

Subject which the list is checking if some operation can access it

* * *

```php
public **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

Active access which the list is checking if some operation can access it

* * *

```php
public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

イベントマネージャーをセットします

* * *

```php
public **getEventsManager** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

内部イベントマネージャーを返します

* * *

```php
public **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

デフォルトのアクセスレベル (Phalcon\Acl::ALLOW または Phalcon\Acl::DENY)をセットします。

* * *

```php
public **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter)
```

デフォルトのACLアクセスレベルを返します