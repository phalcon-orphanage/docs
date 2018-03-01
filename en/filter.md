<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Filtering and Sanitizing</a> 
      <ul>
        <li>
          <a href="#types">Types of Built-in Filters</a>
        </li>
        <li>
          <a href="#sanitizing">Sanitizing data</a>
        </li>
        <li>
          <a href="#sanitizing-from-controllers">Sanitizing from Controllers</a>
        </li>
        <li>
          <a href="#filtering-action-parameters">Filtering Action Parameters</a>
        </li>
        <li>
          <a href="#filtering-data">Filtering data</a>
        </li>
        <li>
          <a href="#combining-filters">Combining Filters</a>
        </li>
        <li>
          <a href="#adding-filters">Adding filters</a>
        </li>
        <li>
          <a href="#complex-sanitization-filtering">Complex Sanitizing and Filtering</a>
        </li>
        <li>
          <a href="#custom">Implementing your own Filter</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>
# Filtering and Sanitizing
Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/images/content/filter-sql.png)

[Full image on XKCD](http://xkcd.com/327)

The `Phalcon\Filter` component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension.

<a name='types'></a>
## Types of Built-in Filters
The following are the built-in filters provided by this component:

| Name          | Description                                                                                                   |
|---------------|---------------------------------------------------------------------------------------------------------------|
| string        | Strip tags and encode HTML entities, including single and double quotes                                       |
| email         | Remove all characters except letters, digits and `!#$%&*+-/=?^_`{\|}~@.[]`                                    |
| int           | Remove all characters except digits, plus and minus sign                                                      |
| int!          | Convert the value to an integer value using [intval](http://php.net/manual/en/function.intval.php) function   |
| absint        | Gets the absolute value of a value that was converted to integer                                              |
| float         | Remove all characters except digits, dot, plus and minus sign                                                 |
| float!        | Convert the value to an float value using [floatval](http://php.net/manual/en/function.floatval.php) function |
| alphanum      | Remove all characters except [a-zA-Z0-9]                                                                      |
| striptags     | Applies the [strip_tags](http://www.php.net/manual/en/function.strip-tags.php) function                       |
| special_chars | Escape '"<>& and characters with ASCII value less than 32                                                     |
| trim          | Applies the [trim](http://www.php.net/manual/en/function.trim.php) function                                   |
| lower         | Applies the [strtolower](http://www.php.net/manual/en/function.strtolower.php) function                       |
| url           | Remove all characters except letters, digits and `|`$-_.+!*'(),{}[]<>#%";/?:@&=.^~\\`                         |
| upper         | Applies the [strtoupper](http://www.php.net/manual/en/function.strtoupper.php) function                       |

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
You can access a `Phalcon\Filter` object from your controllers when accessing `GET` or `POST` input data (through the request object). The first parameter is the name of the variable to be obtained; the second is the filter to be applied on it.

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
In addition to sanitizing, `Phalcon\Filter` also provides filtering by removing or modifying input data to the format we expect.

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
You can add your own filters to `Phalcon\Filter`. The filter function could be an anonymous function:

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
PHP itself provides an excellent filter extension you can use. Check out its documentation: [Data Filtering at PHP Documentation](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>
## Implementing your own Filter
The `Phalcon\FilterInterface` interface must be implemented to create your own filtering service replacing the one provided by Phalcon.
