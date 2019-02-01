---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Reader'
---
# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reader.zep)

解析 docblocks 返回数组与发现注释

## 方法

public **parse** (*mixed* $className)

Reads annotations from the class dockblocks, its methods and/or properties

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

解析返回注释的原始文档块