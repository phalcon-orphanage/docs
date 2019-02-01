---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Adapter'
---
# Abstract class **Phalcon\Logger\Adapter**

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter.zep)

Base class for Phalcon\Logger adapters

## 方法

public **setLogLevel** (*mixed* $level)

筛选日志发送到特定级别比都小于或等于的处理

public **getLogLevel** ()

返回当前的日志级别

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

设置消息格式化程序

public **begin** ()

启动一个事务

public **commit** ()

提交的内部事务

public **rollback** ()

回滚的内部事务

public **isTransaction** ()

返回是否记录器处于当前活动的事务或不

public **critical** (*mixed* $message, [*array* $context])

关键消息发送/写入日志

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

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Logs messages to the internal logger. Appends logs to the logger

abstract public **getFormatter** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...