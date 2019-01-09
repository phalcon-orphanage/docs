* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Volt: Motor de plantillas

Volt es un lenguaje de plantillas ultrarrápido y de diseño amigable, escrito en C para PHP. Le proporciona un conjunto de ayudantes a escribir vistas de una manera fácil. Volt están altamente integrado con otros componentes de Phalcon, del mismo modo que puede utilizarlo como componente independiente en sus aplicaciones.

![](/assets/images/content/volt.jpg)

Volt está inspirado en [Jinja](http://jinja.pocoo.org/), originalmente creado por [Armin Ronacher](https://github.com/mitsuhiko). Por lo tanto muchos desarrolladores estarán en territorio familiar al utilizar la misma sintaxis que han estado utilizando con motores de plantillas similares. La sintaxis y características de Volt se han mejorado con más elementos y, por supuesto, con el rendimiento que los desarrolladores están acostumbrados a trabajar en Phalcon.

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

| Opción              | Descripción                                                                                                                            | Predeterminado |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------------- | -------------- |
| `autoescape`        | Habilita a nivel global el autoescape de HTML                                                                                          | `false`        |
| `compileAlways`     | Volt de compilar las plantillas en cada solicitud o sólo cuando hubo un cambio en ellas                                                | `false`        |
| `compiledExtension` | Una extensión adicional anexada al archivo PHP compilado                                                                               | `.php`         |
| `compiledPath`      | Un ruta con permisos de escritura donde se puede almacenar las plantillas PHP compiladas                                               | `./`           |
| `compiledSeparator` | Volt reemplaza los separadores de directorio / y \ por este separador con el fin de crear un único archivo en el directorio compilado | `%%`           |
| `prefix`            | Permite anteponer un prefijo a las plantillas en la ruta de compilación                                                                | `null`         |
| `stat`              | Si Phalcon debe verificar si existen diferencias entre el archivo de plantilla y su ruta compilada                                     | `true`         |

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

Object variables may have attributes which can be accessed using the syntax: `foo.bar`. If you are passing arrays, you have to use the square bracket syntax: `foo['bar']`

```twig
{% raw %}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
{% endraw %}
```

<a name='filters'></a>

## Filtros

Variables can be formatted or modified using filters. The pipe operator `|` is used to apply filters to variables:

```twig
{% raw %}
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
{% endraw %}
```

La siguiente lista contiene los filtros disponibles incorporados en Volt:

| Filtro             | Descripción                                                                                                                                           |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Se aplica la función [abs](http://php.net/manual/en/function.abs.php) de PHP a un valor.                                                              |
| `capitalize`       | Capitaliza una cadena mediante la aplicación de la función PHP [ucwords](http://php.net/manual/en/function.ucwords.php) al valor                      |
| `convert_encoding` | Convierte una cadena de un conjunto de caracteres a otro                                                                                              |
| `default`          | Establece un valor predeterminado en caso de que la expresión evaluada este vacía (no se establece o se evalúa como un valor falso)                   |
| `e`                | Se aplica `Phalcon\Escaper->escapeHtml()` al valor                                                                                                |
| `escape`           | Se aplica `Phalcon\Escaper->escapeHtml()` al valor                                                                                                |
| `escape_attr`      | Se aplica `Phalcon\Escaper->escapeHtmlAttr()` al valor                                                                                            |
| `escape_css`       | Se aplica `Phalcon\Escaper->escapeCss()` al valor                                                                                                 |
| `escape_js`        | Se aplica `Phalcon\Escaper->escapeJs()` al valor                                                                                                  |
| `format`           | Formatea una cadena utilizando [sprintf](http://php.net/manual/en/function.sprintf.php).                                                              |
| `json_encode`      | Convierte un valor en su representación [JSON](http://php.net/manual/en/function.json-encode.php)                                                     |
| `json_decode`      | Convierte un valor de su representación [JSON](http://php.net/manual/en/function.json-encode.php) en una representación de PHP                        |
| `join`             | Se unen las partes de un array usando un separador [join](http://php.net/manual/en/function.join.php)                                                 |
| `keys`             | Devuelve las llaves de la matriz usando [array_keys](http://php.net/manual/en/function.array-keys.php)                                                |
| `left_trim`        | Se aplica la función [ltrim](http://php.net/manual/en/function.ltrim.php) PHP al valor. Quita espacios extra a la izquierda                           |
| `length`           | Cuenta la longitud de la cadena de texto o cuántos elementos hay en un array u objeto                                                                 |
| `lower`            | Cambiar una cadena a minúsculas                                                                                                                       |
| `nl2br`            | Cambia los saltos de línea `\n` por saltos de línea (`<br />`). Utiliza la función de PHP [nl2br](http://php.net/manual/en/function.nl2br.php) |
| `right_trim`       | Se aplica la función [rtrim](http://php.net/manual/en/function.rtrim.php) PHP al valor. Quita espacios extra a la derecha                             |
| `sort`             | Ordena una matriz mediante la función PHP [asort](http://php.net/manual/en/function.asort.php)                                                        |
| `stripslashes`     | Se aplica la función [stripslashes](http://php.net/manual/en/function.stripslashes.php) de PHP al valor. Quita las comillas escapadas                 |
| `striptags`        | Se aplica la función [striptags](http://php.net/manual/en/function.striptags.php) de PHP al valor. Remueve las etiquetas HTML                         |
| `trim`             | Se aplica la función [trim](http://php.net/manual/en/function.trim.php) de PHP al valor. Quita espacios extra a la izquierda y derecha                |
| `upper`            | Cambiar una cadena a mayúsculas                                                                                                                       |
| `url_encode`       | Se aplica la función [urlencode](http://php.net/manual/en/function.urlencode.php) PHP al valor                                                        |

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

La sentencia `switch` ejecuta instrucción por instrucción, por lo tanto es necesario en algunos casos la instrucción `break`. Cualquier salida (incluyendo espacios en blanco) entre una instrucción switch y el primer `case` dará lugar a un error de sintaxis. Por lo tanto pueden borrar los espacios en blanco y líneas vacías para reducir el número de errores. Para más información visite [sintaxis alternativa de estructuras de control](http://php.net/control-structures.alternative-syntax).

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

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

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

Una variable especial está disponible dentro de los bucles `for`, proporcionando información sobre:

| Variable         | Descripción                                                            |
| ---------------- | ---------------------------------------------------------------------- |
| `loop.index`     | Iteración actual del bucle. (comenzando desde 1)                       |
| `loop.index0`    | Iteración actual del bucle. (comenzando desde 0)                       |
| `loop.revindex`  | El número de iteraciones desde el final del bucle (comenzando desde 1) |
| `loop.revindex0` | El número de iteraciones desde el final del bucle (comenzando desde 0) |
| `loop.first`     | Si es la primera iteración, el valor será `true`.                      |
| `loop.last`      | Si es la última iteración, el valor será `true`.                       |
| `loop.length`    | El número de elementos iterar                                          |

Ejemplo:

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

Se permiten las asignaciones múltiples en la misma instrucción:

```twig
{% raw %}
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
{% endraw %}
```

Además, puede utilizar operadores de asignación compuestos:

```twig
{% raw %}
{% set price += 100.00 %}

{% set age *= 5 %}
{% endraw %}
```

Las siguientes operadores están disponibles:

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

Si una expresión necesita ser evaluada pero no impresa, se puede utilizar la instrucción `do`:

```twig
{% raw %}
{% do (1 + 1) * 2 %}
{% endraw %}
```

<a name='expressions-literals'></a>

### Literales

Son soportados los siguientes literales:

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

Si usas PHP 5.3 o >= 5.4 puedes crear matrices adjuntando una lista de valores entre corchetes:

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

Las llaves también pueden usarse para definir matrices o arrays asociativos:

```twig
{% raw %}
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
{% endraw %}
```

<a name='expressions-math'></a>

### Matemáticas

Se pueden hacer cálculos en las plantillas mediante los siguientes operadores:

| Operator | Descripción                                                                                  |
|:--------:| -------------------------------------------------------------------------------------------- |
|   `+`    | Realizar una operación de adición. `{% raw %}{{ 2 + 3 }}{% endraw %}` returns 5              |
|   `-`    | Perform a substraction operation `{% raw %}{{ 2 - 3 }}{% endraw %}` returns -1               |
|   `*`    | Perform a multiplication operation `{% raw %}{{ 2 * 3 }}{% endraw %}` returns 6              |
|   `/`    | Perform a division operation `{% raw %}{{ 10 / 2 }}{% endraw %}` returns 5                   |
|   `%`    | Calculate the remainder of an integer division `{% raw %}{{ 10 % 3 }}{% endraw %}` returns 1 |

<a name='expressions-comparisons'></a>

### Comparaciones

Los siguientes operadores de comparación están disponibles:

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

Los operadores lógicos son útiles en la evaluación de expresiones `if` para combinar múltiples pruebas:

|  Operator  | Descripción                                                                   |
|:----------:| ----------------------------------------------------------------------------- |
|    `or`    | Devuelve true si el operando de la derecha o la izquierda se evalúa como true |
|   `and`    | Devuelve true si los operandos izquierdo y derecho se evalúan como verdadero  |
|   `not`    | Niega una expresión                                                           |
| `( expr )` | Las expresiones se agrupan entre paréntesis                                   |

<a name='expressions-other-operators'></a>

### Otros operadores

También están disponibles otros operadores:

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

En el ejemplo siguiente se muestra cómo utilizar operadores:

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

Las siguientes pruebas integradas están disponibles en Volt:

| Prueba        | Descripción                                                                |
| ------------- | -------------------------------------------------------------------------- |
| `defined`     | Comprueba si una variable esta definida (`isset()`)                        |
| `divisibleby` | Comprueba si un valor es divisible por otro valor                          |
| `empty`       | Comprueba si una variable está vacía                                       |
| `even`        | Comprueba si un valor numérico es par                                      |
| `iterable`    | Comprueba si un valor es iterable. Que puede ser utilizado en un bucle for |
| `numeric`     | Comprueba si el valor es numérico                                          |
| `odd`         | Comprueba si un valor numérico es impar                                    |
| `sameas`      | Comprueba si un valor es idéntico a otro valor                             |
| `scalar`      | Comprueba si el valor es escalar (no una matriz, objeto o recurso)         |
| `type`        | Comprueba si un valor es del tipo especificado                             |

Más ejemplos:

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

Las macros pueden utilizarse para reutilizar la lógica de una plantilla, actúan como funciones PHP, pueden recibir parámetros y devolver valores:

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

Al llamar a las macros, se pueden pasar parámetros por nombre:

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

Las macros pueden devolver valores:

```twig
{% raw %}
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
{% endraw %}
```

Y recibir parámetros opcionales:

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

Se genera el siguiente código PHP:

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

Las siguientes funciones integradas están disponibles en Volt:

| Nombre        | Descripción                                                         |
| ------------- | ------------------------------------------------------------------- |
| `content`     | Incluye el contenido producido en una etapa anterior de renderizado |
| `get_content` | Alias de `content`                                                  |
| `partial`     | Carga dinámicamente una vista parcial en la plantilla actual        |
| `super`       | Presenta el contenido del bloque padre                              |
| `time`        | Llama a la función `time()` de PHP                                  |
| `date`        | Llama a la función `date()` de PHP                                  |
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

Una vista parcial es incluida en tiempo de ejecución, Volt proporciona también `include`, este compila el contenido de una vista y devuelve su contenido como parte de la vista que se incluye:

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

`include` tiene un comportamiento especial que nos ayudará a mejorar un poco el rendimiento cuando se usa Volt, si especifica la extensión al incluir el archivo y existe cuando se compila la plantilla, Volt puede incrustar el contenido de la plantilla incluida en la plantilla principal donde está definida la inclusión. Las plantillas no serán incrustadas si el `include` tiene variables pasadas con `with`:

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

Tenga los siguientes puntos en cuenta al elegir utilizar la función `partial` o `include`:

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

Con herencia de plantillas se pueden crear plantillas base que pueden ampliarse con otras plantillas permitiendo reutilizar código. En una plantilla base se definen bloques *blocks* que puede ser reemplazados por una plantilla hija. Supongamos que tenemos la siguiente plantilla de base:

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

Desde otra plantilla podríamos ampliar la plantilla base, reemplazando los bloques:

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

        <title>Index - Mi Página Web</title>
    </head>

    <body>
        <div id='content'>
            <h1>Index</h1>
            <p class='important'>Bienvenido a mi increíble página principal.</p>
        </div>

        <div id='footer'>
            &copy; Copyright 2015, Todos los derechos reservados.
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

La plantilla `layout.volt` extiende de `main.volt`

```twig
{% raw %}
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
{% endraw %}
```

Finalmente una vista que se extiende de `layout.volt`:

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

El renderizado de `index.volt` producirá:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Título</title>
    </head>

    <body>

        <h1>Tabla de contenidos</h1>

        <ul>
            <li>Una opción</li>
            <li>Otra opción</li>
        </ul>

    </body>
</html>
```

Tenga en cuenta la llamada a la función `super()`. Con esa función es posible representar los contenidos del bloque padre. Al igual que en las vistas parciales, la ruta para definir una herencia con `extends` es una ruta de acceso relativa del directorio actual de las vistas (es decir, `app/views/`).

<h5 class='alert alert-warning'>Por defecto y por motivos de rendimiento, Volt sólo comprueba cambios en las plantillas hijas para saber cuándo debe volver a compilar y generar PHP plano otra vez, por lo que es recomendable inicializar Volt con la opción de <code>'compileAlways' =&gt; true</code>. Por lo tanto, las plantillas se compilan siempre teniendo en cuenta los cambios en las plantillas padre. </h5>

<a name='autoescape'></a>

## Modo de Autoescape

Es posible activar el auto-escape de todas las variables en un bloque usando el modo autoescape:

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

A diferencia de otros motores de plantillas, Volt en sí mismo no está obligado a ejecutar las plantillas compiladas. Una vez que se compilan las plantillas no hay ninguna dependencia con Volt. Con independencia del rendimiento en mente, Volt sólo actúa como un compilador de plantillas PHP.

El compilador de Volt permite ser ampliado, añadiendole más funciones, tests o filtros a los ya existentes.

<a name='extending-functions'></a>

### Funciones

Las funciones actúan como funciones normales de PHP, un nombre de cadena válida se requiere como nombre de la función. Las funciones se pueden agregar mediante dos estrategias, retornando una cadena simple o utilizando una función anónima. Siempre es necesario que la estrategia elegida devuelva una expresión de PHP válida:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// Vincular la función con nombre 'shuffle' en Volt a la función 'str_shuffle' de PHP
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

Trate los argumentos de manera independiente y sin resolver:

```php
<?php

$compiler->addFunction(
    'repeat',
    function ($resolvedArgs, $exprArgs) use ($compiler) {
        // Resolver el primer argumento
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        // Comprobar si el segundo argumento fue pasado
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            // Por defecto, usar '10'
            $secondArgument = '10';
        }

        return 'str_repeat(' . $firstArgument . ', ' . $secondArgument . ')';
    }
);
```

Generar el código basado en la disponibilidad de alguna función:

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

Las funciones integradas se pueden reemplazar agregando una función con su nombre:

```php
<?php

// Reemplazar la función incorporada 'dump'
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### Filtros

A filter has the following form in a template: leftExpr|name(optional-args). Adding new filters is similar as seen with the functions:

```php
<?php

// Creamos el filtro 'hash' que usa la funcion 'md5' de PHP
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

Los filtros incorporados se pueden reemplazar agregando una función con su nombre:

```php
<?php

// Reemplazar el filtro incorporado 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### Extensiones

Con las extensiones, el desarrollador tiene más flexibilidad para extender el motor de la plantilla y reemplazar la compilación de una instrucción específica, cambiar el comportamiento de una expresión o un operador, añadir funciones y filtros y mucho más.

An extension is a class that implements the events triggered by Volt as a method of itself. For example, the class below allows to use any PHP function in Volt:

```php
<?php

class PhpFunctionExtension
{
    /**
     * Este metodo es llamado ante cualquier intento de compilar una función llamada
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }
}
```

La clase anterior implementa el método `compileFunction` que se invoca antes de cualquier intento de compilar una llamada a la función en cualquier plantilla. El propósito de la extensión es verificar si una función tiene que ser compilada es una función PHP que permite ser llamar desde la plantilla. Los eventos en las extensiones deben devolver código PHP válido, este será usado como resultado de la compilación en vez del generado por Volt. Si un evento no devuelve una cadena, la compilación se realiza utilizando el comportamiento predeterminado proporcionado por el motor.

Los siguientes eventos de compilación están disponibles para ser implementados en extensiones:

| Método/Evento       | Descripción                                                                                                                     |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| `compileFunction`   | Es activado antes de intentar compilar cualquier llamada a una función en una plantilla                                         |
| `compileFilter`     | Es activado antes de intentar compilar cualquier llamada a un filtro en una plantilla                                           |
| `resolveExpression` | Activado antes de intentar compilar cualquier expresión. Esto permite a los desarrolladores sobreescribir operadores            |
| `compileStatement`  | Activado antes de intentar compilar cualquier expresión. Esto permite a los desarrolladores sobreescribir cualquier declaración |

Las extensiones de Volt deben estar registradas en el compilador, estando a disposición en tiempo de compilación:

```php
<?php

// Registrar la extensión en el compilador
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

Establecer un número específico de segundos:

```twig
{% raw %}
{# cache the sidebar by 1 hour #}
{% cache 'sidebar' 3600 %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
{% endraw %}
```

Cualquier expresión válida puede utilizarse como clave del caché:

```twig
{% raw %}
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
{% endraw %}
```

El almacenamiento en caché lo realiza el componente `Phalcon\Cache` mediante el componente de la vista. Learn more about how this integration works in the section [Caching View Fragments](/3.4/en/views#caching-fragments).

<a name='services-in-templates'></a>

## Inyectar servicios en una plantilla

Si un contenedor de servicio (DI) está disponible para Volt, puede usar los servicios accediendo solamente el nombre del servicio en la plantilla:

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

A continuación demostramos como utilizar Volt en modo independiente:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

// Crear un compilador
$compiler = new VoltCompiler();

// Opcionalmente agregar algunas opciones
$compiler->setOptions(
    [
        // ...
    ]
);

// Compilar la cadena de la plantilla, retornando código PHP
echo $compiler->compileString(
    "{{ 'hola' }}"
);

// Compilar una plantilla en un archivo, especificando su destino
$compiler->compileFile(
    'layouts/main.volt',
    'cache/layouts/main.volt.php'
);

// Compilar una plantillas en un archivo, basando en las opciones pasadas en el compilador
$compiler->compile(
    'layouts/main.volt'
);

// Requerir la plantilla compilada (opcional)
require $compiler->getCompiledTemplatePath();
```

## Recursos externos

* Un paquete para Sublime/Textmate está disponible [aquí](https://github.com/phalcon/volt-sublime-textmate)
* [Álbum-O-Rama](https://album-o-rama.phalconphp.com) es una aplicación de ejemplo que usa Volt como motor de la plantilla, [código fuente en Github](https://github.com/phalcon/album-o-rama)
* [Nuestro sitio web](https://phalconphp.com) se ejecuta usando Volt como motor de la plantilla, [código fuente en Github](https://github.com/phalcon/website)
* [Phosphorum](https://forum.phalconphp.com), el foro de Phalcon, también utiliza Volt, [código fuente en Github](https://github.com/phalcon/forum)
* [Vökuró](https://vokuro.phalconphp.com), es otra aplicación de ejemplo que utiliza Volt, [ódigo de ejemplo en Github](https://github.com/phalcon/vokuro)