<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Overview</a> <ul>
        <li>
          <a href="#introduction">Introduction</a>
        </li>
        <li>
          <a href="#setup">Activating Volt</a>
        </li>
        <li>
          <a href="#basic-usage">Basic Usage</a>
        </li>
        <li>
          <a href="#variables">Variables</a>
        </li>
        <li>
          <a href="#filters">Filters</a>
        </li>
        <li>
          <a href="#comments">Comments</a>
        </li>
        <li>
          <a href="#control-structures">List of Control Structures</a> <ul>
            <li>
              <a href="#control-structures-for">For</a>
            </li>
            <li>
              <a href="#control-structures-loops">Loop Controls</a>
            </li>
            <li>
              <a href="#control-structures-loop">Loop Context</a> <ul>
                <li>
                  <a href="#assignments">Assignments</a>
                </li>
                <li>
                  <a href="#expressions">Expressions</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#expressions-literals">Literals</a>
            </li>
            <li>
              <a href="#expressions-arrays">Arrays</a>
            </li>
            <li>
              <a href="#expressions-math">Math</a>
            </li>
            <li>
              <a href="#expressions-comparisons">Comparisons</a>
            </li>
            <li>
              <a href="#expressions-logic">Logic</a>
            </li>
            <li>
              <a href="#expressions-other-operators">Other Operators</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#tests">Tests</a>
        </li>
        <li>
          <a href="#macros">Macros</a>
        </li>
        <li>
          <a href="#tag-helpers">Using Tag Helpers</a>
        </li>
        <li>
          <a href="#functions">Functions</a>
        </li>
        <li>
          <a href="#view-integrations">View Integration</a> <ul>
            <li>
              <a href="#view-integration-include">Include</a>
            </li>
            <li>
              <a href="#view-integration-partial-vs-include">Partial vs Include</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#template-inheritance">Template Inheritance</a> <ul>
            <li>
              <a href="#template-inheritance-multiple">Multiple Inheritance</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#autoescape">Autoescape mode</a>
        </li>
        <li>
          <a href="#extending">Extending Volt</a> <ul>
            <li>
              <a href="#extending-functions">Functions</a>
            </li>
            <li>
              <a href="#extending-filters">Filters</a>
            </li>
            <li>
              <a href="#extending-extensions">Extensions</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#caching-view-fragments">Caching view fragments</a>
        </li>
        <li>
          <a href="#services-in-templates">Inject Services into a Template</a>
        </li>
        <li>
          <a href="#stand-alone">Stand-alone component</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Volt: Template Engine

Volt is an ultra-fast and designer friendly templating language written in C for PHP. It provides you a set of helpers to write views in an easy way. Volt is highly integrated with other components of Phalcon, just as you can use it as a stand-alone component in your applications.

![](/images/content/volt.jpg)

Volt is inspired by [Jinja](http://jinja.pocoo.org/), originally created by [Armin Ronacher](https://github.com/mitsuhiko). Therefore many developers will be in familiar territory using the same syntax they have been using with similar template engines. Volt's syntax and features have been enhanced with more elements and of course with the performance that developers have been accustomed to while working with Phalcon.

<a name='introduction'></a>

## Introduction

Volt views are compiled to pure PHP code, so basically they save the effort of writing PHP code manually:

```twig
{# app/views/products/show.volt #}

{% block last_products %}

{% for product in products %}
    * Name: {{ product.name|e }}
    {% if product.status === 'Active' %}
       Price: {{ product.price + product.taxes/100 }}
    {% endif  %}
{% endfor  %}

{% endblock %}
```

<a name='setup'></a>

## Activating Volt

As with other templating engines, you may register Volt in the view component, using a new extension or reusing the standard `.phtml`:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Register Volt as a service
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

// Register Volt as template engine
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

// Register Volt as template engine with an anonymous function
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

| Option              | Description                                                                                                                       | Default |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------- | ------- |
| `compiledPath`      | Доступный для записи путь, по которому будут размещены скомпилированные шаблоны PHP                                               | `./`    |
| `compiledExtension` | Дополнительное расширение добавляется к скомпилированному файлу PHP                                                               | `.php`  |
| `compiledSeparator` | Volt заменяет разделители каталогов / и \ by этот разделитель предназначен для создания одного файла в скомпилированном каталоге | `%%`    |
| `stat`              | Должен ли Phalcon проверять, существуют ли различия между файлом шаблона и его скомпилированным путем                             | `true`  |
| `compileAlways`     | Сообщите Volt, если шаблоны должны быть скомпилированы в каждом запросе или только при их изменении                               | `false` |
| `prefix`            | Allows to prepend a prefix to the templates in the compilation path                                                               | `null`  |
| `autoescape`        | Позволяет autoescape во всем мире в HTML                                                                                          | `false` |

The compilation path is generated according to the above options, if the developer wants total freedom defining the compilation path, an anonymous function can be used to generate it, this function receives the relative path to the template in the views directory. The following examples show how to change the compilation path dynamically:

```php
<?php

// Just append the .php extension to the template path
// leaving the compiled templates in the same directory
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            return $templatePath . '.php';
        }
    ]
);

// Recursively create the same structure in another directory
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            $dirName = dirname($templatePath);

            if (!is_dir('cache/' . $dirName)) {
                mkdir('cache/' . $dirName);
            }

            return 'cache/' . $dirName . '/'. $templatePath . '.php';
        }
    ]
);
```

<a name='basic-usage'></a>

## Basic Usage

A view consists of Volt code, PHP and HTML. A set of special delimiters is available to enter into Volt mode. `{% ... %}` is used to execute statements such as for-loops or assign values and `{{ ... }}`, prints the result of an expression to the template.

Below is a minimal template that illustrates a few basics:

```twig
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
```

Using `Phalcon\Mvc\View` you can pass variables from the controller to the views. In the above example, four variables were passed to the view: `show_navigation`, `menu`, `title` and `post`:

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

## Variables

Object variables may have attributes which can be accessed using the syntax: `foo.bar`. If you are passing arrays, you have to use the square bracket syntax: `foo['bar']`

```twig
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
```

<a name='filters'></a>

## Filters

Variables can be formatted or modified using filters. The pipe operator `|` is used to apply filters to variables:

```twig
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
```

The following is the list of available built-in filters in Volt:

| Filter             | Description                                                                                                                        |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Applies the [abs](http://php.net/manual/en/function.abs.php) PHP function to a value.                                              |
| `capitalize`       | Capitalizes a string by applying the [ucwords](http://php.net/manual/en/function.ucwords.php) PHP function to the value            |
| `convert_encoding` | Converts a string from one charset to another                                                                                      |
| `default`          | Sets a default value in case that the evaluated expression is empty (is not set or evaluates to a falsy value)                     |
| `e`                | Applies `Phalcon\Escaper->escapeHtml()` to the value                                                                           |
| `escape`           | Applies `Phalcon\Escaper->escapeHtml()` to the value                                                                           |
| `escape_attr`      | Applies `Phalcon\Escaper->escapeHtmlAttr()` to the value                                                                       |
| `escape_css`       | Applies `Phalcon\Escaper->escapeCss()` to the value                                                                            |
| `escape_js`        | Applies `Phalcon\Escaper->escapeJs()` to the value                                                                             |
| `format`           | Formats a string using [sprintf](http://php.net/manual/en/function.sprintf.php).                                                   |
| `json_encode`      | Converts a value into its [JSON](http://php.net/manual/en/function.json-encode.php) representation                                 |
| `json_decode`      | Converts a value from its [JSON](http://php.net/manual/en/function.json-encode.php) representation to a PHP representation         |
| `join`             | Joins the array parts using a separator [join](http://php.net/manual/en/function.join.php)                                         |
| `keys`             | Returns the array keys using [array_keys](http://php.net/manual/en/function.array-keys.php)                                        |
| `left_trim`        | Applies the [ltrim](http://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                  |
| `length`           | Counts the string length or how many items are in an array or object                                                               |
| `lower`            | Change the case of a string to lowercase                                                                                           |
| `nl2br`            | Changes newlines `\n` by line breaks (`<br />`). Uses the PHP function [nl2br](http://php.net/manual/en/function.nl2br.php) |
| `right_trim`       | Applies the [rtrim](http://php.net/manual/en/function.rtrim.php) PHP function to the value. Removing extra spaces                  |
| `разрезы`          | Применяет [косых](http://php.net/manual/en/function.slashes.php) функция PHP значение. Экранирование значений                      |
| `род`              | Сортировка массива с помощью функции PHP [asort](http://php.net/manual/en/function.asort.php)                                      |
| `stripslashes`     | Применяет [stripslashes](http://php.net/manual/en/function.stripslashes.php) функция PHP значение. Удаление экранированных кавычек |
| `striptags`        | Применяет [striptags](http://php.net/manual/en/function.striptags.php) функция PHP значение. Удаление тегов HTML                   |
| `отделка`          | Применяет функцию [trim](http://php.net/manual/en/function.trim.php) PHP к значению. Удаление лишних пробелов                      |
| `верхний`          | Измените регистр строки на верхний регистр                                                                                         |
| `url_encode`       | Применяет [функция urlencode](http://php.net/manual/en/function.urlencode.php) функция PHP значение                                |

Examples:

```twig
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
```

<a name='comments'></a>

## Comments

Comments may also be added to a template using the `{# ... #}` delimiters. All text inside them is just ignored in the final output:

```twig
{# note: this is a comment
    {% set price = 100; %}
#}
```

<a name='control-structures'></a>

## List of Control Structures

Volt provides a set of basic but powerful control structures for use in templates:

<a name='control-structures-for'></a>

### For

Loop over each item in a sequence. The following example shows how to traverse a set of 'robots' and print his/her name:

```twig
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        <li>
            {{ robot.name|e }}
        </li>
    {% endfor %}
</ul>
```

for-loops can also be nested:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    {% for part in robot.parts %}
        Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
    {% endfor %}
{% endfor %}
```

You can get the element `keys` as in the PHP counterpart using the following syntax:

```twig
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
```

An `if` evaluation can be optionally set:

```twig
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for value in numbers if value < 2 %}
    Value: {{ value }}
{% endfor %}

{% for name, value in numbers if name !== 'two' %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
```

If an `else` is defined inside the `for`, it will be executed if the expression in the iterator result in zero iterations:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% else %}
    There are no robots to show
{% endfor %}
```

Alternative syntax:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% elsefor %}
    There are no robots to show
{% endfor %}
```

<a name='control-structures-loops'></a>

### Loop Controls

The `break` and `continue` statements can be used to exit from a loop or force an iteration in the current block:

```twig
{# skip the even robots #}
{% for index, robot in robots %}
    {% if index is even %}
        {% continue %}
    {% endif %}
    ...
{% endfor %}
```

```twig
{# exit the foreach on the first even robot #}
{% for index, robot in robots %}
    {% if index is even %}
        {% break %}
    {% endif %}
    ...
{% endfor %}
```

<a name='control-structures-if'></a>

### If

As PHP, an `if` statement checks if an expression is evaluated as true or false:

```twig
<h1>Cyborg Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% endif %}
    {% endfor %}
</ul>
```

The else clause is also supported:

```twig
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
```

The `elseif` control flow structure can be used together with if to emulate a `switch` block:

```twig
{% if robot.type === 'cyborg' %}
    Robot is a cyborg
{% elseif robot.type === 'virtual' %}
    Robot is virtual
{% elseif robot.type === 'mechanical' %}
    Robot is mechanical
{% endif %}
```

<a name='control-structures-loop'></a>

### Loop Context

Специальная переменная доступна внутри `для` петли предоставления информации о

| Variable         | Description                                                   |
| ---------------- | ------------------------------------------------------------- |
| `loop.index`     | The current iteration of the loop. (1 indexed)                |
| `loop.index0`    | The current iteration of the loop. (0 indexed)                |
| `loop.revindex`  | The number of iterations from the end of the loop (1 indexed) |
| `loop.revindex0` | The number of iterations from the end of the loop (0 indexed) |
| `loop.first`     | True if in the first iteration.                               |
| `loop.last`      | True if in the last iteration.                                |
| `loop.length`    | The number of items to iterate                                |

Образец:

```twig
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
```

<a name='assignments'></a>

## Assignments

Переменные могут быть изменены в шаблоне с помощью инструкции 'set':

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set name = robot.name %}
```

Несколько назначений разрешены в одной инструкции:

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
```

Кроме того, можно использовать составные операторы присваивания:

```twig
{% set price += 100.00 %}

{% set age *= 5 %}
```

Доступны следующие операторы:

| Operator | Description               |
| -------- | ------------------------- |
| `=`      | Standard Assignment       |
| `+=`     | Addition assignment       |
| `-=`     | Subtraction assignment    |
| `\*=`  | Multiplication assignment |
| `/=`     | Division assignment       |

<a name='expressions'></a>

## Expressions

Вольт обеспечивает основной набор поддержки выражения, включая литералы и общие операторы. Выражение можно вычислить и распечатать с помощью ` {</0 > и <code>}}` разделители:

```twig
{{ (1 + 1) * 2 }}
```

Если выражение должно оцениваться не будут напечатаны в `а` инструкция может быть использована:

```twig
{% do (1 + 1) * 2 %}
```

<a name='expressions-literals'></a>

### Literals

Поддерживаются следующие литералы:

| Filter               | Description                                                        |
| -------------------- | ------------------------------------------------------------------ |
| `'this is a string'` | Text between double quotes or single quotes are handled as strings |
| `100.25`             | Numbers with a decimal part are handled as doubles/floats          |
| `100`                | Numbers without a decimal part are handled as integers             |
| `false`              | Constant 'false' is the boolean false value                        |
| `true`               | Constant 'true' is the boolean true value                          |
| `null`               | Constant 'null' is the Null value                                  |

<a name='expressions-arrays'></a>

### Arrays

Если вы используете PHP 5.3 или >= 5.4, вы можете создать массивы, заключив список значений в квадратные скобки:

```twig
{# Simple array #}
{{ ['Apple', 'Banana', 'Orange'] }}

{# Other simple array #}
{{ ['Apple', 1, 2.5, false, null] }}

{# Multi-Dimensional array #}
{{ [[1, 2], [3, 4], [5, 6]] }}

{# Hash-style array #}
{{ ['first': 1, 'second': 4/2, 'third': '3'] }}
```

Фигурные скобки также можно использовать для определения массивов или хэшей:

```twig
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
```

<a name='expressions-math'></a>

### Math

Вычисления в шаблонах можно выполнять с помощью следующих операторов:

| Operator | Description                                                             |
|:--------:| ----------------------------------------------------------------------- |
|   `+`    | Perform an adding operation. `{{ 2 + 3 }}` returns 5                    |
|   `-`    | Perform a substraction operation `{{ 2 - 3 }}` returns -1               |
|   `*`    | Perform a multiplication operation `{{ 2 * 3 }}` returns 6              |
|   `/`    | Perform a division operation `{{ 10 / 2 }}` returns 5                   |
|   `%`    | Calculate the remainder of an integer division `{{ 10 % 3 }}` returns 1 |

<a name='expressions-comparisons'></a>

### Comparisons

Доступны следующие операторы сравнения:

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

<a name='expressions-logic'></a>

### Logic

Логические операторы являются полезными в `if` оценка выражений для объединения нескольких тестов:

|  Operator  | Description                                                       |
|:----------:| ----------------------------------------------------------------- |
|    `or`    | Return true if the left or right operand is evaluated as true     |
|   `and`    | Return true if both left and right operands are evaluated as true |
|   `not`    | Negates an expression                                             |
| `( expr )` | Parenthesis groups expressions                                    |

<a name='expressions-other-operators'></a>

### Other Operators

Дополнительные операторы доступны следующие операторы:

| Operator          | Description                                                                     |
| ----------------- | ------------------------------------------------------------------------------- |
| `~`               | Concatenates both operands `{{ 'hello ' ~ 'world' }}`                           |
| `|`               | Applies a filter in the right operand to the left `{{ 'hello'|uppercase }}`     |
| `..`              | Creates a range `{{ 'a'..'z' }}` `{{ 1..10 }}`                                  |
| `is`              | Same as == (equals), also performs tests                                        |
| `in`              | To check if an expression is contained into other expressions `if 'a' in 'abc'` |
| `is not`          | Same as != (not equals)                                                         |
| `'a' ? 'b' : 'c'` | Ternary operator. The same as the PHP ternary operator                          |
| `++`              | Increments a value                                                              |
| `--`              | Decrements a value                                                              |

В следующем примере показано использование операторов:

```twig
{% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

{% for index in 0..robots|length %}
    {% if robots[index] is defined %}
        {{ 'Name: ' ~ robots[index] }}
    {% endif %}
{% endfor %}
```

<a name='tests'></a>

## Tests

Тесты можно использовать для проверки, если переменная имеет допустимое ожидаемое значение. Оператор `is`. используется для выполнения тестов:

```twig
{% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

{% for position, name in robots %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}
```

Следующие встроенные тесты доступны в Вольте:

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

Еще много примеров:

```twig
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
```

<a name='macros'></a>

## Macros

Макросы могут использоваться для повторного использования логики в шаблоне, они действуют как функции PHP, могут получать параметры и возвращать значения:

```twig
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
```

При вызове макросов параметры могут передаваться по имени:

```twig
{%- macro error_messages(message, field, type) %}
    <div>
        <span class='error-type'>{{ type }}</span>
        <span class='error-field'>{{ field }}</span>
        <span class='error-message'>{{ message }}</span>
    </div>
{%- endmacro %}

{# Call the macro #}
{{ error_messages('type': 'Invalid', 'message': 'The name is invalid', 'field': 'name') }}
```

Макросы могут возвращать значения:

```twig
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

И получите опционные параметры:

```twig
{%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

<a name='tag-helpers'></a>

## Using Tag Helpers

Volt is highly integrated with `Phalcon\Tag`, so it's easy to use the helpers provided by that component in a Volt template:

```twig
{{ javascript_include('js/jquery.js') }}

{{ form('products/save', 'method': 'post') }}

    <label for='name'>Name</label>
    {{ text_field('name', 'size': 32) }}

    <label for='type'>Type</label>
    {{ select('type', productTypes, 'using': ['id', 'name']) }}

    {{ submit_button('Send') }}

{{ end_form() }}
```

Генерируется следующий PHP:

```php
<?php echo Phalcon\Tag::javascriptInclude('js/jquery.js') ?>

<?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

    <label for='name'>Name</label>
    <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

    <label for='type'>Type</label>
    <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

    <?php echo Phalcon\Tag::submitButton('Send'); ?>

{{ end_form() }}
```

Для вызова `Phalcon\Tag` помощника, вам нужно только позвонить версии uncamelized метода:

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

<a name='functions'></a>

## Functions

Следующие встроенные функции доступны в Вольте:

| Name          | Description                                                 |
| ------------- | ----------------------------------------------------------- |
| `content`     | Includes the content produced in a previous rendering stage |
| `get_content` | Same as `content`                                           |
| `partial`     | Dynamically loads a partial view in the current template    |
| `super`       | Render the contents of the parent block                     |
| `time`        | Calls the PHP function with the same name                   |
| `date`        | Calls the PHP function with the same name                   |
| `dump`        | Calls the PHP function `var_dump()`                         |
| `version`     | Returns the current version of the framework                |
| `constant`    | Reads a PHP constant                                        |
| `url`         | Generate a URL using the 'url' service                      |

<a name='view-integrations'></a>

## View Integration

Также, Вольт интегрирован с `Phalcon\Mvc\View`, Вы также можете играть с иерархией представлений и включать частичные элементы:

```twig
{{ content() }}

<!-- Simple include of a partial -->
<div id='footer'>{{ partial('partials/footer') }}</div>

<!-- Passing extra variables -->
<div id='footer'>{{ partial('partials/footer', ['links': links]) }}</div>
```

Частичное включается во время выполнения, Вольт также обеспечивает `include`, это компилирует содержимое представления и возвращает его содержимое как часть представления, которое было включено:

```twig
{# Simple include of a partial #}
<div id='footer'>
    {% include 'partials/footer' %}
</div>

{# Passing extra variables #}
<div id='footer'>
    {% include 'partials/footer' with ['links': links] %}
</div>
```

<a name='view-integration-include'></a>

### Include

`include` имеет особое поведение, которое поможет нам улучшить производительность немного при использовании Вольт, если вы укажите расширение файла, когда в том числе и он существует, когда шаблон компилируется, Вольт может встроить содержимое шаблона в родительском шаблоне, где он включен. Шаблоны не встроены, если`include` переменные, переданные с `with`:

```twig
{# The contents of 'partials/footer.volt' is compiled and inlined #}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
```

<a name='view-integration-partial-vs-include'></a>

### Partial vs Include

Держите следующие моменты в виду при выборе, чтобы использовать `partial` функция или `include`:

- `partial` позволяет Вам включить шаблоны сделанные в Вольте и в других двигателях шаблона также
- `partial` позволяет передавать выражение как переменную, позволяющую динамически включать содержимое другого представления
- `partial` лучше, если Контент, который вы должны часто включать изменения

- `include` копирует скомпилированное содержимое в представление, что повышает производительность

- `include` только позволяет включать шаблоны, сделанные с Вольт
- `include` требуется существующий шаблон во время компиляции

<a name='template-inheritance'></a>

## Template Inheritance

С помощью наследования шаблонов вы можете создавать базовые шаблоны, которые могут быть расширены другими шаблонами, позволяющими повторно использовать код. Базовый шаблон определить *blocks* чем может быть переопределено дочерним шаблоном. Давайте представим, что у нас есть следующий базовый шаблон:

```twig
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
```

От другого шаблона мы смогли расширить низкопробный шаблон заменяя блоки:

```twig
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style type='text/css'>.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class='important'>Welcome on my awesome homepage.</p>
{% endblock %}
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

### Multiple Inheritance

Расширенные шаблоны могут расширять другие шаблоны. Следующий пример иллюстрирует это:

```twig
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
```

Template `layout.volt` extends `main.volt`

```twig
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
```

Finally a view that extends `layout.volt`:

```twig
{# index.volt #}
{% extends 'layout.volt' %}

{% block content %}

    {{ super() }}

    <ul>
        <li>Some option</li>
        <li>Some other option</li>
    </ul>

{% endblock %}
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

Note the call to the function `super()`. С помощью этой функции можно отобразить содержимое родительского блока. Как частичными, путь значение `extends` является относительным путем под видом текущего каталога (т. е. `app/views/`).

<h5 class='alert alert-warning'>По умолчанию, и, исходя из соображений производительности, Вольт только для проверки изменений в детей шаблоны, чтобы знать, когда, чтобы перекомпилировать на обычном PHP снова, поэтому рекомендуется инициализировать Вольт вариант <code>'compileAlways' =&gt; true</code>. Таким образом, шаблоны компилируются всегда с учетом изменений в родительских шаблонах. </h5>

<a name='autoescape'></a>

## Autoescape mode

Можно включить автоматическое экранирование всех переменных, напечатанных в блоке, в режиме автоэскейпа:

```twig
Manually escaped: {{ robot.name|e }}

{% autoescape true %}
    Autoescaped: {{ robot.name }}
    {% autoescape false %}
        No Autoescaped: {{ robot.name }}
    {% endautoescape %}
{% endautoescape %}
```

<a name='extending'></a>

## Extending Volt

В отличие от других шаблонов двигателей, сам Volt не требуется для запуска скомпилированных шаблонов. После того, как шаблоны составляются нет зависимости от Вольта. Имея в виду независимость от производительности, Volt действует только как компилятор для шаблонов PHP.

Компилятор Volt позволяет расширить его, добавляя больше функций, тестов или фильтров к существующим.

<a name='extending-functions'></a>

### Functions

Функции действуют как обычные функции PHP, в качестве имени функции требуется допустимое имя строки. Функции можно добавлять с помощью двух стратегий, возвращая простую строку или используя анонимную функцию. Всегда требуется, чтобы выбранная стратегия возвращала допустимое строковое выражение PHP:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// This binds the function name 'shuffle' in Volt to the PHP function 'str_shuffle'
$compiler->addFunction('shuffle', 'str_shuffle');
```

Зарегистрируйте функцию с анонимной функцией. Этот случай мы используем `$resolvedArgs` передавать аргументы точно так, как они были переданы в аргументах:

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

Рассматривайте аргументы независимо и неразрешенно:

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

Создание кода на основе доступности некоторых функций:

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

Встроенные функции можно переопределить, добавив функцию с именем:

```php
<?php

// Replace built-in function dump
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### Filters

Фильтр имеет следующий вид шаблон: leftExpr|название(по желанию-аргументы). Добавление новых фильтров аналогично тому, как показано в функциях:

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

Встроенные фильтры можно переопределить, добавив функцию с ее именем:

```php
<?php

// Replace built-in filter 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### Extensions

С расширениями Разработчик имеет больше гибкости, чтобы расширить механизм шаблонов и переопределить компиляцию конкретной инструкции, изменить поведение выражения или оператора, добавить функции/фильтры с лишним.

Расширение-это класс, реализующий события, вызванные Volt, как метод сам по себе. Например, класс ниже позволяет использовать любую функцию PHP в Volt:

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

Приведенный выше класс реализует метод `compileFunction` который вызывается перед любой попыткой компиляции вызова функции в любом шаблоне. The purpose of the extension is to verify if a function to be compiled is a PHP function allowing to call it from the template. Events in extensions must return valid PHP code, this will be used as result of the compilation instead of the one generated by Volt. If an event doesn't return an string the compilation is done using the default behavior provided by the engine.

The following compilation events are available to be implemented in extensions:

| Event/Method        | Description                                                                                            |
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

## Caching view fragments

With Volt it's easy cache view fragments. This caching improves performance preventing that the contents of a block from being executed by PHP each time the view is displayed:

```twig
{% cache 'sidebar' %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
```

Setting a specific number of seconds:

```twig
{# cache the sidebar by 1 hour #}
{% cache 'sidebar' 3600 %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
```

Any valid expression can be used as cache key:

```twig
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
```

The caching is done by the `Phalcon\Cache` component via the view component. Learn more about how this integration works in the section [Caching View Fragments](/[[language]]/[[version]]/views#caching-fragments).

<a name='services-in-templates'></a>

## Inject Services into a Template

Если для Volt доступен сервисный контейнер (DI), вы можете использовать службы, только обратившись к имени службы в шаблоне:

```twig
{# Inject the 'flash' service #}
<div id='messages'>{{ flash.output() }}</div>

{# Inject the 'security' service #}
<input type='hidden' name='token' value='{{ security.getToken() }}'>
```

<a name='stand-alone'></a>

## Stand-alone component

Использование Вольта в автономном режиме может быть продемонстрировано ниже:

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

## External Resources

- Пакет для sublime/текст. Сообщ доступен [здесь](https://github.com/phalcon/volt-sublime-textmate)
- [Album-O-Rama](https://album-o-rama.phalconphp.com) представляет собой образец приложения с использованием Вольт в качестве шаблона двигателя, [Github](https://github.com/phalcon/album-o-rama)
- [наш сайт](https://phalconphp.com) работает с использованием Вольт в качестве шаблона двигателя, [Github](https://github.com/phalcon/website)
- [Phosphorum](https://forum.phalconphp.com), форум Phalcon, также использует Volt, [Github](https://github.com/phalcon/forum)
- [Vökuró](https://vokuro.phalconphp.com), еще один пример приложения, которые используют Вольт, [Github](https://github.com/phalcon/vokuro)