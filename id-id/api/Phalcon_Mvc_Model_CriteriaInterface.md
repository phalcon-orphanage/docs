---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\CriteriaInterface'
---
# Interface **Phalcon\Mvc\Model\CriteriaInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/criteriainterface.zep)

## Metode

abstrak umum **mengatur Nama Model**(*campuran* $modelName)

...

abstract public **getModelName** ()

...

abstrak umum **mengikat** (*susunan* $bindParams)

...

abstrak umum **Jenis mengikat** (*menyusun* $bindTypes)

...

abstrak umum **dimana** (*campuran* $conditions)

...

abstrak umum **keadaan** (*campuran* $conditions)

...

abstrak umum **Dari pesanan** (*campuran* $orderColumns)

...

abstrak umum **batas** (*campuran* $limit, [*campuran* $offset])

...

abstrak umum **Perbaharui untuk** ([*campuran* $forUpdate])

...

abstrak umum **Kunci bersama** ([*campuran* $sharedLock])

...

abstrak umum **dan Dimana** (*campuran* $conditions, [*campuran* $bindParams], [*campuran* $bindTypes])

...

abstrak umum **atau Dimana** (*campuran* $conditions, [*campuran* $bindParams], [*campuran* $bindTypes])

...

abstrak umum **Dimana antara** (*campuran* $expr, *campuran* $minimum, *campuran* $maximum)

...

abstract public **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

...

abstrak umum **Dimana dalam** (*campuran* $expr, *menyusun* $values)

...

abstract public **notInWhere** (*mixed* $expr, *array* $values)

...

abstrak umum **Dimana mendapatkan** ()

...

abstrak umum **mendapatkan Keadaan** ()

...

abstrak umum **mendapatkan Batas** ()

...

abstrak umum **mendapatkan Pesanan Dari** ()

...

abstrak publik **terakhirmendapatkankunci**()

...

publik abstrak **execute** ()

...