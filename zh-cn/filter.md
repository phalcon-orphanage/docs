* * *

layout: default language: 'en' version: '4.0'

* * *

<a name='overview'></a>

# Filtering and Sanitizing

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](http://xkcd.com/327)

The [Phalcon\Filter](api/Phalcon_Filter) component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension.

<a name='types'></a>

## Types of Built-in Filters

The following are the built-in filters provided by this component:

| Name      | Description                                                                             |
| --------- | --------------------------------------------------------------------------------------- |
| absint    | 将值强制转换为整数, 并返回它的绝对值。                                                                    |
| alphanum  | 除去[a-zA-Z0-9] 之外的所有字符                                                                   |
| email     | 删除所有字符除了字母, 数字和< 0 >! # $ %,* +,/ =? ^ _ < / 0 > {\ |}~ @。[]”。                         |
| float     | Remove all characters except digits, dot, plus and minus sign.                          |
| float!    | 删除除数字、点、加号和减号之外的所有字符, 然后将结果强制转换为浮点型。                                                    |
| int       | 除去所有字符除了数字，加减号。                                                                         |
| int!      | 删除除数字、加号和减号之外的所有字符, 并将结果强制转换为整数。                                                        |
| lower     | Applies the [strtolower](http://www.php.net/manual/en/function.strtolower.php) function |
| string    | 标签和编码HTML实体，包括单引号和双引号。                                                                  |
| striptags | 应用[strip_tags](http://www.php.net/manual/en/function.strip-tags.php)函数                  |
| trim      | Applies the [trim](http://www.php.net/manual/en/function.trim.php) function             |
| upper     | 应用[strtoupper](http://www.php.net/manual/en/function.strtoupper.php)函数                  |

请注意，组件在内部使用[filter_var](https://secure.php.net/manual/en/function.filter-var.php)PHP函数。

常数是可用的，可以用来定义所需的过滤类型：

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

清理数据是将用户或应用程序不需要或不需要的特定字符从值中删除的过程。 通过对输入进行清理，我们可以确保应用程序的完整性是完整的。

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

You can access a [Phalcon\Filter](api/Phalcon_Filter) object from your controllers when accessing `GET` or `POST` input data (through the request object). 第一个参数是要获得的变量的名称; 第二个是应用于它的过滤器。

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

下一个例子展示了如何清理控制器动作中的动作参数:

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

您还可以同时在一个字符串上运行多个过滤器，方法是传递一个过滤器标识符数组作为第二个参数:

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

或者，如果您愿意，您可以在类中实现过滤器:

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

PHP本身提供了一个您可以使用的优秀过滤器扩展。查看它的文档:[数据过滤PHP文档](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## Implementing your own Filter

The [Phalcon\FilterInterface](api/Phalcon_FilterInterface) interface must be implemented to create your own filtering service replacing the one provided by Phalcon.