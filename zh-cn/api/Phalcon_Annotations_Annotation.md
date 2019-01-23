---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/annotation.zep)

表示注释集合中的单个注释

## 方法

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

public **getName** ()

返回所批注的名称

public *mixed* **getExpression** (*array* $expr)

解析表达式注释

public *array* **getExprArguments** ()

返回表达式参数没有解决

public *array* **getArguments** ()

返回表达式参数

public **numberArguments** ()

返回批注具有的参数数目

public *mixed* **getArgument** (*int* | *string* $position)

返回参数中的特定位置

public *boolean* **hasArgument** (*int* | *string* $position)

返回参数中的特定位置

public *mixed* **getNamedArgument** (*mixed* $name)

返回一个已命名的参数

public *mixed* **getNamedParameter** (*mixed* $name)

返回一个已命名的参数