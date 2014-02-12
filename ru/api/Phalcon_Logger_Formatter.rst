Abstract class **Phalcon\\Logger\\Formatter**
=============================================

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

This is a base class for logger formatters


Methods
-------

public *string*  **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



protected  **interpolate** (*string* $message, *array* $context)

Interpolates context values into the message placeholders



abstract public  **format** (*string* $message, *int* $type, *int* $timestamp, *array* $context) inherited from Phalcon\\Logger\\FormatterInterface

Applies a format to a message before sent it to the internal log



