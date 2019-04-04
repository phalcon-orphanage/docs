---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query\Lang'
---
# Abstract class **Phalcon\Mvc\Model\Query\Lang**

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query/lang.zep)

PHQL is implemented as a parser (written in C) that translates syntax in that of the target RDBMS. It allows Phalcon to offer a unified SQL language to the developer, while internally doing all the work of translating PHQL instructions to the most optimal SQL instructions depending on the RDBMS type associated with a model.

To achieve the highest performance possible, we wrote a parser that uses the same technology as SQLite. This technology provides a small in-memory parser with a very low memory footprint that is also thread-safe.

```php
<?php

$intermediate = Phalcon\Mvc\Model\Query\Lang::parsePHQL("SELECT r.* FROM Robots r LIMIT 10");

```

## メソッド

public static *string* **parsePHQL** (*string* $phql)

Parses a PHQL statement returning an intermediate representation (IR)