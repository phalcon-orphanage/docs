Class **Phalcon\\Mvc\\Model\\ValidationFailed**
===============================================

*extends* class :doc:`Phalcon\\Mvc\\Model\\Exception <Phalcon_Mvc_Model_Exception>`

*implements* `Throwable <http://php.net/manual/en/class.throwable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/validationfailed.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This exception is generated when a model fails to save a record
Phalcon\\Mvc\\Model must be set up to have this behavior


Methods
-------

public  **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\\Mvc\\Model\\ValidationFailed constructor



public  **getModel** ()

Returns the model that generated the messages



public  **getMessages** ()

Returns the complete group of messages produced in the validation



final private `Exception <http://php.net/manual/en/class.exception.php>`_ **__clone** () inherited from `Exception <http://php.net/manual/en/class.exception.php>`_

Clone the exception



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



