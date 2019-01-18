---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\Adapter\Memory'
---
# Class **Phalcon\Acl\Adapter\Memory**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapter/memory.zep)

| Extends    | [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter) |
| Implements | [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface) |


### Description

Manages ACL lists in memory

### Example

```php
<?php

namespace Phalcon\Acl\Adapter;

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// Register operations
$operations = [
    "users"  => new Operation("Users"),
    "guests" => new Operation("Guests"),
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
    $acl->addSubject(new Subject($subjectName), $actions);
}

// Public area subjects
$publicSubjects = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicSubjects as $subjectName => $actions) {
    $acl->addSubject(new Subject($subjectName), $actions);
}

// Grant access to public areas to both users and guests
foreach ($operations as $operation){
    foreach ($publicSubjects as $subject => $actions) {
        $acl->allow($operation->getName(), $subject, "");
    }
}

// Grant access to private area to operation Users
foreach ($privateSubjects as $subject => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $subject, $action);
    }
}
```

### Properties

```php
protected mixed $access         
```
Access


```php
protected mixed $accessList
```         
Access List


```php
protected mixed $activeFunction
```         
Returns latest function used to acquire access


```php
protected int $activeFunctionCustomArgumentsCount = 0
```
`Returns number of additional arguments(excluding role and resource) for active function


```php
protected string|null $activeKey  
```
Returns latest key used to acquire access


```php
protected mixed $func         
```
Function List


```php
protected mixed $noArgumentsDefaultAction = Acl::DENY         
```
Default action for no arguments is allow


```php
protected mixed $operations         
```
Operations


```php
protected mixed $operationInherits         
```
Operation Inherits


```php
protected mixed $operationsNames         
```
Operations Names


```php
protected mixed $subjects         
```
Subjects


```php
protected mixed $subjectsNames         
```
Subject Names



### Methods

Returns latest function used to acquire access

```php
public function getActiveFunction(): mixed
```
<hr/>


Returns number of additional arguments(excluding role and resource) for active function

```php
public function getActiveFunctionCustomArgumentsCount(): int
```
<hr/>


Returns latest key used to acquire access

```php
public function getActiveKey():? string
```
<hr/>


Inherit from an existing operation

```php
public function addInherit(string $operationName, mixed $operationToInherits): bool
```

```php
$acl->addOperation("administrator", "consultant");
$acl->addOperation("administrator", ["consultant", "consultant2"]);
```
<hr/>


Adds a operation to the ACL list. Second parameter allows inheriting access data from other existing operation

```php
public function addOperation(
    Phalcon\Acl\OperationInterface|string|array $operation, 
    string $accessInherits = null
): bool
```

 ```php
$acl->addOperation(
    new Phalcon\Acl\Operation("administrator"),
    "consultant"
 );
 
 $acl->addOperation("administrator", "consultant");
 $acl->addOperation("administrator", ["consultant", "consultant2"]);
```
<hr/>


Adds a subject to the ACL list

```php
public function addSubject(
    Phalcon\Acl\SubjectInterface|string $subjectValue, 
    array|string $accessList
): bool
```

```php
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
<hr/>


Adds access to subjects

```php
public function addSubjectAccess(string $subjectName, array|string $accessList): bool
```
<hr/>


Allow access to a operation on a subject

```php
public function allow( string $operationName, string $subjectName, mixed $access [, mixed $func = null] )
```

```php
// Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

// Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

// Allow access to any operation to browse on products
$acl->allow("", "products", "browse");

// Allow access to any operation to browse on any subject
$acl->allow("", "", "browse");
```
<hr/>


Deny access to a operation on a subject

```php
public function deny( string $operationName, string $subjectName, mixed $access [, mixed $func = null] )
```

```php
// Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

// Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

// Deny access to any operation to browse on products
$acl->deny("", "products", "browse");

// Deny access to any operation to browse on any subject
$acl->deny("", "", "browse");
```
<hr/>


Removes an access from a subject

```php
public function dropSubjectAccess( string $subjectName, array|string $accessList )
```
<hr/>


Returns the default ACL access level for no arguments provided in `isAllowed()` action if there exists func for accessKey

```php
public function getNoArgumentsDefaultAction(): int {}
```
<hr/>


Return an array with every operation registered in the list

```php
public function getOperations(): Phalcon\Acl\OperationInterface[]
```
<hr/>


Return an array with every subject registered in the list

```php
public function getSubjects(): [Phalcon\Acl\SubjectInterface](Phalcon_Acl_SubjectInterface)[]
```
<hr/>

Check whether a operation is allowed to access an action from a subject

```php
public function isAllowed(
    Phalcon\Acl\OperationInterface|Phalcon\Acl\OperationAware|string $operationName, 
    Phalcon\Acl\SubjectInterface|Phalcon\Acl\SubjectAware|string $subjectName, 
    string $access, 
    array $parameters = null
): bool
```

```php
// Does andres have access to the customers subject to create?
$acl->isAllowed("andres", "Products", "create");

// Do guests have access to any subject to edit?
$acl->isAllowed("guests", "", "edit");
```
<hr/>


Check whether operation exist in the operations list

```php
public function isOperation(string $operationName): bool 
```
<hr/>


Check whether subject exist in the subjects list

```php
public function isSubject(string $subjectName): bool
```
<hr/>


Sets the default access level (`Phalcon\Acl::ALLOW` or `Phalcon\Acl::DENY`) for no arguments provided in `isAllowed()` action if a `func` exists for `accessKey`

```php
public function setNoArgumentsDefaultAction(int $defaultAccess)
```
<hr/>
