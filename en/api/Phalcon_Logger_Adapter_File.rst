Class **Phalcon\\Logger\\Adapter\\File**
========================================

*extends* :doc:`Phalcon\\Logger <Phalcon_Logger>`

Constants
---------

integer **SPECIAL**

integer **CUSTOM**

integer **DEBUG**

integer **INFO**

integer **NOTICE**

integer **WARNING**

integer **ERROR**

integer **ALERT**

integer **CRITICAL**

integer **EMERGENCE**

Methods
---------

public **__construct** (*string* $name, *array* $options)

Phalcon\\Logger\\Adapter\\File constructor



public **setFormat** (*string* $format)

Set the log format



*format* public **getFormat** ()

Returns the log format



*string* public **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



*string* protected **_applyFormat** ()

Applies the internal format to the message



public **setDateFormat** (*string* $date)

Sets the internal date format



*string* public **getDateFormat** ()

Returns the internal date format



public **log** (*string* $message, *int* $type)

Sends/Writes messages to the file log



public **begin** ()

Starts a transaction



public **commit** ()

Commits the internal transaction



public **rollback** ()

Rollbacks the internal transaction



*boolean* public **close** ()

Closes the logger



public **__wakeup** ()

Opens the internal file handler after unserialization



public **debug** (*unknown* $message)

public **error** (*unknown* $message)

public **info** (*unknown* $message)

public **notice** (*unknown* $message)

public **warning** (*unknown* $message)

public **alert** (*unknown* $message)

