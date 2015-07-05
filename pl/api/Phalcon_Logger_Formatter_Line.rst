Class **Phalcon\\Logger\\Formatter\\Line**
==========================================

*extends* abstract class :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Formats messages using an one-line string


Methods
-------

public  **getDateFormat** ()

Default date format



public  **setDateFormat** (*unknown* $dateFormat)

Default date format



public  **getFormat** ()

Format applied to each message



public  **setFormat** (*unknown* $format)

Format applied to each message



public  **__construct** ([*unknown* $format], [*unknown* $dateFormat])

Phalcon\\Logger\\Formatter\\Line construct



public *string*  **format** (*unknown* $message, *unknown* $type, *unknown* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log



public  **getTypeString** (*unknown* $type) inherited from Phalcon\\Logger\\Formatter

Returns the string meaning of a logger constant



public  **interpolate** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Formatter

Interpolates context values into the message placeholders



