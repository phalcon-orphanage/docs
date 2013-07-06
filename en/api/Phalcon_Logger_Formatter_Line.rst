Class **Phalcon\\Logger\\Formatter\\Line**
==========================================

*extends* :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Formats messages using an one-line string


Methods
---------

public  **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\\Logger\\Formatter\\Line construct



public  **setFormat** (*string* $format)

Set the log format



public *format*  **getFormat** ()

Returns the log format



public  **setDateFormat** (*string* $date)

Sets the internal date format



public *string*  **getDateFormat** ()

Returns the internal date format



public *string*  **format** (*string* $message, *int* $type, *int* $timestamp)

Applies a format to a message before sent it to the internal log



public *string*  **getTypeString** (*integer* $type) inherited from Phalcon\\Logger\\Formatter

Returns the string meaning of a logger constant



