# Abstract class **Phalcon\\Logger\\Formatter**

*implements* [Phalcon\Logger\FormatterInterface](/en/3.1.2/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/formatter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is a base class for logger formatters


## Methods
public  **getTypeString** (*mixed* $type)

Returns the string meaning of a logger constant



public  **interpolate** (*string* $message, [*array* $context])

Interpolates context values into the message placeholders



abstract public  **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](/en/3.1.2/api/Phalcon_Logger_FormatterInterface)

...


