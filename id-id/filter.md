---
layout: default
language: 'id-id'
version: '4.0'
upgrade: '#filter'
title: 'Filter'
keywords: 'filter, sanitize'
---

# Filter

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327)

Sanitizing content can be achieved using the [Phalcon\Filter](api/phalcon_filter#filter) and [Phalcon\Filter\FilterFactory](api/phalcon_filter#filter-filterfactory) classes.

## FilterFactory

This component creates a new locator with predefined filters attached to it. Each filter is lazy loaded for maximum performance. To instantiate the factory and retrieve the [Phalcon\Filter](api/phalcon_filter#filter) with the preset sanitizers you need to call `newInstance()`

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();
```

You can now use the locator wherever you need and sanitize content as per the needs of your application.

## Filter

The [Phalcon\Filter](api/phalcon_filter#filter) component implements a locator service and can be used as a stand alone component, without initializing the built-in filters.

```php
<?php

use MyApp\Sanitizers\HelloSanitizer;
use Phalcon\Filter;

$services = [
    'hello' => HelloSanitizer::class,
];

$locator = new Filter($services);

$text = $locator->hello('World');
```

> **NOTE**: The [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container already has a [Phalcon\Filter](api/phalcon_filter#filter) object loaded with the predefined sanitizers. The component can be accessed using the `filter` name.
{: .alert .alert-info }

## Built-in

> **NOTE**: Where appropriate, the sanitizers will cast the value to the type expected. For example the `absint` sanitizer will remove all non numeric characters from the input, cast the input to an integer and return its absolute value.
{: .alert .alert-warning }

The following are the built-in filters provided by this component:

#### `absint`

```php
AbsInt( mixed $input ): int
```

Removes any non numeric characters, casts the value to integer and returns its absolute value. Internally it uses [`filter_var`] for the integer part, [`intval`](https://secure.php.net/manual/en/function.intval.php) for casting and [`absint`](https://secure.php.net/manual/en/function.absint.php).

#### `alnum`

```php
Alnum( mixed $input ): string | array
```

Removes all characters that are not numbers or characters of the alphabet. It uses [`preg_replace`](https://secure.php.net/manual/en/function.preg-replace.php) which can also accept arrays of strings as the parameters.

#### `alpha`

```php
Alpha( mixed $input ): string | array
```

Removes all characters that are not characters of the alphabet. It uses [preg_replace](https://secure.php.net/manual/en/function.preg-replace.php) which can also accept arrays of strings as the parameters.

#### `bool`

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

#### `email`

```php
Email( mixed $input ): string
```

Removes all characters except letters, digits and ``!#$%&*+-/=?^_`{\|}~@.[]``. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php) with `FILTER_FLAG_EMAIL_UNICODE`.

#### `float`

```php
FloatVal( mixed $input ): float
```

Removes all characters except digits, dot, plus and minus sign and casts the value as a `double`. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php) and `(double)`.

#### `int`

```php
IntVal( mixed $input ): int
```

Remove all characters except digits, plus and minus sign abd casts the value as an integer. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php) and `(int)`.

#### `lower`

```php
Lower( mixed $input ): string
```

Converts all characters to lowercase. If the [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) extension is loaded, it will use [mb_convert_case](https://secure.php.net/manual/en/function.mb-convert-case.php) to perform the transformation. As a fallback it uses the [`strtolower`](https://secure.php.net/manual/en/function.strtolower.php) PHP function, with [utf8_decode](https://secure.php.net/manual/en/function.utf8-decode.php).

#### `lowerFirst`

```php
LowerFirst( mixed $input ): string
```

Converts the first character of the input to lower case. Internally it uses [`lcfirst`](https://secure.php.net/manual/en/function.lcfirst.php).

#### `regex`

```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```

Performs a regex replacement on the input using a `pattern` and the `replace` parameter. Internally it uses [`preg_replace`](https://secure.php.net/manual/en/function.preg-replace.php).

#### `remove`

```php
Remove( mixed $input, mixed $replace ): string
```

Performs a replacement on the input, replacing the `replace` parameter with an empty string, effectively removing it. Internally it uses [`str_replace`](https://secure.php.net/manual/en/function.str-replace.php).

#### `replace`

```php
Replace( mixed $input, mixed $from, mixed $to ): string
```

Performs a replacement on the input based on the `from` and `to` passed parameters. Internally it uses [`str_replace`](https://secure.php.net/manual/en/function.str-replace.php).

#### `special`

```php
Special( mixed $input ): string
```

Escapes all HTML characters of the input, as well as `'"<>&` and characters with ASCII value less than 32. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php).

#### `specialFull`

```php
SpecialFull( mixed $input ): string
```

Converts all the special characters of the input to HTML entities (both double and single quotes). Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php).

#### `string`

```php
StringVal( mixed $input ): string
```

Strip tags and encode HTML entities, including single and double quotes. Internally it uses [`filter_var`](https://secure.php.net/manual/en/function.filter-var.php).

#### `striptags`

```php
StripTags( mixed $input ): int
```

Removes all HTML and PHP tags from the input. Internally it uses [`strip_tags`](https://www.php.net/manual/en/function.strip-tags.php).

#### `trim`

```php
Trim( mixed $input ): string
```

Removes all leading and trailing whitespace from the input. Internally it uses [`trim`](https://www.php.net/manual/en/function.trim.php).

#### `upper`

```php
Upper( mixed $input ): string
```

Converts all characters to uppercase. If the [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) extension is loaded, it will use [`mb_convert_case`](https://secure.php.net/manual/en/function.mb-convert-case.php) to perform the transformation. As a fallback it uses the [`strtoupper`](https://secure.php.net/manual/en/function.strtoupper.php) PHP function, with [`utf8_decode`](https://secure.php.net/manual/en/function.utf8-decode.php).

#### `upperFirst`

```php
UpperFirst( mixed $input ): string
```

Converts the first character of the input to upper case. Internally it uses [`ucfirst`](https://secure.php.net/manual/en/function.ucfirst.php).

#### `upperWords`

```php
UpperWords( mixed $input ): string
```

Converts into uppercase the first character of each word from the input. Internally it uses [`ucwords`](https://secure.php.net/manual/en/function.ucwords.php).

#### `url`

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

## Sanitizing Data

Sanitizing is the process which removes specific characters from a value, that are not required or desired by the user or application. By sanitizing input we ensure that application integrity will be intact.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();
$locator = $factory->newInstance();

// 'someone@example.com'
$locator->sanitize('some(one)@exa\mple.com', 'email');

// 'hello'
$locator->sanitize('hello<<', 'string');

// '100019'
$locator->sanitize('!100a019', 'int');

// '100019.01'
$locator->sanitize('!100a019.01a', 'float');
```

## Controllers

You can access the [Phalcon\Filter](api/phalcon_filter#filter) object from your controllers when accessing `GET` or `POST` input data (through the request object). The first parameter is the name of the variable to be obtained; the second is the sanitizer to be applied on it. The second parameter can also be an array with any number of sanitizers that you want to apply.

```php
<?php

use Phalcon\Filter;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Request $request
 */
class ProductsController extends Controller
{
    public function saveAction()
    {
        if (true === $this->request->isPost()) {
            $price = $this->request->getPost('price', 'double');

            $email = $this->request->getPost(
                'customerEmail',
                Filter::FILTER_EMAIL
            );
        }
    }
}
```

## Action Parameters

If you have used the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) as your DI container, the [Phalcon\Filter](api/phalcon_filter#filter) is already registered for you with the default sanitizers. To access it we can use the name `filter`. If you do not use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, you will need to set the service up in it, so that it can be accessible in your controllers.

We can sanitize values passed into controller actions as follows:

```php
<?php

use Phalcon\Filter;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Filter $filter
 */
class ProductsController extends Controller
{
    public function showAction($productId)
    {
        $productId = $this->filter->sanitize($productId, 'absint');
    }
}
```

## Filtering Data

The [Phalcon\Filter](api/phalcon_filter#filter) both filters and sanitizes data, depending on the sanitizers used. For instance the `trim` sanitizer will remove all leading and trailing whitespace, leaving the remaining input unchanged. The description of each sanitizer (see [Built-in Sanitizers](#built-in-sanitizers)) can help you to understand and use the sanitizers according to your needs.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

// 'Hello'
$locator->sanitize('<h1>Hello</h1>', 'striptags');

// 'Hello'
$locator->sanitize('  Hello   ', 'trim');
```

## Adding Sanitizers

You can add your own sanitizers to [Phalcon\Filter](api/phalcon_filter#filter). The sanitizer can be an anonymous function when initializing the locator:

```php
<?php

use Phalcon\Filter;

$services = [
    'md5' => function ($input) {
        return md5($input);
    },
];

$locator = new Filter($services);

$sanitized = $locator->sanitize($value, 'md5');
```

If you already have an instantiated filter locator object (for instance if you have used the [Phalcon\Filter\FilterFactory](api/phalcon_filter#filter-filterfactory) and `newInstance()`), then you can simply add the custom filter:

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$sanitized = $locator->sanitize($value, 'md5');
```

Or, if you prefer, you can implement the filter in a class:

```php
<?php

use Phalcon\Filter\FilterFactory;

class IPv4
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Sanitize with the 'ipv4' filter
$filteredIp = $locator->sanitize('127.0.0.1', 'ipv4');
```

## Combining Sanitizers

There are times where one sanitizer is not enough for your data. For instance a very common usage is the `striptags` and `trim` sanitizers for text input. The [Phalcon\Filter](api/phalcon_filter#filter) component offers the ability to accept an array of names for sanitizers to be applied on the input value. The following example demonstrates this:

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

// Returns 'Hello'
$locator->sanitize(
    '   <h1> Hello </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

Note that this feature also works on the [Phalcon\Http\Request](api/Phalcon_Http_Request) object, when calling methods to retrieve data from `GET` and `POST`, namely `getQuery()` and `getPost()`.

```php
<?php

use Phalcon\Filter;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class ProductsController
 * 
 * @property Request $request
 */
class ProductsController extends Controller
{
    public function saveAction()
    {
        if (true === $this->request->isPost()) {
            $message =  $this->request->getPost(
                '   <h1> Hello </h1>   ',
                [
                    'striptags',
                    'trim',
                ]
            );

        }
    }
}
```

## Custom Sanitizer

A custom sanitizer can be implemented as as an anonymous function. If however you prefer to use a class per sanitizer, all you need to do is make it a callable by implementing the [__invoke](https://secure.php.net/manual/en/language.oop5.magic.php#object.invoke) method with the relevant parameters.

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$sanitized = $locator->sanitize($value, 'md5');
```

Or, if you prefer, you can implement the sanitizer in a class:

```php
<?php

use Phalcon\Filter\FilterFactory;

class IPv4
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$factory = new FilterFactory();

$locator = $factory->newInstance();

$locator->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Sanitize with the 'ipv4' filter
$filteredIp = $locator->sanitize('127.0.0.1', 'ipv4');
```