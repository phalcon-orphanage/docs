---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Paginator\Adapter'
---
# Abstract class **Phalcon\Paginator\Adapter**

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter.zep)

## 方法

public **setCurrentPage** (*mixed* $page)

设置当前页码

public **setLimit** (*mixed* $limitRows)

设置当前行数限制

public **getLimit** ()

获取当前行限制

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

...