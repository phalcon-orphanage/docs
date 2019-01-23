---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Firephp'
---
# Class **Phalcon\Logger\Formatter\Firephp**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/firephp.zep)

设置邮件的格式，以便他们可以发送到 FirePHP

## 方法

public **getTypeString** (*mixed* $type)

返回一个记录器常量的字符串含义

public **setShowBacktrace** ([*mixed* $isShow])

返回一个记录器常量的字符串含义

public **getShowBacktrace** ()

返回一个记录器常量的字符串含义

public **enableLabels** ([*mixed* $isEnable])

返回一个记录器常量的字符串含义

public **labelsEnabled** ()

返回标签启用

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

发送到日志之前应用于该消息的格式

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

入到消息占位符的上下文值内插方式