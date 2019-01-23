---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

该接口必须实现 Phalcon\\Annotations 适配器

## 方法

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

设置批注分析器

abstract public **getReader** ()

返回批注读者

abstract public **get** (*string|object* $className)

解析或检索发现在类中的所有批注

abstract public **getMethods** (*string* $className)

返回该类的所有方法中发现的批注

abstract public **getMethod** (*string* $className, *string* $methodName)

返回特定方法中找到的注释

abstract public **getProperties** (*string* $className)

返回该类的所有方法中发现的批注

abstract public **getProperty** (*string* $className, *string* $propertyName)

返回在特定的属性中找到的注释