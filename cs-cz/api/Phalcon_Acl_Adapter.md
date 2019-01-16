* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Acl\Adapter'

* * *

# Abstract class **Phalcon\Acl\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/acl/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Adapter for Phalcon\Acl adapters

## Methods

```php
public getActiveOperation()
```

Operation which the list is checking if it's allowed to certain subject/access

* * *

```php
public getActiveSubject()
```

Subject which the list is checking if some operation can access it

* * *

```php
public getActiveAccess()
```

Active access which the list is checking if some operation can access it

* * *

```php
public setEventsManager([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)
```

Sets the events manager

* * *

```php
public getEventsManager()
```

Returns the internal event manager

* * *

```php
public setDefaultAction(mixed $defaultAccess)
```

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

* * *

```php
public getDefaultAction()
```

Returns the default ACL access level

* * *

```php
abstract public setNoArgumentsDefaultAction(mixed $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getNoArgumentsDefaultAction() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addOperation(mixed $operation, [mixed $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addInherit(mixed $operationName, mixed $operationToInherit) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public isOperation(mixed $operationName) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public isSubject(mixed $subjectName) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addSubject(mixed $subjectObject, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addSubjectAccess(mixed $subjectName, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public dropSubjectAccess(mixed $subjectName, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public allow(mixed $operationName, mixed $subjectName, mixed $access, [mixed $func]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public deny(mixed $operationName, mixed $subjectName, mixed $access, [mixed $func]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public isAllowed(mixed $operationName, mixed $subjectName, mixed $access, [array $parameters]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getOperations() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getSubjects() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *