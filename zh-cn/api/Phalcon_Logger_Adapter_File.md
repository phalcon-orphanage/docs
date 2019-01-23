---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Logger\Adapter\File'
---
# Class **Phalcon\Logger\Adapter\File**

*extends* abstract class [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter/file.zep)

适配器在纯文本文件中存储日志

```php
<?php

$logger = new \Phalcon\Logger\Adapter\File("app/logs/test.log");

$logger->log("This is a message");
$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();

```

## 方法

public **getPath** ()

文件路径

public **__construct** (*string* $name, [*array* $options])

Phalcon\Logger\Adapter\File constructor

public **getFormatter** ()

返回内部格式化程序

public **logInternal** (*mixed* $message, *mixed* $type, *mixed* $time, *array* $context)

将日志写入到文件本身

public **close** ()

关闭记录器

public **__wakeup** ()

将内部文件处理程序打开后和解

public **setLogLevel** (*mixed* $level) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

筛选日志发送到特定级别比都小于或等于的处理

public **getLogLevel** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

返回当前的日志级别

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

设置消息格式化程序

public **begin** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

启动一个事务

public **commit** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

提交的内部事务

public **rollback** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

回滚的内部事务

public **isTransaction** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

返回是否记录器处于当前活动的事务或不

public **critical** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

关键消息发送/写入日志

public **emergency** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

紧急消息发送/写入日志

public **debug** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

调试消息发送/写入日志

public **error** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

一条错误消息发送/写入日志

public **info** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Info 消息发送/写入日志

public **notice** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

通知消息发送/写入日志

public **warning** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

一条警告消息发送/写入日志

public **alert** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

警报消息发送/写入日志

public **log** (*mixed* $type, [*mixed* $message], [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Logs messages to the internal logger. Appends logs to the logger