Class **Phalcon\\Logger\\Formatter\\Firephp**
=============================================

*extends* abstract class :doc:`Phalcon\\Logger\\Formatter <Phalcon_Logger_Formatter>`

*implements* :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/formatter/firephp.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Formats messages so that they can be sent to FirePHP


Methods
-------

public  **getTypeString** (*unknown* $type)

Returns the string meaning of a logger constant



public  **setShowBacktrace** ([*unknown* $isShow])

Returns the string meaning of a logger constant



public  **getShowBacktrace** ()

Returns the string meaning of a logger constant



public  **enableLabels** ([*unknown* $isEnable])

Returns the string meaning of a logger constant



public  **labelsEnabled** ()

Returns the labels enabled



public *string*  **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sending it to the log



public  **interpolate** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Formatter

Interpolates context values into the message placeholders



