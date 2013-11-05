Class **Phalcon\\Logger\\Formatter\\Firephp**
=============================================

*extends* abstract class :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

Formats messages so that they can be sent to FirePHP


Methods
---------

public *string*  **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



public  **getShowBacktrace** ()

...


public  **setShowBacktrace** ([*unknown* $show])

...


public *string*  **format** (*string* $message, *int* $type, *int* $timestamp)

Applies a format to a message before sending it to the log



