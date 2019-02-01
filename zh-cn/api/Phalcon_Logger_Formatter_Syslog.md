---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Syslog'
---
# Class **Phalcon\Logger\Formatter\Syslog**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/syslog.zep)

准备一条在Syslog后端使用的消息

## 方法

public *array* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

将格式应用到一条消息发送到内部日志

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

返回一个记录器常量的字符串含义

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

入到消息占位符的上下文值内插方式