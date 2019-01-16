---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\Operation'
---
# Class [Phalcon\Acl\Operation](Phalcon_Acl_Operation)

**implements**{:.language-php .highlighter-rouge .highligter .hljs-keyword} [Phalcon\Acl\OperationInterface](Phalcon_Acl_OperationInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/operation.zep)

This class defines a subject entity and its description

## Methods
```php
public __construct( string $name [, string $description = NULL] )
```
Phalcon\Acl\Operation constructor

```php
public getDescription(): string
```
Operation description
<hr/>
```php
public getName(): string
```
Operation name
<hr/>
```php
public __toString(): string
```
Operation name
<hr/>
