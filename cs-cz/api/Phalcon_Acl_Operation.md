---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\Operation'
---
# Class [Phalcon\Acl\Operation](/4.0/en/api/Phalcon_Acl_Operation)

**implements**{:.c-mod} [Phalcon\Acl\OperationInterface](/4.0/en/api/Phalcon_Acl_OperationInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/acl/operation.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class defines a subject entity and its description

## Methods

```php
public __construct( string $name [, string $description= NULL] )
```

Phalcon\Acl\Operation constructor

```php
public getDescription(): string
```

Operation description

* * *

```php
public getName(): string
```

Operation name

* * *

```php
public __toString(): string
```

Operation name

* * *