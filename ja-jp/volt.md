* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Volt: テンプレートエンジン

Volt is an ultra-fast and designer friendly templating language written in C for PHP. It provides you a set of helpers to write views in an easy way. Volt is highly integrated with other components of Phalcon, just as you can use it as a stand-alone component in your applications.

![](/assets/images/content/volt.jpg)

Volt is inspired by [Jinja](https://jinja.pocoo.org/), originally created by [Armin Ronacher](https://github.com/mitsuhiko). Therefore many developers will be in familiar territory using the same syntax they have been using with similar template engines. Volt's syntax and features have been enhanced with more elements and of course with the performance that developers have been accustomed to while working with Phalcon.

<a name='introduction'></a>

## はじめに

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

## Voltを使うために

As with other templating engines, you may register Volt in the view component, using a new extension or reusing the standard `.phtml`:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Voltをサービスとして登録
$di->set(
    'voltService',
    function ($view, $di) {
        $volt = new Volt($view, $di);

        $volt->setOptions(
            [
                'compiledPath'      => '../app/compiled-templates/',
                'compiledExtension' => '.compiled',
            ]
        );

        return $volt;
    }
);

// Voltをテンプレートエンジンとして登録
$di->set(
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

// 無名関数によってVoltをテンプレートエンジンとして登録
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => function ($view, $di) {
                    $volt = new Volt($view, $di);

                    // Set some options here

                    return $volt;
                }
            ]
        );

        return $view;
    }
);
```

The following options are available in Volt:

| オプション               | Description                                                                                      | デフォルト   |
| ------------------- | ------------------------------------------------------------------------------------------------ | ------- |
| `autoescape`        | Enables globally autoescape of HTML                                                              | `false` |
| `compileAlways`     | Tell Volt if the templates must be compiled in each request or only when they change             | `false` |
| `compiledExtension` | An additional extension appended to the compiled PHP file                                        | `.php`  |
| `compiledPath`      | A writable path where the compiled PHP templates will be placed                                  | `./`    |
| `compiledSeparator` | Voltはコンパイルされたディレクトリに単一のファイルを作成するために、この区切り文字/を\に置き換えます                                           | `%%`    |
| `prefix`            | コンパイルパスのテンプレートにプレフィックスを付加することができます                                                               | `null`  |
| `stat`              | Whether Phalcon must check if exists differences between the template file and its compiled path | `true`  |

The compilation path is generated according to the above options, if the developer wants total freedom defining the compilation path, an anonymous function can be used to generate it, this function receives the relative path to the template in the views directory. The following examples show how to change the compilation path dynamically:

```php
<?php

// .php拡張子をテンプレートパスに追加するだけ
// コンパイルされたテンプレートは同じディレクトリに残す
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            return $templatePath . '.php';
        }
    ]
);

// 他のディレクトリに同じ構造で作成
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

## 基本的な使い方

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

        // Or...

        $this->view->setVar('show_navigation', true);
        $this->view->setVar('menu',            $menu);
        $this->view->setVar('title',           $post->title);
        $this->view->setVar('post',            $post);
    }
}
```

<a name='variables'></a>

## 変数

Object variables may have attributes which can be accessed using the syntax: `foo.bar`. If you are passing arrays, you have to use the square bracket syntax: `foo['bar']`

```twig
{% raw %}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
{% endraw %}
```

<a name='filters'></a>

## フィルター

Variables can be formatted or modified using filters. The pipe operator `|` is used to apply filters to variables:

```twig
{% raw %}
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
{% endraw %}
```

The following is the list of available built-in filters in Volt:

| Filter             | Description                                                                                                                         |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Applies the [abs](https://php.net/manual/en/function.abs.php) PHP function to a value.                                              |
| `capitalize`       | Capitalizes a string by applying the [ucwords](https://php.net/manual/en/function.ucwords.php) PHP function to the value            |
| `convert_encoding` | 文字列をある文字セットから別の文字セットに変換します                                                                                                          |
| `default`          | 評価された式が空（設定されていないかfalse）である場合のデフォルト値を設定します                                                                                          |
| `e`                | `Phalcon\Escaper->escapeHtml()` を値に適用します                                                                                        |
| `escape`           | `Phalcon\Escaper->escapeHtml()` を値に適用します                                                                                        |
| `escape_attr`      | `Phalcon\Escaper->escapeHtmlAttr()` を値に適用します                                                                                    |
| `escape_css`       | `Phalcon\Escaper->escapeCss()` を値に適用します                                                                                         |
| `escape_js`        | `Phalcon\Escaper->escapeJs()` を値に適用します                                                                                          |
| `format`           | Formats a string using [sprintf](https://php.net/manual/en/function.sprintf.php).                                                   |
| `json_encode`      | Converts a value into its [JSON](https://php.net/manual/en/function.json-encode.php) representation                                 |
| `json_decode`      | Converts a value from its [JSON](https://php.net/manual/en/function.json-encode.php) representation to a PHP representation         |
| `join`             | Joins the array parts using a separator [join](https://php.net/manual/en/function.join.php)                                         |
| `keys`             | Returns the array keys using [array_keys](https://php.net/manual/en/function.array-keys.php)                                        |
| `left_trim`        | Applies the [ltrim](https://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                  |
| `length`           | 文字列の長さ、または配列、オブジェクトに含まれるアイテムの数を数えます                                                                                                 |
| `lower`            | 文字列を小文字に変更します。                                                                                                                      |
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

## コメント

Comments may also be added to a template using the `{% raw %}{# ... #}{% endraw %}` delimiters. All text inside them is just ignored in the final output:

```twig
{% raw %}
{# note: this is a comment
    {% set price = 100; %}
#}
{% endraw %}
```

<a name='control-structures'></a>

## 制御構文の一覧

Volt provides a set of basic but powerful control structures for use in templates:

<a name='control-structures-for'></a>

### for文

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

### ループ制御

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

### If文

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

### switch文

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

#### `switch` 無し `case` 文

```twig
{% raw %}
{% case EXPRESSION %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

#### `endswitch` 無し `switch` 文

```twig
{% raw %}
{% switch EXPRESSION %}
{% endraw %}
Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.
```

#### `switch` 無し `default` 文

```twig
{% raw %}
{% default %}
{% endraw %}
```

Will not throw an error because `default` is a reserved word for filters like `{% raw %}{{ EXPRESSION | default(VALUE) }}{% endraw %}` but in this case the expression will only output an empty char '' .

#### ネストした `switch` 文

```twig
{% raw %}
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

#### 式の無い `switch` 文

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

### ループ変数

A special variable is available inside `for` loops providing you information about

| Variable         | Description          |
| ---------------- | -------------------- |
| `loop.index`     | ループの現在の反復回数。（1始まり）   |
| `loop.index0`    | ループの現在の反復回数。（0始まり）   |
| `loop.revindex`  | ループの終わりからの反復回数（1始まり） |
| `loop.revindex0` | ループの終わりからの反復回数（0始まり） |
| `loop.first`     | ループの最初ならtrue。        |
| `loop.last`      | ループの最後ならtrue。        |
| `loop.length`    | ループするアイテムの数          |

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

## 変数割り当て

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

| 演算子     | Description |
| ------- | ----------- |
| `=`     | 代入          |
| `+=`    | 値を足す        |
| `-=`    | 値を引く        |
| `\*=` | 値を掛ける       |
| `/=`    | 値で割る        |

<a name='expressions'></a>

## 条件式

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

### 定数

The following literals are supported:

| Filter               | Description                      |
| -------------------- | -------------------------------- |
| `'this is a string'` | 二重引用符または一重引用符間のテキストは文字列として扱われます  |
| `100.25`             | 小数点以下の桁数はdouble / floatとして扱われます。 |
| `100`                | 小数部のない数値は整数として扱われます              |
| `false`              | 定数 'false' はbool値のfalseです        |
| `true`               | 定数 'true' はbool値のtrueです          |
| `null`               | 定数 'null' はNULLの値です              |

<a name='expressions-arrays'></a>

### 配列

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

### 計算

You may make calculations in templates using the following operators:

| 演算子 | Description                                                                                  |
|:---:| -------------------------------------------------------------------------------------------- |
| `+` | Perform an adding operation. `{% raw %}{{ 2 + 3 }}{% endraw %}` returns 5                    |
| `-` | Perform a substraction operation `{% raw %}{{ 2 - 3 }}{% endraw %}` returns -1               |
| `*` | Perform a multiplication operation `{% raw %}{{ 2 * 3 }}{% endraw %}` returns 6              |
| `/` | Perform a division operation `{% raw %}{{ 10 / 2 }}{% endraw %}` returns 5                   |
| `%` | Calculate the remainder of an integer division `{% raw %}{{ 10 % 3 }}{% endraw %}` returns 1 |

<a name='expressions-comparisons'></a>

### 比較

The following comparison operators are available:

|    演算子     | Description                           |
|:----------:| ------------------------------------- |
|    `==`    | 両方のオペランドが等しいかどうかをチェックする               |
|    `!=`    | 両方のオペランドが等しくないかをチェックする                |
| `<>` | 両方のオペランドが等しくないかをチェックする                |
|   `>`   | 左オペランドが右オペランドより大きいかどうかをチェックする         |
|   `<`   | 左オペランドが右オペランドより小さいかどうかをチェックする         |
|  `<=`   | 左オペランドが右オペランドより小さい、もしくは等しいかどうかをチェックする |
|  `>=`   | 左オペランドが右オペランドより大きい、もしくは等しいかどうかをチェックする |
|   `===`    | 両方のオペランドが同一かどうかをチェックする                |
|   `!==`    | 両方のオペランドが同一では無いかをチェックする               |

<a name='expressions-logic'></a>

### 演算子

Logic operators are useful in the `if` expression evaluation to combine multiple tests:

|    演算子     | Description                          |
|:----------:| ------------------------------------ |
|   `または`    | 左または右のオペランドがtrueと評価された場合はtrueを返します。  |
|   `and`    | 左と右の両方のオペランドがtrueと評価された場合はtrueを返します。 |
|   `not`    | 式を否定します                              |
| `( expr )` | 式のグルーピング                             |

<a name='expressions-other-operators'></a>

### その他演算子

Additional operators seen the following operators are available:

| 演算子               | Description                                                                                      |
| ----------------- | ------------------------------------------------------------------------------------------------ |
| `~`               | Concatenates both operands `{% raw %}{{ 'hello ' ~ 'world' }}{% endraw %}`                       |
| `|`               | Applies a filter in the right operand to the left `{% raw %}{{ 'hello'|uppercase }}{% endraw %}` |
| `..`              | Creates a range `{% raw %}{{ 'a'..'z' }}{% endraw %}` `{% raw %}{{ 1..10 }}{% endraw %}`         |
| `is`              | ==（equals）と同じですが、テストも実行します                                                                       |
| `in`              | 式が他の式に含まれている事をチェックする `if 'a' in 'abc'`                                                           |
| `is not`          | != (not equals) と同じ                                                                              |
| `'a' ? 'b' : 'c'` | 三項演算子。 PHPの三項演算子と同じ                                                                              |
| `++`              | 値を増やす                                                                                            |
| `--`              | 値を減らす                                                                                            |

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

## テスト

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

| テスト           | Description                         |
| ------------- | ----------------------------------- |
| `defined`     | 変数が定義されているかどうかをチェックします (`isset()`)  |
| `divisibleby` | 値が他の値で割り切れるかどうかをチェックします             |
| `empty`       | 変数が空であるかどうかをチェックします                 |
| `even`        | 数値が偶数であるかどうかをチェックします。               |
| `iterable`    | 値が反復可能かどうかをチェックします。 'for' 文で取得できます  |
| `numeric`     | 値が数値かどうかをチェックします                    |
| `odd`         | 数値が奇数かどうかをチェックします                   |
| `sameas`      | 値が他の値と等しいかどうかをチェックします               |
| `scalar`      | 値がスカラー（配列またはオブジェクトではない）かどうかをチェックします |
| `type`        | 値が指定された型かどうかをチェックします                |

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

## マクロ

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

## タグヘルパーを使用する

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

| メソッド                              | Volt関数               |
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

## 関数

The following built-in functions are available in Volt:

| Name          | Description                  |
| ------------- | ---------------------------- |
| `content`     | 以前のレンダリング段階で作成されたコンテンツが含まれます |
| `get_content` | `content` と同じです              |
| `partial`     | 現在のテンプレートにパーシャルビューを動的にロードする  |
| `super`       | 親ブロックの内容をレンダリングする            |
| `time`        | 同じ名前のPHP関数を呼び出します            |
| `date`        | 同じ名前のPHP関数を呼び出します            |
| `dump`        | PHP関数を呼び出します `var_dump()`    |
| `version`     | フレームワークの現在のバージョンを返します        |
| `constant`    | PHP定数を読み込む                   |
| `url`         | 'url' サービスを使用してURLを生成する      |

<a name='view-integrations'></a>

## Viewとの連携

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

### include文

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

### partial文 vs include文

Keep the following points in mind when choosing to use the `partial` function or `include`:

| Type       | Description                                   |
| ---------- | --------------------------------------------- |
| `partial`  | Voltと他のテンプレートエンジンで作成されたテンプレートをインクルードすることができます |
|            | 他のビューのコンテンツを動的に含めることができる、変数のような式を渡すことができます    |
|            | 含める必要があるコンテンツが頻繁に変更される場合はベスト                  |
| `includes` | コンパイルされたコンテンツをビューにコピーしてパフォーマンスを向上させます         |
|            | Voltで作成したテンプレートのみインクルードできます                   |
|            | コンパイル時に既存のテンプレートが必要です                         |

<a name='template-inheritance'></a>

## テンプレートの継承

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

### 多重継承

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

## 自動エスケープ モード

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

## Volt の拡張

Unlike other template engines, Volt itself is not required to run the compiled templates. Once the templates are compiled there is no dependence on Volt. With performance independence in mind, Volt only acts as a compiler for PHP templates.

The Volt compiler allow you to extend it adding more functions, tests or filters to the existing ones.

<a name='extending-functions'></a>

### 関数

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
        // 最初の引数を解決する
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        // 2番目の引数が渡されたかどうかをチェックする
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            // デフォルトで '10' を使用
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

// 組み込み関数のdumpを置き換える
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### フィルター

A filter has the following form in a template: leftExpr|name(optional-args). Adding new filters is similar as seen with the functions:

```php
<?php

// これにより、PHP関数 'md5'を使用するフィルタ 'hash' が作成されます。
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

// 組み込みフィルタを置き換える 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### エクステンション

With extensions the developer has more flexibility to extend the template engine, and override the compilation of a specific instruction, change the behavior of an expression or operator, add functions/filters, and more.

An extension is a class that implements the events triggered by Volt as a method of itself. For example, the class below allows to use any PHP function in Volt:

```php
<?php

class PhpFunctionExtension
{
    /**
     * このメソッドは、関数呼び出しをコンパイルしようとすると呼び出されます
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

| イベント/関数             | Description                                                                                            |
| ------------------- | ------------------------------------------------------------------------------------------------------ |
| `compileFunction`   | Triggered before trying to compile any function call in a template                                     |
| `compileFilter`     | Triggered before trying to compile any filter call in a template                                       |
| `resolveExpression` | Triggered before trying to compile any expression. This allows the developer to override operators     |
| `compileStatement`  | Triggered before trying to compile any expression. This allows the developer to override any statement |

Volt extensions must be in registered in the compiler making them available in compile time:

```php
<?php

// コンパイラに拡張機能を登録する
$compiler->addExtension(
    new PhpFunctionExtension()
);
```

<a name='caching-view-fragments'></a>

## Viewの断片のキャッシュ

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

## テンプレートへのサービス注入

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

## 独立コンポーネント

Using Volt in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

// コンパイラーを生成
$compiler = new VoltCompiler();

// オプションでいくつかのオプションを追加する
$compiler->setOptions(
    [
        // ...
    ]
);

// PHPコードを返すテンプレート文字列をコンパイルする
echo $compiler->compileString(
    "{{ 'hello' }}"
);

// コピー先のファイルを指定してファイル内のテンプレートをコンパイルする
$compiler->compileFile(
    'layouts/main.volt',
    'cache/layouts/main.volt.php'
);

// コンパイラに渡されるオプションに基づいてファイル内のテンプレートをコンパイルする
$compiler->compile(
    'layouts/main.volt'
);

// コンパイルされたテンプレートをrequire（オプション）
require $compiler->getCompiledTemplatePath();
```

## External Resources

* A bundle for Sublime/Textmate is available [here](https://github.com/phalcon/volt-sublime-textmate)
* [Album-O-Rama](https://album-o-rama.phalconphp.com) is a sample application using Volt as template engine, [Github](https://github.com/phalcon/album-o-rama)
* [Our website](https://phalconphp.com) is running using Volt as template engine, [Github](https://github.com/phalcon/website)
* [Phosphorum](https://forum.phalconphp.com), the Phalcon's forum, also uses Volt, [Github](https://github.com/phalcon/forum)
* [Vökuró](https://vokuro.phalconphp.com), is another sample application that use Volt, [Github](https://github.com/phalcon/vokuro)