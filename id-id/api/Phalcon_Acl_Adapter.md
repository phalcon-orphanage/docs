---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Acl\Adapter'
---
# Abstract class **Phalcon\Acl\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapter.zep)

Adaptor untuk Phalcon\Acl adapter

## Metode

```php
public getActiveAccess()
```

Akses aktif dimana daftar memeriksa jika beberapa operasi dapat mengeksesnya

* * *

```php
public getActiveOperation()
```

Operasi dimana daftar melakukan cek jika diizinkan untuk masuk ke beberapa subject/access

* * *

```php
public getActiveSubject()
```

Subjek dimana daftar memeriksa jika beberapa operasi mendapatkan akses

* * *

```php
```php
public getDefaultAction()
```

Mengembalikan tingkat akses ACL default

* * *

public getEventsManager()

    Returns the internal event manager
    <hr/>
    ```php
    public setDefaultAction(mixed $defaultAccess)
    

Menetapkan tingkat akses default (Phalcon\Acl::ALLOW atau Phalcon\Acl:: DENY)

* * *

```php
public setEventsManager([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)
```

Menyetel pengelola acara

* * *

```php
abstract public addInherit(mixed $operationName, mixed $operationToInherit) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public addOperation(mixed $operation, [mixed $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
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
abstract public allow(mixed $operationName, mixed $subjectName, mixed $access, [mixed $func]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public deny(mixed $operationName, mixed $subjectName, mixed $access, [mixed $func]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public dropSubjectAccess(mixed $subjectName, mixed $accessList) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *

```php
abstract public getNoArgumentsDefaultAction() inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
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

```php
abstract public isAllowed(mixed $operationName, mixed $subjectName, mixed $access, [array $parameters]) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
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
abstract public setNoArgumentsDefaultAction(mixed $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)
```

* * *