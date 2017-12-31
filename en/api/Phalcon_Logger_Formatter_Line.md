# Class **Phalcon\\Logger\\Formatter\\Line**

*extends* abstract class [Phalcon\Logger\Formatter](/en/3.1.2/api/Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](/en/3.1.2/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/formatter/line.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Formats messages using an one-line string

## Methods
public  **getDateFormat** ()

Default date format

public  **setDateFormat** (*mixed* $dateFormat)

Default date format

public  **getFormat** ()

Format applied to each message

public  **setFormat** (*mixed* $format)

Format applied to each message

public  **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\\Logger\\Formatter\\Line construct

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log

public  **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](/en/3.1.2/api/Phalcon_Logger_Formatter)

Returns the string meaning of a logger constant

public  **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](/en/3.1.2/api/Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders

