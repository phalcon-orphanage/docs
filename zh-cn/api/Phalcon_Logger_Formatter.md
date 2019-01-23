---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Formatter'
---
# Abstract class **Phalcon\Logger\Formatter**

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter.zep)

这是一个基类记录器格式化程序

## 方法

public **getTypeString** (*mixed* $type)

返回一个记录器常量的字符串含义

public **interpolate** (*string* $message, [*array* $context])

入到消息占位符的上下文值内插方式

abstract public **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

...