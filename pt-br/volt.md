---
layout: default
language: 'pt-br'
version: '4.0'
upgrade: '#volt'
title: 'Volt: Template Engine'
keywords: 'volt, template engine, php generation, view data'
---

# Volt: Template Engine

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Volt is an ultra-fast and designer friendly templating engine written in C for PHP. It offers a set of helpers to write views easily. Volt is highly integrated with other components of Phalcon, but can be used as a stand alone component in your application.

![](/assets/images/content/views-volt.png)

Volt is inspired by [Jinja](https://github.com/pallets/jinja), originally created by [Armin Ronacher](https://github.com/mitsuhiko).

Many developers will be in familiar territory, using the same syntax they have been using with similar template engines. Volt's syntax and features have been enhanced with more elements and of course with the performance that developers have been accustomed to, while working with Phalcon.

## Syntax

Volt views are compiled to pure PHP code, so basically they save the effort of writing PHP code manually:

```twig
{% raw %}
{% for invoice in invoices %}
<div class='row'>
    <div>
        ID: {{ invoice.titleinv_id }}
    </div>
    <div>
        {%- if 1 === invoice.titleinv_status_flag -%}
        Paid
        {%- else -%}
        Unpaid
        {%- endif -%}
    </div>
    <div>
        {{ invoice.titleinv_description }}
    </div>
    <div>
        {{ invoice.titleinv_total }}
    </div>
</div>
{% endfor %}{% endraw %}
```

compared to:

```php
<?php foreach ($invoices as $invoice) { ?>
<div class='row'>
    <div>
        ID: <?php echo $invoice->inv_id; ?>
    </div>
    <div>
        <?php if (1 === $invoice->inv_status_flag) { ?>
        Paid
        <?php } else { ?>
        Unpaid
        <?php } ?>
    </div>
    <div>
        <?php echo $invoice->inv_description; ?>
    </div>
    <div>
        <?php echo $invoice->total; ?>
    </div>
</div>
<?php } ?>
```

## Constructor

```php
public function __construct(
    ViewBaseInterface $view, 
    DiInterface $container = null
)
```

The constructor accepts a [Phalcon\Mvc\View](views) or any component that implements the `ViewBaseInterface`, and a DI container.

## Methods

There are several methods available in Volt. In most cases, only a handful of them are used in modern day applications.

```php
callMacro(string $name, array $arguments = []): mixed
```

Checks if a macro is defined and calls it

```php
convertEncoding(string $text, string $from, string $to): string
```

Performs a string conversion

```php
getCompiler(): Compiler
```

Returns the Volt's compiler

```php
getContent(): string
```

Returns cached output on another view stage

```php
getOptions(): array
```

Return Volt's options

```php
getView(): ViewBaseInterface
```

Returns the view component related to the adapter

```php
isIncluded(mixed $needle, mixed $haystack): bool
```

Checks if the needle is included in the haystack

```php
length(mixed $item): int
```

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen

```php
partial(string $partialPath, mixed $params = null): string
```

Renders a partial inside another view

```php
render(string $templatePath, mixed $params, bool $mustClean = false)
```

Renders a view using the template engine

```php
setOptions(array $options)
```

Set Volt's options

```php
slice(mixed $value, int $start = 0, mixed $end = null)
```

Extracts a slice from a string/array/traversable object value

```php
sort(array $value): array
```

Sorts an array

## Activation

As with other templating engines, you may register Volt in the view component, using a new extension or reusing the standard `.phtml`:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

$container = new FactoryDefault();

$container->setShared(
    'voltService',
    function (ViewBaseInterface $view) use ($container) {
        $volt = new Volt($view, $container);
        $volt->setOptions(
            [
                'always'    => true,
                'extension' => '.php',
                'separator' => '_',
                'stat'      => true,
                'path'      => appPath('storage/cache/volt/'),
                'prefix'    => '-prefix-',
            ]
        );

        return $volt;
    }
);

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => 'voltService',
            ]
        );

        return $view;
    }
);
```

To use the standard `.phtml` extension:

```php
<?php

$view->registerEngines(
    [
        '.phtml' => 'voltService',
    ]
);
```

You don't have to specify the Volt Service in the DI; you can also use the Volt engine with the default settings:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;


$view->registerEngines(
    [
        '.volt' => Volt::class,
    ]
);
```

If you do not want to reuse Volt as a service, you can pass an anonymous function to register the engine instead of a service name:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');
        $view->registerEngines(
            [
                '.volt' => function (ViewBaseInterface $view) {
                    $volt = new Volt($view, $this);

                    $volt->setOptions(
                        [
                            'always'    => true,
                            'extension' => '.php',
                            'separator' => '_',
                            'stat'      => true,
                            'path'      => appPath('storage/cache/volt/'),
                            'prefix'    => '-prefix-',
                        ]
                    );

                    return $volt;
                }
            ]
        );

        return $view;
    }
);
```

The following options are available in Volt:

| Option       | Default | Description                                                                                                              |
| ------------ | ------- | ------------------------------------------------------------------------------------------------------------------------ |
| `autoescape` | `false` | Enables autoescape HTML globally                                                                                         |
| `always`     | `false` | Whether templates must be compiled in each request or when they change                                                   |
| `extension`  | `.php`  | An additional extension appended to the compiled PHP file                                                                |
| `path`       | `./`    | A writeable path where the compiled PHP templates will be placed                                                         |
| `separator`  | `%%`    | Replace directory separators `/` and `` with this separator in order to create a single file in the compiled directory |
| `prefix`     | `null`  | Prepend a prefix to the templates in the compilation path                                                                |
| `stat`       | `true`  | Whether Phalcon must check if there are differences between the template file and its compiled path                      |

The compilation path is generated according to the options above. You however, have total freedom in defining the compilation path as an anonymous function, including the logic used to generate it. The anonymous function receives the relative path to the template in the predefined views directory.

**Appending extensions**

Append the `.php` extension to the template path, leaving the compiled templates in the same directory:

```php
<?php

$volt->setOptions(
    [
        'path' => function ($templatePath) {
            return $templatePath . '.php';
        }
    ]
);
```

**Different directories**

The following example will create the same structure in a different directory

```php
<?php

$volt->setOptions(
    [
        'path' => function (string $templatePath) {
            $dirName = dirname($templatePath);

            if (true !== is_dir('cache/' . $dirName)) {
                mkdir(
                    'cache/' . $dirName,
                    0777,
                    true
                );
            }

            return 'cache/' . $dirName . '/' . $templatePath . '.php';
        }
    ]
);
```

## Utilização

Volt uses specific delimiters for its syntax. `
{%- raw -%}
{% ... %}
{% endraw %}
` is used to execute statements such as for-loops or assign values and `
{%- raw -%}
{{ ... }}{% endraw %}
` prints the result of an expression to the template. The view files can also contain PHP and HTML should you choose to.

Below is a sample template that illustrates a few basics:

```twig
{%- raw -%}
{# app/views/posts/show.phtml #}
<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }} - An example blog</title>
    </head>
    <body>
        {% if true === showNavigation %}
        <ul id='navigation'>
            {% for item in menu %}
                <li>
                    <a href='{{ item.href }}'>
                        {{ item.caption }}
                    </a>
                </li>
            {% endfor %}
        </ul>
        {% endif %}

        <h1>{{ post.title }}</h1>

        <div class='content'>
            {{ post.content }}
        </div>

    </body>
</html>{% endraw %}
```

Using [Phalcon\Mvc\View](view) you can pass variables from the controller to the views. In the above example, four variables were passed to the view: `showNavigation`, `menu`, `title` and `post`:

```php
<?php

use MyApp\Models\Menu;
use MyApp\Models\Post;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class PostsController extends Controller
{
    public function showAction()
    {
        $post = Post::findFirst();
        $menu = Menu::findFirst();

        $this->view->showNavigation = true;
        $this->view->menu           = $menu;
        $this->view->title          = $post->title;
        $this->view->post           = $post;

        // Or...

        $this->view->setVar('showNavigation', true);
        $this->view->setVar('menu',           $menu);
        $this->view->setVar('title',          $post->title);
        $this->view->setVar('post',           $post);
    }
}
```

> **NOTE** The placeholders for Volt `
{% raw %}{{{% endraw %}
`, `
{% raw %}}}
{% endraw %}
`, `
{% raw %}{%
{% endraw %}
` and `{% raw %}%}{% endraw %}
` cannot be changed or set. 
{: .alert .alert-warning }

### Vue.js

If you are using [Vue](https://vuejs.org) you will need to change the interpolators in Vue itself:

```javascript
new Vue(
    {
        el: '#app',
        data: data,
        delimiters: ["<%","%>"]
    }
);
```

### Angular

If you are using [Angular](https://angular.io) you can set the interpolators as follows:

```javascript
  var myApp = angular.module('myApp', []);

  myApp.config(
    function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }
);
```

## Variables

Object variables may have attributes which can be accessed using the syntax: `foo.bar`. If you are passing arrays, you have to use the square bracket syntax: `foo['bar']`

```twig
{%- raw -%}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
{% endraw %}
```

## Filters

Variables can be formatted or modified using filters. The pipe operator `|` is used to apply filters to variables:

```twig
{%- raw -%}
{{ post.title | e }}
{{ post.content | striptags }}
{{ name | capitalize | trim }}
{% endraw %}
```

The available built-in filters are:

| Filter             | Description                                                                                                                                     |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Applies the [`abs`](https://php.net/manual/en/function.abs.php) PHP function to a value.                                                        |
| `capitalize`       | Capitalizes a string by applying the [`ucwords`](https://php.net/manual/en/function.ucwords.php) PHP function to the value                      |
| `convert_encoding` | Converts a string from one charset to another                                                                                                   |
| `default`          | Sets a default value in case the evaluated expression is empty, not set or evaluates to falsy value                                             |
| `e`                | Applies [`Phalcon\Escaper->escapeHtml()`](escaper) to the value                                                                             |
| `escape`           | Applies [`Phalcon\Escaper->escapeHtml()`](escaper) to the value                                                                             |
| `escape_attr`      | Applies [`Phalcon\Escaper->escapeHtmlAttr()`](escaper) to the value                                                                         |
| `escape_css`       | Applies [`Phalcon\Escaper->escapeCss()`](escaper) to the value                                                                              |
| `escape_js`        | Applies [`Phalcon\Escaper->escapeJs()`](escaper) to the value                                                                               |
| `format`           | Formats a string using [`sprintf`](https://php.net/manual/en/function.sprintf.php)                                                              |
| `json_encode`      | Converts a value into its [JSON](https://php.net/manual/en/function.json-encode.php) representation                                             |
| `json_decode`      | Converts a value from its [JSON](https://php.net/manual/en/function.json-encode.php) representation to a PHP representation                     |
| `join`             | Joins the array parts using a separator [`join`](https://php.net/manual/en/function.join.php)                                                   |
| `keys`             | Returns the array keys using [`array_keys`](https://php.net/manual/en/function.array-keys)                                                      |
| `left_trim`        | Applies the [`ltrim`](https://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                            |
| `length`           | Counts the string length or how many items are in an array or object, equivalent of [`count`](https://www.php.net/manual/en/function.count.php) |
| `lower`            | Change the case of a string to lowercase                                                                                                        |
| `nl2br`            | Changes newlines `\n` by line breaks (`<br />`). Uses the PHP function [`nl2br`](https://php.net/manual/en/function.nl2br.php)           |
| `right_trim`       | Applies the [`rtrim`](https://php.net/manual/en/function.rtrim.php) PHP function to the value. Removing extra spaces                            |
| `slashes`          | Applies the [`addslashes`](https://php.net/manual/en/function.addslashes.php) PHP function to the value.                                        |
| `slice`            | Slices strings, arrays or traversable objects                                                                                                   |
| `sort`             | Sorts an array using the PHP function [`asort`](https://php.net/manual/en/function.asort.php)                                                   |
| `stripslashes`     | Applies the [`stripslashes`](https://php.net/manual/en/function.stripslashes.php) PHP function to the value. Removing escaped quotes            |
| `striptags`        | Applies the [`striptags`](https://php.net/manual/en/function.strip-tags.php) PHP function to the value. Removing HTML tags                      |
| `trim`             | Applies the [`trim`](https://php.net/manual/en/function.trim.php) PHP function to the value. Removing extra spaces                              |
| `upper`            | Applies the [`strtoupper`](https://www.php.net/manual/en/function.strtoupper.php) PHP function to the value.                                    |
| `url_encode`       | Applies the [`urlencode`](https://php.net/manual/en/function.urlencode.php) PHP function to the value                                           |

**Examples**

```twig
{%- raw -%}
{# e or escape filter #}
{{ '<h1>Hello<h1>'|e }}
{{ '<h1>Hello<h1>'|escape }}

{# trim filter #}
{{ '   hello   '|trim }}

{# striptags filter #}
{{ '<h1>Hello<h1>'|striptags }}

{# slashes filter #}
{{ ''this is a string''|slashes }}

{# stripslashes filter #}
{{ '\'this is a string\''|stripslashes }}

{# capitalize filter #}
{{ 'hello'|capitalize }}

{# lower filter #}
{{ 'HELLO'|lower }}

{# upper filter #}
{{ 'hello'|upper }}

{# length filter #}
{{ 'invoices'|length }}
{{ [1, 2, 3]|length }}

{# nl2br filter #}
{{ 'some\ntext'|nl2br }}

{# sort filter #}
{% set sorted = [3, 1, 2]|sort %}

{# keys filter #}
{% set keys = ['first': 1, 'second': 2, 'third': 3]|keys %}

{# join filter #}
{% set joined = 'a'..'z'|join(',') %}

{# format filter #}
{{ 'My real name is %s'|format(name) }}

{# json_encode filter #}
{% set encoded = invoices|json_encode %}

{# json_decode filter #}
{% set decoded = '{'one':1,'two':2,'three':3}'|json_decode %}

{# url_encode filter #}
{{ post.permanent_link|url_encode }}

{# convert_encoding filter #}
{{ 'désolé'|convert_encoding('utf8', 'latin1') }}
{% endraw %}
```

## Comments

Comments may also be added to a template using the `
{%- raw -%}
{# ... #}{% endraw %}
` delimiters. All text inside them is just ignored in the final output:

```twig
{%- raw -%}
{# note: this is a comment
    {% set price = 100; %}
#}{% endraw %}
```

## Control Structures

Volt provides a set of basic but powerful control structures for use in templates:

### For

Loop over each item in a sequence. The following example shows how to traverse a set of `invoices` and print each title:

```twig
{%- raw -%}
<h1>Invoices</h1>
<ul>
    {% for invoice in invoices %}
    <li>
        {{ invoice.inv_title | e }}
    </li>
    {% endfor %}
</ul>{% endraw %}
```

for-loops can also be nested:

```twig
{%- raw -%}
<h1>Invoices</h1>
{% for invoice in invoices %}
    {% for product in invoice.products %}
Product: {{ product.prd_title|e }} {{ product.prd_price|e }} USD <br />
    {% endfor %}
{% endfor %}

{% endraw %}
```

You can get the element `keys` as in the PHP counterpart using the following syntax:

```twig
{%- raw -%}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }} <br />
{% endfor %}

{% endraw %}
```

An `if` evaluation can be optionally set:

```twig
{%- raw -%}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for value in numbers if value < 2 %}
    Value: {{ value }} <br />
{% endfor %}

{% for name, value in numbers if name !== 'two' %}
    Name: {{ name }} Value: {{ value }} <br />
{% endfor %}
{% endraw %}
```

If an `else` is defined inside the `for`, it will be executed if the expression in the iterator result in zero iterations:

```twig
{%- raw -%}
<h1>Invoices</h1>
{% for invoice in invoices %}
    Invoice: {{ invoice.inv_number | e }} - {{ invoice.inv_title | e }} <br />
{% else %}
    There are no invoices to show
{% endfor %}
{% endraw %}
```

Alternative syntax:

```twig
{%- raw -%}
<h1>Invoices</h1>
{% for invoice in invoices %}
    Invoice: {{ invoice.inv_number | e }} - {{ invoice.inv_title | e }} <br />
{% elsefor %}
    There are no invoices to show
{% endfor %}
{% endraw %}
```

### Loops

The `break` and `continue` statements can be used to exit from a loop or force an iteration in the current block:

```twig
{%- raw -%}
{# skip the even invoices #}
{% for index, invoice in invoices %}
    {% if index is even %}
        {% continue %}
    {% endif %}
    ...
{% endfor %}
{% endraw %}
```

```twig
{%- raw -%}
{# exit the foreach on the first even invoice #}
{% for index, invoice in invoices %}
    {% if index is even %}
        {% break %}
    {% endif %}
    ...
{% endfor %}
{% endraw %}
```

### If

As PHP, an `if` statement checks if an expression is evaluated as true or false:

```twig
{%- raw -%}
<h1>Paid Invoices</h1>
<ul>
    {% for invoice in invoices %}
        {% if invoice.inv_paid_flag === 1 %}
            <li>{{ invoice.inv_title | e }}</li>
        {% endif %}
    {% endfor %}
</ul>{% endraw %}
```

The else clause is also supported:

```twig
{%- raw -%}
<h1>Invoices</h1>
<ul>
    {% for invoice in invoices %}
        {% if invoice.inv_paid_flag === 1 %}
            <li>{{ invoice.inv_title | e }}</li>
        {% else %}
            <li>{{ invoice.inv_title | e }} [NOT PAID]</li>
        {% endif %}
    {% endfor %}
</ul>{% endraw %}
```

The `elseif` control flow structure can be used together with if to emulate a `switch` block:

```twig
{%- raw -%}
{% if invoice.inv_paid_flag === constant('MyApp\Constants\Status::PAID') %}
    Invoice is paid
{% elseif invoice.inv_paid_flag === 2 %}
    Invoice is not paid
{% else %}
    Invoice is paid status is not defined
{% endif %}
{% endraw %}
```

### Switch

An alternative to the `if` statement is `switch`, allowing you to create logical execution paths in your application:

```twig
{%- raw -%}
{% switch foo %}
    {% case 0 %}
    {% case 1 %}
    {% case 2 %}
        "foo" is less than 3 but not negative
        {% break %}
    {% case 3 %}
        "foo" is 3
        {% break %}
    {% default %}
        "foo" is {{ foo }}
{% endswitch %}
{% endraw %}
```

The `switch` statement executes statement by statement, therefore the `break` statement is necessary in some cases. Any output (including whitespace) between a switch statement and the first `case` will result in a syntax error. Empty lines and whitespaces can therefore be cleared to reduce the number of errors [see here](https://php.net/control-structures.alternative-syntax).

**`case` without `switch`**

```twig
{%- raw -%}
{% case EXPRESSION %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

**`switch` without `endswitch`**

```twig
{%- raw -%}
{% switch EXPRESSION %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.

**`default` without `switch`**

```twig
{%- raw -%}
{% default %}
{% endraw %}
```

Will not throw an error because `default` is a reserved word for filters like `{%- raw -%}{{ EXPRESSION | default(VALUE) }}{% endraw %}
` but in this case the expression will only output an empty char `''` .

**nested `switch`**

```twig
{%- raw -%}
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

**a `switch` without an expression**

```twig
{%- raw -%}
{% switch %}
  {% case EXPRESSION %}
      {% break %}
{% endswitch %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected token
{%- raw -%}
%}{% endraw %} in ... on line ...`

### Loop Context

A special variable is available inside `for` loops providing you information about

| Variable         | Description                                                   |
| ---------------- | ------------------------------------------------------------- |
| `loop.first`     | True if in the first iteration.                               |
| `loop.index`     | The current iteration of the loop. (1 indexed)                |
| `loop.index0`    | The current iteration of the loop. (0 indexed)                |
| `loop.length`    | The number of items to iterate                                |
| `loop.last`      | True if in the last iteration.                                |
| `loop.revindex`  | The number of iterations from the end of the loop (1 indexed) |
| `loop.revindex0` | The number of iterations from the end of the loop (0 indexed) |

Example:

```twig
{%- raw -%}
{% for invoice in invoices %}
    {% if loop.first %}
        <table>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Title</th>
            </tr>
    {% endif %}
            <tr>
                <td>{{ loop.index }}</td>
                <td>{{ invoice.inv_id }}</td>
                <td> {{ invoice.inv_title }}
    </td>
            </tr>
    {% if loop.last %}
        </table>
    {% endif %}
{% endfor %}
{% endraw %}
```

## Assignments

Variables may be changed in a template using the instruction `set`:

```twig
{%- raw -%}
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set title = invoice.inv_title %}
{% endraw %}
```

Multiple assignments are allowed in the same instruction:

```twig
{%- raw -%}
{% set fruits = ['Apple', 'Banana', 'Orange'], name = invoice.inv_title, active = true %}
{% endraw %}
```

Additionally, you can use compound assignment operators:

```twig
{%- raw -%}
{% set price += 100.00 %}

{% set age *= 5 %}
{% endraw %}
```

The following operators are available:

| Operator | Description               |
| -------- | ------------------------- |
| `=`      | Standard Assignment       |
| `+=`     | Addition assignment       |
| `-=`     | Subtraction assignment    |
| `\*=`  | Multiplication assignment |
| `/=`     | Division assignment       |

## Expressions

Volt provides a basic set of expression support, including literals and common operators. A expression can be evaluated and printed using the `
{%- raw -%}
{{
{% endraw %}
` and `
{%- raw -%}
}}{% endraw %}
` delimiters:

```twig
{%- raw -%}
{{ (1 + 1) * 2 }}
{% endraw %}
```

If an expression needs to be evaluated without be printed the `do` statement can be used:

```twig
{%- raw -%}
{% do (1 + 1) * 2 %}
{% endraw %}
```

### Literals

The following literals are supported:

| Filter               | Description                                                        |
| -------------------- | ------------------------------------------------------------------ |
| `'this is a string'` | Text between double quotes or single quotes are handled as strings |
| `100.25`             | Numbers with a decimal part are handled as doubles/floats          |
| `100`                | Numbers without a decimal part are handled as integers             |
| `false`              | Constant `false` is the boolean `false` value                      |
| `true`               | Constant `true` is the boolean `true` value                        |
| `null`               | Constant `null` is the `null` value                                |

### Arrays

You can create arrays by enclosing a list of values in square brackets:

```twig
{%- raw -%}
{# Simple array #}
{{ ['Apple', 'Banana', 'Orange'] }}

{# Other simple array #}
{{ ['Apple', 1, 2.5, false, null] }}

{# Multi-Dimensional array #}
{{ [[1, 2], [3, 4], [5, 6]] }}

{# Hash-style array #}
{{ ['first': 1, 'second': 4/2, 'third': '3'] }}
{% endraw %}
```

Curly braces also can be used to define arrays or hashes:

```twig
{%- raw -%}
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}

{% endraw %}
```

### Math

You may make calculations in templates using the following operators:

| Operator | Description                                                                                    |
|:--------:| ---------------------------------------------------------------------------------------------- |
|   `+`    | Perform an adding operation. `{%- raw -%}{{ 2 + 3 }}{% endraw %}` returns 5                    |
|   `-`    | Perform a subtraction operation `{%- raw -%}{{ 2 - 3 }}{% endraw %}` returns -1                |
|   `*`    | Perform a multiplication operation `{%- raw -%}{{ 2 * 3 }}{% endraw %}` returns 6              |
|   `/`    | Perform a division operation `{%- raw -%}{{ 10 / 2 }}{% endraw %}` returns 5                   |
|   `%`    | Calculate the remainder of an integer division `{%- raw -%}{{ 10 % 3 }}{% endraw %}` returns 1 |

### Comparisons

The following comparison operators are available:

|  Operator  | Description                                                       |
|:----------:| ----------------------------------------------------------------- |
|    `==`    | Check whether both operands are equal                             |
|    `!=`    | Check whether both operands aren't equal                          |
| `<>` | Check whether both operands aren't equal                          |
|   `>`   | Check whether left operand is greater than right operand          |
|   `<`   | Check whether left operand is less than right operand             |
|  `<=`   | Check whether left operand is less or equal than right operand    |
|  `>=`   | Check whether left operand is greater or equal than right operand |
|   `===`    | Check whether both operands are identical                         |
|   `!==`    | Check whether both operands aren't identical                      |

### Logic

Logic operators are useful in the `if` expression evaluation to combine multiple tests:

|  Operator  | Description                                                       |
|:----------:| ----------------------------------------------------------------- |
|    `or`    | Return true if the left or right operand is evaluated as true     |
|   `and`    | Return true if both left and right operands are evaluated as true |
|   `not`    | Negates an expression                                             |
| `( expr )` | Parenthesis groups expressions                                    |

### Other Operators

Additional operators seen the following operators are available:

| Operator          | Description                                                                                        |
| ----------------- | -------------------------------------------------------------------------------------------------- |
| `~`               | Concatenates both operands `{%- raw -%}{{ 'hello ' ~ 'world' }}{% endraw %}`                       |
| `|`               | Applies a filter in the right operand to the left `{%- raw -%}{{ 'hello'|uppercase }}{% endraw %}` |
| `..`              | Creates a range `{%- raw -%}{{ 'a'..'z' }}{% endraw %}` `{%- raw -%}{{ 1..10 }}{% endraw %}`       |
| `is`              | Same as == (equals), also performs tests                                                           |
| `in`              | To check if an expression is contained into other expressions `if 'a' in 'abc'`                    |
| `is not`          | Same as != (not equals)                                                                            |
| `'a' ? 'b' : 'c'` | Ternary operator. The same as the PHP ternary operator                                             |
| `++`              | Increments a value                                                                                 |
| `--`              | Decrements a value                                                                                 |

The following example shows how to use operators:

```twig
{%- raw -%}
{% set fruits = ['Apple', 'Banana', 'Orange', 'Kiwi'] %}

{% for index in 0..fruits | length %}
    {% if invoices[index] is defined %}
        {{ 'Name: ' ~ invoices[index] }}
    {% endif %}
{% endfor %}

{% endraw %}
```

## Tests

Tests can be used to test if a variable has a valid expected value. The operator `is` is used to perform the tests:

```twig
{%- raw -%}
{% set invoices = ['1': 'Apple', '2': 'Banana', '3': 'Orange'] %}

{% for position, name in invoices %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}

{% endraw %}
```

The following built-in tests are available in Volt:

| Test          | Description                                                          |
| ------------- | -------------------------------------------------------------------- |
| `defined`     | Checks if a variable is defined (`isset()`)                          |
| `divisibleby` | Checks if a value is divisible by other value                        |
| `empty`       | Checks if a variable is empty                                        |
| `even`        | Checks if a numeric value is even                                    |
| `iterable`    | Checks if a value is iterable. Can be traversed by a 'for' statement |
| `numeric`     | Checks if value is numeric                                           |
| `odd`         | Checks if a numeric value is odd                                     |
| `sameas`      | Checks if a value is identical to other value                        |
| `scalar`      | Checks if value is scalar (not an array or object)                   |
| `type`        | Checks if a value is of the specified type                           |

More examples:

```twig

{%- raw -%}
{% if invoice is defined %}
    The invoice variable is defined
{% endif %}

{% if invoice is empty %}
    The invoice is null or is not defined
{% endif %}

{% for key, name in [1: 'Apple', 2: 'Banana', 3: 'Orange'] %}
    {% if key is even %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Apple', 2: 'Banana', 3: 'Orange'] %}
    {% if key is odd %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Apple', 2: 'Banana', 'third': 'Orange'] %}
    {% if key is numeric %}
        {{ name }}
    {% endif %}
{% endfor %}

{% set invoices = [1: 'Apple', 2: 'Banana'] %}
{% if invoices is iterable %}
    {% for invoice in invoices %}
        ...
    {% endfor %}
{% endif %}

{% set world = 'hello' %}
{% if world is sameas('hello') %}
    {{ 'it's hello' }}
{% endif %}

{% set external = false %}
{% if external is type('boolean') %}
    {{ 'external is false or true' }}
{% endif %}

{% endraw %}
```

## Macros

Macros can be used to reuse logic in a template, they act as PHP functions, can receive parameters and return values:

```twig
{%- raw -%}
{# Macro 'display a list of links to related topics' #}
{%- macro related_bar(related_links) %}
    <ul>
        {%- for link in related_links %}
        <li>
            <a href='{{ url(link.url) }}' 
               title='{{ link.title|striptags }}'>
                {{ link.text }}
            </a>
        </li>
        {%- endfor %}
    </ul>
{%- endmacro %}

{# Print related links #}
{{ related_bar(links) }}

<div>This is the content</div>

{# Print related links again #}
{{ related_bar(links) }}
{% endraw %}
```

When calling macros, parameters can be passed by name:

```twig
{%- raw -%}
{%- macro error_messages(message, field, type) %}
    <div>
        <span class='error-type'>{{ type }}</span>
        <span class='error-field'>{{ field }}</span>
        <span class='error-message'>{{ message }}</span>
    </div>
{%- endmacro %}

{# Call the macro #}
{{ 
    error_messages(
        'type': 'Invalid', 
        'message': 'The name not invalid', 
        'field': 'name'
    ) 
}}
{% endraw %}
```

Macros can return values:

```twig
{%- raw -%}
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
{% endraw %}
```

And receive optional parameters:

```twig
{%- raw -%}
{%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
{% endraw %}
```

## Tag Helpers

Volt is highly integrated with [Phalcon\Tag](tag), so it's easy to use the helpers provided by that component in a Volt template:

```twig
{%- raw -%}
{{ javascript_include('js/jquery.js') }}

{{ form('products/save', 'method': 'post') }}

    <label for='name'>Name</label>
    {{ text_field('name', 'size': 32) }}

    <label for='type'>Type</label>
    {{ select({'type', productTypes, 'using': ['id', 'name']}) }}

    <label for='type'>Section</label>
    {{ 
        select(
            [
                'type', 
                productSections, 
                'using': ['id', 'name'], 
                'useEmpty': true, 
                'emptyText': '...', 
                'emptyValue': '', 
                'class': 'form-control'
            ]
        ) 
    }}

    {{ submit_button('Send') }}

{{ end_form() }}
{% endraw %}
```

The following PHP is generated:

```php
<?php echo Phalcon\Tag::javascriptInclude('js/jquery.js') ?>

<?php echo Phalcon\Tag::form(['products/save', 'method' => 'post']); ?>

    <label for='name'>Name</label>
    <?php echo Phalcon\Tag::textField(['name', 'size' => 32]); ?>

    <label for='type'>Type</label>
    <?php echo Phalcon\Tag::select(['type', $productTypes, 'using' => ['id', 'name']]); ?>

    <label for='type'>Section</label>
    <?php echo Phalcon\Tag::select(['type', $productSections, 'using' => ['id', 'name'], 'useEmpty' => true, 'emptyText' => '...', 'emptyValue' => '', 'class' => 'form-control']); ?>

    <?php echo Phalcon\Tag::submitButton('Send'); ?>
{%- raw -%}
{{ end_form() }}
{% endraw %}
```

To call a [Phalcon\Tag](api/Phalcon_Tag) helper, you only need to call an uncamelized version of the method:

| Method                            | Volt function        |
| --------------------------------- | -------------------- |
| `Phalcon\Tag::checkField`        | `check_field`        |
| `Phalcon\Tag::dateField`         | `date_field`         |
| `Phalcon\Tag::emailField`        | `email_field`        |
| `Phalcon\Tag::endForm`           | `end_form`           |
| `Phalcon\Tag::fileField`         | `file_field`         |
| `Phalcon\Tag::form`              | `form`               |
| `Phalcon\Tag::friendlyTitle`     | `friendly_title`     |
| `Phalcon\Tag::getTitle`          | `get_title`          |
| `Phalcon\Tag::hiddenField`       | `hidden_field`       |
| `Phalcon\Tag::image`             | `image`              |
| `Phalcon\Tag::javascriptInclude` | `javascript_include` |
| `Phalcon\Tag::linkTo`            | `link_to`            |
| `Phalcon\Tag::numericField`      | `numeric_field`      |
| `Phalcon\Tag::passwordField`     | `password_field`     |
| `Phalcon\Tag::radioField`        | `radio_field`        |
| `Phalcon\Tag::select`            | `select`             |
| `Phalcon\Tag::selectStatic`      | `select_static`      |
| `Phalcon\Tag::stylesheetLink`    | `stylesheet_link`    |
| `Phalcon\Tag::submitButton`      | `submit_button`      |
| `Phalcon\Tag::textArea`          | `text_area`          |
| `Phalcon\Tag::textField`         | `text_field`         |

## Functions

The following built-in functions are available in Volt:

| Name          | Description                                                 |
| ------------- | ----------------------------------------------------------- |
| `constant`    | Reads a PHP constant                                        |
| `content`     | Includes the content produced in a previous rendering stage |
| `date`        | Calls the PHP function with the same name                   |
| `dump`        | Calls the PHP function `var_dump()`                         |
| `get_content` | Same as `content`                                           |
| `partial`     | Dynamically loads a partial view in the current template    |
| `static_url`  | Generate a static url using the `url` service               |
| `super`       | Render the contents of the parent block                     |
| `time`        | Calls the PHP function with the same name                   |
| `url`         | Generate a URL using the `url` service                      |
| `version`     | Returns the current version of the framework                |
| `version_id`  | Returns the current version id of the framework             |

## View

Also, Volt is integrated with [Phalcon\Mvc\View](view), you can play with the view hierarchy and include partials as well:

```twig
{%- raw -%}
{{ content() }}

<div id='footer'>
    {{ partial('partials/footer') }}
    {{ partial('partials/footer', ['links': links]) }}
</div>{% endraw %}
```

A partial is included in runtime, Volt also provides `include`, this compiles the content of a view and returns its contents as part of the view which was included:

```twig
{%- raw -%}
<div id='footer'>
    {% include 'partials/footer' %}
    {% include 'partials/footer' with ['links': links] %}
</div>{% endraw %}
```

### Include

`include` has a special behavior that will help us improve performance a bit when using Volt, if you specify the extension when including the file and it exists when the template is compiled, Volt can inline the contents of the template in the parent template where it's included. Templates aren't inlined if the `include` have variables passed with `with`:

```twig
{%- raw -%}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
{% endraw %}
```

### Partial Vs Include

Keep the following points in mind when choosing to use the `partial` function or `include`:

| Type       | Description                                                                                                                                                                                                                                                        |
| ---------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `partial`  | allows you to include templates made in Volt and in other template engines as well allows you to pass an expression like a variable allowing to include the content of other view dynamically is better if the content that you have to include changes frequently |
| `includes` | copies the compiled content into the view which improves the performance only allows to include templates made with Volt requires an existing template at compile time                                                                                             |

## Inheritance

With template inheritance you can create base templates that can be extended by others templates allowing to reuse code. A base template define *blocks* than can be overridden by a child template. Let's pretend that we have the following base template:

```twig
{%- raw -%}
{# templates/base.volt #}
<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel='stylesheet' href='style.css' />
        {% endblock %}

        <title>{% block title %}
            {% endblock %}
        - My Webpage</title>
    </head>

    <body>
        <div id='content'>{% block content %}
    
{% endblock %}
</div>

        <div id='footer'>
            {% block footer %}
                &copy; Copyright 2012-present. 
                All rights reserved.

{% endblock %}
</div>
    </body>
</html>
{% endraw %}
```

From other template we could extend the base template replacing the blocks:

```twig
{%- raw -%}
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style type='text/css'>.important { color: #336699; }</style>{% endblock %}

{% block content %}

    <h1>Index</h1>
    <p class='important'>Welcome on my awesome homepage.</p>

{% endblock %}
{% endraw %}
```

Not all blocks must be replaced at a child template, only those that are needed. The final output produced will be the following:

```html
<!DOCTYPE html>
<html>
    <head>
        <style type='text/css'>.important { color: #336699; }</style>

        <title>Index - My Webpage</title>
    </head>

    <body>
        <div id='content'>
            <h1>Index</h1>
            <p class='important'>Welcome on my awesome homepage.</p>
        </div>

        <div id='footer'>
            &copy; Copyright 2012-present. 
            All rights reserved.
        </div>
    </body>
</html>
```

### Multiple Inheritance

Extended templates can extend other templates. The following example illustrates this:

```twig
{%- raw -%}
{# main.volt #}
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>

    <body>
        {% block content %}{% endblock %}
    </body>
</html>
{% endraw %}
```

Template `layout.volt` extends `main.volt`

```twig
{%- raw -%}
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
{% endraw %}
```

Finally a view that extends `layout.volt`:

```twig
{%- raw -%}{# index.volt #}
{% extends 'layout.volt' %}

{% block content %}{{ super() }}

    <ul>
        <li>Some option</li>
        <li>Some other option</li>
    </ul>

{% endblock %}
{% endraw %}
```

Rendering `index.volt` produces:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>

    <body>

        <h1>Table of contents</h1>

        <ul>
            <li>Some option</li>
            <li>Some other option</li>
        </ul>

    </body>
</html>
```

Note the call to the function `super()`. With that function it is possible to render the contents of the parent block. As partials, the path set to `extends` is a relative path under the current views directory (i.e. `app/views/`).

> **NOTE**: By default, and for performance reasons, Volt only checks for changes in the children templates to know when to re-compile to plain PHP again, so it is recommended initialize Volt with the option `'always' => true`. Thus, the templates are compiled always taking into account changes in the parent templates.
{: .alert .alert-warning }

## Autoescape Mode

You can enable auto-escaping of all variables printed in a block using the autoescape mode:

```twig
{%- raw -%}
Manually escaped: {{ invoice.inv_title|e }}

{% autoescape true %}
    Autoescaped: {{ invoice.inv_title }}
    {% autoescape false %}
        No Autoescaped: {{ invoice.inv_title }}{% endautoescape %}
{% endautoescape %}
{% endraw %}
```

## Extending Volt

Unlike other template engines, Volt itself is not required to run the compiled templates. Once the templates are compiled there is no dependence on Volt. With performance independence in mind, Volt only acts as a compiler for PHP templates.

The Volt compiler allow you to extend it adding more functions, tests or filters to the existing ones.

### Functions

Functions act as normal PHP functions, a valid string name is required as function name. Functions can be added using two options, returning a simple string or using an anonymous function. Whichever option you use, you must return a valid PHP string expression.

The following example binds the function name `shuffle` in Volt to the PHP function `str_shuffle`:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $container);

$compiler = $volt->getCompiler();

$compiler->addFunction('shuffle', 'str_shuffle');
```

and in Volt:

```twig
{% raw %}{{ str_suffle('abcdefg') }}{% endraw %}
```

The example below registers the function with an anonymous function. Here we use `$resolvedArgs` to pass the arguments exactly when calling the method from the view:

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

and in Volt:

```twig
{% raw %}{{ widget('param1', 'param2') }}{% endraw %}
```

You can also treat the arguments independently and also check for unresolved parameters. In the example below, we retrieve the first parameter and then check for the existence of a second parameter. If present, we store it, otherwise we use the default `10`. Finally we call the `str_repeat` PHP method on the first and second parameter.

```php
<?php

$compiler->addFunction(
    'repeat',
    function ($resolvedArgs, $exprArgs) use ($compiler) {
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            $secondArgument = '10';
        }

        return 'str_repeat(' . $firstArgument . ', ' . $secondArgument . ')';
    }
);
```

and in Volt:

```twig
{% raw %}{{ repeat('Apples', 'Oranges') }}{% endraw %}
```

You can also check the availability of functions in your system and call them if present. In the following example we will call `mb_stripos` if the `mbstring` extension is present. If present, then `mb_stripos` will be called, otherwise `stripos`:

```php
<?php

$compiler->addFunction(
    'contains_text',
    function ($resolvedArgs, $exprArgs) {
        if (true === function_exists('mb_stripos')) {
            return 'mb_stripos(' . $resolvedArgs . ')';
        } else {
            return 'stripos(' . $resolvedArgs . ')';
        }
    }
);
```

You can also override built-in functions by using the same name in the defined function. In the example below, we *replace* the built-in Volt function `dump()` with PHP's `print_r`.

```php
<?php

$compiler->addFunction('dump', 'print_r');
```

### Filters

A filter has the following form in a template: `leftExpr|name(optional-args)`. Adding new filters is similar as with the functions.

Add a new filter called `hash` using the `sha1` method:

```php
<?php

$compiler->addFilter('hash', 'sha1');
```

Add a new filter called `int`:

```php
<?php

$compiler->addFilter(
    'int',
    function ($resolvedArgs, $exprArgs) {
        return 'intval(' . $resolvedArgs . ')';
    }
);
```

Built-in filters can be overridden adding a function with the same name. The example below will replace the built-in `capitalize` filter with PHP's [lcfirst](https://php.net/manual/en/function.lcfirst.php) function:

```php
<?php

$compiler->addFilter('capitalize', 'lcfirst');
```

### Extensions

With extensions the developer has more flexibility to extend the template engine, and override the compilation of instructions, change the behavior of an expression or operator, add functions/filters, and more.

An extension is a class that implements the events triggered by Volt as a method of itself. For example, the class below allows to use any PHP function in Volt:

```php
<?php

namespace MyApp\View\Extensions;

class PhpFunctionExtension
{
    public function compileFunction(string $name, string $arguments)
    {
        if (true === function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }
}
```

The above class implements the method `compileFunction` which is invoked before any attempt to compile a function call in any template. The purpose of the extension is to verify if a function to be compiled is a PHP function allowing to call the PHP function from the template. Events in extensions must return valid PHP code, which will be used as result of the compilation instead of code generated by Volt. If an event does not return a string the compilation is done using the default behavior provided by the engine.

Volt extensions must be in registered in the compiler making them available in compile time:

```php
<?php

use MyApp\View\Extensions\PhpFunctionExtension;

$compiler->addExtension(
    new PhpFunctionExtension()
);
```

### Compiler

The Volt compiler depends on the Volt parser. The parser parses the Volt templates and creates an Intermediate Representation (IR) from it. The compiler uses that representation and produces the compiled PHP code.

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler;

$compiler = new Compiler();

$compiler->compile("views/partials/header.volt");

require $compiler->getCompiledTemplatePath();
```

The [Phalcon\Mvc\View\Engine\Volt\Compiler](api/phalcon_mvc#mvc-view-engine-volt-compiler) offers a number of methods that can be extended to suit your application needs.

```php
public function __construct(ViewBaseInterface $view = null)
```

Constructor

```php
public function addExtension(mixed $extension): Compiler
```

Registers an extension

```php
public function addFilter(
    string $name, 
    mixed definition
): Compiler
```

Register a new filter

```php
public function addFunction(
    string $name, 
    mixed $definition
): Compiler
```

Register a new function

```php
public function attributeReader(array $expr): string
```

Resolves attribute reading

```php
public function compile(
    string $templatePath, 
    bool $extendsMode = false
)
```

Compiles a template into a file applying the compiler options. This method does not return the compiled path if the template was not compiled

```php
$compiler->compile("views/layouts/main.volt");

require $compiler->getCompiledTemplatePath();
```

```php
public function compileAutoEscape(
    array $statement, 
    bool $extendsMode
): string
```

Compiles a "autoescape" statement returning PHP code

```php
public function compileCache(
    array $statement, 
    bool $extendsMode = false
): string
```

Compiles a `cache` statement returning PHP code

```php
public function compileCall(array $statement, bool $extendsMode)
```

Compiles calls to macros

```php
public function compileCase(
    array $statement, 
    bool $caseClause = true
): string
```

Compiles a `case`/`default` clause returning PHP code

```php
public function compileDo(array $statement): string
```

Compiles a `do` statement returning PHP code

```php
public function compileEcho(array $statement): string
```

Compiles a {% raw %}`{{` `}}`{% endraw %} statement returning PHP code

```php
public function compileElseIf(array $statement): string
```

Compiles a `elseif` statement returning PHP code

```php
public function compileFile(
    string $path, 
    string $compiledPath, 
    bool $extendsMode = false
): string | array
```

Compiles a template into a file also creating the destination path

```php
$compiler->compileFile(
    "views/layouts/main.volt",
    "views/layouts/main.volt.php"
);
```

```php
public function compileForeach(
    array $statement, 
    bool $extendsMode = false
): string
```

Compiles a `foreach` statement returning PHP code

```php
public function compileForElse(): string
```

Compiles a `forelse` statement returning PHP code

```php
public function compileIf(
    array $statement, 
    bool $extendsMode = false
): string
```

Compiles a `if` statement returning PHP code

```php
public function compileInclude(array $statement): string
```

Compiles a `include` statement returning PHP code

```php
public function compileMacro(
    array $statement, 
    bool $extendsMode
): string
```

Compiles a macro

```php
public function compileReturn(array $statement): string
```

Compiles a `return` statement returning PHP code

```php
public function compileSet(array $statement): string
```

Compiles a setter statement (assignment of value to variable) returning PHP code

```php
public function compileString(
    string $viewCode, 
    bool $extendsMode = false
): string
```

Compiles a template into a string

```php
echo $compiler->compileString({% raw %}'{{ "hello world" }}'{% endraw %});
```

```php
public function compileSwitch(
    array $statement, 
    bool $extendsMode = false
): string
```

Compiles a `switch` statement returning PHP code

```php
final public function expression(array $expr): string
```

Resolves an expression node in an AST volt tree

```php
final public function fireExtensionEvent(
    string $name, 
    array $arguments = null
)
```

```php
public function functionCall(array $expr): string
```

Resolves function intermediate code into PHP function calls

```php
public function getCompiledTemplatePath(): string
```

Returns the path to the last compiled template

```php
public function getExtensions(): array
```

Returns the registered extensions

```php
public function getFilters(): array
```

Register the registered user filters

```php
public function getFunctions(): array
```

Register the registered user functions

```php
public function getOption(string $option): string
```

Returns an option of the compiler

```php
public function getOptions(): array
```

Returns the compiler options

```php
public function getTemplatePath(): string
```

Returns the path that is currently being compiled

```php
public function getUniquePrefix(): string
```

Return a unique prefix to be used as prefix for compiled variables and contexts

```php
public function parse(string $viewCode): array
```

Parses a Volt template returning its intermediate representation

```php
print_r(
    $compiler->parse("{% raw %}{{ 3 + 2 }}{% endraw %}")
);
```

```php
public function resolveTest(array $test, string $left): string
```

Resolves filter intermediate code into a valid PHP expression

```php
public function setOption(string $option, mixed $value)
```

Sets a single compiler option

```php
public function setOptions(array $options)
```

Sets the compiler options

```php
public function setUniquePrefix(string $prefix): Compiler
```

Set a unique prefix to be used as prefix for compiled variables

## Events

The following compilation <events> are available to be implemented in extensions:

| Event/Method        | Description                                                                                            |
| ------------------- | ------------------------------------------------------------------------------------------------------ |
| `compileFunction`   | Triggered before trying to compile any function call in a template                                     |
| `compileFilter`     | Triggered before trying to compile any filter call in a template                                       |
| `resolveExpression` | Triggered before trying to compile any expression. This allows the developer to override operators     |
| `compileStatement`  | Triggered before trying to compile any expression. This allows the developer to override any statement |

## Caching

With Volt it's easy cache view fragments. This mechanism improves performance, preventing the generated code from being executed by PHP, each time the view is displayed:

```twig
{%- raw -%}{% cache 'sidebar' %}
    <!-- .... -->
{% endcache %}
{% endraw %}
```

Setting a specific number of seconds (1 hour):

```twig
{%- raw -%}{% cache 'sidebar' 3600 %}
    <!-- ... -->
{% endcache %}
{% endraw %}
```

Any valid expression can be used as cache key:

```twig
{%- raw -%}{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
{% endraw %}
```

The caching is done by the [Phalcon\Cache](cache) component via the view component.

## Services

If a service container (DI) is available for Volt. Any registered service in the DI container is available in volt, with a variable having the same name as the one that the service is registered with. In the example below we use the `flash` service as well as the `security` one:

```twig
{%- raw -%}
<div id='messages'>{{ flash.output() }}</div>
<input type='hidden' name='token' value='{{ security.getToken() }}'>
{% endraw %}
```

## Stand-alone

You can use Volt as a stand along component in any application.

Register the compiler and set some options:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

$compiler = new VoltCompiler();
$compiler->setOptions(
    [
        // ...
    ]
);
```

Compilation of templates or strings:

```php
<?php

echo $compiler->compileString(
    "{{ 'hello' }}"
);

$compiler->compileFile(
    'layouts/main.volt',
    'cache/layouts/main.volt.php'
);

$compiler->compile(
    'layouts/main.volt'
);
```

You can finally include the compiled template if needed:

```php
<?php

require $compiler->getCompiledTemplatePath();
```

## Compiling

Every time you deploy your application to production, you will need to delete the pre-compiled `.volt` files, so that any changes you made in your templates are displayed to your users. A very easy way to do this is to clean the `volt/` folder using a CLI script or manually delete all files.

If we assume that your `volt` path is located at: `/app/storage/cache/volt/` then the following script will allow you to clear that folder anytime you run it, usually after a deployment.

```php
<?php

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function in_array;
use function substr;

$fileList    = [];
$whitelist   = ['.', '..', '.gitignore'];
$path        = appPath('storage/cache');
$dirIterator = new RecursiveDirectoryIterator($path);
$iterator    = new RecursiveIteratorIterator(
    $dirIterator,
    RecursiveIteratorIterator::CHILD_FIRST
);

foreach ($iterator as $file) {
    if (true !== $file->isDir() && 
        true !== in_array($file->getFilename(), $whitelist)) {
        $fileList[] = $file->getPathname();
    }
}

echo sprintf('Found %s files', count($fileList)) . PHP_EOL;
foreach ($fileList as $file) {
    echo '.';
    unlink($file);
}

echo PHP_EOL . 'Folder cleared' . PHP_EOL;
```

In the example above, we use PHP's [RecursiveDirectoryIterator](https://www.php.net/manual/en/class.recursivedirectoryiterator.php) and [RecursiveIteratorIterator](https://www.php.net/manual/en/class.recursiveiteratoriterator.php) to iterate through a folder recursively and create a list of files in the `$fileList` array. After that, we iterate through that array and [unlink](https://www.php.net/manual/en/function.unlink.php) each file in turn.

As mentioned above, based on the options provided during setup, Volt can check whether the compiled files exist and generate them accordingly. Additionally, Volt can check if the files have been changed and if yes, generate them.

These checks are performed when the `always` and `stat` options are set to `true`. For any project, checking the file system multiple times per request (one time per Volt file), is consuming resources. Additionally, you need to ensure that the folder used by Volt to compile the templates is writeable by your web server.

You can create a script or a CLI task (using the [CLI Application](application-cli)) to compile and save all the Volt files when you deploy code. This way, you will be able to instruct Volt not to compile or stat each file in turn, increasing performance. Additionally, since these files are compiled during the deployment process, the volt folder will not need to be writeable, increasing security. Since the compiled Volt templates are phtml fragments, not allowing the web server to generate executable code is always a good idea.

Remember this script will be executed at the command line, but in order to compile our templates we will need to bootstrap our web application. In the example below, we will need to get the DI container that has all the services registered for our web application. Then we can use the Volt compiler to compile all the templates to the relevant folder.

In the example below, we assume that we have a `Bootstrap\Web` class that is responsible for setting up all of our services for the Web application. The class returns the DI container using `getContainer()`. Your implementation might vary.

```php
<?php

use MyApp\Library\Bootstrap\Web;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function in_array;
use function substr;

if (php_sapi_name() !== "cli") {
    throw new Exception(
        'You need to run this script from the command line'
    );
}

$bootstrap = new Web();
$container = $bootstrap->getContainer();
$view      = $container->getShared('view'); 
$viewPath  = $view->getViewsDir();
$volt      = $container->getShared('volt');

$fileList    = [];
$whitelist   = ['.', '..', '.gitignore'];
$path        = $viewPath;
$dirIterator = new RecursiveDirectoryIterator($path);
$iterator    = new RecursiveIteratorIterator(
    $dirIterator,
    RecursiveIteratorIterator::CHILD_FIRST
);

foreach ($iterator as $file) {
    if (true !== $file->isDir() && 
        true !== in_array($file->getFilename(), $whitelist)) {
        $fileList[] = $file->getPathname();
    }
}

echo sprintf('Found %s files', count($fileList)) . PHP_EOL;
foreach ($fileList as $file) {
    echo '.';
    $volt->getCompiler()->compile($file);
}

echo PHP_EOL . 'Templates compiled' . PHP_EOL;
```

## External Resources

* A bundle for Sublime/Textmate is available [here](https://github.com/phalcon/volt-sublime-textmate)
* [Phosphorum](https://forum.phalcon.io), the Phalcon's forum, also uses Volt, [GitHub](https://github.com/phalcon/forum)
* [Vökuró](tutorial-vokuro), is another sample application that uses Volt, [GitHub](https://github.com/phalcon/vokuro)