---
layout: article
language: 'en'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filter Component
<hr/>

## Built-in Sanitizers

> Where appropriate, the sanitizers will cast the value to the type expected. For example the [absint][absint] sanitizer will remove all non numeric characters from the input, cast the input to an integer and return its absolute value.
{: .alert .alert-warning }

The following are the built-in filters provided by this component:

#### absint
```php
AbsInt( mixed $input ): int
```
Removes any non numeric characters, casts the value to integer and returns its absolute value. Internally it uses [filter_var] for the integer part, [intval][intval] for casting and [absint][absint].

#### alnum
```php
Alnum( mixed $input ): string | array
```
Removes all characters that are not numbers or characters of the alphabet. It uses [preg_replace][preg_replace] which can also accept arrays of strings as the parameters. 

#### alpha
```php
Alpha( mixed $input ): string | array
```
Removes all characters that are not characters of the alphabet. It uses [preg_replace][preg_replace] which can also accept arrays of strings as the parameters. 

#### bool
```php
BoolVal( mixed $input ): bool
```
Casts the value to a boolean. 

It also returns `true` if the value is:

* `true`
* `on`
* `yes`
* `y`
* `1`

It also returns `false` if the value is:

* `false`
* `off`
* `no`
* `n`
* `0`

#### email
```php
Email( mixed $input ): string
```
Removes all characters except letters, digits and ``!#$%&*+-/=?^_`{\|}~@.[]``. Internally it uses [filter_var][filter_var].

#### float
```php
FloatVal( mixed $input ): float
```
Removes all characters except digits, dot, plus and minus sign and casts the value as a `double`. Internally it uses [filter_var][filter_var] and `(double)`.

#### int        
```php
IntVal( mixed $input ): int
```
Remove all characters except digits, plus and minus sign abd casts the value as an integer. Internally it uses [filter_var][filter_var] and `(int)`.

#### lower
```php
Lower( mixed $input ): string
```
Converts all characters to lowercase. If the [mbstring][mbstring] extension is loaded, it will use [mb_convert_case][mb_convert_case] to perform the transformation. As a fallback it uses the [strtolower][strtolower] PHP function, with [utf8_decode][utf8_decode].

#### lowerFirst 
```php
LowerFirst( mixed $input ): string
```
Converts the first character of the input to lower case. Internally it uses [lcfirst][lcfirst].

#### regex
```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```
Performs a regex replacement on the input using a `pattern` and the `replace` parameter. Internally it uses [preg_replace][preg_replace].

#### remove
```php
Remove( mixed $input, mixed $remove ): string
```
Performs a replacement on the input, replacing the `replace` parameter with an empty string, effectively removing it. Internally it uses [str_replace][str_replace].

#### replace
```php
Replace( mixed $input, mixed $from, mixed $to ): string
```
Performs a replacement on the input based on the `from` and `to` passed parameters. Internally it uses [str_replace][str_replace].

#### special
```php
Special( mixed $input ): string
```
Escapes all HTML characters of the input, as well as `'"<>&` and characters with ASCII value less than 32. Internally it uses [filter_var][filter_var].

#### specialFull
```php
SpecialFull( mixed $input ): string
```
Converts all the special characters of the input to HTML entities (both double and single quotes). Internally it uses [filter_var][filter_var].

#### string
```php
StringVal( mixed $input ): string
```
Strip tags and encode HTML entities, including single and double quotes. Internally it uses [filter_var][filter_var].

#### striptags
```php
StripTags( mixed $input ): int
```
Removes all HTML and PHP tags from the input. Internally it uses [strip_tags][strip_tags].

#### trim
```php
Trim( mixed $input ): string
```
Removes all leading and trailing whitespace from the input. Internally it uses [trim][trim].

#### upper
```php
Upper( mixed $input ): string
```
Converts all characters to uppercase. If the [mbstring][mbstring] extension is loaded, it will use [mb_convert_case][mb_convert_case] to perform the transformation. As a fallback it uses the [strtoupper][strtoupper] PHP function, with [utf8_decode][utf8_decode].

#### upperFirst 
```php
UpperFirst( mixed $input ): string
```
Converts the first character of the input to upper case. Internally it uses [ucfirst][ucfirst].

#### upperWords
```php
UpperWords( mixed $input ): string
```
Converts into uppercase the first character of each word from the input. Internally it uses [ucwords][ucwords].

#### url
```php
Url( mixed $input ): string
```
Constants are available and can be used to define the type of sanitizing required:

```php
<?php

const FILTER_ABSINT      = 'absint';
const FILTER_ALNUM       = 'alnum';
const FILTER_ALPHA       = 'alpha';
const FILTER_BOOL        = 'bool';
const FILTER_EMAIL       = 'email';
const FILTER_FLOAT       = 'float';
const FILTER_INT         = 'int';
const FILTER_LOWER       = 'lower';
const FILTER_LOWERFIRST  = 'lowerFirst';
const FILTER_REGEX       = 'regex';
const FILTER_REMOVE      = 'remove';
const FILTER_REPLACE     = 'replace';
const FILTER_SPECIAL     = 'special';
const FILTER_SPECIALFULL = 'specialFull';
const FILTER_STRING      = 'string';
const FILTER_STRIPTAGS   = 'striptags';
const FILTER_TRIM        = 'trim';
const FILTER_UPPER       = 'upper';
const FILTER_UPPERFIRST  = 'upperFirst';
const FILTER_UPPERWORDS  = 'upperWords';
const FILTER_URL         = 'url';
```


[absint]: https://secure.php.net/manual/en/function.absint.php
[filter_var]: https://secure.php.net/manual/en/function.filter-var.php
[intval]: https://secure.php.net/manual/en/function.intval.php 
[invoke]: https://secure.php.net/manual/en/language.oop5.magic.php#object.invoke
[lcfirst]: https://secure.php.net/manual/en/function.lcfirst.php
[mb_convert_case]: https://secure.php.net/manual/en/function.mb-convert-case.php
[mbstring]: https://secure.php.net/manual/en/book.mbstring.php
[preg_replace]: https://secure.php.net/manual/en/function.preg-replace.php
[strip_tags]: https://www.php.net/manual/en/function.strip-tags.php
[str_replace]: https://secure.php.net/manual/en/function.str-replace.php 
[strtolower]: https://secure.php.net/manual/en/function.strtolower.php 
[strtoupper]: https://secure.php.net/manual/en/function.strtoupper.php 
[trim]: https://www.php.net/manual/en/function.trim.php
[ucfirst]: https://secure.php.net/manual/en/function.ucfirst.php
[ucwords]: https://secure.php.net/manual/en/function.ucwords.php
[utf8_decode]: https://secure.php.net/manual/en/function.utf8-decode.php
