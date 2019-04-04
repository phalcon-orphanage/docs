---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction\Failed'
---
# Class **Phalcon\Mvc\Model\Transaction\Failed**

*extends* class [Phalcon\Mvc\Model\Transaction\Exception](Phalcon_Mvc_Model_Transaction_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction/failed.zep)

This class will be thrown to exit a try/catch block for isolated transactions

## 方法

public **__construct** (*mixed* $message, [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record])

Phalcon\Mvc\Model\Transaction\Failed constructor

public **getRecordMessages** ()

Returns validation record messages which stop the transaction

public **getRecord** ()

Returns validation record messages which stop the transaction

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clone the exception

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

获取异常消息

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

获取异常代码

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

获取发生异常的文件

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

获取发生异常的行

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

获取堆栈跟踪

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

返回前一个异常

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

以字符串形式获取堆栈跟踪

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

异常的字符串表示形式