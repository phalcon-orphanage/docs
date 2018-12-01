<div class='article-menu'>
  <ul>
    <li>
      <a href="#总览">过滤和处理</a> <ul>
        <li>
          <a href="#类型">类型的内置过滤器</a>
        </li>
        <li>
          <a href="#sanitizing">清理数据</a>
        </li>
        <li>
          <a href="#sanitizing-from-controllers">在控制器中进行数据清理</a>
        </li>
        <li>
          <a href="#filtering-action-parameters">过滤操作参数</a>
        </li>
        <li>
          <a href="#filtering-data">数据过滤</a>
        </li>
        <li>
          <a href="#combining-filters">组合过滤器</a>
        </li>
        <li>
          <a href="#adding-filters">添加过滤器</a>
        </li>
        <li>
          <a href="#complex-sanitization-filtering">复杂的清理和过滤</a>
        </li>
        <li>
          <a href="#custom">实现自己的过滤器</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 过滤和清理

清理用户输入是软件开发的关键部分。 信任或忽略对用户输入进行清理可能会导致未经授权访问应用程序的内容, 主要是用户数据, 甚至是应用程序所在的服务器。

![](/images/content/filter-sql.png)

[XKCD上的完整图像](http://xkcd.com/327)

`Phalcon\Filter` 组件提供了一组常用的过滤器和数据清理助手程序。它提供了围绕 php 过滤器扩展的面向对象的包装。

<a name='types'></a>

## 内置筛选器的类型

以下是此组件提供的内置筛选器:

| 名称        | 说明                                                                     |
| --------- | ---------------------------------------------------------------------- |
| absint    | 将值强制转换为整数, 并返回它的绝对值。                                                   |
| alphanum  | 除去[a-zA-Z0-9] 之外的所有字符                                                  |
| email     | 删除所有字符除了字母, 数字和< 0 >! # $ %,* +,/ =? ^ _ < / 0 > {\ |}~ @。[]”。        |
| float     | 除去所有字符除了数字，点，加减号。                                                      |
| float!    | 删除除数字、点、加号和减号之外的所有字符, 然后将结果强制转换为浮点型。                                   |
| int       | 除去所有字符除了数字，加减号。                                                        |
| int!      | 删除除数字、加号和减号之外的所有字符, 并将结果强制转换为整数。                                       |
| lower     | 应用[strtolower](http://www.php.net/manual/en/function.strtolower.php)函数 |
| string    | 标签和编码HTML实体，包括单引号和双引号。                                                 |
| striptags | 应用[strip_tags](http://www.php.net/manual/en/function.strip-tags.php)函数 |
| trim      | 应用[trim](http://www.php.net/manual/en/function.trim.php)函数             |
| upper     | 应用[strtoupper](http://www.php.net/manual/en/function.strtoupper.php)函数 |

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

## 清理数据

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

## 在控制器中进行数据清理

当访问`GET`或`POST`输入数据(通过请求对象) 时，可以从控制器访问`Phalcon\Filter`对象。 第一个参数是要获得的变量的名称; 第二个是应用于它的过滤器。

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

## 过滤操作参数

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

## 数据过滤

除了清理之外，`Phalcon\Filter`还通过删除或修改输入数据以达到我们期望的格式来提供过滤。

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

## 组合过滤器

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

## 添加过滤器

您可以将自己的过滤器添加到`Phalcon\Filter`。过滤器函数可以是匿名函数:

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

## 复杂的清理和过滤

PHP本身提供了一个您可以使用的优秀过滤器扩展。查看它的文档:[数据过滤PHP文档](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## 实现自己的过滤器

必须实现`Phalcon\FilterInterface`接口，以创建您自己的过滤服务，以取代Phalcon提供的过滤服务。