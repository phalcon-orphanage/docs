* * *

<<<<<<< HEAD
layout: default language: 'en' version: '4.0' title: 'Phalcon\Logger\Formatter'
=======
layout: article language: 'en' version: '4.0' title: 'Phalcon\Logger\Formatter'
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

* * *

# Abstract class **Phalcon\Logger\Formatter**

<<<<<<< HEAD
*implements* [Phalcon\Logger\FormatterInterface](/3.4/en/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/logger/formatter.zep" class="btn btn-default btn-sm">Source on GitHub</a>
=======
*implements* [Phalcon\Logger\FormatterInterface](/4.0/en/api/Phalcon_Logger_FormatterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/logger/formatter.zep" class="btn btn-default btn-sm">Source on GitHub</a>
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

This is a base class for logger formatters

## Methods

public **getTypeString** (*mixed* $type)

Returns the string meaning of a logger constant

public **interpolate** (*string* $message, [*array* $context])

Interpolates context values into the message placeholders

<<<<<<< HEAD
abstract public **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](/3.4/en/api/Phalcon_Logger_FormatterInterface)
=======
abstract public **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](/4.0/en/api/Phalcon_Logger_FormatterInterface)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

...