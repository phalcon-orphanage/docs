Class **Phalcon\\Logger\\Formatter\\Syslog**
============================================

*extends* abstract class :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Prepares a message to be used in a Syslog backend


Methods
-------

public *array*  **format** (*unknown* $message, *unknown* $type, *unknown* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log



public *string*  **getTypeString** (*unknown* $type) inherited from Phalcon\\Logger\\Formatter

Returns the string meaning of a logger constant



public  **interpolate** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Formatter

Interpolates context values into the message placeholders



