# Class **Phalcon\\Logger\\Formatter\\Syslog**

*extends* abstract class [Phalcon\Logger\Formatter](/en/3.2/api/Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](/en/3.2/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/formatter/syslog.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Prepares a message to be used in a Syslog backend

## Methods

public *array* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](/en/3.2/api/Phalcon_Logger_Formatter)

Returns the string meaning of a logger constant

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](/en/3.2/api/Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders