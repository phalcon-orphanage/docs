---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Apc'
---
# Class **Phalcon\Annotations\Adapter\Apc**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/apc.zep)

Stores the parsed annotations in APC. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apc;

$annotations = new Apc();

```

## 方法

public **__construct** ([*array* $options])

Phalcon\Annotations\Adapter\Apc constructor

public **read** (*mixed* $key)

读解析从 APC 的注释

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

写操作解析 APC 的说明

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

设置批注分析器

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

返回批注读者

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

解析或检索发现在类中的所有批注

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

返回该类的所有方法中发现的批注

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

返回特定方法中找到的注释

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

返回该类的所有方法中发现的批注

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

返回在特定的属性中找到的注释