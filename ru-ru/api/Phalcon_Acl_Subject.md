---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Acl\Subject'
---
# Class [Phalcon\Acl\Subject](Phalcon_Acl_Subject)

**implements**{:.c-mod} [Phalcon\Acl\SubjectInterface](Phalcon_Acl_SubjectInterface)

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/subject.zep)

This class defines a subject entity and its description

## Methods

```php
public __construct( string $name [, string $description = NULL] )
```

Phalcon\Acl\Subject constructor

* * *

```php
public getDescription(): string
```

Subject description

* * *

```php
public getName(): string
```

Subject name

* * *

```php
public __toString(): string
```

Subject name

* * *