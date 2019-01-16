* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\ValidationFailed'

* * *

# Class **Phalcon\Mvc\Model\ValidationFailed**

*extends* class [Phalcon\Mvc\Model\Exception](Phalcon_Mvc_Model_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/validationfailed.zep" class="btn btn-default btn-sm">源码在GitHub</a>

This exception is generated when a model fails to save a record Phalcon\Mvc\Model must be set up to have this behavior

## 方法

public **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\Mvc\Model\ValidationFailed constructor

public **getModel** ()

Returns the model that generated the messages

public **getMessages** ()

Returns the complete group of messages produced in the validation

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