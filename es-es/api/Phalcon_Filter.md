* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Filter'

* * *

# Class **Phalcon\Filter**

*implements* [Phalcon\FilterInterface](Phalcon_FilterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/filter.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

The Phalcon\Filter component provides a set of commonly needed data filters. It provides object oriented wrappers to the php filter extension. Also allows the developer to define his/her own filters

```php
<?php

$filter = new \Phalcon\Filter();

$filter->sanitize("some(one)@exa\mple.com", "email"); // returns "someone@example.com"
$filter->sanitize("hello<<", "string"); // returns "hello"
$filter->sanitize("!100a019", "int"); // returns "100019"
$filter->sanitize("!100a019.01a", "float"); // returns "100019.01"

```

## Constantes

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

## Métodos

public **add** (*mixed* $name, *mixed* $handler)

Añade un filtro definido por el usuario

public **sanitize** (*mixed* $value, *mixed* $filters, [*mixed* $noRecursive])

Limpia un valor con un único filtro o un conjunto de los mismos

protected **_sanitize** (*mixed* $value, *mixed* $filter)

Envoltorio interno de filter_var para limpieza

public **getFilters** ()

Devuelve los filtros definidos por el usuario en la instancia