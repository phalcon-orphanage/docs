Class **Phalcon\\Queue\\Beanstalk\\Exception**
==============================================

*extends* class :doc:`Phalcon\\Exception <Phalcon_Exception>`

*implements* `Throwable <http://php.net/manual/en/class.throwable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/queue/beanstalk/exception.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

final private `Exception <http://php.net/manual/en/class.exception.php>`_ **__clone** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Clone the exception



public  **__construct** ([*string* $message], [*int* $code], [`Exception <http://php.net/manual/en/class.exception.php>`_ $previous]) inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Exception constructor



public  **__wakeup** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

...


final public *string* **getMessage** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Gets the Exception message



final public *int* **getCode** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Gets the Exception code



final public *string* **getFile** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Gets the file in which the exception occurred



final public *int* **getLine** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Gets the line in which the exception occurred



final public *array* **getTrace** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Gets the stack trace



final public `Exception <http://php.net/manual/en/class.exception.php>`_ **getPrevious** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Returns previous Exception



final public `Exception <http://php.net/manual/en/class.exception.php>`_ **getTraceAsString** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Gets the stack trace as a string



public *string* **__toString** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

String representation of the exception



