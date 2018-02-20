<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang tanaw">Pangkalahatang tanaw</a> <ul>
        <li>
          <a href="#pagpapakilala">Pagpapakilala</a>
        </li>
        <li>
          <a href="#pagkakalagay">Pagpapagana ng Volt</a>
        </li>
        <li>
          <a href="#pangkaraniwang-paggamit">Pangkaraniwang Paggamit</a>
        </li>
        <li>
          <a href="#mga variable">Mga Variable</a>
        </li>
        <li>
          <a href="#mga sumasala">Mga Sumasala</a>
        </li>
        <li>
          <a href="#mga komento">Mga Komento</a>
        </li>
        <li>
          <a href="#control-mga istraktura">Lisatahan ng mga Istrakturang Kinokontrol</a> <ul>
            <li>
              <a href="#control-mga istraktura para">Para</a>
            </li>
            <li>
              <a href="#control-mga istraktura-mga loop">Kontrol ng Loop</a>
            </li>
            <li>
              <a href="#control-mga istraktura-loop">Laman ng Loop</a> <ul>
                <li>
                  <a href="#mga takdang aralin">Mga Takdang Aralin</a>
                </li>
                <li>
                  <a href="#expressions">Mga Ekspresyon</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#expressions-literals">Mga Literal</a>
            </li>
            <li>
              <a href="#expressions-arrays">Mga Array</a>
            </li>
            <li>
              <a href="#expressions-math">Matematika</a>
            </li>
            <li>
              <a href="#expressions-comparisons">Paghahambing</a>
            </li>
            <li>
              <a href="#expressions-logic">Lohika</a>
            </li>
            <li>
              <a href="#expressions-other-operators">Ibang mga Operator</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#tests">Mga Pagsusulit</a>
        </li>
        <li>
          <a href="#macros">Macros</a>
        </li>
        <li>
          <a href="#tag-helpers">Paggamit ng mga Tumutulong na Tag</a>
        </li>
        <li>
          <a href="#functions">Mga Gamit</a>
        </li>
        <li>
          <a href="#view-integrations">Tingnan ang Pagsasama</a> <ul>
            <li>
              <a href="#view-integration-include">Isama</a>
            </li>
            <li>
              <a href="#view-integration-partial-vs-include">Kalahati kumpara sa Isama</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#template-inheritance">Pagmana ng Template</a> <ul>
            <li>
              <a href="#template-inheritance-multiple">Maramihang Pagmana</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#autoescape">Awtomatikong Pagalabas na mode</a>
        </li>
        <li>
          <a href="#extending">Pagpapalawig ng Volt</a> <ul>
            <li>
              <a href="#extending-functions">Mga Gamit</a>
            </li>
            <li>
              <a href="#extending-filters">Mga Sumasala</a>
            </li>
            <li>
              <a href="#extending-extensions">Mga extensyon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#caching-view-fragments">Pag-cache ng tinignan na mga fragment</a>
        </li>
        <li>
          <a href="#services-in-templates">Pagturok ng mga Serbisyo sa isang Template</a>
        </li>
        <li>
          <a href="#stand-alone">Mag-isang bahagi</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Volt: Makina ng Template

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

| Option                 | Description                                                                                                                               | Default |
| ---------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- | ------- |
| `naipongLangdas`       | Isang masusulatang muli na landas kung saan ang naipong mga template ng PHP ay malalagyan                                                 | `./`    |
| `naipongmgaKaugnay`    | Isang nadagdag na extension ang idadagdag sa naipong file ng PHP                                                                          | `.php`  |
| `naipongHumihiwalay`   | Ang Volt ay pumapalit sa direktorya ng humihiwalay \ at / sa humihiwalay na ito upang ito ay makagwa ng isang file sa naipong direktorya | `%%`    |
| `istat`                | Kung ang Phalcon ay dapat na sumuri kung may umiiral na pagkakaiba sa pagitan ng file ng template at sa naipong landas                    | `true`  |
| `naipongPalagi`        | Sabihan ang Volt kung ang mga template ay dapat na naipon sa isang hiling o kung may babagohin sila                                       | `false` |
| `prefix`               | Allows to prepend a prefix to the templates in the compilation path                                                                       | `null`  |
| `awtomatikongpaglabas` | Paganahin ang panmundong awtomatikongpgalabas ng HTML                                                                                     | `false` |

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

| Filter             | Description                                                                                                                                            |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `abs`              | Applies the [abs](http://php.net/manual/en/function.abs.php) PHP function to a value.                                                                  |
| `capitalize`       | Capitalizes a string by applying the [ucwords](http://php.net/manual/en/function.ucwords.php) PHP function to the value                                |
| `convert_encoding` | Converts a string from one charset to another                                                                                                          |
| `default`          | Sets a default value in case that the evaluated expression is empty (is not set or evaluates to a falsy value)                                         |
| `e`                | Applies `Phalcon\Escaper->escapeHtml()` to the value                                                                                               |
| `escape`           | Applies `Phalcon\Escaper->escapeHtml()` to the value                                                                                               |
| `escape_attr`      | Applies `Phalcon\Escaper->escapeHtmlAttr()` to the value                                                                                           |
| `escape_css`       | Applies `Phalcon\Escaper->escapeCss()` to the value                                                                                                |
| `escape_js`        | Applies `Phalcon\Escaper->escapeJs()` to the value                                                                                                 |
| `format`           | Formats a string using [sprintf](http://php.net/manual/en/function.sprintf.php).                                                                       |
| `json_encode`      | Converts a value into its [JSON](http://php.net/manual/en/function.json-encode.php) representation                                                     |
| `json_decode`      | Converts a value from its [JSON](http://php.net/manual/en/function.json-encode.php) representation to a PHP representation                             |
| `join`             | Joins the array parts using a separator [join](http://php.net/manual/en/function.join.php)                                                             |
| `keys`             | Returns the array keys using [array_keys](http://php.net/manual/en/function.array-keys.php)                                                            |
| `left_trim`        | Applies the [ltrim](http://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                                      |
| `length`           | Counts the string length or how many items are in an array or object                                                                                   |
| `lower`            | Change the case of a string to lowercase                                                                                                               |
| `nl2br`            | Changes newlines `\n` by line breaks (`<br />`). Uses the PHP function [nl2br](http://php.net/manual/en/function.nl2br.php)                     |
| `right_trim`       | Applies the [rtrim](http://php.net/manual/en/function.rtrim.php) PHP function to the value. Removing extra spaces                                      |
| `mga slash`        | Magagamit ang [slashes](http://php.net/manual/en/function.slashes.php) na katangian ng PHP sa halaga. Ang mga nakakwalang mga halaga                   |
| `uriin`            | Uriin ang array gamit ang katangian ng PHP [asort](http://php.net/manual/en/function.asort.php)                                                        |
| `stripslashes`     | Magagamit ang [stripslashes](http://php.net/manual/en/function.stripslashes.php) na katangian ng PHP sa halaga. Tanggalin ang mga nakawalang mga quote |
| `striptags`        | Magagamit ang [striptags](http://php.net/manual/en/function.striptags.php) na katangian ng PHP sa halaga. Tanggalin ang mga tag ng HTML                |
| `pantay`           | Magagamit ang [pantay](http://php.net/manual/en/function.trim.php) na katangian ng PHP sa halaga. Tanggalin ang mga sobrang mga puwang                 |
| `taas`             | Baguhin ang kaso ng isang string sa malaking letra                                                                                                     |
| `url_encode`       | Magagamit ang [urlencode](http://php.net/manual/en/function.urlencode.php) sa katangian ng PHP sa halaga                                               |

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

Isang espesyal na variable ang magagamit sa loob ng `for` na mga loop na nagbibigay sa iyo nga mga impormasyon tungkol sa

| Variable         | Description                                                   |
| ---------------- | ------------------------------------------------------------- |
| `loop.index`     | The current iteration of the loop. (1 indexed)                |
| `loop.index0`    | The current iteration of the loop. (0 indexed)                |
| `loop.revindex`  | The number of iterations from the end of the loop (1 indexed) |
| `loop.revindex0` | The number of iterations from the end of the loop (0 indexed) |
| `loop.first`     | True if in the first iteration.                               |
| `loop.last`      | True if in the last iteration.                                |
| `loop.length`    | The number of items to iterate                                |

Halimbawa:

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

Ang mga variable ay maaring baguhin sa isang template gamit ang isang 'itinakdang' pagtuturo:

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set name = robot.name %}
```

Ang maraming mga takdang aralin ay hindi pinapayagansa parehong pagtuturo:

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
```

Sa karagdagan, pwede kang gumamit ng magakatambal na tagatalaga ng mga tagagawa:

```twig
{% set price += 100.00 %}

{% set age *= 5 %}
```

Ang mga sumusunod na mga tagagawa ay pwedeng magamit:

| Operator | Description               |
| -------- | ------------------------- |
| `=`      | Standard Assignment       |
| `+=`     | Addition assignment       |
| `-=`     | Subtraction assignment    |
| `\*=`  | Multiplication assignment |
| `/=`     | Division assignment       |

<a name='expressions'></a>

## Expressions

Ang Volt ay nagbibigay ng pangunahing set ng ekspresyon na susuporta, kabilang ang mga literal at karaniwang mga operator. Ang isang ekspresyon ay maaaring masuri at mai-print gamit ang `{{` and `}}` na mga delimiter:

```twig
{{ (1 + 1) * 2 }}
```

Kung ang isang ekspresyon ay kailanagang suriin ng hindi na print `do` na pahayag ang pwedeng gamitin:

```twig
{% do (1 + 1) * 2 %}
```

<a name='expressions-literals'></a>

### Literals

Ang mga sumusunod na mga literal ay suportado:

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

Kung ang iyong ginagamit na PHP ay 5.3 o mas mataas pa sa 5.4. Ikaw ay pwedeng gumawa ng mga array sa pagitan ng pagsarado sa isang listahan ng mga halaga sa isang kwadradong mga bracket:

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

Ang mga liko-liko na mga brace ay pwedeng gamitin para bigyang kahulugan ang mga array o mga hash:

```twig
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
```

<a name='expressions-math'></a>

### Math

Ikaw ay pwedeng gumawa ng mga kalkulasyon sa mga template gamit ang mga sumusunod na tagagawa:

| Operator | Description                                                             |
|:--------:| ----------------------------------------------------------------------- |
|   `+`    | Perform an adding operation. `{{ 2 + 3 }}` returns 5                    |
|   `-`    | Perform a substraction operation `{{ 2 - 3 }}` returns -1               |
|   `*`    | Perform a multiplication operation `{{ 2 * 3 }}` returns 6              |
|   `/`    | Perform a division operation `{{ 10 / 2 }}` returns 5                   |
|   `%`    | Calculate the remainder of an integer division `{{ 10 % 3 }}` returns 1 |

<a name='expressions-comparisons'></a>

### Comparisons

Ang mg sumusunod na pagkokompara na tagagawa ay pwede na magamit:

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

Ang mga logic na mga taga-operate ay mapapakinabangan sa `if` na ekspresyon ng pagsuri ng pagsamahin ang mga maraming pagsusuri:

|  Operator  | Description                                                       |
|:----------:| ----------------------------------------------------------------- |
|    `or`    | Return true if the left or right operand is evaluated as true     |
|   `and`    | Return true if both left and right operands are evaluated as true |
|   `not`    | Negates an expression                                             |
| `( expr )` | Parenthesis groups expressions                                    |

<a name='expressions-other-operators'></a>

### Other Operators

Ang mga karagdagang mga operator ay makikita sa mga sumusunod ay magagamit na:

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

Ang mga sumusunod na halimbawa ay nagpapakita ng kung paano gamitin ang mga operator:

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

Ang mga pagsusuri ay pwedeng gamitin kung ang isang variable ay mayroong balidong halaga. Ang operator `is` ay ginagamit upang magsawa ng mga pagsusuri:

```twig
{% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

{% for position, name in robots %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}
```

Ang mga sumusunod na nakasamang mga pagsusuri ay pwede ng magagamit sa Volt:

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

Mas marami pang mga halimbawa:

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

Ang mga macros ay pwedeng magamit muli sa lohika sa isang template, sila ay gumaganap na katangian ng PHP, sila ay tumatanggap ng mga parameter at bumabalik na mga halaga:

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

<div>Ito ay ang laman</div>

{# Print related links again #}
{{ related_bar(links) }}
```

Kapag tumatawg ng mga macro, ang mga parameter ay pwedeng ipasa sa pamamgitan ng pangalan:

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

Ang mga macro ay pwedeng magbalik ng mga halaga:

```twig
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

At tumanggap ng mga pagpipiliang mga parameter:

```twig
%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

<a name='tag-helpers'></a>

## Using Tag Helpers

Ang Volt ay may mataas na integridad kasama ang `Phalcon\Tag`, kaya madaling gamitin ang mga katulong na binigay ng bahagi sa isang template ng Volt:

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

Ang mga sumusunod na mga PHP ang nagawa:

```php
<label for='name'>Name</label>
    <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

    <label for='type'>Type</label>
    <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

    <?php echo Phalcon\Tag::submitButton('Send'); ?>

{{ end_form() }}
```

Upang tumuwag ng isang `Phalcon\Tag` na katulong, pwede kang tumawag lang na isang hindi pa camilized na bersyon ng paraan ng pagtawag:

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

Ang mga sumusunod na mga kasamang katangian ay pwede na magamit sa Volt:

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

Ang Volt din ay isinama sa `Phalcon\Mvc\View`, ikaw ay pwedeng maglaro kasama ang pinamanag tanawin at isama din ang mga partial:

```twig
{{ content() }}

<!-- Simple include of a partial -->
<div id='footer'>{{ partial('partials/footer') }}</div>

<!-- Passing extra variables -->
<div id='footer'>{{ partial('partials/footer', ['links': links]) }}</div>
 
Context | Request Context
```

Isang partial ay kasama sa pagtakbo ng oras, ang Volt ay nagbibigay din `include`, ito ay nagiipon sa mga laman ng isang tanawin at bumabalik sa laman bilang isang parte ng isang tanawin na nakasama:

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

Ang `include` ay may espesyal na pag-uugali na tutulong sa para mapabuti ang pagganap na maliit kapag gumagamit ng Volt, kung gusto mong tukuyin ang extensyon kapag isinasama ang file at ito ay umiiral kapag ang template ay naipon, ang Volt ay pwedeng magsalinya nga mga laman nga template sa isang magulang na template kung saan ito ay masasama. Ang mga template ay hindi nakalinya kung ang `include` ay mayroong mga variable na napasa kasama ang `with`:

```twig
{# The contents of 'partials/footer.volt' is compiled and inlined #}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
```

<a name='view-integration-partial-vs-include'></a>

### Partial vs Include

Panatilihin ang mga sumusunod na mga punto sa isip kapag pumipili ng gagamiting `partial` gamit o `include`:

- `partial` na nagpaphintulot sa iyo upang isama ang mga template na ginawa sa Volt at sa ibang mga makina ng template din
- `partial` nagpapahintulot sa iyo na magpasa ng isang ekspresyon kagaya ng isang variable na nagpaphintulot na isama ang laman ng ibang tanaw ng masigla
- `partial` ay mas mabuti kung ang laman na iyong isinama sa pagbabago ng madalas

- `includes` mga kopya na naipon na laman sa tanawin na nagpapabuti sa pagganap

- `include` ay nagpaphintulot na isama ang mga template na ginawa sa Volt
- `include` ay nangangailangan ng umiiral na template at naipong oras

<a name='template-inheritance'></a>

## Template Inheritance

Sa pagmana ng template ikaw ay pwedeng gumawa ng basihan na template na pwedeng pahabain na ibang mga template na nagpapahintulot na gamiting muli ang code. Ang basihan na template na tutukuyin *blocks* na pwedeng ma-override ng isang batang template. Tayo ay magpanggap na tayo ay mayroong mga sumusunod na basihan na template:

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

Galing sa ibang template pwede tayong magextend na basihan na template na nagpapalit sa mga bloke:

```twig
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style type='text/css'>.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class='important'>Welcome on my awesome homepage.</p>
{% endblock %}
```

Hindi lahat ng mga bloke ay kailangang palitan ng isang batang template, iyong lamang mga kailangan. Ang huling mga output na ginawa ang mga sumusunod:

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

Ang mga pinahabang template ay pwedeng pahabain ng ibang mga template. Ang mga sumusunod na halimbawa na nagpapakita nito:

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

Sa wakas may tanawin na nag-eextend `layout.volt`:

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

Pagrender `index.volt` na gumagawa:

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

Tandaan ang pagtawag ng gamit `super()`. Kasama ang gamit pwedeng ma render ang mga laman ng magulang na bloke. Bilang mga bahagyan, ang landas ay nakaset sa `extends`na isang kamag-anak sa ilalim ng kasalukuyang direktorya (i.e. `app/views/`).

<h5 class='alert alert-warning'>Sa default, at sa rason ng pagganap, ang volt ay sumusuri lang sa mga pagbabago sa mga batang mga template upang malaman kung kailan muling iponin upang mapantay muli ang PHP, kaya nirerekomenda na simulan ang Volt na may opsyon <code>'compileAlways' = &gt; true</code>. Kaya naman, ang mga template ay palaging naiipon na isinalang-alang sa pagbabago sa magulang na mga template. </h5>

<a name='autoescape'></a>

## Autoescape mode

Pwede mong paganahin ang awtomatikong-paglabas ng lahat ng mga variable na naprint na sa isang bloke gamit ang awtomatikong paglabad na mode:

```twig
Manu-manong nakatakas:  {{ robot.name|e }}

{% autoescape true %}
    Autoescaped: {{ robot.name }}
    {% autoescape false %}
        No Autoescaped: {{ robot.name }}
    {% endautoescape %}
{% endautoescape %}
```

<a name='extending'></a>

## Extending Volt

Hindi kagaya ng ibang mga makina ng template, ang Volt ay hindi kinakailangan na patakbuhin ang mga naipong mga template. Kapag ang isang template ay naipon na hindi dumedepende sa Volt. Sa malayang pagganap sa isip. Ang Volt ay kumikilos bilang isang tagaipon para sa mga template ng PHP.

Ang Volt na tagaipon ay nagpaphintulot sa iyo na palawigin ito sa pagdagdag na mas maraming mga gamit, mga pagsusuri, o mga sumasala sa mga umiiral na.

<a name='extending-functions'></a>

### Functions

Ang mga gamit ay kumikilos bilang mga karaniwang mga gamit ng PHP, ang isang balidong pangalan ng string ay kinakailangan bilang isang pangalan ng gamit. Ang mga gamit ay pwedeng maidagdag gamit ang dalawang mga stratehiya, bumabalik sa isang simpleng string o gamit ang isang hindi kilalang mga gamit. Palagi ay kianakailangan sa piniling stratehiya na bumabalik sa isang balidong ekspresyon ng string ng PHP:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// This binds the function name 'shuffle' in Volt to the PHP function 'str_shuffle'
$compiler->addFunction('shuffle', 'str_shuffle');
```

Pagrehistro sa gamit sa isang hindi kilalang gamit. Ang kasong ito ay magagamit `$resolvedArgs` para magpasa ng mga argumento na eksakto sa napasang mga argumento:

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

Tratohin ang mga argumento na malaya at hindi maresolba:

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

Gumawa ng code base sa ilang mga gamit na mayroon:

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

Mga gamit na nakalakip na pwedeng ma-override na nagdadagdag ng isang gamit na kasama ang pangalan nito:

```php
<?php

// Replace built-in function dump
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### Filters

Ang sumasala ay may mga sumusunod na porma sa isang template: leftExpr|name(optional-args). Magdagdag ng bagong mga sumasala ay makikita kasama ang mga gamit:

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

Ang mga nakalakip na mga sumsala ay pwedeng ma -override ang mga naidagdag na gamit kasama ang pangalan nito:

```php
<?php

// Replace built-in filter 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### Extensions

Kasama ang mga extensyon ang nagdedevelop ay magkakaroon ng kakayahang makaangkop upnag pahabain ang makina ng template, at ma-override ang mga naipon sa tiyak na instruksyon, baguhin ang pag-uugali ng isang ekspresyon o operator, magdagdag ng mga gamit/mga sumasala, at marami pa.

Ang isang extensyon ay isang klase na nagppatupad ng mga nangyayari na pinapagana ng Volt bilang isang paraan. Halimbawa, ang klase sa ibaba ay nagpapahintulot na gumamit ng kahit anong gamit ng PHP sa Volt:

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
            return $name . '('. $arguments. ')';
        }
    }
}
```

Ang nasa itaas na klase na nagpapatupad ng paraan `compileFunction` na tumatawag bago ang isang pagsubok na umipon ng pagtawag na gamit sa kahit anong template. Ang layunin ng extensyon upang maverify kung ang isang gamit na maiipon ay isang gamit ng PHP na nagpapahintulot na tawagin ito galing sa template. Ang mga nangyayari ay kailangang bumalik sa balidong code ng PHP, ito ay ginagamit bilang resulta na naipon sa halip na sa isang ginawa ng Volt. Kung ang isang pangyayari ay hindi bumalik saisang string na naipon ay natapos na gamit ang default na pag-uugali na binigay ng makina.

Ang mga sumusunod na naipong mga pangyayari na magagamit upang maipatupad sa mga extensyon:

| Pangyayari/Paraan   | Description                                                                                                                                         |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| `naipongGamit`      | Na-trigger na bago muling sumubok na iponin ang kahit anong gamit ng pagtawag sa isang template                                                     |
| `naipongSumasala`   | Na-trigger bago muling sumubok na iponin ang kahit anong pagsala ng pagtawag sa isang template                                                      |
| `resolbaEkspresyon` | Na-trigger bago sumubok muli na iponin ang kahit anong ekspresyon. Ito ay nagpapahintulot sa nagdedevelop na ma-override ang mga operator           |
| `naipongPahayag`    | Na-trigger na bago sumubok muli na iponin ang kahit anong ekspresyon. Ito ay nagpapahintulot sa nagdedevelop na ma-override ang kahit anong pahayag |

Ang mga extensyon ng Volt ay kailangang nakarehistro sa taga-ipon na sila ay ginagawang magagamit sa naipong oras:

```php
<?php

// Register the extension in the compiler
$compiler->addExtension(
    new PhpFunctionExtension();
);
```

<a name='caching-view-fragments'></a>

## Caching view fragments

Sa Volt madali lamang ang cache ng tinignan na mga fragment. Ang pagcache nito ay mas nagpapabuti sa pagganap na pumipigil sa laman ng isang bloke para magawa ng PHP na kapag may tanawing pinakita:

```twig
{% cache 'sidebar' %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
```

Ang pagset ng tiyak na bilang ng mga segundo:

```twig
{# cache the sidebar by 1 hour #}
{% cache 'sidebar' 3600 %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
```

Kahit anong balidong ekspresyon ay pwedeng magamit bilang isang susi ng cache:

```twig
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
```

Ang pagcache ay natatapos sa pamamagitan ng `Phalcon\Cache` na bahagi sa pamamagitan ng pagtingin ng bahagi. Matuto nang higit pa tungkol sa kung papaano ang pagsasamang ito ay gumagana sa seksyong ito [Caching View Fragments](/[[language]]/[[version]]/views#caching-fragments).

<a name='services-in-templates'></a>

## Inject Services into a Template

Kung ang isang lalagyan ng serbisyo (DI) ay magagamit para sa Volt, ikaw ay pwedeng gumamit ng mga serbisyo sa pamamagitan lang ng pag-access sa pangalan ng serbisyo sa template:

```twig
{# Inject the 'flash' service #}
<div id='messages'>{{ flash.output() }}</div>

{# Inject the 'security' service #}
<input type='hidden' name='token' value='{{ security.getToken() }}'>
```

<a name='stand-alone'></a>

## Stand-alone component

Ang paggamit sa Volt sa isang mag-isang mode ay ipapakita sa ibaba:

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

- Isang bunble para sa Sublime/Textmate ay magagamit na [dito](https://github.com/phalcon/volt-sublime-textmate)
- [Album-O-Rama](https://album-o-rama.phalconphp.com) ay isang halimbawang aplikasyon gamit ang Volt bilang isang makina ng template, [Github](https://github.com/phalcon/album-o-rama)
- [Ang aming website](https://phalconphp.com) ay tumatakbo gamit ang Volt biang isang makina ng template, [Github](https://github.com/phalcon/website)
- [Phosphorum](https://forum.phalconphp.com), ang forum ng Phalcon, gumagamit din ng Volt, [Github](https://github.com/phalcon/forum)
- [Vökuró](https://vokuro.phalconphp.com), ay isang halimbawa din ng gumagamit ng Volt, [Github](https://github.com/phalcon/vokuro)