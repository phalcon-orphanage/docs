Class **Phalcon\\Logger\\Formatter\\Syslog**
============================================

*extends* :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Prepares a message to be used in a Syslog backend


Methods
---------

public  **format** (*string* $message, *int* $type, *int* $timestamp)

Applies a format to a message before sent it to the internal log



public *string*  **getTypeString** (*integer* $type) inherited from Phalcon\\Logger\\Formatter

Returns the string meaning of a logger constant



