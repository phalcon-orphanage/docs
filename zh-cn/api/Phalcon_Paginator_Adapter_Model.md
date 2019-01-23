---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Paginator\Adapter\Model'
---
# Class **Phalcon\Paginator\Adapter\Model**

*extends* abstract class [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter/model.zep)

This adapter allows to paginate data using a Phalcon\Mvc\Model resultset as a base.

```php
<?php

use Phalcon\Paginator\Adapter\Model;

$paginator = new Model(
    [
        "data"  => Robots::find(),
        "limit" => 25,
        "page"  => $currentPage,
    ]
);

$paginate = $paginator->getPaginate();

```

## 方法

public **__construct** (*array* $config)

Phalcon\Paginator\Adapter\Model constructor

public **getPaginate** ()

返回的结果集显示在分页中一片

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

设置当前页码

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

设置当前行数限制

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

获取当前行限制