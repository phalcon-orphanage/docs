Class **Phalcon\\Mvc\\Model\\Transaction\\Failed**
==================================================

*extends* class :doc:`Phalcon\\Mvc\\Model\\Transaction\\Exception <Phalcon_Mvc_Model_Transaction_Exception>`

*implements* Throwable

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transaction/failed.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class will be thrown to exit a try/catch block for isolated transactions


Methods
-------

public  **__construct** (*mixed* $message, [:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record])

Phalcon\\Mvc\\Model\\Transaction\\Failed constructor



public  **getRecordMessages** ()

Returns validation record messages which stop the transaction



public  **getRecord** ()

Returns validation record messages which stop the transaction



final private *Exception*  **__clone** () inherited from Exception

Clone the exception



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



