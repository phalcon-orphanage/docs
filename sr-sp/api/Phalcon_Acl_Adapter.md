---
layout: default
language: 'sr-sp'
version: '4.0'
title: 'Phalcon\Acl\Adapter'
---

# Abstract class **Phalcon\Acl\Adapter**

**implements** [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapter.zep)

Adapter for Phalcon\Acl adapters

## Methods

```php
public getActiveAccess()
```

Active access which the list is checking if some role can access it

* * *

```php
public getActiveRole()
```

Role which the list is checking if it's allowed to certain component/access

* * *

```php
public getActiveComponent()
```

Component which the list is checking if some role can access it

* * *

```php
```php
public getDefaultAction()
```

Returns the default ACL access level

* * *

public getEventsManager()

    Returns the internal event manager
    <hr/>
    ```php
    public setDefaultAction(mixed $defaultAccess)
    

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

* * *

```php
public setEventsManager([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)
```

Sets the events manager

* * *

```php
abstract public addInherit(mixed $roleName, mixed $roleToInherit) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addRole(mixed $role, [mixed $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addComponent(mixed $componentObject, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addComponentAccess(mixed $componentName, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public allow(mixed $roleName, mixed $componentName, mixed $access, [mixed $func]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public deny(mixed $roleName, mixed $componentName, mixed $access, [mixed $func]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public dropComponentAccess(mixed $componentName, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getNoArgumentsDefaultAction() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getRoles() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getComponents() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public isAllowed(mixed $roleName, mixed $componentName, mixed $access, [array $parameters]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public isRole(mixed $roleName) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public isComponent(mixed $componentName) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public setNoArgumentsDefaultAction(mixed $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *