* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Acl\Adapter'

* * *

# Abstract class **Phalcon\Acl\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/3.4/en/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/acl/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Adapter for Phalcon\Acl adapters

## Methods

```php
public **getActiveRole** ()
```

Role which the list is checking if it's allowed to certain resource/access

* * *

```php
public **getActiveResource** ()
```

Resource which the list is checking if some role can access it

* * *

```php
public **getActiveAccess** ()
```

Active access which the list is checking if some role can access it

* * *

```php
public **setEventsManager** ([Phalcon\Events\ManagerInterface](/3.4/en/api/Phalcon_Events_ManagerInterface) $eventsManager)
```

Sets the events manager

* * *

```php
public **getEventsManager** ()
```

Returns the internal event manager

* * *

```php
public **setDefaultAction** (*mixed* $defaultAccess)
```

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

* * *

```php
public **getDefaultAction** ()
```

Returns the default ACL access level

* * *

```php
abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **getNoArgumentsDefaultAction** () inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **isRole** (*mixed* $roleName) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **isResource** (*mixed* $resourceName) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters]) inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **getRoles** () inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *

```php
abstract public **getResources** () inherited from [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

...
* * *