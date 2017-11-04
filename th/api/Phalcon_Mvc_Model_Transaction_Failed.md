# Class **Phalcon\\Mvc\\Model\\Transaction\\Failed**

*extends* class [Phalcon\Mvc\Model\Transaction\Exception](/en/3.2/api/Phalcon_Mvc_Model_Transaction_Exception)

*implements* [Throwable](http://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transaction/failed.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class will be thrown to exit a try/catch block for isolated transactions

## Methods

public **__construct** (*mixed* $message, [[Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $record])

Phalcon\\Mvc\\Model\\Transaction\\Failed constructor

public **getRecordMessages** ()

Returns validation record messages which stop the transaction

public **getRecord** ()

Returns validation record messages which stop the transaction

final private [Exception](http://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Clone the exception

public **__wakeup** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Gets the Exception message

final public *int* **getCode** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Gets the Exception code

final public *string* **getFile** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Gets the file in which the exception occurred

final public *int* **getLine** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Gets the line in which the exception occurred

final public *array* **getTrace** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Gets the stack trace

final public [Exception](http://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Returns previous Exception

final public [Exception](http://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Gets the stack trace as a string

public *string* **__toString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

String representation of the exception