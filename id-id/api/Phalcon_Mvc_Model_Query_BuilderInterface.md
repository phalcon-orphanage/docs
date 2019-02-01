---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query\BuilderInterface'
---
# Interface **Phalcon\Mvc\Model\Query\BuilderInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query/builderinterface.zep)

## Constants

*string* **OPERATOR_OR**

*string* **OPERATOR_AND**

## Metode

kolom publik abstrak** ** (*campuran* $columns)

...

abstrak publik **getColumns** ()

...

abstrak publik **dari** (*mixed* $models)

...

abstrak publik **addFrom** (*mixed* $model, [*mixed* $alias])

...

abstrak publik **getFrom** ()

...

abstrak publik **join** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias], [*dicampur* $type])

...

abstrak publik **innerJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...

abstrak publik **leftJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...

abstract public **rightJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...

abstract public **getJoins** ()

...

abstract public **where** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...

abstrak umum **dan Dimana** (*campuran* $conditions, [*campuran* $bindParams], [*campuran* $bindTypes])

...

abstrak umum **atau Dimana** (*campuran* $conditions, [*campuran* $bindParams], [*campuran* $bindTypes])

...

abstract public **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

...

abstract public **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

...

abstract public **inWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

...

abstract public **notInWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

...

abstrak umum **Dimana mendapatkan** ()

...

abstract public **orderBy** (*mixed* $orderBy)

...

abstrak umum **mendapatkan Pesanan Dari** ()

...

abstract public **having** (*mixed* $having)

...

abstract public **getHaving** ()

...

abstrak umum **batas** (*campuran* $limit, [*campuran* $offset])

...

abstrak umum **mendapatkan Batas** ()

...

abstract public **groupBy** (*mixed* $group)

...

abstract public **getGroupBy** ()

...

abstract public **getPhql** ()

...

abstract public **getQuery** ()

...