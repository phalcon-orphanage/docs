* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Volt: Motor de plantillas

Volt es un lenguaje de plantillas ultrarrápido y de diseño amigable, escrito en C para PHP. Le proporciona un conjunto de ayudantes a escribir vistas de una manera fácil. Volt están altamente integrado con otros componentes de Phalcon, del mismo modo que puede utilizarlo como componente independiente en sus aplicaciones.

![](/assets/images/content/volt.jpg)

Volt is inspired by [Jinja](https://jinja.pocoo.org/), originally created by [Armin Ronacher](https://github.com/mitsuhiko). Por lo tanto muchos desarrolladores estarán en territorio familiar al utilizar la misma sintaxis que han estado utilizando con motores de plantillas similares. La sintaxis y características de Volt se han mejorado con más elementos y, por supuesto, con el rendimiento que los desarrolladores están acostumbrados a trabajar en Phalcon.

<a name='introduction'></a>

## Introducción

Las vistas de Volt se compilan a código PHP puro, así que, básicamente ahorran el esfuerzo de escribir el código PHP manualmente:

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

## Activando Volt

Como con otros motores de plantillas, se puede registrar Volt en el componente de la vista, usando una nueva extensión o reusar el estándar `phtml`:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Registrar Volt como un servicio
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

// Registrar Volt como motor de plantillas
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

Utilice la extensión estándar `phtml`:

```php
<?php

$view->registerEngines(
    [
        '.phtml' => 'voltService',
    ]
);
```

No tienes que especificar el servicio Volt en el DI; también puede utilizar el motor de Volt con la configuración predeterminada:

```php
<?php

$view->registerEngines(
    [
        '.volt' => Phalcon\Mvc\View\Engine\Volt::class,
    ]
);
```

Si no quieres reutilizar Volt como un servicio, puedes pasar una función anónima para registrar el motor en lugar de un nombre de servicio:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Registrar Volt como motor de plantillas con una función anónima
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => function ($view, $di) {
                    $volt = new Volt($view, $di);

                    // Configurar otras opciones aquí

                    return $volt;
                }
            ]
        );

        return $view;
    }
);
```

Las siguientes opciones están disponibles en Volt:

| Opción              | Descripción                                                                                                                  | Predeterminado |
| ------------------- | ---------------------------------------------------------------------------------------------------------------------------- | -------------- |
| `autoescape`        | Enables globally autoescape of HTML                                                                                          | `false`        |
| `compileAlways`     | Tell Volt if the templates must be compiled in each request or only when they change                                         | `false`        |
| `compiledExtension` | An additional extension appended to the compiled PHP file                                                                    | `.php`         |
| `compiledPath`      | A writable path where the compiled PHP templates will be placed                                                              | `./`           |
| `compiledSeparator` | Volt replaces the directory separators / and \ by this separator in order to create a single file in the compiled directory | `%%`           |
| `prefix`            | Permite anteponer un prefijo a las plantillas en la ruta de compilación                                                      | `null`         |
| `stat`              | Whether Phalcon must check if exists differences between the template file and its compiled path                             | `true`         |

La ruta de compilación se genera según las opciones anteriores, si el desarrollador quiere libertad total para definir la ruta de compilación, una función anónima puede utilizarse para generarlas, esta función recibe la ruta relativa de acceso a la plantilla al directorio de las vistas. Los ejemplos siguientes muestran cómo cambiar dinámicamente la ruta de compilación:

```php
<?php

// Simplemente añadir la extensión .php a la ruta de la plantilla
// Dejando las plantillas compiladas en el mismo directorio
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            return $templatePath . '.php';
        }
    ]
);

// Crear recursivamente la misma estructura en otro directorio
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

## Uso básico

Una vista consiste en código Volt, PHP y HTML. Un conjunto de delimitadores especiales está disponible para entrar en modo de Volt. `{% raw %}{% ... %}{% endraw %}` is used to execute statements such as for-loops or assign values and `{% raw %}{{ ... }}{% endraw %}`, prints the result of an expression to the template.

Abajo se encuentra una plantilla mínima, que muestra algunos conceptos básicos:

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

Using [Phalcon\Mvc\View](api/Phalcon_Mvc_View) you can pass variables from the controller to the views. En el ejemplo anterior, se pasaron cuatro variables a la vista: `show_navigation`, `menu`, `title` y `post`:

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

        // O...

        $this->view->setVar('show_navigation', true);
        $this->view->setVar('menu',            $menu);
        $this->view->setVar('title',           $post->title);
        $this->view->setVar('post',            $post);
    }
}
```

<a name='variables'></a>

## Variables

Las variables de objetos pueden tener atributos, que se pueden acceder utilizando la sintaxis: `foo.bar`. Si usted está pasando arreglos, tienes que usar la sintaxis de corchetes: `foo['bar']`

```twig
{% raw %}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
{% endraw %}
```

<a name='filters'></a>

## Filtros

Las variables pueden ser formateadas o modificadas mediante filtros. El operador de la pipa o pleca `|` se utiliza para aplicar filtros a las variables:

```twig
{% raw %}
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
{% endraw %}
```

La siguiente lista contiene los filtros disponibles incorporados en Volt:

| Filtro             | Descripción                                                                                                                         |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Applies the [abs](https://php.net/manual/en/function.abs.php) PHP function to a value.                                              |
| `capitalize`       | Capitalizes a string by applying the [ucwords](https://php.net/manual/en/function.ucwords.php) PHP function to the value            |
| `convert_encoding` | Convierte una cadena de un conjunto de caracteres a otro                                                                            |
| `default`          | Establece un valor predeterminado en caso de que la expresión evaluada este vacía (no se establece o se evalúa como un valor falso) |
| `e`                | Se aplica `Phalcon\Escaper->escapeHtml()` al valor                                                                              |
| `escape`           | Se aplica `Phalcon\Escaper->escapeHtml()` al valor                                                                              |
| `escape_attr`      | Se aplica `Phalcon\Escaper->escapeHtmlAttr()` al valor                                                                          |
| `escape_css`       | Se aplica `Phalcon\Escaper->escapeCss()` al valor                                                                               |
| `escape_js`        | Se aplica `Phalcon\Escaper->escapeJs()` al valor                                                                                |
| `format`           | Formats a string using [sprintf](https://php.net/manual/en/function.sprintf.php).                                                   |
| `json_encode`      | Converts a value into its [JSON](https://php.net/manual/en/function.json-encode.php) representation                                 |
| `json_decode`      | Converts a value from its [JSON](https://php.net/manual/en/function.json-encode.php) representation to a PHP representation         |
| `join`             | Joins the array parts using a separator [join](https://php.net/manual/en/function.join.php)                                         |
| `keys`             | Returns the array keys using [array_keys](https://php.net/manual/en/function.array-keys.php)                                        |
| `left_trim`        | Applies the [ltrim](https://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                  |
| `length`           | Cuenta la longitud de la cadena de texto o cuántos elementos hay en un array u objeto                                               |
| `lower`            | Cambiar una cadena a minúsculas                                                                                                     |
| `nl2br`            | Changes newlines `\n` by line breaks (`<br />`). Uses the PHP function [nl2br](https://php.net/manual/en/function.nl2br.php) |
| `right_trim`       | Applies the [rtrim](https://php.net/manual/en/function.rtrim.php) PHP function to the value. Removing extra spaces                  |
| `sort`             | Sorts an array using the PHP function [asort](https://php.net/manual/en/function.asort.php)                                         |
| `stripslashes`     | Applies the [stripslashes](https://php.net/manual/en/function.stripslashes.php) PHP function to the value. Removing escaped quotes  |
| `striptags`        | Applies the [striptags](https://php.net/manual/en/function.striptags.php) PHP function to the value. Removing HTML tags             |
| `trim`             | Applies the [trim](https://php.net/manual/en/function.trim.php) PHP function to the value. Removing extra spaces                    |
| `upper`            | Change the case of a string to uppercase                                                                                            |
| `url_encode`       | Applies the [urlencode](https://php.net/manual/en/function.urlencode.php) PHP function to the value                                 |

Ejemplos:

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

## Comentarios

Comments may also be added to a template using the `{% raw %}{# ... #}{% endraw %}` delimiters. All text inside them is just ignored in the final output:

```twig
{% raw %}
{# note: this is a comment
    {% set price = 100; %}
#}
{% endraw %}
```

<a name='control-structures'></a>

## Lista de estructuras de Control

Volt proporciona un conjunto de estructuras de control básicas pero de gran alcance para el uso de plantillas:

<a name='control-structures-for'></a>

### For

Un bucle sobre cada elemento en una secuencia. En el ejemplo siguiente se muestra cómo recorrer un conjunto de 'robots' e imprimir su nombre:

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

Los bucles `for` también se pueden anidar:

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

Usted puede conseguir las `claves` de los elementos, como la contraparte PHP, con la siguiente sintaxis:

```twig
{% raw %}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
{% endraw %}
```

Opcionalmente, se puede establecer una evaluación `if`:

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

Si un `else` se define dentro del `for`, se ejecutará si la expresión en el iterador da como resultado cero iteraciones:

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

Sintaxis alternativa:

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

### Controles de bucle

Las declaraciones de `break` y `continue` pueden utilizarse para salir de un bucle o forzar una iteración en el bloque actual:

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

Como en PHP, una declaración `if` comprueba si una expresión se evalúa como verdadera o falsa:

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

También se admite la cláusula `else`:

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

También puede utilizar la estructura de flujo de control `elseif` para emular un bloque `switch`:

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

Una alternativa a la instrucción `if` es `switch`, que le permite crear caminos de ejecución lógica en su aplicación:

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

La sentencia `switch` ejecuta instrucción por instrucción, por lo tanto es necesario en algunos casos la instrucción `break`. Cualquier salida (incluyendo espacios en blanco) entre una instrucción switch y el primer `case` dará lugar a un error de sintaxis. Empty lines and whitespaces can therefore be cleared to reduce the number of errors [see here](https://php.net/control-structures.alternative-syntax).

#### `case` sin `switch`

```twig
{% raw %}
{% case EXPRESSION %}
{% endraw %}
```

Lanzará un `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

#### `switch` sin `endswitch`

```twig
{% raw %}
{% switch EXPRESSION %}
{% endraw %}
Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.
```

#### `default` sin `switch`

```twig
{% raw %}
{% default %}
{% endraw %}
```

Will not throw an error because `default` is a reserved word for filters like `{% raw %}{{ EXPRESSION | default(VALUE) }}{% endraw %}` but in this case the expression will only output an empty char '' .

#### `switch` anidados

```twig
{% raw %}
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
{% endraw %}
```

Lanzará un `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

#### un `switch` sin expresión

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

### Contexto de bucle

A special variable is available inside `for` loops providing you information about

| Variable         | Descripción                                                            |
| ---------------- | ---------------------------------------------------------------------- |
| `loop.index`     | Iteración actual del bucle. (comenzando desde 1)                       |
| `loop.index0`    | Iteración actual del bucle. (comenzando desde 0)                       |
| `loop.revindex`  | El número de iteraciones desde el final del bucle (comenzando desde 1) |
| `loop.revindex0` | El número de iteraciones desde el final del bucle (comenzando desde 0) |
| `loop.first`     | Si es la primera iteración, el valor será `true`.                      |
| `loop.last`      | Si es la última iteración, el valor será `true`.                       |
| `loop.length`    | El número de elementos iterar                                          |

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

## Asignaciones

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

| Operator | Descripción                  |
| -------- | ---------------------------- |
| `=`      | Asignación estándar          |
| `+=`     | Asignación de adición        |
| `-=`     | Asignación de resta          |
| `\*=`  | Asignación de multiplicación |
| `/=`     | Asignación de división       |

<a name='expressions'></a>

## Expresiones

Volt proporciona un conjunto básico de expresiones, incluyendo literales y operadores comunes. A expression can be evaluated and printed using the `{% raw %}{{{% endraw %}` and `{% raw %}}}{% endraw %}` delimiters:

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

### Literales

The following literals are supported:

| Filtro                 | Descripción                                                                           |
| ---------------------- | ------------------------------------------------------------------------------------- |
| `'esto es una cadena'` | Los textos entre doble comillas simples o dobles se tratan como cadenas de caracteres |
| `100.25`               | Los números con parte decimal se tratan como dobles/flotadores                        |
| `100`                  | Los número sin parte decimal se tratan como enteros                                   |
| `false`                | La constante 'false' es el valor booleano falso                                       |
| `true`                 | La constante 'true' es el valor booleano verdadero                                    |
| `null`                 | La constante 'null' es el valor Null                                                  |

<a name='expressions-arrays'></a>

### Arrays

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

### Matemáticas

You may make calculations in templates using the following operators:

| Operator | Descripción                                                                                  |
|:--------:| -------------------------------------------------------------------------------------------- |
|   `+`    | Perform an adding operation. `{% raw %}{{ 2 + 3 }}{% endraw %}` returns 5                    |
|   `-`    | Perform a substraction operation `{% raw %}{{ 2 - 3 }}{% endraw %}` returns -1               |
|   `*`    | Perform a multiplication operation `{% raw %}{{ 2 * 3 }}{% endraw %}` returns 6              |
|   `/`    | Perform a division operation `{% raw %}{{ 10 / 2 }}{% endraw %}` returns 5                   |
|   `%`    | Calculate the remainder of an integer division `{% raw %}{{ 10 % 3 }}{% endraw %}` returns 1 |

<a name='expressions-comparisons'></a>

### Comparaciones

The following comparison operators are available:

|  Operator  | Descripción                                                                       |
|:----------:| --------------------------------------------------------------------------------- |
|    `==`    | Comprobar si ambos operandos son iguales                                          |
|    `!=`    | Comprobar si ambos operandos no son iguales                                       |
| `<>` | Comprobar si ambos operandos no son iguales                                       |
|   `>`   | Compruebe si el operando izquierdo es mayor que el operando derecho               |
|   `<`   | Compruebe si el operando izquierdo es menor que el operando derecho               |
|  `<=`   | Compruebe si el operando de la izquierda es menor o igual que el operando derecho |
|  `>=`   | Compruebe si el operando izquierdo es mayor o igual que el operando derecho       |
|   `===`    | Compruebe si ambos operandos son idénticos                                        |
|   `!==`    | Comprobar si ambos operandos no son identicos                                     |

<a name='expressions-logic'></a>

### Lógica

Logic operators are useful in the `if` expression evaluation to combine multiple tests:

|  Operator  | Descripción                                                                   |
|:----------:| ----------------------------------------------------------------------------- |
|    `o`     | Devuelve true si el operando de la derecha o la izquierda se evalúa como true |
|   `and`    | Devuelve true si los operandos izquierdo y derecho se evalúan como verdadero  |
|   `not`    | Niega una expresión                                                           |
| `( expr )` | Las expresiones se agrupan entre paréntesis                                   |

<a name='expressions-other-operators'></a>

### Otros operadores

Additional operators seen the following operators are available:

| Operator          | Descripción                                                                                      |
| ----------------- | ------------------------------------------------------------------------------------------------ |
| `~`               | Concatenates both operands `{% raw %}{{ 'hello ' ~ 'world' }}{% endraw %}`                       |
| `|`               | Applies a filter in the right operand to the left `{% raw %}{{ 'hello'|uppercase }}{% endraw %}` |
| `..`              | Creates a range `{% raw %}{{ 'a'..'z' }}{% endraw %}` `{% raw %}{{ 1..10 }}{% endraw %}`         |
| `is`              | Alias de == (igual), también realiza pruebas                                                     |
| `in`              | Para comprobar si una expresión está contenida en otras expresiones `if 'a' in 'abc'`            |
| `is not`          | Alias de != (no iguales)                                                                         |
| `'a' ? 'b' : 'c'` | Operador ternario. Igual al operador ternario de PHP                                             |
| `++`              | Incrementa un valor                                                                              |
| `--`              | Decrementa un valor                                                                              |

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

## Pruebas

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

| Prueba        | Descripción                                                                                    |
| ------------- | ---------------------------------------------------------------------------------------------- |
| `defined`     | Comprueba si una variable esta definida (`isset()`)                                            |
| `divisibleby` | Comprueba si un valor es divisible por otro valor                                              |
| `empty`       | Comprueba si una variable está vacía                                                           |
| `even`        | Comprueba si un valor numérico es par                                                          |
| `iterable`    | Comprueba si un valor es iterable. Es decir, que puede ser recorrido por una instrucción 'for' |
| `numeric`     | Comprueba si el valor es numérico                                                              |
| `odd`         | Comprueba si un valor numérico es impar                                                        |
| `sameas`      | Comprueba si un valor es idéntico a otro valor                                                 |
| `scalar`      | Comprueba si el valor es escalar (no una matriz, objeto o recurso)                             |
| `type`        | Comprueba si un valor es del tipo especificado                                                 |

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

## Macros

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

## Usando los ayudantes de etiqueta

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

| Método                            | Función en Volt      |
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

## Funciones

The following built-in functions are available in Volt:

| Nombre        | Descripción                                                         |
| ------------- | ------------------------------------------------------------------- |
| `content`     | Incluye el contenido producido en una etapa anterior de renderizado |
| `get_content` | Alias de `content`                                                  |
| `partial`     | Carga dinámicamente una vista parcial en la plantilla actual        |
| `super`       | Presenta el contenido del bloque padre                              |
| `time`        | Llama a la función `time()` de PHP                                  |
| `date`        | Llama a la función `time()` de PHP                                  |
| `dump`        | Llama la función `var_dump()` de PHP                                |
| `version`     | Devuelve la versión actual del framework                            |
| `constant`    | Lee una constante de PHP                                            |
| `url`         | Genera una dirección URL utilizando el servicio 'url'               |

<a name='view-integrations'></a>

## Integración de la vista

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

### Incluir

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

### Parciales vs inclusiones

Keep the following points in mind when choosing to use the `partial` function or `include`:

| Tipo      | Descripción                                                                                                   |
| --------- | ------------------------------------------------------------------------------------------------------------- |
| `partial` | Permite incluir plantillas en Volt, igual que en otros motores de plantillas                                  |
|           | Permite pasar de una expresión como una variable permitiendo incluir el contenido de otra vista dinámicamente |
|           | Es mejor si el contenido que usted tiene que incluir cambia con frecuencia                                    |
| `include` | Copia el contenido compilado en la vista, mejorando el rendimiento                                            |
|           | Sólo permite incluir plantillas creadas con Volt                                                              |
|           | Requiere de una plantilla existente en tiempo de compilación                                                  |

<a name='template-inheritance'></a>

## Herencia de Plantillas

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

### Herencia múltiple

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

## Modo de Autoescape

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

## Extender Volt

Unlike other template engines, Volt itself is not required to run the compiled templates. Once the templates are compiled there is no dependence on Volt. With performance independence in mind, Volt only acts as a compiler for PHP templates.

The Volt compiler allow you to extend it adding more functions, tests or filters to the existing ones.

<a name='extending-functions'></a>

### Funciones

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

### Filtros

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

### Extensiones

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

| Event/Method        | Descripción                                                                                            |
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

## Almacenamiento en caché de fragmentos de la vista

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

## Inyectar servicios en una plantilla

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

## Componente independiente

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

## Recursos externos

* A bundle for Sublime/Textmate is available [here](https://github.com/phalcon/volt-sublime-textmate)
* [Album-O-Rama](https://album-o-rama.phalconphp.com) is a sample application using Volt as template engine, [Github](https://github.com/phalcon/album-o-rama)
* [Our website](https://phalconphp.com) is running using Volt as template engine, [Github](https://github.com/phalcon/website)
* [Phosphorum](https://forum.phalconphp.com), the Phalcon's forum, also uses Volt, [Github](https://github.com/phalcon/forum)
* [Vökuró](https://vokuro.phalconphp.com), is another sample application that use Volt, [Github](https://github.com/phalcon/vokuro)