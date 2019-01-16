* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Config\Exception'

* * *

# Class **Phalcon\Config\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/config/exception.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clone the exception

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

异常构造函数

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