---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Acl\Operation'
---
# Class [Phalcon\Acl\Operation](Phalcon_Acl_Operation)

**implements**{:.language-php .highlighter-rouge .highligter .hljs-keyword} [Phalcon\Acl\OperationInterface](Phalcon_Acl_OperationInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/operation.zep)

This class defines a subject entity and its description

## Metodlar

```php
public __construct( string $name [, string $description = NULL] )
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