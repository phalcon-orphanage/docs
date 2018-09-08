# Class **Phalcon\\Mvc\\Model\\ValidationFailed**

*extends* class [Phalcon\Mvc\Model\Exception](/[[language]]/[[version]]/api/Phalcon_Mvc_Model_Exception)

*implements* [Throwable](http://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/validationfailed.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This exception is generated when a model fails to save a record Phalcon\\Mvc\\Model must be set up to have this behavior

## Methods

public **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\\Mvc\\Model\\ValidationFailed constructor

public **getModel** ()

Returns the model that generated the messages

public **getMessages** ()

Returns the complete group of messages produced in the validation

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