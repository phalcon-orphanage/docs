---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#mvc'
title: 'Volt: Motor de plantillas'
keywords: 'volt, motor de plantillas, generación php, datos de vista'
---

# Volt: Motor de plantillas
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Volt es un motor de plantillas ultrarrápido y de diseño amigable, escrito en C para PHP. Ofrece un conjunto de ayudantes para escribir las vistas fácilmente. Volt is highly integrated with other components of Phalcon, but can be used as a stand-alone component in your application.

![](/assets/images/content/views-volt.png)

Volt is inspired by [Jinja][jinja], originally created by [Armin Ronacher][armin].

Muchos desarrolladores estarán en territorio familiar al utilizar la misma sintaxis que han estado utilizando con motores de plantillas similares. La sintaxis y características de Volt se han mejorado con más elementos y, por supuesto, con el rendimiento al que los desarrolladores han estado acostumbrados mientras trabajan con Phalcon.

## Sintaxis
Las vistas de Volt se compilan a código PHP puro, así que, básicamente ahorran el esfuerzo de escribir el código PHP manualmente:

```twig
{% raw %}
{% for invoice in invoices %}
<div class='row'>
    <div>
        ID: {{ invoice.inv_id }}
    </div>
    <div>
        {%- if 1 === invoice.inv_status_flag -%}
        Paid
        {%- else -%}
        Unpaid
        {%- endif -%}
    </div>
    <div>
        {{ invoice.inv_description }}
    </div>
    <div>
        {{ invoice.inv_total }}
    </div>
</div>
{% endfor %}{% endraw %}
```

comparado con:

```php
<?php foreach ($invoices as $invoice) { ?>
<div class='row'>
    <div>
        ID: <?= $invoice->inv_id; ?>
    </div>
    <div>
        <?php if (1 === $invoice->inv_status_flag) { ?>
        Paid
        <?php } else { ?>
        Unpaid
        <?php } ?>
    </div>
    <div>
        <?= $invoice->inv_description; ?>
    </div>
    <div>
        <?= $invoice->total; ?>
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

El constructor acepta un [Phalcon\Mvc\View](views) o cualquier componente que implemente la `ViewBaseInterface`, y un contenedor DI.

## Métodos
Hay varios métodos disponibles en Volt. En la mayoría de los casos, sólo un puñado de ellos se utilizan en aplicaciones modernas.

```php
callMacro(string $name, array $arguments = []): mixed
```

Comprueba si una macro está definida y la llama

```php
convertEncoding(string $text, string $from, string $to): string
```

Realiza una conversión cadena

```php
getCompiler(): Compiler
```

Devuelve el compilador del Volt

```php
getContent(): string
```

Devuelve la salida almacenada en caché en otra etapa de visualización

```php
getOptions(): array
```

Obtener las opciones de Volt

```php
getView(): ViewBaseInterface
```

Devuelve el componente de vista relacionados con el adaptador

```php
isIncluded(mixed $needle, mixed $haystack): bool
```

Comprueba si se incluye la aguja en el pajar

```php
length(mixed $item): int
```

Filtro de longitud. Si se pasa un objeto o matriz se realiza un `count()`, de lo contrario realiza un `strlen()<code>/`mb_strlen()</code>

```php
partial(string $partialPath, mixed $params = null): string
```

Representa una vista parcial dentro de otro punto de vista

```php
render(string $templatePath, mixed $params, bool $mustClean = false)
```

Renderiza una vista utilizando el motor de plantillas

```php
setOptions(array $options)
```

Establecer las opciones del Volt

```php
slice(mixed $value, int $start = 0, mixed $end = null)
```

Extrae un trozo de un valor de un string/array/objecto iterable

```php
sort(array $value): array
```

Ordena una matriz

## Activación
Como con otros motores de plantillas, se puede registrar Volt en el componente de la vista, usando una nueva extensión o reusar el estándar `phtml`:

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

Para utilizar la extensión estándar `phtml`:

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

use Phalcon\Mvc\View\Engine\Volt;


$view->registerEngines(
    [
        '.volt' => Volt::class,
    ]
);
```

Si no quieres reutilizar Volt como un servicio, puedes pasar una función anónima para registrar el motor en lugar de un nombre de servicio:

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

Las siguientes opciones están disponibles en Volt:

| Opción       | Predeterminado | Descripción                                                                                                                          |
| ------------ | -------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| `autoescape` | `false`        | Habilita el autoescape HTML globalmente                                                                                              |
| `always`     | `false`        | Si se deben compilar las plantillas en cada petición o cuando cambian                                                                |
| `extension`  | `.php`         | Extensión adicional añadida al fichero PHP compilado                                                                                 |
| `path`       | `./`           | Una ruta escribible donde se colocarán las plantillas PHP compiladas                                                                 |
| `separator`  | `%%`           | Sustituye los separadores de directorio `/` and `\` con este separador para poder crear un único fichero en el directorio compilado |
| `prefix`     | `null`         | Antepone un prefijo a las plantillas en la ruta de compilación                                                                       |
| `stat`       | `true`         | Si Phalcon debe comprobar si hay diferencias entre el fichero de plantilla y su ruta compilada                                       |


La ruta de compilación se genera de acuerdo a las opciones anteriores. Sin embargo, tiene total libertad para definir la ruta de compilación como una función anónima, incluyendo la lógica usada para generarla. The anonymous function receives the relative path to the template in the predefined `views` directory.

**Añadir extensiones**

Añadir la extensión `.php` a la ruta de plantilla, dejando las plantillas compiladas en el mismo directorio:

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

**Directorios diferentes**

El siguiente ejemplo creará la misma estructura en directorios diferentes

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

## Uso
Volt usa delimitadores específicos para su sintaxis. `{%- raw -%}{% ... %}{% endraw %}` is used to execute statements such as for-loops or assign values and `{%- raw -%}{{ ... }}{% endraw %}` prints the result of an expression to the template. Los ficheros de vistas también pueden contener PHP y HTML si así lo desea.

Abajo se muestra un ejemplo de plantilla que ilustra unos pocos conceptos básicos:

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
</html>
{% endraw %}
```

Using [Phalcon\Mvc\View](views) you can pass variables from the controller to the views. En el ejemplo anterior, se pasaron cuatro variables a la vista: `showNavigation`, `menu`, `title` y `post`:

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

> **NOTE** The placeholders for Volt `{% raw %}{{{% endraw %}`, `{% raw %}}}{% endraw %}`, `{% raw %}{%{% endraw %}` and `{% raw %}%}{% endraw %}` cannot be changed or set. 
> 
> {: .alert .alert-warning }

### Vue.js
If you are using [Vue][vue] you will need to change the interpolators in Vue itself:

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
If you are using [Angular][angular] you can set the interpolators as follows:

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
Las variables de objetos pueden tener atributos, que se pueden acceder utilizando la sintaxis: `foo.bar`. Si usted está pasando un array, tiene que usar la sintaxis de corchete: `foo ['bar']`

```twig
{%- raw -%}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
{% endraw %}
```

## Filtros
Las variables pueden ser formateadas o modificación mediante filtros. El operador de tubería o pleca `|` se utiliza para aplicar filtros a las variables:

```twig
{%- raw -%}
{{ post.title | e }}
{{ post.content | striptags }}
{{ name | capitalize | trim }}
{% endraw %}
```

Los filtros incorporados disponibles son:

| Filtro             | Descripción                                                                                                              |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------ |
| `abs`              | Applies the [`abs`][abs] PHP function to a value.                                                                        |
| `capitalize`       | Capitalizes a string by applying the [`ucwords`][ucwords] PHP function to the value                                      |
| `convert_encoding` | Convierte una cadena de un conjunto de caracteres a otro                                                                 |
| `default`          | Establece un valor por defecto en caso de que la expresión evaluada esté vacía, no establecida o evalúa a un valor falso |
| `e`                | Applies [`Phalcon\Html\Escaper->html()`][escaper] to the value                                                      |
| `escape`           | Applies [`Phalcon\Html\Escaper->html()`][escaper] to the value                                                      |
| `escape_attr`      | Applies [`Phalcon\Html\Escaper->attributes()`][escaper] to the value                                                |
| `escape_css`       | Applies [`Phalcon\Html\Escaper->css()`][escaper] to the value                                                       |
| `escape_js`        | Applies [`Phalcon\Html\Escaper->js()`][escaper] to the value                                                        |
| `format`           | Formats a string using [`sprintf`][sprintf]                                                                              |
| `json_encode`      | Converts a value into its [JSON][json] representation                                                                    |
| `json_decode`      | Converts a value from its [JSON][json] representation to a PHP representation                                            |
| `join`             | Joins the array parts using a separator [`join`][join]                                                                   |
| `keys`             | Returns the array keys using [`array_keys`][array_keys]                                                                  |
| `left_trim`        | Applies the [`ltrim`][ltrim] PHP function to the value. Elimina los espacios extra                                       |
| `length`           | Counts the string length or how many items are in an array or object, equivalent of [`count`][count]                     |
| `lower`            | Cambiar una cadena a minúsculas                                                                                          |
| `nl2br`            | Cambia nuevas líneas `\n` por roturas de línea (`<br />`). Uses the PHP function [`nl2br`][nl2br]                 |
| `right_trim`       | Applies the [`rtrim`][rtrim] PHP function to the value. Elimina los espacios extra                                       |
| `slashes`          | Applies the [`addslashes`][addslashes] PHP function to the value.                                                        |
| `slice`            | Corta cadenas, vectores u objetos atravesables                                                                           |
| `sort`             | Sorts an array using the PHP function [`asort`][asort]                                                                   |
| `stripslashes`     | Applies the [`stripslashes`][stripslashes] PHP function to the value. Elimina comillas escapadas                         |
| `striptags`        | Applies the [`striptags`][striptags] PHP function to the value. Elimina etiquetas HTML                                   |
| `trim`             | Applies the [`trim`][trim] PHP function to the value. Elimina los espacios extra                                         |
| `upper`            | Applies the [`strtoupper`][strtoupper] PHP function to the value.                                                        |
| `url_encode`       | Applies the [`urlencode`][urlencode] PHP function to the value                                                           |

**Ejemplos**

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

## Comentarios
Comments may also be added to a template using the `{%- raw -%}{# ... #}{% endraw %}` delimiters. Todo el texto entre ellos simplemente se ignorará en la salida final:

```twig
{%- raw -%}
{# note: this is a comment
    {% set price = 100; %}
#}
{% endraw %}
```

## Estructuras de Control
Volt proporciona un conjunto de estructuras de control básicas pero poderosas para usar en las plantillas:

### For
Itera sobre cada elemento de una secuencia. El ejemplo siguiente muestra cómo recorrer un conjunto de `invoices` y mostrar cada título:

```twig
{%- raw -%}
<h1>Invoices</h1>
<ul>
    {% for invoice in invoices %}
    <li>
        {{ invoice.inv_title | e }}
    </li>
    {% endfor %}
</ul>
{% endraw %}
```

los bucles-for también se pueden anidar:

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

Puede obtener el elemento `keys` como en la homóloga en PHP usando la siguiente sintaxis:

```twig
{%- raw -%}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }} <br />
{% endfor %}
{% endraw %}
```

Se puede establecer opcionalmente una evaluación `if`:

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

Si se define un `else` dentro del `for`, se ejecutará si la expresión en el iterador resulta en cero iteraciones:

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

Sintaxis alternativa:

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

### Bucles
Las declaraciones de `break` y `continue` pueden utilizarse para salir de un bucle o forzar una iteración en el bloque actual:

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
Como en PHP, una declaración `if` comprueba si una expresión se evalúa como verdadera o falsa:

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

También se admite la cláusula `else`:

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

La estructura de flujo de control `elseif` se puede usar junto con `if` para emular un bloque `switch`:

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
Una alternativa a la sentencia `if` es `switch`, que le permite crear rutas de ejecución lógicas en su aplicación:

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

La sentencia `switch` ejecuta sentencia a sentencia, por lo que la sentencia `break` es necesaria en algunos casos. Cualquier salida (incluyendo espacios) entre una sentencia en blanco y el primer `case` resultará en error de sintaxis. Empty lines and whitespaces can therefore be cleared to reduce the number of errors [see here][control_structures].

**`case` sin `switch`**
```twig
{%- raw -%}
{% case EXPRESSION %}
{% endraw %}
```

Lanzará `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

**`switch` sin `endswitch`**
```twig
{%- raw -%}
{% switch EXPRESSION %}
{% endraw %}
```

Lanzará `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.

**`default` sin `switch`**
```twig
{%- raw -%}
{% default %}
{% endraw %}
```
No lanzará un error porque `default` es una palabra reservada para filtros como `{%- raw -%}{{ EXPRESSION | default(VALUE) }}{% endraw %}` pero en este caso la expresión solo mostrará un caracter vacío `''`.

**`switch` anidado**
```twig
{%- raw -%}
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
{% endraw %}
```

Lanzará `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

**un `switch` sin una expresión**
```twig
{%- raw -%}
{% switch %}
  {% case EXPRESSION %}
      {% break %}
{% endswitch %}
{% endraw %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected token {%- raw -%}%}{% endraw %} in ... on line ...`

### Contexto de Bucle
Una variable especial está disponible dentro de bucles `for` para proporcionarle información sobre

| Variable         | Descripción                                                    |
| ---------------- | -------------------------------------------------------------- |
| `loop.first`     | Verdadero si es la primera iteración.                          |
| `loop.index`     | La iteración actual del bucle. (indexado 1)                    |
| `loop.index0`    | La iteración actual del bucle. (indexado 0)                    |
| `loop.length`    | El número de elementos a iterar                                |
| `loop.last`      | Verdadero si está en la última iteración.                      |
| `loop.revindex`  | El número de iteraciones desde el final del bucle (indexado 1) |
| `loop.revindex0` | El número de iteraciones desde el final del bucle (indexado 0) |

Ejemplo:

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
                <td>{{ invoice.inv_title }}</td>
            </tr>
    {% if loop.last %}
        </table>
    {% endif %}
{% endfor %}
{% endraw %}
```

## Asignaciones
Las variables pueden cambiar en una plantilla usando la instrucción `set`:

```twig
{%- raw -%}
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set title = invoice.inv_title %}
{% endraw %}
```

Se permiten las asignaciones múltiples en la misma instrucción:

```twig
{%- raw -%}
{% set fruits = ['Apple', 'Banana', 'Orange'], name = invoice.inv_title, active = true %}
{% endraw %}
```

Además, puede usar operaciones de asignación compuestos:

```twig
{%- raw -%}
{% set price += 100.00 %}

{% set age *= 5 %}
{% endraw %}
```

Los siguientes operadores están disponibles:

| Operador | Descripción                  |
|:--------:| ---------------------------- |
|   `=`    | Asignación estándar          |
|   `+=`   | Asignación de adición        |
|   `-=`   | Asignación de resta          |
| `\*=`  | Asignación de multiplicación |
|   `/=`   | Asignación de división       |

## Expresiones
Volt proporciona un conjunto básico de expresiones, incluyendo literales y operadores comunes. An expression can be evaluated and printed using the `{%- raw -%}{{{% endraw %}` and `{%- raw -%}}}{% endraw %}` delimiters:

```twig
{%- raw -%}
{{ (1 + 1) * 2 }}
{% endraw %}
```

Si una expresión necesita ser evaluada sin imprimirse se puede usar la sentencia `do`:

```twig
{%- raw -%}
{% do (1 + 1) * 2 %}
{% endraw %}
```

### Literales
Se soportan los siguientes literales:

| Filtro                 | Descripción                                                                           |
| ---------------------- | ------------------------------------------------------------------------------------- |
| `'esto es una cadena'` | Los textos entre doble comillas simples o dobles se tratan como cadenas de caracteres |
| `100.25`               | Los números con parte decimal se tratan como dobles/flotadores                        |
| `100`                  | Los número sin parte decimal se tratan como enteros                                   |
| `false`                | La constante `false` es el valor booleano `false`                                     |
| `true`                 | La constante `true` es el valor booleano `true`                                       |
| `null`                 | La constante `null` es el valor `null`                                                |

### Vectores
Puede crear vectores encerrando una lista de valores entre corchetes cuadrados:

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

Las llaves también se usan para definir vectores o `hashes`:

```twig
{%- raw -%}
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
{% endraw %}
```

### Matemáticas
Puede hacer cálculos en las plantillas usando los siguientes operadores:

| Operador | Descripción                                                                              |
|:--------:| ---------------------------------------------------------------------------------------- |
|   `+`    | Realiza una operación de suma. `{%- raw -%}{{ 2 + 3 }}{% endraw %}` devuelve 5           |
|   `-`    | Realiza una operación de resta `{%- raw -%}{{ 2 - 3 }}{% endraw %}` devuelve -1          |
|   `*`    | Realiza una operación de multiplicación `{%- raw -%}{{ 2 * 3 }}{% endraw %}` devuelve 6  |
|   `/`    | Realiza una operación de división `{%- raw -%}{{ 10 / 2 }}{% endraw %}` devuelve 5       |
|   `%`    | Calcula el resto de una división entera `{%- raw -%}{{ 10 % 3 }}{% endraw %}` devuelve 1 |

### Comparaciones
Están disponibles los siguientes operadores de comparación:

|  Operador  | Descripción                                                                       |
|:----------:| --------------------------------------------------------------------------------- |
|    `==`    | Comprueba si ambos operandos son iguales                                          |
|    `!=`    | Comprueba si ambos operandos no son iguales                                       |
| `<>` | Comprueba si ambos operandos no son iguales                                       |
|   `>`   | Comprueba si el operando izquierdo es mayor que el operando derecho               |
|   `<`   | Comprueba si el operando izquierdo es menor que el operando derecho               |
|  `<=`   | Comprueba si el operando de la izquierda es menor o igual que el operando derecho |
|  `>=`   | Comprueba si el operando izquierdo es mayor o igual que el operando derecho       |
|   `===`    | Comprueba si ambos operandos son idénticos                                        |
|   `!==`    | Comprueba si ambos operandos no son idénticos                                     |

### Lógica
Los operadores lógicos son útiles en la evaluación de la expresión `if` para combinar múltiples pruebas:

|  Operador  | Descripción                                                                   |
|:----------:| ----------------------------------------------------------------------------- |
|    `o`     | Devuelve true si el operando de la derecha o la izquierda se evalúa como true |
|   `and`    | Devuelve true si los operandos izquierdo y derecho se evalúan como verdadero  |
|   `not`    | Niega una expresión                                                           |
| `( expr )` | Las expresiones se agrupan entre paréntesis                                   |

### Otros operadores
También están disponibles otros operadores:

| Operador                  | Descripción                                                                                |
| ------------------------- | ------------------------------------------------------------------------------------------ |
| `~`                       | Concatena ambos operandos `{%- raw -%}{{ 'hello ' ~ 'world' }}{% endraw %}`                |
| <code>&#124;</code> | Applies a filter in the right operand to the left <code>{%- raw -%}{{ 'hello' &#124; uppercase }}{% endraw %}</code>                 |
| `..`                      | Crea un rango `{%- raw -%}{{ 'a'..'z' }}{% endraw %}` `{%- raw -%}{{ 1..10 }}{% endraw %}` |
| `is`                      | Alias de == (igual), también realiza pruebas                                               |
| `in`                      | Para comprobar si una expresión está contenida en otras expresiones `if 'a' in 'abc'`      |
| `is not`                  | Alias de != (no iguales)                                                                   |
| `'a' ? 'b' : 'c'`         | Operador ternario. El mismo que el operador ternario de PHP                                |
| `++`                      | Incrementa un valor                                                                        |
| `--`                      | Decrementa un valor                                                                        |

El ejemplo siguiente muestra cómo usar los operadores:

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

## Pruebas
Las pruebas de pueden usar para comprobar si una variable tiene un valor esperado válido. Se usa el operador `is` para realizar las pruebas:

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

Están disponibles las siguientes pruebas integradas en Volt:

| Prueba        | Descripción                                                                  |
| ------------- | ---------------------------------------------------------------------------- |
| `defined`     | Comprueba si una variable esta definida (`isset()`)                          |
| `divisibleby` | Comprueba si un valor es divisible por otro valor                            |
| `empty`       | Comprueba si una variable está vacía                                         |
| `even`        | Comprueba si un valor numérico es par                                        |
| `iterable`    | Comprueba si un valor es iterable. Se puede recorrer con una sentencia 'for' |
| `numeric`     | Comprueba si el valor es numérico                                            |
| `odd`         | Comprueba si un valor numérico es impar                                      |
| `sameas`      | Comprueba si un valor es idéntico a otro valor                               |
| `scalar`      | Comprueba si el valor es escalar (no una matriz, objeto o recurso)           |
| `type`        | Comprueba si un valor es del tipo especificado                               |

Más ejemplos:

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
Las macros pueden utilizarse para reutilizar la lógica de una plantilla, actúan como funciones PHP, pueden recibir parámetros y devolver valores:

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

Al llamar a las macros, se pueden pasar parámetros por nombre:

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
        'message': 'The name is not valid', 
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

Y recibir parámetros opcionales:

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

## Ayudantes de Etiquetas
Volt is highly integrated with [Phalcon\Html\TagFactory](html-tagfactory), so it's easy to use the helpers provided by that component in a Volt template:

```twig
{%- raw -%}
{{ script().add('js/jquery.js') }}

{{ form(['action' => 'products/save', 'method': 'post']) }}

    <label for='name'>Name</label>
    {{ inputText('name', null, ['size': 32]) }}

    <label for='type'>Type</label>
    {% for productType in productTypes }}
    {{ inputSelect().addPlaceholder('...').add(productType.name, productType.id) }}
    {% endfor %}

    {{ inputSubmit('Send') }}

{{ close('form') }}
{% endraw %}
```

Se genera el siguiente PHP:

```php
<?= $this->tag->script("\t", "\n\n") ?>

<?= $this->tag->form(['products/save', 'method' => 'post']); ?>

    <label for='name'>Name</label>
    <?= $this->tag->inputText(['name', 'size' => 32]); ?>

    <label for='type'>Type</label>
    <?php foreach ($productTypes as $productType) { ?>
    <?= $this->tag->addPlaceholder('...').add(productType.name, productType.id); ?>
    <?php } ?>

    <?= $this->tag->inputSubmit('Send'); ?>

<?= $this->tag->close('form'); ?>
```

You can call any of the helpers that [Phalcon\Html\TagFactory](html-tagfactory) provides directly in Volt.

| Volt Function        | Clase                                         |
| -------------------- | --------------------------------------------- |
| `a`                  | `Phalcon\Html\Helper\Anchor`               |
| `base`               | `Phalcon\Html\Helper\Base`                 |
| `body`               | `Phalcon\Html\Helper\Body`                 |
| `button`             | `Phalcon\Html\Helper\Button`               |
| `close`              | `Phalcon\Html\Helper\Close`                |
| `doctype`            | `Phalcon\Html\Helper\Doctype`              |
| `element`            | `Phalcon\Html\Helper\Element`              |
| `form`               | `Phalcon\Html\Helper\Form`                 |
| `img`                | `Phalcon\Html\Helper\Img`                  |
| `inputCheckbox`      | `Phalcon\Html\Helper\Input\Checkbox`      |
| `inputColor`         | `Phalcon\Html\Helper\Input\Color`         |
| `inputDate`          | `Phalcon\Html\Helper\Input\Date`          |
| `inputDateTime`      | `Phalcon\Html\Helper\Input\DateTime`      |
| `inputDateTimeLocal` | `Phalcon\Html\Helper\Input\DateTimeLocal` |
| `inputEmail`         | `Phalcon\Html\Helper\Input\Email`         |
| `inputFile`          | `Phalcon\Html\Helper\Input\File`          |
| `inputHidden`        | `Phalcon\Html\Helper\Input\Hidden`        |
| `inputImage`         | `Phalcon\Html\Helper\Input\Image`         |
| `inputInput`         | `Phalcon\Html\Helper\Input\Input`         |
| `inputMonth`         | `Phalcon\Html\Helper\Input\Month`         |
| `inputNumeric`       | `Phalcon\Html\Helper\Input\Numeric`       |
| `inputPassword`      | `Phalcon\Html\Helper\Input\Password`      |
| `inputRadio`         | `Phalcon\Html\Helper\Input\Radio`         |
| `inputRange`         | `Phalcon\Html\Helper\Input\Range`         |
| `inputSearch`        | `Phalcon\Html\Helper\Input\Search`        |
| `inputSelect`        | `Phalcon\Html\Helper\Input\Select`        |
| `inputSubmit`        | `Phalcon\Html\Helper\Input\Submit`        |
| `inputTel`           | `Phalcon\Html\Helper\Input\Tel`           |
| `inputText`          | `Phalcon\Html\Helper\Input\Text`          |
| `inputTextarea`      | `Phalcon\Html\Helper\Input\Textarea`      |
| `inputTime`          | `Phalcon\Html\Helper\Input\Time`          |
| `inputUrl`           | `Phalcon\Html\Helper\Input\Url`           |
| `inputWeek`          | `Phalcon\Html\Helper\Input\Week`          |
| `label`              | `Phalcon\Html\Helper\Label`                |
| `link`               | `Phalcon\Html\Helper\Link`                 |
| `meta`               | `Phalcon\Html\Helper\Meta`                 |
| `ol`                 | `Phalcon\Html\Helper\Ol`                   |
| `script`             | `Phalcon\Html\Helper\Script`               |
| `style`              | `Phalcon\Html\Helper\Style`                |
| `title`              | `Phalcon\Html\Helper\Title`                |
| `ul`                 | `Phalcon\Html\Helper\Ul`                   |

Also, you can use the [Phalcon\Tag](api/phalcon_tag) helper methods. You only need to call an uncamelized version of the method:

| Función en Volt      | Método                            |
| -------------------- | --------------------------------- |
| `check_field`        | `Phalcon\Tag::checkField`        |
| `date_field`         | `Phalcon\Tag::dateField`         |
| `email_field`        | `Phalcon\Tag::emailField`        |
| `end_form`           | `Phalcon\Tag::endForm`           |
| `file_field`         | `Phalcon\Tag::fileField`         |
| `form_legacy`        | `Phalcon\Tag::form`              |
| `friendly_title`     | `Phalcon\Tag::friendlyTitle`     |
| `get_title`          | `Phalcon\Tag::getTitle`          |
| `hidden_field`       | `Phalcon\Tag::hiddenField`       |
| `image`              | `Phalcon\Tag::image`             |
| `javascript_include` | `Phalcon\Tag::javascriptInclude` |
| `link_to`            | `Phalcon\Tag::linkTo`            |
| `numeric_field`      | `Phalcon\Tag::numericField`      |
| `password_field`     | `Phalcon\Tag::passwordField`     |
| `radio_field`        | `Phalcon\Tag::radioField`        |
| `select`             | `Phalcon\Tag::select`            |
| `select_static`      | `Phalcon\Tag::selectStatic`      |
| `stylesheet_link`    | `Phalcon\Tag::stylesheetLink`    |
| `submit_button`      | `Phalcon\Tag::submitButton`      |
| `text_area`          | `Phalcon\Tag::textArea`          |
| `text_field`         | `Phalcon\Tag::textField`         |

## Funciones
Las siguientes funciones integradas están disponibles en Volt:

| Nombre        | Descripción                                                        |
| ------------- | ------------------------------------------------------------------ |
| `constant`    | Lee una constante PHP                                              |
| `content`     | Incluye el contenido producido en la etapa de renderizado anterior |
| `date`        | Llama a la función PHP con el mismo nombre                         |
| `dump`        | Llama a la función PHP `var_dump()`                                |
| `get_content` | Lo mismo que `content`                                             |
| `partial`     | Dinámicamente carga una vista parcial en la plantilla actual       |
| `static_url`  | Genera una url estática usando el servicio `url`                   |
| `super`       | Renderiza el contenido del bloque padre                            |
| `time`        | Llama a la función PHP con el mismo nombre                         |
| `url`         | Genera una URL usando el servicio `url`                            |
| `version`     | Devuelve la versión actual del framework                           |
| `version_id`  | Devuelve el ID de la versión actual del framework                  |

## Vistas
Also, Volt is integrated with [Phalcon\Mvc\View](views), you can play with the view hierarchy and include partials as well:

```twig
{%- raw -%}
{{ content() }}

<div id='footer'>
    {{ partial('partials/footer') }}
    {{ partial('partials/footer', ['links': links]) }}
</div>
{% endraw %}
```

Una vista parcial es incluida en tiempo de ejecución, Volt también proporciona `include`, esto compila el contenido de una vista y devuelve su contenido como parte de la vista en el que se incluye:

```twig
{%- raw -%}
<div id='footer'>
    {% include 'partials/footer' %}
    {% include 'partials/footer' with ['links': links] %}
</div>
{% endraw %}
```

### Incluir
`include` has a special behavior that will help us improve performance a bit when using Volt, if you specify the extension when including the file, and it exists when the template is compiled, Volt can inline the contents of the template in the parent template where it's included. Las plantillas no se incrustarán si el `include` tiene variables pasadas con `with`:

```twig
{%- raw -%}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
{% endraw %}
```

### Parcial Vs Incluir
Tenga los siguientes puntos en mente cuando elija usar la función `partial` o `include`:

| Tipo      | Descripción                                                                                                                                                                                                                                                                      |
| --------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `partial` | le permite incluir plantillas hechas en Volt y en otros motores de plantillas. También permite pasar de una expresión como una variable permitiendo incluir el contenido de otra vista dinámicamente. Es mejor si el contenido que usted tiene que incluir cambia con frecuencia |
| `include` | copia el contenido compilado en la vista, mejorando el rendimiento. Sólo permite incluir plantillas creadas con Volt. Requiere de una plantilla existente en tiempo de compilación                                                                                               |

## Herencia
Con la herencia de plantillas puede crear plantillas base que pueden ser extendidas por otras plantillas, permitiéndole reutilizar código. A base template define *blocks* than can be overridden by a child template. Supongamos que tenemos la siguiente plantilla base:

```twig
{%- raw -%}
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
            {% block footer %}
                &copy; Copyright 2012-present. 
                All rights reserved.
            {% endblock %}
        </div>
    </body>
</html>
{% endraw %}
```

Desde otra plantilla podríamos extender la plantilla base reemplazando los bloques:

```twig
{%- raw -%}
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style>.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class='important'>Welcome on my awesome homepage.</p>
{% endblock %}
{% endraw %}
```

No todos los bloques deben ser reemplazados en la plantilla hija, sólo aquellos que lo necesiten. La salida final producida será la siguiente:

```html
<!DOCTYPE html>
<html>
    <head>
        <style>.important { color: #336699; }</style>

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

### Herencia múltiple
Las plantillas extendidas pueden extender otras plantillas. El ejemplo siguiente ilustra esto:

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

La plantilla `layout.volt` extiende `main.volt`

```twig
{%- raw -%}
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
{% endraw %}
```

Finally, a view that extends `layout.volt`:

```twig
{%- raw -%}
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

Al renderizar `index.volt` produce:

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

Fíjese en la llamada a la función `super()`. Con esa función es posible renderizar los contenidos del bloque padre. Como parciales, la ruta establecida en `extends` es una ruta relativa bajo el directorio actual de vistas (ej. `app/views/`).

> **NOTE**: By default, and for performance reasons, Volt only checks for changes in the children templates to know when to re-compile to plain PHP again, so it is recommended initialize Volt with the option `'always' => true`. Así, las plantillas se compilan siempre teniendo en cuenta los cambios en las plantillas padre. 
> 
> {: .alert .alert-warning }

## Modo Autoescape
Puede habilitar el autoescape de todas las variables impresas en un bloque usando el modo autoescape:

```twig
{%- raw -%}
Manually escaped: {{ invoice.inv_title|e }}

{% autoescape true %}
    Autoescaped: {{ invoice.inv_title }}
    {% autoescape false %}
        No Autoescaped: {{ invoice.inv_title }}
    {% endautoescape %}
{% endautoescape %}
{% endraw %}
```

## Extender Volt
A diferencia de otros motores de plantillas, Volt en sí mismo no está obligado a ejecutar las plantillas compiladas. Una vez que se compilan las plantillas no hay ninguna dependencia con Volt. Con independencia del rendimiento en mente, Volt sólo actúa como un compilador de plantillas PHP.

El compilador de Volt permite ser ampliado, añadiéndole más funciones, tests o filtros a los ya existentes.

### Funciones
Las funciones actúan como funciones normales de PHP, un nombre de cadena válida se requiere como nombre de la función. Las funciones se pueden agregar mediante dos opciones, retornando una cadena simple o utilizando una función anónima. Cualquiera que sea la opción que utilice, debe devolver una expresión de cadena de texto PHP válida.

El siguiente ejemplo vincula el nombre de función `shuffle` en Volt a la función PHP `str_shuffle`:
```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $container);

$compiler = $volt->getCompiler();

$compiler->addFunction('shuffle', 'str_shuffle');
```

y en Volt:

```twig
{% raw %}{{ shuffle('abcdefg') }}{% endraw %}
```

El ejemplo a continuación registra la función con una función anónima. Aquí usamos `$resolvedArgs` para pasar los argumentos exactamente al llamar al método desde la vista:

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

y en Volt:

```twig
{% raw %}{{ widget('param1', 'param2') }}{% endraw %}
```

También puede tratar los argumentos de forma independiente y también comprobar si hay parámetros sin resolver. En el ejemplo siguiente, recuperamos el primer parámetro y luego comprobamos la existencia de un segundo parámetro. Si está presente, lo almacenamos, de lo contrario usaremos el valor predeterminado `10`. Finally, we call the `str_repeat` PHP method on the first and second parameter.

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

y en Volt:

```twig
{% raw %}{{ repeat('Apples', 'Oranges') }}{% endraw %}
```

También puede comprobar la disponibilidad de funciones en su sistema y llamarlas si está presente. En el siguiente ejemplo llamaremos a `mb_stripos` si la extensión `mbstring` está presente. Si está presente, entonces `mb_stripos` será llamado, de lo contrario `stripos`:

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

También puede sobreescribir funciones integradas usando el mismo nombre en la función definida. In the example below, we _replace_ the built-in Volt function `dump()` with PHP's `print_r`.

```php
<?php

$compiler->addFunction('dump', 'print_r');
```

### Filtros
Un filtro tiene la siguiente forma en una plantilla: `leftExpr|name(optional-args)`. Agregar nuevos filtros es similar a lo visto en las funciones.

Añadir un nuevo filtro llamado `hash` usando el método `sha1`:

```php
<?php

$compiler->addFilter('hash', 'sha1');
```

Añade un nuevo filtro llamado `int`:

```php
<?php

$compiler->addFilter(
    'int',
    function ($resolvedArgs, $exprArgs) {
        return 'intval(' . $resolvedArgs . ')';
    }
);
```

Los filtros incorporados se pueden reemplazar agregando una función con el mismo nombre. The example below will replace the built-in `capitalize` filter with PHP's [lcfirst][lcfirst] function:

```php
<?php

$compiler->addFilter('capitalize', 'lcfirst');
```

### Extensiones
Con las extensiones, el desarrollador tiene más flexibilidad para extender el motor de plantillas, y sobreescribir la compilación de instrucciones, cambiar el comportamiento de una expresión u operador, añadir funciones/filtros, y más.

Una extensión es una clase que implementa los eventos disparados por Volt como un método de sí mismo. Por ejemplo, la clase siguiente permite usar cualquier función PHP en Volt:

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

La clase anterior implementa el método `compileFunction` que se invoca antes de cualquier intento de compilar una llamada de función en cualquier plantilla. El propósito de la extensión es verificar si una función a compilar es una función PHP que permite llamar a la función PHP desde la plantilla. Los eventos en extensiones deben devolver código PHP válido, que se usará como resultado de la compilación en lugar del código generado por Volt. Si un evento no devuelve una cadena, la compilación se hace usando el comportamiento predeterminado proporcionado por el motor.

Las extensiones Volt se deben registrar en el compilador, haciéndolas disponibles en tiempo de compilación:

```php
<?php

use MyApp\View\Extensions\PhpFunctionExtension;

$compiler->addExtension(
    new PhpFunctionExtension()
);
```

### Compilador
El compilador Volt depende del analizador Volt. El analizador analiza las plantillas Volt y crea una Representación Intermedia (IR) de ellas. El compilador usa esa representación y produce el código PHP compilado.

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler;

$compiler = new Compiler();

$compiler->compile("views/partials/header.volt");

require $compiler->getCompiledTemplatePath();
```

The [Phalcon\Mvc\View\Engine\Volt\Compiler][mvc-view-engine-volt-compiler] offers a number of methods that can be extended to suit your application needs.

```php
public function __construct(ViewBaseInterface $view = null)
```
Constructor

```php
public function addExtension(mixed $extension): Compiler
```
Registra una extensión

```php
public function addFilter(
    string $name, 
    mixed definition
): Compiler
```
Registra un nuevo filtro

```php
public function addFunction(
    string $name, 
    mixed $definition
): Compiler
```
Registra una nueva función

```php
public function attributeReader(array $expr): string
```
Resuelve la lectura de atributos

```php
public function compile(
    string $templatePath, 
    bool $extendsMode = false
)
```
Compila una plantilla en un fichero aplicando las opciones del compilador. Este método no devuelve la ruta compilada si la plantilla no se compiló

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
Compila una sentencia "autoescape" devolviendo código PHP

```php
/**
 * @deprecated Will be removed in 5.0
 */
public function compileCache(
    array $statement, 
    bool $extendsMode = false
): string
```
(DEPRECATED) Compila una sentencia `cache` devolviendo código PHP

```php
public function compileCall(array $statement, bool $extendsMode)
```
Compila llamadas a macros

```php
public function compileCase(
    array $statement, 
    bool $caseClause = true
): string
```
Compila una cláusula `case`/`default` devolviendo código PHP

```php
public function compileDo(array $statement): string
```
Compila una sentencia `do` devolviendo código PHP

```php
public function compileEcho(array $statement): string
```
Compila una sentencia {% raw %}`{{` `}}`{% endraw %} devolviendo código PHP

```php
public function compileElseIf(array $statement): string
```
Compila una sentencia `elseif` devolviendo código PHP

```php
public function compileFile(
    string $path, 
    string $compiledPath, 
    bool $extendsMode = false
): string | array
```
Compila una plantilla en un fichero, también creando la ruta destino

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
Compila una sentencia `foreach` devolviendo código PHP

```php
public function compileForElse(): string
```
Compila una sentencia `forelse` devolviendo código PHP

```php
public function compileIf(
    array $statement, 
    bool $extendsMode = false
): string
```
Compila una sentencia `if` devolviendo código PHP

```php
public function compileInclude(array $statement): string
```
Compila una sentencia `include` devolviendo código PHP

```php
public function compileMacro(
    array $statement, 
    bool $extendsMode
): string
```
Compila una macro

```php
public function compileReturn(array $statement): string
```
Compila una sentencia `return` devolviendo código PHP

```php
public function compileSet(array $statement): string
```
Compila una sentencia *setter* (asignación de valor a variable) devolviendo código PHP

```php
public function compileString(
    string $viewCode, 
    bool $extendsMode = false
): string
```
Compila una plantilla en una cadena

```php
echo $compiler->compileString({% raw %}'{{ "hello world" }}'{% endraw %});
```

```php
public function compileSwitch(
    array $statement, 
    bool $extendsMode = false
): string
```
Compila una sentencia `switch` devolviendo código PHP

```php
final public function expression(array $expr): string
```
Resuelve un nodo de expresión en un árbol AST de Volt

```php
final public function fireExtensionEvent(
    string $name, 
    array $arguments = null
)
```

```php
public function functionCall(array $expr): string
```
Resuelve el código intermedio de funciones en llamadas a funciones PHP

```php
public function getCompiledTemplatePath(): string
```
Devuelve la ruta a la última plantilla compilada

```php
public function getExtensions(): array
```
Devuelve las extensiones registradas

```php
public function getFilters(): array
```
Devuelve los filtros de usuario registrados

```php
public function getFunctions(): array
```
Devuelve las funciones de usuario registradas

```php
public function getOption(string $option): string
```
Devuelve una opción del compilador

```php
public function getOptions(): array
```
Devuelve las opciones del compilador

```php
public function getTemplatePath(): string
```
Devuelve la ruta que está siendo compilada actualmente

```php
public function getUniquePrefix(): string
```
Devuelve un prefijo único a usar como prefijo de las variables y contextos compilados

```php
public function parse(string $viewCode): array
```
Analiza una plantilla Volt devolviendo su representación intermedia

```php
print_r(
    $compiler->parse("{% raw %}{{ 3 + 2 }}{% endraw %}")
);
```

```php
public function resolveTest(array $test, string $left): string
```
Resuelve el código intermedio de filtro en una expresión PHP válida

```php
public function setOption(string $option, mixed $value)
```
Establece una única opción del compilador

```php
public function setOptions(array $options)
```
Establece las opciones del compilador

```php
public function setUniquePrefix(string $prefix): Compiler
```
Establece un prefijo único a usar como prefijo de las variables compiladas

## Eventos
Están disponibles los siguientes [eventos](events) de compilación para ser implementados en extensiones:

| Evento/Método       | Descripción                                                                                                             |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| `compileFunction`   | Disparado antes de intentar compilar cualquier llamada de función en una plantilla                                      |
| `compileFilter`     | Disparado antes de intentar compilar ningún llamada de filtro en una plantilla                                          |
| `resolveExpression` | Disparado antes de intentar compilar ninguna expresión. Esto permite al desarrollador sobreescribir operadores          |
| `compileStatement`  | Disparado antes de intentar compilar ninguna sentencia. Esto permite al desarrollador sobreescribir cualquier sentencia |


## Servicios
Si un contenedor de servicios (DI) está disponible en Volt. Cualquier servicio registrado en el contendedor DI está disponible en Volt, con una variable del mismo nombre con el que está registrado el servicio. En el ejemplo siguiente usamos el servicio `flash`, así como `security`:

```twig
{%- raw -%}
<div id='messages'>{{ flash.output() }}</div>
<input type='hidden' name='token' value='{{ security.getToken() }}'>
{% endraw %}
```

## Independiente
Puede usar Volt como componente independiente en cualquier aplicación.

Registre el compilador y establezca algunas opciones:

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

Compilación de plantillas o cadenas:

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

Finalmente puede incluir la plantilla compilada si es necesario:

```php
<?php

require $compiler->getCompiledTemplatePath();
```

## Compilar
Cada vez que despliega su aplicación a producción, necesitará eliminar los ficheros `.volt` precompilados, para que se muestre cualquier cambio hecho en sus plantillas a los usuarios. Una forma muy fácil de hacer esto es limpiar la carpeta `volt/` usando un *script* CLI o eliminar manualmente todos los ficheros.

Si asumimos que su ruta `volt` se localiza en: `/app/storage/cache/volt/` entonces el siguiente *script* le permitirá limpiar esa carpeta cada vez lo ejecute, normalmente después de un despliegue.

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

In the example above, we use PHP's [RecursiveDirectoryIterator][recursivedirectoryiterator] and [RecursiveIteratorIterator][recursiveiteratoriterator] to iterate through a folder recursively and create a list of files in the `$fileList` array. After that, we iterate through that array and [unlink][unlink] each file in turn.

Como hemos mencionado antes, basado en las opciones proporcionadas durante la configuración, Volt puede comprobar si los ficheros compilados existen y generarlos en consecuencia. Adicionalmente, Volt puede comprobar si los ficheros han cambiado, y en caso afirmativo regenerarlos.

Estas comprobaciones se realizan cuando las opciones `always` y `stat` están establecidas a `true`. Para cualquier proyecto, comprobar el sistema de ficheros muchas veces por petición (una vez por fichero Volt), está consumiendo recursos. Adicionalmente, necesita asegurarse de que la carpeta usada para Volt para compilar las plantillas es escribible por su servidor web.

Puede crear un *script* o una tarea CLI (usando la [Aplicación CLI](application-cli)) para compilar y guardar todos los ficheros cuando despliegue el código. De esta manera, será capaz de instruir a Volt que no compile o registre cada fichero por turno, incrementando el rendimiento. Adicionalmente, ya que estos ficheros se compilan durante el proceso de despliegue, la carpeta volt no necesitará ser escribible, incrementando la seguridad. Ya que las plantillas Volt compiladas son fragmentos phtml, no permitir al servidor web generar código ejecutable es siempre una buena idea.

Recuerde que este *script* será ejecutado en línea de comandos, pero para compilar nuestras plantillas necesitaremos arrancar nuestra aplicación web. En el ejemplo siguiente, necesitaremos obtener el contenedor DI que tiene todos los servicios registrados para nuestra aplicación web. Luego podemos usar el compilador Volt para compilar todas las plantillas a la carpeta correspondiente.

En el ejemplo siguiente, asumimos que tenemos una clase `Bootstrap\Web` que es la responsable de configurar todos nuestros servicios para la aplicación Web. La clase devuelve el contenedor DI usando `getContainer()`. Su implementación podría variar.

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

## Recursos externos
* Un paquete para Sublime/Textmate está disponible [aquí](https://github.com/phalcon/volt-sublime-textmate)
* Phosphorum, Phalcon's forum implementation, also uses Volt, [GitHub](https://github.com/phalcon/forum)
* [Vökuró][vokuro], is another sample application that uses Volt, [GitHub](https://github.com/phalcon/vokuro)


[abs]: https://php.net/manual/en/function.abs.php
[addslashes]: https://php.net/manual/en/function.addslashes.php
[angular]: https://angular.io
[armin]: https://github.com/mitsuhiko
[array_keys]: https://php.net/manual/en/function.array-keys
[asort]: https://php.net/manual/en/function.asort.php
[count]: https://www.php.net/manual/en/function.count.php
[escaper]: html-escaper
[escaper]: html-escaper
[escaper]: html-escaper
[escaper]: html-escaper
[jinja]: https://github.com/pallets/jinja
[join]: https://php.net/manual/en/function.join.php
[json]: https://php.net/manual/en/function.json-encode.php
[lcfirst]: https://php.net/manual/en/function.lcfirst.php
[ltrim]: https://php.net/manual/en/function.ltrim.php
[nl2br]: https://php.net/manual/en/function.nl2br.php
[rtrim]: https://php.net/manual/en/function.rtrim.php
[sprintf]: https://php.net/manual/en/function.sprintf.php
[stripslashes]: https://php.net/manual/en/function.stripslashes.php
[striptags]: https://php.net/manual/en/function.strip-tags.php
[trim]: https://php.net/manual/en/function.trim.php
[ucwords]: https://php.net/manual/en/function.ucwords.php
[strtoupper]: https://www.php.net/manual/en/function.strtoupper.php
[urlencode]: https://php.net/manual/en/function.urlencode.php
[vue]: https://vuejs.org
[vokuro]: tutorial-vokuro
[control_structures]: https://php.net/control-structures.alternative-syntax
[recursivedirectoryiterator]: https://www.php.net/manual/en/class.recursivedirectoryiterator.php
[recursiveiteratoriterator]: https://www.php.net/manual/en/class.recursiveiteratoriterator.php
[unlink]: https://www.php.net/manual/en/function.unlink.php
[mvc-view-engine-volt-compiler]: api/phalcon_mvc#mvc-view-engine-volt-compiler
