* * *

layout: default language: 'en' version: '4.0' title: 'Phalcon\Logger\Formatter\Json'

* * *

# Class **Phalcon\Logger\Formatter\Json**

*extends* abstract class [Phalcon\Logger\Formatter](/3.4/en/api/Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](/3.4/en/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/logger/formatter/json.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Formats messages using JSON encoding

## Methods

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](/3.4/en/api/Phalcon_Logger_Formatter)

Returns the string meaning of a logger constant

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](/3.4/en/api/Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders