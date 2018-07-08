# Clase **Phalcon\\Filter**

*implements* [Phalcon\FilterInterface](/[[language]]/[[version]]/api/Phalcon_FilterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/filter.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

El componente de Phalcon\\Filter proporciona un conjunto de filtros de datos comúnmente necesarios. Proporciona contenedores de orientado a objetos para la extensión de filtro de php. También permite al desarrollador definir sus propios filtros

```php
<?php

$filter = new \Phalcon\Filter();

$filter->sanitize("some(one)@exa\\mple.com", "email"); // returna "someone@example.com"
$filter->sanitize("hello<<", "string"); // returna "hello"
$filter->sanitize("!100a019", "int"); // returna "100019"
$filter->sanitize("!100a019.01a", "float"); // returna "100019.01"

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