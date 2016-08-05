Class **Phalcon\\Security\\Exception**
======================================

*extends* class :doc:`Phalcon\\Exception <Phalcon_Exception>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/security/exception.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

final private *Exception*  **__clone** () inherited from Exception

Clone the exception



public  **__construct** ([*string* $message], [*int* $code], [*Exception* $previous]) inherited from Exception

Exception constructor



public  **__wakeup** () inherited from Exception

...


final public *string*  **getMessage** () inherited from Exception

Gets the Exception message



final public *int*  **getCode** () inherited from Exception

Gets the Exception code



final public *string*  **getFile** () inherited from Exception

Gets the file in which the exception occurred



final public *int*  **getLine** () inherited from Exception

Gets the line in which the exception occurred



final public *array*  **getTrace** () inherited from Exception

Gets the stack trace



final public *Exception*  **getPrevious** () inherited from Exception

Returns previous Exception



final public *Exception*  **getTraceAsString** () inherited from Exception

Gets the stack trace as a string



public *string*  **__toString** () inherited from Exception

String representation of the exception



