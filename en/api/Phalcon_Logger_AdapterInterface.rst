Interface **Phalcon\\Logger\\AdapterInterface**
===============================================

Phalcon\\Logger\\AdapterInterface initializer


Methods
---------

abstract public  **setFormat** (*string* $format)

Set the log format



abstract public *format*  **getFormat** ()

Returns the log format



abstract public *string*  **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



abstract public  **setDateFormat** (*string* $date)

Sets the internal date format



abstract public *string*  **getDateFormat** ()

Returns the internal date format



abstract public  **log** (*string* $message, [*int* $type])

Sends/Writes messages to the file log



abstract public  **begin** ()

Starts a transaction



abstract public  **commit** ()

Commits the internal transaction



abstract public  **rollback** ()

Rollbacks the internal transaction



abstract public *boolean*  **close** ()

Closes the logger



abstract public  **debug** (*string* $message)

Sends/Writes a debug message to the log



abstract public  **error** (*string* $message)

Sends/Writes an error message to the log



abstract public  **info** (*string* $message)

Sends/Writes an info message to the log



abstract public  **notice** (*string* $message)

Sends/Writes a notice message to the log



abstract public  **warning** (*string* $message)

Sends/Writes a warning message to the log



abstract public  **alert** (*string* $message)

Sends/Writes an alert message to the log



