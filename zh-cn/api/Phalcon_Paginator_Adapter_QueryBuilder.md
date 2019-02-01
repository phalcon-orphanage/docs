---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Paginator\Adapter\QueryBuilder'
---
# Class **Phalcon\Paginator\Adapter\QueryBuilder**

*extends* abstract class [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter/querybuilder.zep)

分页使用 PHQL 作为数据源的查询生成器

```php
<?php

use Phalcon\Paginator\Adapter\QueryBuilder;

$builder = $this->modelsManager->createBuilder()
                ->columns("id, name")
                ->from("Robots")
                ->orderBy("name");

$paginator = new QueryBuilder(
    [
        "builder" => $builder,
        "limit"   => 20,
        "page"    => 1,
    ]
);

```

## 方法

public **__construct** (*array* $config)

public **getCurrentPage** ()

获取当前页码

public **setQueryBuilder** ([Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) $builder)

设置的查询生成器对象

public **getQueryBuilder** ()

获取查询生成器对象

public **getPaginate** ()

返回的结果集显示在分页中一片

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

设置当前页码

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

设置当前行数限制

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

获取当前行限制