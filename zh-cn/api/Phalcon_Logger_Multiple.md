---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Multiple'
---
# Class **Phalcon\Logger\Multiple**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/multiple.zep)

Handles multiples logger handlers

## 方法

public **getLoggers** ()

...

public **getFormatter** ()

...

public **getLogLevel** ()

...

public **push** ([Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface) $logger)

Pushes a logger to the logger tail

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Sets a global formatter

public **setLogLevel** (*mixed* $level)

Sets a global level

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Sends a message to each registered logger

public **critical** (*mixed* $message, [*array* $context])

Sends/Writes an critical message to the log

public **emergency** (*mixed* $message, [*array* $context])

紧急消息发送/写入日志

public **debug** (*mixed* $message, [*array* $context])

调试消息发送/写入日志

public **error** (*mixed* $message, [*array* $context])

一条错误消息发送/写入日志

public **info** (*mixed* $message, [*array* $context])

Info 消息发送/写入日志

public **notice** (*mixed* $message, [*array* $context])

通知消息发送/写入日志

public **warning** (*mixed* $message, [*array* $context])

一条警告消息发送/写入日志

public **alert** (*mixed* $message, [*array* $context])

警报消息发送/写入日志