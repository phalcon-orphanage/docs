---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Filter'
---
# Class **Phalcon\Filter**

*implements* [Phalcon\FilterInterface](Phalcon_FilterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter.zep)

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

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

*tali* **DEFAULT_DELIMITER**

## Metode

public **addInherit** (*mixed* $name, *mixed* $handler)

Menambahkan filter yang ditentukan pengguna  

publik **tambahkandilineJs** (*campuran* $value, [*campuran* $filters], [*campuran* $noRecursive])

Sanitasi nilai dengan satu atau set filter tertentu  

terlindung **_ukuran** (*campuran* $value, *campuran* $filter)

Pembungkus pembersih internal untuk filter_var  

public **getFilters** ()

Kembalikan filter yang ditentukan pengguna di contoh  