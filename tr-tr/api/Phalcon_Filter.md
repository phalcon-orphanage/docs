---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Filter'
---
# Class **Phalcon\Filter**

*implements* [Phalcon\FilterInterface](Phalcon_FilterInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter.zep)

The Phalcon\Filter component provides a set of commonly needed data filters. It provides object oriented wrappers to the php filter extension. Also allows the developer to define his/her own filters

```php
<?php

$filter = new \Phalcon\Filter();

$filter->sanitize("some(one)@exa\mple.com", "email"); // returns "someone@example.com"
$filter->sanitize("hello<<", "string"); // returns "hello"
$filter->sanitize("!100a019", "int"); // returns "100019"
$filter->sanitize("!100a019.01a", "float"); // returns "100019.01"

```

## Constants

*string* **FILTER_EMAIL**

*string* **FILTER_ABSINT**

*string* **FILTER_INT**

*string* **FILTER_INT_CAST**

*string* **FILTER_STRING**

*string* **FILTER_FLOAT**

*string* **FILTER_FLOAT_CAST**

*string* **FILTER_ALPHANUM**

*string* **FILTER_TRIM**

*string* **FILTER_STRIPTAGS**

*string* **FILTER_LOWER**

*string* **FILTER_UPPER**

*string* **FILTER_URL**

*string* **FILTER_SPECIAL_CHARS**

## Methods

public **add** (*mixed* $name, *mixed* $handler)

Adds a user-defined filter

public **sanitize** (*mixed* $value, *mixed* $filters, [*mixed* $noRecursive])

Sanitizes a value with a specified single or set of filters

protected **_sanitize** (*mixed* $value, *mixed* $filter)

Internal sanitize wrapper to filter_var

public **getFilters** ()

Return the user-defined filters in the instance