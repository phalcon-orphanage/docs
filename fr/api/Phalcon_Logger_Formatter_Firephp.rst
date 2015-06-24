Class **Phalcon\\Logger\\Formatter\\Firephp**
=============================================

*extends* abstract class :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Formats messages so that they can be sent to FirePHP


Methods
-------

public *string*  **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



public *this*  **setShowBacktrace** ([*unknown* $isShow])

Returns the string meaning of a logger constant



public *boolean*  **getShowBacktrace** ()

Returns the string meaning of a logger constant



public *this*  **enableLabels** ([*unknown* $isEnable])

Returns the string meaning of a logger constant



public *boolean*  **labelsEnabled** ()

Returns the labels enabled



public *string*  **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sending it to the log



public  **interpolate** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Formatter

Interpolates context values into the message placeholders



