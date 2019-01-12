* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Logger\Formatter\Firephp'

* * *

# Class **Phalcon\Logger\Formatter\Firephp**

*extends* abstract class [Phalcon\Logger\Formatter](/4.0/en/api/Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](/4.0/en/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/logger/formatter/firephp.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Formats messages so that they can be sent to FirePHP

## Methods

public **getTypeString** (*mixed* $type)

Returns the string meaning of a logger constant

public **setShowBacktrace** ([*mixed* $isShow])

Returns the string meaning of a logger constant

public **getShowBacktrace** ()

Returns the string meaning of a logger constant

public **enableLabels** ([*mixed* $isEnable])

Returns the string meaning of a logger constant

public **labelsEnabled** ()

Returns the labels enabled

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sending it to the log

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](/4.0/en/api/Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders