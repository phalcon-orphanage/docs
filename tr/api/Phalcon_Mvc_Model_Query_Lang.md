# Abstract class **Phalcon\\Mvc\\Model\\Query\\Lang**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/query/lang.zep" class="btn btn-default btn-sm">GitHub üzerindeki kaynak</a>

PHQL, RDBMS hedefinde (C dilinde yazılmış olan) bir sözdizimini çeviren bir ayrıştırıcı olarak uygulanır. It allows Phalcon to offer a unified SQL language to the developer, while internally doing all the work of translating PHQL instructions to the most optimal SQL instructions depending on the RDBMS type associated with a model.

To achieve the highest performance possible, we wrote a parser that uses the same technology as SQLite. This technology provides a small in-memory parser with a very low memory footprint that is also thread-safe.

```php
<?php

$intermediate = Phalcon\Mvc\Model\Query\Lang::parsePHQL("SELECT r.* FROM Robots r LIMIT 10");

```

## Yöntemler

public static *string* **parsePHQL** (*string* $phql)

Parses a PHQL statement returning an intermediate representation (IR)