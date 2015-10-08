Class **Phalcon\\Logger\\Formatter\\Json**
==========================================

*extends* abstract class :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Formats messages using JSON encoding


Methods
-------

public *string*  **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log



public  **getTypeString** (*unknown* $type) inherited from Phalcon\\Logger\\Formatter

Returns the string meaning of a logger constant



public  **interpolate** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Formatter

Interpolates context values into the message placeholders



