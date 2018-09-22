<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">フィルタとサニタイズ</a> <ul>
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

# フィルタとサニタイズ

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/images/content/filter-sql.png)

[Full image on XKCD](http://xkcd.com/327)

The `Phalcon\Filter` component provides a set of commonly used filters and data sanitizing helpers. It provides object-oriented wrappers around the PHP filter extension.

<a name='types'></a>

## Types of Built-in Filters

The following are the built-in filters provided by this component:

| 名前        | 説明                                                                             |
| --------- | ------------------------------------------------------------------------------ |
| absint    | 値をintegerとしてキャストし、その絶対値を返す。                                                    |
| alphanum  | [a-zA-Z0-9] 以外のすべての文字を削除します。                                                   |
| email     | 文字、数字、`!#$%&*+-/=?^_`{\|}~@.[]`以外のすべての文字を削除します。                          |
| float     | 数字、ドット、プラス記号、マイナス記号以外のすべての文字を削除します。                                            |
| float!    | 数字、ドット、プラス記号、マイナス記号以外のすべての文字を削除し、残りを float としてキャストする。                          |
| int       | 数字、プラス記号、マイナス記号以外のすべての文字を削除します。                                                |
| int!      | 数字、プラス記号、マイナス記号以外のすべての文字を削除し、残りを integer としてキャストする。                            |
| lower     | [ strtolower ](http://www.php.net/manual/en/function.strtolower.php) 関数を適用します。 |
| string    | タグを除去し、シングルクォートとダブルクォートでHTML エンティティをエンコードします。                                  |
| striptags | [strip_tags](http://www.php.net/manual/en/function.strip-tags.php) 関数を適用します。   |
| trim      | [trim](http://www.php.net/manual/en/function.trim.php) 関数を適用します。               |
| upper     | [strtoupper](http://www.php.net/manual/en/function.strtoupper.php) 関数を適用します。   |

コンポーネントが内部的に[filter_var](https://secure.php.net/manual/en/function.filter-var.php) PHP の関数を使用することに注意してください。

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

## データのサニタイズ

サニタイズは、ユーザーまたはアプリケーションに必要ではないまたは望まれていない、特定の文字を値から削除するプロセスです。 入力値のサニタイズによって、アプリケーションの整合性を確かめます。

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

## データのフィルタリング

サニタイズに加えて、`Phalcon\Filter` は、入力データを私達が期待する形式に修正したり、削除したりすることで、フィルタリング機能を提供します。

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

自身のフィルターを`Phalcon\Filter`に追加できます。このフィルタ関数は無名関数でも問題ありません。:

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

## 独自のフィルターを実装

Phalconが提供するフィルタリングサービスの代わりに独自のフィルタリングサービスを作成するには、`Phalcon\FilterInterface`インターフェイスを実装する必要があります。