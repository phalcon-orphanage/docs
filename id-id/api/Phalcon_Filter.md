---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Filter'
---

* [Phalcon\Filter\Exception](#Filter_Exception)
* [Phalcon\Filter\Filter](#Filter_Filter)
* [Phalcon\Filter\FilterFactory](#Filter_FilterFactory)
* [Phalcon\Filter\FilterInterface](#Filter_FilterInterface)
* [Phalcon\Filter\Sanitize\AbsInt](#Filter_Sanitize_AbsInt)
* [Phalcon\Filter\Sanitize\Alnum](#Filter_Sanitize_Alnum)
* [Phalcon\Filter\Sanitize\Alpha](#Filter_Sanitize_Alpha)
* [Phalcon\Filter\Sanitize\BoolVal](#Filter_Sanitize_BoolVal)
* [Phalcon\Filter\Sanitize\Email](#Filter_Sanitize_Email)
* [Phalcon\Filter\Sanitize\FloatVal](#Filter_Sanitize_FloatVal)
* [Phalcon\Filter\Sanitize\IntVal](#Filter_Sanitize_IntVal)
* [Phalcon\Filter\Sanitize\Lower](#Filter_Sanitize_Lower)
* [Phalcon\Filter\Sanitize\LowerFirst](#Filter_Sanitize_LowerFirst)
* [Phalcon\Filter\Sanitize\Regex](#Filter_Sanitize_Regex)
* [Phalcon\Filter\Sanitize\Remove](#Filter_Sanitize_Remove)
* [Phalcon\Filter\Sanitize\Replace](#Filter_Sanitize_Replace)
* [Phalcon\Filter\Sanitize\Special](#Filter_Sanitize_Special)
* [Phalcon\Filter\Sanitize\SpecialFull](#Filter_Sanitize_SpecialFull)
* [Phalcon\Filter\Sanitize\StringVal](#Filter_Sanitize_StringVal)
* [Phalcon\Filter\Sanitize\Striptags](#Filter_Sanitize_Striptags)
* [Phalcon\Filter\Sanitize\Trim](#Filter_Sanitize_Trim)
* [Phalcon\Filter\Sanitize\Upper](#Filter_Sanitize_Upper)
* [Phalcon\Filter\Sanitize\UpperFirst](#Filter_Sanitize_UpperFirst)
* [Phalcon\Filter\Sanitize\UpperWords](#Filter_Sanitize_UpperWords)
* [Phalcon\Filter\Sanitize\Url](#Filter_Sanitize_Url)

<h1 id="Filter_Exception">Class Phalcon\Filter\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/exception.zep)

| Namespace | Phalcon\Filter | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Filter will use this class

<h1 id="Filter_Filter">Class Phalcon\Filter\Filter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/filter.zep)

| Namespace | Phalcon\Filter | | Uses | Phalcon\Filter\Exception, Phalcon\Filter\FilterInterface | | Implements | FilterInterface |

Lazy loads, stores and exposes sanitizer objects

## Constants

```php
const FILTER_ABSINT = absint;
const FILTER_ALNUM = alnum;
const FILTER_ALPHA = alpha;
const FILTER_BOOL = bool;
const FILTER_EMAIL = email;
const FILTER_FLOAT = float;
const FILTER_INT = int;
const FILTER_LOWER = lower;
const FILTER_LOWERFIRST = lowerFirst;
const FILTER_REGEX = regex;
const FILTER_REMOVE = remove;
const FILTER_REPLACE = replace;
const FILTER_SPECIAL = special;
const FILTER_SPECIALFULL = specialFull;
const FILTER_STRING = string;
const FILTER_STRIPTAGS = striptags;
const FILTER_TRIM = trim;
const FILTER_UPPER = upper;
const FILTER_UPPERFIRST = upperFirst;
const FILTER_UPPERWORDS = upperWords;
const FILTER_URL = url;
```

## Properties

```php
/**
 * @var array
 */
protected mapper;

/**
 * @var array
 */
protected services;

```

## Methods

```php
public function __construct( array $mapper ): void;
```

Key value pairs with name as the key and a callable as the value for the service object

```php
public function get( string $name ): object;
```

Get a service. If it is not in the mapper array, create a new object, set it and then return it.

```php
public function has( string $name ): bool;
```

Checks if a service exists in the map array

```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = false ): mixed;
```

Sanitizes a value with a specified single or set of sanitizers

```php
public function set( string $name, callable $service ): void;
```

Set a new service to the mapper array

```php
protected function init( array $mapper ): void;
```

Loads the objects in the internal mapper array

<h1 id="Filter_FilterFactory">Class Phalcon\Filter\FilterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/filterfactory.zep)

| Namespace | Phalcon\Filter | | Uses | Phalcon\Filter\Filter |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalconphp.com>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

```php
public function newInstance(): LocatorInterface;
```

Returns a Locator object with all the helpers defined in anonynous functions

```php
protected function getAdapters(): array;
```

//

<h1 id="Filter_FilterInterface">Interface Phalcon\Filter\FilterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/filterinterface.zep)

| Namespace | Phalcon\Filter |

Lazy loads, stores and exposes sanitizer objects

## Methods

```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = false ): mixed;
```

Sanitizes a value with a specified single or set of sanitizers

<h1 id="Filter_Sanitize_AbsInt">Class Phalcon\Filter\Sanitize\AbsInt</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/absint.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to absolute integer

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Alnum">Class Phalcon\Filter\Sanitize\Alnum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/alnum.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to an alphanumeric value

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Alpha">Class Phalcon\Filter\Sanitize\Alpha</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/alpha.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to an alpha value

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_BoolVal">Class Phalcon\Filter\Sanitize\BoolVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/boolval.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to boolean

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Email">Class Phalcon\Filter\Sanitize\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/email.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes an email string

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_FloatVal">Class Phalcon\Filter\Sanitize\FloatVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/floatval.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to float

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_IntVal">Class Phalcon\Filter\Sanitize\IntVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/intval.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to integer

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Lower">Class Phalcon\Filter\Sanitize\Lower</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/lower.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to lowercase

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_LowerFirst">Class Phalcon\Filter\Sanitize\LowerFirst</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/lowerfirst.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to lcfirst

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Regex">Class Phalcon\Filter\Sanitize\Regex</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/regex.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value performing preg_replace

## Methods

```php
public function __invoke( mixed $input, mixed $pattern, mixed $replace );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Remove">Class Phalcon\Filter\Sanitize\Remove</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/remove.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value removing parts of a string

## Methods

```php
public function __invoke( mixed $input, mixed $replace );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Replace">Class Phalcon\Filter\Sanitize\Replace</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/replace.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value replacing parts of a string

## Methods

```php
public function __invoke( mixed $input, mixed $from, mixed $to );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Special">Class Phalcon\Filter\Sanitize\Special</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/special.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value special characters

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_SpecialFull">Class Phalcon\Filter\Sanitize\SpecialFull</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/specialfull.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value special characters (htmlspecialchars() and ENT_QUOTES)

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_StringVal">Class Phalcon\Filter\Sanitize\StringVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/stringval.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to string

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Striptags">Class Phalcon\Filter\Sanitize\Striptags</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/striptags.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value striptags

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Trim">Class Phalcon\Filter\Sanitize\Trim</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/trim.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value removing leading and trailing spaces

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Upper">Class Phalcon\Filter\Sanitize\Upper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/upper.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to uppercase

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_UpperFirst">Class Phalcon\Filter\Sanitize\UpperFirst</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/upperfirst.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to ucfirst

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_UpperWords">Class Phalcon\Filter\Sanitize\UpperWords</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/upperwords.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value to uppercase teh first character of each word

## Methods

```php
public function __invoke( string $input );
```

Invokes the sanitizer

<h1 id="Filter_Sanitize_Url">Class Phalcon\Filter\Sanitize\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/sanitize/url.zep)

| Namespace | Phalcon\Filter\Sanitize |

Sanitizes a value url

## Methods

```php
public function __invoke( mixed $input );
```

Invokes the sanitizer