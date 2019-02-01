---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## 方法

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

设置批注分析器

public **getReader** ()

返回批注读者

public **get** (*string* | *object* $className)

解析或检索发现在类中的所有批注

public **getMethods** (*mixed* $className)

返回该类的所有方法中发现的批注

public **getMethod** (*mixed* $className, *mixed* $methodName)

返回特定方法中找到的注释

public **getProperties** (*mixed* $className)

返回该类的所有方法中发现的批注

public **getProperty** (*mixed* $className, *mixed* $propertyName)

返回在特定的属性中找到的注释