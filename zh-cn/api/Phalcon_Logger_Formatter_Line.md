---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Line'
---
# Class **Phalcon\Logger\Formatter\Line**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/line.zep)

使用单行字符串格式化消息

## 方法

public **getDateFormat** ()

默认的日期格式

public **setDateFormat** (*mixed* $dateFormat)

默认的日期格式

public **getFormat** ()

获得应用到每个消息的格式

public **setFormat** (*mixed* $format)

获得应用到每个消息的格式

public **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\Logger\Formatter\Line construct

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

将格式应用到一条消息发送到内部日志

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

返回一个记录器常量的字符串含义

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

入到消息占位符的上下文值内插方式