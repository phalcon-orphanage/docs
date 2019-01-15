* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Filtering and Sanitizing

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327)

The [Phalcon\Filter](api/Phalcon_Filter) component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension.

<a name='types'></a>

## Types of Built-in Filters

The following are the built-in filters provided by this component:

| Name      | Description                                                                                   |
| --------- | --------------------------------------------------------------------------------------------- |
| absint    | Casts the value as an integer and returns the absolute value of it.                           |
| alphanum  | Remove all characters except [a-zA-Z0-9]                                                      |
| email     | Remove all characters except letters, digits and `!#$%&*+-/=?^_`{\|}~@.[]`.             |
| float     | Remove all characters except digits, dot, plus and minus sign.                                |
| float!    | Remove all characters except digits, dot, plus and minus sign and cast the result as a float. |
| int       | Remove all characters except digits, plus and minus sign.                                     |
| int!      | Remove all characters except digits, plus and minus sign and cast the result as an integer.   |
| lower     | Applies the [strtolower](https://www.php.net/manual/en/function.strtolower.php) function      |
| string    | Strip tags and encode HTML entities, including single and double quotes.                      |
| striptags | Applies the [strip_tags](https://www.php.net/manual/en/function.strip-tags.php) function      |
| trim      | Applies the [trim](https://www.php.net/manual/en/function.trim.php) function                  |
| upper     | Applies the [strtoupper](https://www.php.net/manual/en/function.strtoupper.php) function      |

Please note that the component uses the [filter_var](https://secure.php.net/manual/en/function.filter-var.php) PHP function internally.

Constants are available and can be used to define the type of filtering required:

```php
<?php
const FILTER_ABSINT     = "absint";
const FILTER_ALPHANUM   = "alphanum";
const FILTER_EMAIL      = "email";
const FILTER_FLOAT      = "float";
const FILTER_FLOAT_CAST = "float!";
const FILTER_INT        = "int";
const FILTER_INT_CAST   = "int!";
const FILTER_LOWER      = "lower";
const FILTER_STRING     = "string";
const FILTER_STRIPTAGS  = "striptags";
const FILTER_TRIM       = "trim";
const FILTER_UPPER      = "upper";
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

<a name='filtering-action-parameters'></a>

## Filtering Action Parameters

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

<a name='filtering-data'></a>

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

<a name='combining-filters'></a>

## Combining Filters

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

<a name='adding-filters'></a>

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