---
layout: article
language: 'ja-jp'
version: '4.0'
---


<a name='overview'></a>

# Filtering and Sanitizing

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327)

Sanitizing content can be achieved using the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) and [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory) classes.

## FilterLocatorFactory

This component creates a new locator with predefined filters attached to it. Each filter is lazy loaded for maximum performance. To instantiate the factory and retrieve the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) with the preset sanitizers you need to call `newInstance()`

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();
```

You can now use the locator wherever you need and sanitize content as per the needs of your application.

> The `Phalcon\Di` container already has a `Phalcon\Filter\FilterLocator` object loaded with the predefined sanitizers. The component can be accessed using the `filter` name. {: .alert .alert-info }

<a name='sanitizers'></a>

## Built-in Sanitizers

> Where appropriate, the sanitizers will cast the value to the type expected. For example the `absint` sanitizer will remove all non numeric characters from the input, cast the input to an integer and return its absolute value. {: .alert .alert-warning }

The following are the built-in filters provided by this component:

#### absint

```php
AbsInt( mixed $input ): int
```

Removes any non numeric characters, casts the value to integer and returns its absolute value. Internally it uses [filter_var](https://secure.php.net/manual/en/function.filter-var.php) for the integer part, `intval` for casting and `absint`

#### alnum

```php
Alnum( mixed $input ): string | array
```

Removes all characters that are not numbers or characters of the alphabet. It uses `preg_replace` which can also accept arrays of strings as the parameters.

#### alpha

```php
Alpha( mixed $input ): string | array
```

Removes all characters that are not characters of the alphabet. It uses `preg_replace` which can also accept arrays of strings as the parameters.

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

Removes all characters except letters, digits and `!#$%&*+-/=?^_`{\|}~@.[]`. Internally it uses [filter_var](https://secure.php.net/manual/en/function.filter-var.php)

#### float

```php
FloatVal( mixed $input ): float
```

Removes all characters except digits, dot, plus and minus sign and casts the value as a `double`. Internally it uses [filter_var](https://secure.php.net/manual/en/function.filter-var.php) and `(double)`.

#### int

```php
IntVa( mixed $input ): int
```

Remove all characters except digits, plus and minus sign abd casts the value as an integer. Internally it uses [filter_var](https://secure.php.net/manual/en/function.filter-var.php) and `(int)`.

#### `lower`

Converts all characters to lowercase. If the `mbstring` extension is loaded, it will use `mb_convert_case` to perform the transformation. As a fallback it uses the `strtolower` PHP function, with `utf8_decode`.

#### `lowerFirst`

Converts the first character of the input to lower case. Internally it uses `lcfirst`.

#### `regex`

#### `remove`

#### `replace`

#### `special`

#### `specialFull`

#### `string`

Strip tags and encode HTML entities, including single and double quotes.

#### `striptags`

Applies the [strip_tags](https://www.php.net/manual/en/function.strip-tags.php) function

#### `trim`

Applies the [trim](https://www.php.net/manual/en/function.trim.php) function

#### `upper`

Converts all characters to uppercase. If the `mbstring` extension is loaded, it will use `mb_convert_case` to perform the transformation. As a fallback it uses the `strtoupper` PHP function, with `utf8_decode`.

#### `upperFirst`

Converts the first character of the input to upper case. Internally it uses `ucfirst`.

#### `upperWords`

#### `url`

Constants are available and can be used to define the type of filtering required:

```php
<?php

const FILTER_ABSINT      = "absint";
const FILTER_ALNUM       = "alnum";
const FILTER_ALPHA       = "alpha";
const FILTER_BOOL        = "bool";
const FILTER_EMAIL       = "email";
const FILTER_FLOAT       = "float";
const FILTER_INT         = "int";
const FILTER_LOWER       = "lower";
const FILTER_LOWERFIRST  = "lowerFirst";
const FILTER_REGEX       = "regex";
const FILTER_REMOVE      = "remove";
const FILTER_REPLACE     = "replace";
const FILTER_SPECIAL     = "special";
const FILTER_SPECIALFULL = "specialFull";
const FILTER_STRING      = "string";
const FILTER_STRIPTAGS   = "striptags";
const FILTER_TRIM        = "trim";
const FILTER_UPPER       = "upper";
const FILTER_UPPERFIRST  = "upperFirst";
const FILTER_UPPERWORDS  = "upperWords";
const FILTER_URL         = "url";
```

<a name='sanitizing'></a>

## Sanitizing data

Sanitizing is the process which removes specific characters from a value, that are not required or desired by the user or application. By sanitizing input we ensure that application integrity will be intact.

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Returns 'someone@example.com'
$filter->sanitize('some(one)@exa\mple.com', 'email');

// Returns 'hello'
$filter->sanitize('hello<<', 'string');

// Returns '100019'
$filter->sanitize('!100a019', 'int');

// Returns '100019.01'
$filter->sanitize('!100a019.01a', 'float');
```

<a name='sanitizing-from-controllers'></a>

## Sanitizing from Controllers

You can access a [Phalcon\Filter](api/Phalcon_Filter) object from your controllers when accessing `GET` or `POST` input data (through the request object). The first parameter is the name of the variable to be obtained; the second is the filter to be applied on it.

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Sanitizing price from input
        $price = $this->request->getPost('price', 'double');

        // Sanitizing email from input
        $email = $this->request->getPost('customerEmail', 'email');
    }
}
```

<a name='sanitizing-action-parameters'></a>

## Sanitizing Action Parameters

The next example shows you how to sanitize the action parameters within a controller action:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($productId)
    {
        $productId = $this->filter->sanitize($productId, 'int');
    }
}
```

<a name='sanitizing-data'></a>

## Filtering data

In addition to sanitizing, [Phalcon\Filter](api/Phalcon_Filter) also provides filtering by removing or modifying input data to the format we expect.

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Returns 'Hello'
$filter->sanitize('<h1>Hello</h1>', 'striptags');

// Returns 'Hello'
$filter->sanitize('  Hello   ', 'trim');
```

<a name='combining-sanitizers'></a>

## Combining Sanitizers

You can also run multiple filters on a string at the same time by passing an array of filter identifiers as the second parameter:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Returns 'Hello'
$filter->sanitize(
    '   <h1> Hello </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

<a name='adding-sanitizers'></a>

## Adding filters

You can add your own filters to [Phalcon\Filter](api/Phalcon_Filter). The filter function could be an anonymous function:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Using an anonymous function
$filter->add(
    'md5',
    function ($value) {
        return preg_replace('/[^0-9a-f]/', '', $value);
    }
);

// Sanitize with the 'md5' filter
$filtered = $filter->sanitize($possibleMd5, 'md5');
```

Or, if you prefer, you can implement the filter in a class:

```php
<?php

use Phalcon\Filter;

class IPv4Filter
{
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$filter = new Filter();

// Using an object
$filter->add(
    'ipv4',
    new IPv4Filter()
);

// Sanitize with the 'ipv4' filter
$filteredIp = $filter->sanitize('127.0.0.1', 'ipv4');
```

<a name='complex-sanitization-filtering'></a>

## Complex Sanitizing and Filtering

PHP itself provides an excellent filter extension you can use. Check out its documentation: [Data Filtering at PHP Documentation](https://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## Implementing your own Filter

The [Phalcon\FilterInterface](api/Phalcon_FilterInterface) interface must be implemented to create your own filtering service replacing the one provided by Phalcon.