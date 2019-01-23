---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Volt: 模板引擎

Volt is an ultra-fast and designer friendly templating language written in C for PHP. It provides you a set of helpers to write views in an easy way. Volt is highly integrated with other components of Phalcon, just as you can use it as a stand-alone component in your applications.

![](/assets/images/content/volt.jpg)

Volt is inspired by [Jinja](https://jinja.pocoo.org/), originally created by [Armin Ronacher](https://github.com/mitsuhiko). Therefore many developers will be in familiar territory using the same syntax they have been using with similar template engines. Volt's syntax and features have been enhanced with more elements and of course with the performance that developers have been accustomed to while working with Phalcon.

<a name='introduction'></a>

## 简介

Volt views are compiled to pure PHP code, so basically they save the effort of writing PHP code manually:

```twig
{% raw %}
{# app/views/products/show.volt #}

{% block last_products %}

{% for product in products %}
    * Name: {{ product.name|e }}
    {% if product.status === 'Active' %}
       Price: {{ product.price + product.taxes/100 }}
    {% endif  %}
{% endfor  %}

{% endblock %}
{% endraw %}
```

<a name='setup'></a>

## 启用 Volt

As with other templating engines, you may register Volt in the view component, using a new extension or reusing the standard `.phtml`:

```php
<?php
use Phalcon\Mvc\View; 
use Phalcon\Mvc\View\Engine\Volt; 
// Register Volt as a service 
$di->set(    
 'voltService',     function ($view, $di) { 
        $volt = new Volt($view, $di);
         $volt->setOptions(
             [
                 'compiledPath' => '../app/compiled-templates/',
                 'compiledExtension' => '.compiled',
             ]
         );
```

Use the standard `.phtml` extension:

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
 $view->registerEngines(
     [
         '.volt' => Phalcon\Mvc\View\Engine\Volt::class,
     ]
 );
```

` If you do not want to reuse Volt as a service, you can pass an anonymous function to register the engine instead of a service name:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// 使用匿名函数的方法注册Volt为视图引擎
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => function ($view, $di) {
                    $volt = new Volt($view, $di);

                    // 设置Volt选项

                    return $volt;
                }
            ]
        );

        return $view;
    }
);
```

The following options are available in Volt:

| 选项                  | 描述                                                                                                                           | 默认      |
| ------------------- | ---------------------------------------------------------------------------------------------------------------------------- | ------- |
| `autoescape`        | Enables globally autoescape of HTML                                                                                          | `false` |
| `compileAlways`     | Tell Volt if the templates must be compiled in each request or only when they change                                         | `false` |
| `compiledExtension` | An additional extension appended to the compiled PHP file                                                                    | `.php`  |
| `compiledPath`      | A writable path where the compiled PHP templates will be placed                                                              | `./`    |
| `compiledSeparator` | Volt replaces the directory separators / and \ by this separator in order to create a single file in the compiled directory | `%%`    |
| `前缀`                | 设置在指定的compiledPath中编译后的文件前缀                                                                                                  | `null`  |
| `stat`              | Whether Phalcon must check if exists differences between the template file and its compiled path                             | `true`  |

The compilation path is generated according to the above options, if the developer wants total freedom defining the compilation path, an anonymous function can be used to generate it, this function receives the relative path to the template in the views directory. The following examples show how to change the compilation path dynamically:

```php
<?php

// 使用.php作为文件拓展名
// 不用设置编译后的文件路径，让所有的编译后的文件在同一目录
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            return $templatePath . '.php';
        }
    ]
);

// 以递归的方式创建一个相同结构的目录在另一个目录中
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            $dirName = dirname($templatePath);

            if (!is_dir('cache/' . $dirName)) {
                mkdir('cache/' . $dirName , 0777 , true);
            }

            return 'cache/' . $dirName . '/'. $templatePath . '.php';
        }
    ]
);
```

<a name='basic-usage'></a>

## 基本用法

A view consists of Volt code, PHP and HTML. A set of special delimiters is available to enter into Volt mode. `{% raw %}{% ... %}{% endraw %}` is used to execute statements such as for-loops or assign values and `{% raw %}{{ ... }}{% endraw %}`, prints the result of an expression to the template.

Below is a minimal template that illustrates a few basics:

```twig
{% raw %}
{# app/views/posts/show.phtml #}
<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }} - An example blog</title>
    </head>
    <body>

        {% if show_navigation %}
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
</html>
{% endraw %}
```

Using [Phalcon\Mvc\View](api/Phalcon_Mvc_View) you can pass variables from the controller to the views. In the above example, four variables were passed to the view: `show_navigation`, `menu`, `title` and `post`:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function showAction()
    {
        $post = Post::findFirst();
        $menu = Menu::findFirst();

        $this->view->show_navigation = true;
        $this->view->menu            = $menu;
        $this->view->title           = $post->title;
        $this->view->post            = $post;

        // 或者

        $this->view->setVar('show_navigation', true);
        $this->view->setVar('menu',            $menu);
        $this->view->setVar('title',           $post->title);
        $this->view->setVar('post',            $post);
    }
}
```

<a name='variables'></a>

## 变量的使用

Object variables may have attributes which can be accessed using the syntax: `foo.bar`. If you are passing arrays, you have to use the square bracket syntax: `foo['bar']`

```twig
{% raw %}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
{% endraw %}
```

<a name='filters'></a>

## 过滤器

Variables can be formatted or modified using filters. The pipe operator `|` is used to apply filters to variables:

```twig
{% raw %}
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
{% endraw %}
```

The following is the list of available built-in filters in Volt:

| 筛选器                | 描述                                                                                                                                  |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Applies the [abs](https://php.net/manual/en/function.abs.php) PHP function to a value.                                              |
| `capitalize`       | Capitalizes a string by applying the [ucwords](https://php.net/manual/en/function.ucwords.php) PHP function to the value            |
| `convert_encoding` | 将一个字符串从一个字符集转换到另一个                                                                                                                  |
| `default`          | 在表达式的计算结果为空的情况下设置一个默认值 （不存在或计算结果为 false 的值）                                                                                         |
| `e`                | 使用`Phalcon\Escaper->escapeHtml()`处理这个变量                                                                                         |
| `escape`           | 使用`Phalcon\Escaper->escapeHtml()`处理这个变量                                                                                         |
| `escape_attr`      | 使用`Phalcon\Escaper-> escapeHtmlAttr()`处理这个变量                                                                                    |
| `escape_css`       | 使用`Phalcon\Escaper-> escapeCss()`处理这个变量                                                                                         |
| `escape_js`        | 使用`Phalcon\Escaper-> escapeJs()`处理这个变量                                                                                          |
| `format`           | Formats a string using [sprintf](https://php.net/manual/en/function.sprintf.php).                                                   |
| `json_encode`      | Converts a value into its [JSON](https://php.net/manual/en/function.json-encode.php) representation                                 |
| `json_decode`      | Converts a value from its [JSON](https://php.net/manual/en/function.json-encode.php) representation to a PHP representation         |
| `join`             | Joins the array parts using a separator [join](https://php.net/manual/en/function.join.php)                                         |
| `keys`             | Returns the array keys using [array_keys](https://php.net/manual/en/function.array-keys.php)                                        |
| `left_trim`        | Applies the [ltrim](https://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                  |
| `length`           | 计算字符串长度或数组或对象中有多少项                                                                                                                  |
| `lower`            | 将字符串的大小更改为小写                                                                                                                        |
| `nl2br`            | Changes newlines `\n` by line breaks (`<br />`). Uses the PHP function [nl2br](https://php.net/manual/en/function.nl2br.php) |
| `right_trim`       | Applies the [rtrim](https://php.net/manual/en/function.rtrim.php) PHP function to the value. Removing extra spaces                  |
| `sort`             | Sorts an array using the PHP function [asort](https://php.net/manual/en/function.asort.php)                                         |
| `stripslashes`     | Applies the [stripslashes](https://php.net/manual/en/function.stripslashes.php) PHP function to the value. Removing escaped quotes  |
| `striptags`        | Applies the [striptags](https://php.net/manual/en/function.striptags.php) PHP function to the value. Removing HTML tags             |
| `trim`             | Applies the [trim](https://php.net/manual/en/function.trim.php) PHP function to the value. Removing extra spaces                    |
| `upper`            | Change the case of a string to uppercase                                                                                            |
| `url_encode`       | Applies the [urlencode](https://php.net/manual/en/function.urlencode.php) PHP function to the value                                 |

Examples:

```twig
{% raw %}
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
{{ 'robots'|length }}
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
{% set encoded = robots|json_encode %}

{# json_decode filter #}
{% set decoded = '{'one':1,'two':2,'three':3}'|json_decode %}

{# url_encode filter #}
{{ post.permanent_link|url_encode }}

{# convert_encoding filter #}
{{ 'désolé'|convert_encoding('utf8', 'latin1') }}
{% endraw %}
```

<a name='comments'></a>

## 注释

Comments may also be added to a template using the `{% raw %}{# ... #}{% endraw %}` delimiters. All text inside them is just ignored in the final output:

```twig
{% raw %}
{# note: this is a comment
    {% set price = 100; %}
#}
{% endraw %}
```

<a name='control-structures'></a>

## 列表输出和结构输出

Volt provides a set of basic but powerful control structures for use in templates:

<a name='control-structures-for'></a>

### For循环列表

Loop over each item in a sequence. The following example shows how to traverse a set of 'robots' and print his/her name:

```twig
{% raw %}
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        <li>
            {{ robot.name|e }}
        </li>
    {% endfor %}
</ul>
{% endraw %}
```

for-loops can also be nested:

```twig
{% raw %}
<h1>Robots</h1>
{% for robot in robots %}
    {% for part in robot.parts %}
        Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
    {% endfor %}
{% endfor %}
{% endraw %}
```

You can get the element `keys` as in the PHP counterpart using the following syntax:

```twig
{% raw %}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
{% endraw %}
```

An `if` evaluation can be optionally set:

```twig
{% raw %}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for value in numbers if value < 2 %}
    Value: {{ value }}
{% endfor %}

{% for name, value in numbers if name !== 'two' %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
{% endraw %}
```

If an `else` is defined inside the `for`, it will be executed if the expression in the iterator result in zero iterations:

```twig
{% raw %}
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% else %}
    There are no robots to show
{% endfor %}
{% endraw %}
```

Alternative syntax:

```twig
{% raw %}
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% elsefor %}
    There are no robots to show
{% endfor %}
{% endraw %}
```

<a name='control-structures-loops'></a>

### Loop循环

The `break` and `continue` statements can be used to exit from a loop or force an iteration in the current block:

```twig
{% raw %}
{# skip the even robots #}
{% for index, robot in robots %}
    {% if index is even %}
        {% continue %}
    {% endif %}
    ...
{% endfor %}
{% endraw %}
```

```twig
{% raw %}
{# exit the foreach on the first even robot #}
{% for index, robot in robots %}
    {% if index is even %}
        {% break %}
    {% endif %}
    ...
{% endfor %}
{% endraw %}
```

<a name='control-structures-if'></a>

### If

As PHP, an `if` statement checks if an expression is evaluated as true or false:

```twig
{% raw %}
<h1>Cyborg Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% endif %}
    {% endfor %}
</ul>
{% endraw %}
```

The else clause is also supported:

```twig
{% raw %}
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% else %}
            <li>{{ robot.name|e }} (not a cyborg)</li>
        {% endif %}
    {% endfor %}
</ul>
{% endraw %}
```

The `elseif` control flow structure can be used together with if to emulate a `switch` block:

```twig
{% raw %}
{% if robot.type === 'cyborg' %}
    Robot is a cyborg
{% elseif robot.type === 'virtual' %}
    Robot is virtual
{% elseif robot.type === 'mechanical' %}
    Robot is mechanical
{% endif %}
{% endraw %}
```

<a name='controls-structures-switch'></a>

### Switch

An alternative to the `if` statement is `switch`, allowing you to create logical execution paths in your application:

```twig
{% raw %}
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

#### `case` without `switch`

```twig
{% raw %}
{% case EXPRESSION %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

#### `switch` without `endswitch`

```twig
{% raw %}
{% switch EXPRESSION %}
{% endraw %}
Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.
```

#### `default` without `switch`

```twig
{% raw %}
{% default %}
{% endraw %}
```

Will not throw an error because `default` is a reserved word for filters like `{% raw %}{{ EXPRESSION | default(VALUE) }}{% endraw %}` but in this case the expression will only output an empty char '' .

#### nested `switch`

```twig
{% raw %}
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

#### a `switch` without an expression

```twig
{% raw %}
{% switch %}
  {% case EXPRESSION %}
      {% break %}
{% endswitch %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected token {% raw %}%}{% endraw %} in ... on line ...`

<a name='control-structures-loop'></a>

### Loop的高级使用

A special variable is available inside `for` loops providing you information about

| Variable         | 描述                                             |
| ---------------- | ---------------------------------------------- |
| `loop.index`     | The current iteration of the loop. (1 indexed) |
| `loop.index0`    | The current iteration of the loop. (0 indexed) |
| `loop.revindex`  | 循环结束的迭代次数（1个为起始）                               |
| `loop.revindex0` | 循环结束的迭代次数（0个起始）                                |
| `loop.first`     | 如果在第一次迭代值为 true。                               |
| `loop.last`      | 如果在最后一次迭代值为 true。                              |
| `loop.length`    | 要循环的次数                                         |

Example:

```twig
{% raw %}
{% for robot in robots %}
    {% if loop.first %}
        <table>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Name</th>
            </tr>
    {% endif %}
            <tr>
                <td>{{ loop.index }}</td>
                <td>{{ robot.id }}</td>
                <td>{{ robot.name }}</td>
            </tr>
    {% if loop.last %}
        </table>
    {% endif %}
{% endfor %}
{% endraw %}
```

<a name='assignments'></a>

## 分配变量

Variables may be changed in a template using the instruction `set`:

```twig
{% raw %}
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set name = robot.name %}
{% endraw %}
```

Multiple assignments are allowed in the same instruction:

```twig
{% raw %}
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
{% endraw %}
```

Additionally, you can use compound assignment operators:

```twig
{% raw %}
{% set price += 100.00 %}

{% set age *= 5 %}
{% endraw %}
```

The following operators are available:

| 运算符     | 描述    |
| ------- | ----- |
| `=`     | 标准的赋值 |
| `+=`    | 加法赋值  |
| `-=`    | 减法赋值  |
| `\*=` | 乘法赋值  |
| `/=`    | 除法赋值  |

<a name='expressions'></a>

## 表达式：

Volt provides a basic set of expression support, including literals and common operators. A expression can be evaluated and printed using the `{% raw %}{{{% endraw %}` and `{% raw %}}}{% endraw %}` delimiters:

```twig
{% raw %}
{{ (1 + 1) * 2 }}
{% endraw %}
```

If an expression needs to be evaluated without be printed the `do` statement can be used:

```twig
{% raw %}
{% do (1 + 1) * 2 %}
{% endraw %}
```

<a name='expressions-literals'></a>

### 字面值(原始的值, 就是直接输出!)

The following literals are supported:

| 筛选器           | 描述                      |
| ------------- | ----------------------- |
| `' 这是一个字符串 '` | 双引号或单引号之间的文本是作为字符串处理    |
| `100.25`      | 小数部分的数字处理作为 "双精度/单精度"数字 |
| `100`         | 没有小数部分的数字是整数作为处理        |
| `false`       | 常量 'false' 是布尔值 false   |
| `true`        | 常量 'true' 是布尔值 true     |
| `null`        | 常数 null 是 Null 值        |

<a name='expressions-arrays'></a>

### 数组

Whether you're using PHP 5.3 or >= 5.4 you can create arrays by enclosing a list of values in square brackets:

```twig
{% raw %}
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
{% raw %}
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
{% endraw %}
```

<a name='expressions-math'></a>

### 计算

You may make calculations in templates using the following operators:

| 运算符 | 描述                                                                                           |
|:---:| -------------------------------------------------------------------------------------------- |
| `+` | Perform an adding operation. `{% raw %}{{ 2 + 3 }}{% endraw %}` returns 5                    |
| `-` | Perform a substraction operation `{% raw %}{{ 2 - 3 }}{% endraw %}` returns -1               |
| `*` | Perform a multiplication operation `{% raw %}{{ 2 * 3 }}{% endraw %}` returns 6              |
| `/` | Perform a division operation `{% raw %}{{ 10 / 2 }}{% endraw %}` returns 5                   |
| `%` | Calculate the remainder of an integer division `{% raw %}{{ 10 % 3 }}{% endraw %}` returns 1 |

<a name='expressions-comparisons'></a>

### 比较运算符

The following comparison operators are available:

|    运算符     | 描述                    |
|:----------:| --------------------- |
|    `==`    | 检查两个操作数是否相等           |
|    `!=`    | 检查是否两个操作数不平等          |
| `<>` | 检查是否两个操作数不平等          |
|   `>`   | 检查左的操作数是否大于右操作数       |
|   `<`   | 检查左的操作数是否小于右操作数       |
|  `<=`   | 检查左的操作数是否小于或等于右边的操作数比 |
|  `>=`   | 检查左的操作数是否大于或等于右边的操作数比 |
|   `===`    | 检查两个操作数是否绝对相同         |
|   `!==`    | 检查是否两个操作数绝对不一致        |

<a name='expressions-logic'></a>

### 逻辑运算符

Logic operators are useful in the `if` expression evaluation to combine multiple tests:

|    运算符     | 描述                          |
|:----------:| --------------------------- |
|    `or`    | 如果向左或向右操作数计算为 true，则返回 true |
|   `and`    | 如果左、 右操作数计算都为 true，则返回 true |
|   `not`    | 对表达式求反                      |
| `( expr )` | 圆括号对表达式进行分组                 |

<a name='expressions-other-operators'></a>

### 其他运算符

Additional operators seen the following operators are available:

| 运算符               | 描述                                                                                               |
| ----------------- | ------------------------------------------------------------------------------------------------ |
| `~`               | Concatenates both operands `{% raw %}{{ 'hello ' ~ 'world' }}{% endraw %}`                       |
| `|`               | Applies a filter in the right operand to the left `{% raw %}{{ 'hello'|uppercase }}{% endraw %}` |
| `..`              | Creates a range `{% raw %}{{ 'a'..'z' }}{% endraw %}` `{% raw %}{{ 1..10 }}{% endraw %}`         |
| `is`              | 同样作为 = = （等于），也执行测试                                                                              |
| `in`              | 要检查是否表达式包含入其他表达式 `如果 'a' 在 'abc'`                                                                |
| `is not`          | 同样作为 ！ = （不等于）                                                                                   |
| `'a' ? 'b' : 'c'` | Ternary operator. The same as the PHP ternary operator                                           |
| `++`              | 递增的值                                                                                             |
| `--`              | 一个值递减                                                                                            |

The following example shows how to use operators:

```twig
{% raw %}
{% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

{% for index in 0..robots|length %}
    {% if robots[index] is defined %}
        {{ 'Name: ' ~ robots[index] }}
    {% endif %}
{% endfor %}
{% endraw %}
```

<a name='tests'></a>

## 检测器

Tests can be used to test if a variable has a valid expected value. The operator `is` is used to perform the tests:

```twig
{% raw %}
{% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

{% for position, name in robots %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}
{% endraw %}
```

The following built-in tests are available in Volt:

| 检测器           | 描述                                                                   |
| ------------- | -------------------------------------------------------------------- |
| `defined`     | 检查变量是否定义 (`isset()`)                                                 |
| `divisibleby` | 检查一个值是否可以被其他值整除                                                      |
| `empty`       | 检查变量是否为空                                                             |
| `even`        | 检查一个数值是否为偶数                                                          |
| `iterable`    | Checks if a value is iterable. Can be traversed by a 'for' statement |
| `numeric`     | 检查值是否真为数字的                                                           |
| `odd`         | 检查是否一个数值是奇数                                                          |
| `sameas`      | 检查一个值是否与其他的值相同                                                       |
| `scalar`      | 检查值是否标量 （不是数组或对象）                                                    |
| `type`        | 检查一个值是否指定类型的                                                         |

More examples:

```twig
{% raw %}
{% if robot is defined %}
    The robot variable is defined
{% endif %}

{% if robot is empty %}
    The robot is null or isn't defined
{% endif %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
    {% if key is even %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
    {% if key is odd %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 'third': 'Bender'] %}
    {% if key is numeric %}
        {{ name }}
    {% endif %}
{% endfor %}

{% set robots = [1: 'Voltron', 2: 'Astroy Boy'] %}
{% if robots is iterable %}
    {% for robot in robots %}
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

<a name='macros'></a>

## 宏定义

Macros can be used to reuse logic in a template, they act as PHP functions, can receive parameters and return values:

```twig
{% raw %}
{# Macro 'display a list of links to related topics' #}
{%- macro related_bar(related_links) %}
    <ul>
        {%- for link in related_links %}
            <li>
                <a href='{{ url(link.url) }}' title='{{ link.title|striptags }}'>
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
{% raw %}
{%- macro error_messages(message, field, type) %}
    <div>
        <span class='error-type'>{{ type }}</span>
        <span class='error-field'>{{ field }}</span>
        <span class='error-message'>{{ message }}</span>
    </div>
{%- endmacro %}

{# Call the macro #}
{{ error_messages('type': 'Invalid', 'message': 'The name is invalid', 'field': 'name') }}
{% endraw %}
```

Macros can return values:

```twig
{% raw %}
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
{% endraw %}
```

And receive optional parameters:

```twig
{% raw %}
{%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
{% endraw %}
```

<a name='tag-helpers'></a>

## 使用标签助手

Volt is highly integrated with [Phalcon\Tag](api/Phalcon_Tag), so it's easy to use the helpers provided by that component in a Volt template:

```twig
{% raw %}
{{ javascript_include('js/jquery.js') }}

{{ form('products/save', 'method': 'post') }}

    <label for='name'>Name</label>
    {{ text_field('name', 'size': 32) }}

    <label for='type'>Type</label>
    {{ select('type', productTypes, 'using': ['id', 'name']) }}

    {{ submit_button('Send') }}

{{ end_form() }}
{% endraw %}
```

The following PHP is generated:

```php
<?php echo Phalcon\Tag::javascriptInclude('js/jquery.js') ?>

<?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

    <label for='name'>Name</label>
    <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

    <label for='type'>Type</label>
    <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

    <?php echo Phalcon\Tag::submitButton('Send'); ?>

{% raw %}
{{ end_form() }}
{% endraw %}
```

To call a [Phalcon\Tag](api/Phalcon_Tag) helper, you only need to call an uncamelized version of the method:

| 方法                                | Volt 方法              |
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

<a name='functions'></a>

## 函数

The following built-in functions are available in Volt:

| 名称            | 描述                     |
| ------------- | ---------------------- |
| `content`     | 引入当前下层级所产生的内容          |
| `get_content` | `content` 相同           |
| `partial`     | 动态加载其他模版到到当前视图         |
| `super`       | 呈现父块的内容                |
| `time`        | 调用具有相同名称的 PHP 函数       |
| `date`        | 调用具有相同名称的 PHP 函数       |
| `dump`        | 调用 PHP 函数 `var_dump()` |
| `version`     | 返回当框架的前版本              |
| `constant`    | 读取一个 PHP 常量            |
| `url`         | 生成使用 url 服务的 URL       |

<a name='view-integrations'></a>

## 视图集成

Also, Volt is integrated with [Phalcon\Mvc\View](api/Phalcon_Mvc_View), you can play with the view hierarchy and include partials as well:

```twig
{% raw %}
{{ content() }}

<!-- Simple include of a partial -->
<div id='footer'>{{ partial('partials/footer') }}</div>

<!-- Passing extra variables -->
<div id='footer'>{{ partial('partials/footer', ['links': links]) }}</div>
{% endraw %}
```

A partial is included in runtime, Volt also provides `include`, this compiles the content of a view and returns its contents as part of the view which was included:

```twig
{% raw %}
{# Simple include of a partial #}
<div id='footer'>
    {% include 'partials/footer' %}
</div>

{# Passing extra variables #}
<div id='footer'>
    {% include 'partials/footer' with ['links': links] %}
</div>
{% endraw %}
```

<a name='view-integration-include'></a>

### Include

`include` has a special behavior that will help us improve performance a bit when using Volt, if you specify the extension when including the file and it exists when the template is compiled, Volt can inline the contents of the template in the parent template where it's included. Templates aren't inlined if the `include` have variables passed with `with`:

```twig
{% raw %}
{# The contents of 'partials/footer.volt' is compiled and inlined #}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
{% endraw %}
```

<a name='view-integration-partial-vs-include'></a>

### 部分 vs 包括

Keep the following points in mind when choosing to use the `partial` function or `include`:

| 类型        | 描述                             |
| --------- | ------------------------------ |
| `partial` | 允许你引入Volt或者其他引擎的模版             |
|           | 允许你像传递变量一样传递一个表达式来动态引入其他试图中的内容 |
|           | 如果模版内容经常改变效果更好                 |
| `引入`      | 将已编译后的模版内容复制到尝试引入的试图中已改变性能     |
|           | 只允许引入Volt模版                    |
|           | 在编译时模版文件需要存在                   |

<a name='template-inheritance'></a>

## 模板继承

With template inheritance you can create base templates that can be extended by others templates allowing to reuse code. A base template define *blocks* than can be overridden by a child template. Let's pretend that we have the following base template:

```twig
{% raw %}
{# templates/base.volt #}
<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel='stylesheet' href='style.css' />
        {% endblock %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <body>
        <div id='content'>{% block content %}{% endblock %}</div>

        <div id='footer'>
            {% block footer %}&copy; Copyright 2015, All rights reserved.{% endblock %}
        </div>
    </body>
</html>
{% endraw %}
```

From other template we could extend the base template replacing the blocks:

```twig
{% raw %}
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
            &copy; Copyright 2015, All rights reserved.
        </div>
    </body>
</html>
```

<a name='template-inheritance-multiple'></a>

### 多重继承

Extended templates can extend other templates. The following example illustrates this:

```twig
{% raw %}
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
{% raw %}
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
{% endraw %}
```

Finally a view that extends `layout.volt`:

```twig
{% raw %}
{# index.volt #}
{% extends 'layout.volt' %}

{% block content %}

    {{ super() }}

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

Note the call to the function `super()`. With that function it's possible to render the contents of the parent block. As partials, the path set to `extends` is a relative path under the current views directory (i.e. `app/views/`).

<h5 class='alert alert-warning'>By default, and for performance reasons, Volt only checks for changes in the children templates to know when to re-compile to plain PHP again, so it is recommended initialize Volt with the option <code>'compileAlways' =&gt; true</code>. Thus, the templates are compiled always taking into account changes in the parent templates. </h5>

<a name='autoescape'></a>

## Autoescape 模式

You can enable auto-escaping of all variables printed in a block using the autoescape mode:

```twig
{% raw %}
Manually escaped: {{ robot.name|e }}

{% autoescape true %}
    Autoescaped: {{ robot.name }}
    {% autoescape false %}
        No Autoescaped: {{ robot.name }}
    {% endautoescape %}
{% endautoescape %}
{% endraw %}
```

<a name='extending'></a>

## 扩展 Volt

Unlike other template engines, Volt itself is not required to run the compiled templates. Once the templates are compiled there is no dependence on Volt. With performance independence in mind, Volt only acts as a compiler for PHP templates.

The Volt compiler allow you to extend it adding more functions, tests or filters to the existing ones.

<a name='extending-functions'></a>

### 函数

Functions act as normal PHP functions, a valid string name is required as function name. Functions can be added using two strategies, returning a simple string or using an anonymous function. Always is required that the chosen strategy returns a valid PHP string expression:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// This binds the function name 'shuffle' in Volt to the PHP function 'str_shuffle'
$compiler->addFunction('shuffle', 'str_shuffle');
```

Register the function with an anonymous function. This case we use `$resolvedArgs` to pass the arguments exactly as were passed in the arguments:

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

Treat the arguments independently and unresolved:

```php
<?php

$compiler->addFunction(
    'repeat',
    function ($resolvedArgs, $exprArgs) use ($compiler) {
        // Resolve the first argument
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        // Checks if the second argument was passed
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            // Use '10' as default
            $secondArgument = '10';
        }

        return 'str_repeat(' . $firstArgument . ', ' . $secondArgument . ')';
    }
);
```

Generate the code based on some function availability:

```php
<?php

$compiler->addFunction(
    'contains_text',
    function ($resolvedArgs, $exprArgs) {
        if (function_exists('mb_stripos')) {
            return 'mb_stripos(' . $resolvedArgs . ')';
        } else {
            return 'stripos(' . $resolvedArgs . ')';
        }
    }
);
```

Built-in functions can be overridden adding a function with its name:

```php
<?php

// Replace built-in function dump
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### 过滤器

A filter has the following form in a template: leftExpr|name(optional-args). Adding new filters is similar as seen with the functions:

```php
<?php

// This creates a filter 'hash' that uses the PHP function 'md5'
$compiler->addFilter('hash', 'md5');
```

```php
<?php

$compiler->addFilter(
    'int',
    function ($resolvedArgs, $exprArgs) {
        return 'intval(' . $resolvedArgs . ')';
    }
);
```

Built-in filters can be overridden adding a function with its name:

```php
<?php

// Replace built-in filter 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### 扩展

With extensions the developer has more flexibility to extend the template engine, and override the compilation of a specific instruction, change the behavior of an expression or operator, add functions/filters, and more.

An extension is a class that implements the events triggered by Volt as a method of itself. For example, the class below allows to use any PHP function in Volt:

```php
<?php

class PhpFunctionExtension
{
    /**
     * This method is called on any attempt to compile a function call
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }
}
```

The above class implements the method `compileFunction` which is invoked before any attempt to compile a function call in any template. The purpose of the extension is to verify if a function to be compiled is a PHP function allowing to call it from the template. Events in extensions must return valid PHP code, this will be used as result of the compilation instead of the one generated by Volt. If an event doesn't return an string the compilation is done using the default behavior provided by the engine.

The following compilation events are available to be implemented in extensions:

| Event/Method        | 描述                                                                                                     |
| ------------------- | ------------------------------------------------------------------------------------------------------ |
| `compileFunction`   | Triggered before trying to compile any function call in a template                                     |
| `compileFilter`     | Triggered before trying to compile any filter call in a template                                       |
| `resolveExpression` | Triggered before trying to compile any expression. This allows the developer to override operators     |
| `compileStatement`  | Triggered before trying to compile any expression. This allows the developer to override any statement |

Volt extensions must be in registered in the compiler making them available in compile time:

```php
<?php

// Register the extension in the compiler
$compiler->addExtension(
    new PhpFunctionExtension()
);
```

<a name='caching-view-fragments'></a>

## 缓存的视图片段

With Volt it's easy cache view fragments. This caching improves performance preventing that the contents of a block from being executed by PHP each time the view is displayed:

```twig
{% raw %}
{% cache 'sidebar' %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
{% endraw %}
```

Setting a specific number of seconds:

```twig
{% raw %}
{# cache the sidebar by 1 hour #}
{% cache 'sidebar' 3600 %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
{% endraw %}
```

Any valid expression can be used as cache key:

```twig
{% raw %}
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
{% endraw %}
```

The caching is done by the `Phalcon\Cache` component via the view component. Learn more about how this integration works in the section [Caching View Fragments](/4.0/en/views#caching-fragments).

<a name='services-in-templates'></a>

## 将服务注入到一个模板

If a service container (DI) is available for Volt, you can use the services by only accessing the name of the service in the template:

```twig
{% raw %}
{# Inject the 'flash' service #}
<div id='messages'>{{ flash.output() }}</div>

{# Inject the 'security' service #}
<input type='hidden' name='token' value='{{ security.getToken() }}'>
{% endraw %}
```

<a name='stand-alone'></a>

## 独立组件

Using Volt in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

// Create a compiler
$compiler = new VoltCompiler();

// Optionally add some options
$compiler->setOptions(
    [
        // ...
    ]
);

// Compile a template string returning PHP code
echo $compiler->compileString(
    "{{ 'hello' }}"
);

// Compile a template in a file specifying the destination file
$compiler->compileFile(
    'layouts/main.volt',
    'cache/layouts/main.volt.php'
);

// Compile a template in a file based on the options passed to the compiler
$compiler->compile(
    'layouts/main.volt'
);

// Require the compiled templated (optional)
require $compiler->getCompiledTemplatePath();
```

## 外部资源

* A bundle for Sublime/Textmate is available [here](https://github.com/phalcon/volt-sublime-textmate)
* [Album-O-Rama](https://album-o-rama.phalconphp.com) is a sample application using Volt as template engine, [GitHub](https://github.com/phalcon/album-o-rama)
* [Our website](https://phalconphp.com) is running using Volt as template engine, [GitHub](https://github.com/phalcon/website)
* [Phosphorum](https://forum.phalconphp.com), the Phalcon's forum, also uses Volt, [GitHub](https://github.com/phalcon/forum)
* [Vökuró](https://vokuro.phalconphp.com), is another sample application that use Volt, [GitHub](https://github.com/phalcon/vokuro)