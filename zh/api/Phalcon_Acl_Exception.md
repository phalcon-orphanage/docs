# Class **Phalcon\\Acl\\Exception**

*extends* class [Phalcon\Exception](/en/3.2/api/Phalcon_Exception)

*implements* [Throwable](http://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/exception.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## Methods

final private [Exception](http://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Clone the exception

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](http://php.net/manual/en/class.exception.php)

异常构造函数

public **__wakeup** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

获取异常消息

final public *int* **getCode** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

获取异常代码

final public *string* **getFile** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

获取发生异常的文件

final public *int* **getLine** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

获取发生异常的行

final public *array* **getTrace** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

获取堆栈跟踪

final public [Exception](http://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

返回前一个异常

final public [Exception](http://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

以字符串形式获取堆栈跟踪

public *string* **__toString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

异常的字符串表示形式