<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Resumen</a> <ul>
        <li>
          <a href="#introduction">Introducción</a>
        </li>
        <li>
          <a href="#setup">Activando Volt</a>
        </li>
        <li>
          <a href="#basic-usage">Uso básico</a>
        </li>
        <li>
          <a href="#variables">Variables</a>
        </li>
        <li>
          <a href="#filters">Filtros</a>
        </li>
        <li>
          <a href="#comments">Comentarios</a>
        </li>
        <li>
          <a href="#control-structures">Lista de estructuras de Control</a> 
          <ul>
            <li>
              <a href="#control-structures-for">For</a>
            </li>
            <li>
              <a href="#control-structures-loops">Controles de bucle</a>
              <ul>
                <li>
                  <a href="#loop-controls-if">If</a>
                </li>
                <li>
                  <a href="#loop-controls-switch">Switch</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#control-structures-loop">Contexto de bucle</a> 
              <ul>
                <li>
                  <a href="#assignments">Asignaciones</a>
                </li>
                <li>
                  <a href="#expressions">Expresiones</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#expressions-literals">Literales</a>
            </li>
            <li>
              <a href="#expressions-arrays">Arrays</a>
            </li>
            <li>
              <a href="#expressions-math">Matemáticas</a>
            </li>
            <li>
              <a href="#expressions-comparisons">Comparaciones</a>
            </li>
            <li>
              <a href="#expressions-logic">Lógica</a>
            </li>
            <li>
              <a href="#expressions-other-operators">Otros operadores</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#tests">Pruebas</a>
        </li>
        <li>
          <a href="#macros">Macros</a>
        </li>
        <li>
          <a href="#tag-helpers">Usando los ayudantes de etiqueta</a>
        </li>
        <li>
          <a href="#functions">Funciones</a>
        </li>
        <li>
          <a href="#view-integrations">Integración de la vista</a> 
          <ul>
            <li>
              <a href="#view-integration-include">Incluir</a>
            </li>
            <li>
              <a href="#view-integration-partial-vs-include">Parciales vs inclusiones</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#template-inheritance">Herencia de Plantillas</a> <ul>
            <li>
              <a href="#template-inheritance-multiple">Herencia múltiple</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#autoescape">Modo de Autoescape</a>
        </li>
        <li>
          <a href="#extending">Extender Volt</a> 
          <ul>
            <li>
              <a href="#extending-functions">Funciones</a>
            </li>
            <li>
              <a href="#extending-filters">Filtros</a>
            </li>
            <li>
              <a href="#extending-extensions">Extensiones</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#caching-view-fragments">Almacenamiento en caché de fragmentos de la vista</a>
        </li>
        <li>
          <a href="#services-in-templates">Inyectar servicios en una plantilla</a>
        </li>
        <li>
          <a href="#stand-alone">Componente independiente</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Volt: Motor de plantillas

Volt es un lenguaje de plantillas ultrarrápido y de diseño amigable, escrito en C para PHP. Le proporciona un conjunto de ayudantes a escribir vistas de una manera fácil. Volt están altamente integrado con otros componentes de Phalcon, del mismo modo que puede utilizarlo como componente independiente en sus aplicaciones.

![](/images/content/volt.jpg)

Volt está inspirado en [Jinja](http://jinja.pocoo.org/), originalmente creado por [Armin Ronacher](https://github.com/mitsuhiko). Por lo tanto muchos desarrolladores estarán en territorio familiar al utilizar la misma sintaxis que han estado utilizando con motores de plantillas similares. La sintaxis y características de Volt se han mejorado con más elementos y, por supuesto, con el rendimiento que los desarrolladores están acostumbrados a trabajar en Phalcon.

<a name='introduction'></a>

## Introducción

Las vistas de Volt se compilan a código PHP puro, así que, básicamente ahorran el esfuerzo de escribir el código PHP manualmente:

```twig
{# app/views/products/show.volt #}

{% block last_products %}

{% for product in products %}
    * Nombre: {{ product.name|e }}
    {% if product.status === 'Activo' %}
       Precio: {{ product.price + product.taxes/100 }}
    {% endif  %}
{% endfor  %}

{% endblock %}
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

Una vista consiste en código Volt, PHP y HTML. Un conjunto de delimitadores especiales está disponible para entrar en modo de Volt. `{% ... %}` se utiliza para ejecutar sentencias como bucles o asignar valores y `{{... }}`, imprime el resultado de una expresión en la plantilla.

Abajo se encuentra una plantilla mínima, que muestra algunos conceptos básicos:

```twig
{# app/views/posts/show.phtml #}
<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }} - Un blog de ejemplo</title>
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

Utilizando `Phalcon\Mvc\View` puede pasar variables del controlador a la vista. En el ejemplo anterior, se pasaron cuatro variables a la vista: `show_navigation`, `menu`, `title` y `post`:

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
{{ post.title }} {# para $post->title #}
{{ post['title'] }} {# para $post['title'] #}
```

<a name='filters'></a>

## Filtros

Las variables pueden ser formateadas o modificadas mediante filtros. El operador de la pipa o pleca `|` se utiliza para aplicar filtros a las variables:

```twig
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
```

La siguiente lista contiene los filtros disponibles incorporados en Volt:

| Filtro             | Descripción                                                                                                                                       |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Se aplica la función [abs](http://php.net/manual/en/function.abs.php) de PHP a un valor.                                                          |
| `capitalize`       | Capitaliza una cadena mediante la aplicación de la función PHP [ucwords](http://php.net/manual/en/function.ucwords.php) al valor                  |
| `convert_encoding` | Convierte una cadena de un conjunto de caracteres a otro                                                                                          |
| `default`          | Establece un valor predeterminado en caso de que la expresión evaluada este vacía (no se establece o se evalúa como un valor falso)               |
| `e`                | Se aplica `Phalcon\Escaper->escapeHtml()` al valor                                                                                            |
| `escape`           | Se aplica `Phalcon\Escaper->escapeHtml()` al valor                                                                                            |
| `escape_attr`      | Se aplica `Phalcon\Escaper->escapeHtmlAttr()` al valor                                                                                        |
| `escape_css`       | Se aplica `Phalcon\Escaper->escapeCss()` al valor                                                                                             |
| `escape_js`        | Se aplica `Phalcon\Escaper->escapeJs()` al valor                                                                                              |
| `format`           | Formatea una cadena utilizando [sprintf](http://php.net/manual/en/function.sprintf.php).                                                          |
| `json_encode`      | Convierte un valor en su representación [JSON](http://php.net/manual/en/function.json-encode.php)                                                 |
| `json_decode`      | Convierte un valor de su representación [JSON](http://php.net/manual/en/function.json-encode.php) en una representación de PHP                    |
| `join`             | Se unen las partes de un array usando un separador [join](http://php.net/manual/en/function.join.php)                                             |
| `keys`             | Devuelve las llaves de la matriz usando [array_keys](http://php.net/manual/en/function.array-keys.php)                                            |
| `left_trim`        | Se aplica la función [ltrim](http://php.net/manual/en/function.ltrim.php) de PHP al valor. Quitar espacios extras a la izquierda                  |
| `length`           | Cuenta la longitud de la cadena de texto o cuántos elementos hay en un array u objeto                                                             |
| `lower`            | Cambiar una cadena a minúsculas                                                                                                                   |
| `nl2br`            | Cambia los saltos de línea `\n` por saltos de línea (`<br/>`). Utiliza la función PHP [nl2br](http://php.net/manual/en/function.nl2br.php) |
| `right_trim`       | Se aplica la función [rtrim](http://php.net/manual/en/function.rtrim.php) PHP al valor. Quitar espacios extras a la derecha                       |
| `sort`             | Ordena una matriz mediante la función PHP [asort](http://php.net/manual/en/function.asort.php)                                                    |
| `stripslashes`     | Se aplica la función [stripslashes](http://php.net/manual/en/function.stripslashes.php) PHP al valor. Eliminando las comillas escapadas           |
| `striptags`        | Se aplica la función PHP [striptags](http://php.net/manual/en/function.striptags.php) al valor. Elimina etiquetas HTML                            |
| `trim`             | Se aplica la función PHP [trim](http://php.net/manual/en/function.trim.php) el valor. Quitar espacios extras al principio y al final              |
| `upper`            | Cambiar una cadena a mayúsculas                                                                                                                   |
| `url_encode`       | Se aplica la función [urlencode](http://php.net/manual/en/function.urlencode.php) PHP al valor                                                    |

Ejemplos:

```twig
{# filtro e o escape #}
{{ '<h1>Hola<h1>'|e }}
{{ '<h1>Hola<h1>'|escape }}

{# filtro trim #}
{{ '   hello   '|trim }}

{# filtro striptags #}
{{ '<h1>Hello<h1>'|striptags }}

{# filtro slashes #}
{{ '"esta es una cadena"'|slashes }}

{# filtro stripslashes #}
{{ "\'esta es una cadena\'"|stripslashes }}

{# filtro capitalize #}
{{ 'hola'|capitalize }}

{# filtro lower #}
{{ 'HOLA'|lower }}

{# filtro upper #}
{{ 'hola'|upper }}

{# filtro length #}
{{ 'robots'|length }}
{{ [1, 2, 3]|length }}

{# filtro nl2br #}
{{ 'algún\ntexto'|nl2br }}

{# filtro sort #}
{% set sorted = [3, 1, 2]|sort %}

{# filtro keys #}
{% set keys = ['primero': 1, 'segundo': 2, 'tercero': 3]|keys %}

{# filtro join #}
{% set joined = 'a'..'z'|join(',') %}

{# filtro format #}
{{ 'Mi nombre real es %s'|format(name) }}

{# filtro json_encode #}
{% set encoded = robots|json_encode %}

{# filtro json_decode #}
{% set decoded = '{'uno':1,'dos':2,'tres':3}'|json_decode %}

{# filtro url_encode #}
{{ post.permanent_link|url_encode }}

{# filtro convert_encoding #}
{{ 'désolé'|convert_encoding('utf8', 'latin1') }}
```

<a name='comments'></a>

## Comentarios

Los comentarios también se pueden agregar a una plantilla con los delimitadores `{# ... #}`. Todo el texto en su interior sólo se omite en el resultado final:

```twig
{# nota: este es un comentario
    {% set price = 100; %}
#}
```

<a name='control-structures'></a>

## Lista de estructuras de Control

Volt proporciona un conjunto de estructuras de control básicas pero de gran alcance para el uso de plantillas:

<a name='control-structures-for'></a>

### For

Un bucle sobre cada elemento en una secuencia. En el ejemplo siguiente se muestra cómo recorrer un conjunto de 'robots' e imprimir su nombre:

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

Los bucles `for` también se pueden anidar:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    {% for part in robot.parts %}
        Robot: {{ robot.name|e }} Parte: {{ part.name|e }} <br />
    {% endfor %}
{% endfor %}
```

Usted puede conseguir las `claves` de los elementos, como la contraparte PHP, con la siguiente sintaxis:

```twig
{% set numbers = ['uno': 1, 'dos': 2, 'tres': 3] %}

{% for name, value in numbers %}
    Nombre: {{ name }} Valor: {{ value }}
{% endfor %}
```

Opcionalmente, se puede establecer una evaluación `if`:

```twig
{% set numbers = ['uno': 1, 'dos': 2, 'tres': 3] %}

{% for value in numbers if value < 2 %}
    Valor: {{ value }}
{% endfor %}

{% for name, value in numbers if name !== 'dos' %}
    Nombre: {{ name }} Valor: {{ value }}
{% endfor %}
```

Si un `else` se define dentro del `for`, se ejecutará si la expresión en el iterador da como resultado cero iteraciones:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Parte: {{ part.name|e }} <br />
{% else %}
    No hay robots para mostrar
{% endfor %}
```

Sintaxis alternativa:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Parte: {{ part.name|e }} <br />
{% elsefor %}
    No hay robots para mostrar
{% endfor %}
```

<a name='control-structures-loops'></a>

### Controles de bucle

Las declaraciones de `break` y `continue` pueden utilizarse para salir de un bucle o forzar una iteración en el bloque actual:

```twig
{# omitir robots pares #}
{% for index, robot in robots %}
    {% if index is even %}
        {% continue %}
    {% endif %}
    ...
{% endfor %}
```

```twig
{# salir del bucle en el primero robot par #}
{% for index, robot in robots %}
    {% if index is even %}
        {% break %}
    {% endif %}
    ...
{% endfor %}
```

<a name='loop-controls-if'></a>

### If

Como en PHP, una declaración `if` comprueba si una expresión se evalúa como verdadera o falsa:

```twig
<h1>Robots Cyborg</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% endif %}
    {% endfor %}
</ul>
```

También se admite la cláusula `else`:

```twig
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% else %}
            <li>{{ robot.name|e }} (no es un cyborg)</li>
        {% endif %}
    {% endfor %}
</ul>
```

También puede utilizar la estructura de flujo de control `elseif` para emular un bloque `switch`:

```twig
{% if robot.type === 'cyborg' %}
    El robot es un cyborg
{% elseif robot.type === 'virtual' %}
    El Robot es virtual
{% elseif robot.type === 'mechanical' %}
    El Robot es mecánico
{% endif %}
```

<a name='loop-controls-switch'></a>

### Switch

Una alternativa a la instrucción `if` es `switch`, que le permite crear caminos de ejecución lógica en su aplicación:

```twig
{% switch foo %}
    {% case 0 %}
    {% case 1 %}
    {% case 2 %}
        "foo" es menor que 3 pero no es negativo
        {% break %}
    {% case 3 %}
        "foo" es 3
        {% break %}
    {% default %}
        "foo" es {{ foo }}
{% endswitch %}

```

La sentencia `switch` ejecuta instrucción por instrucción, por lo tanto es necesario en algunos casos la instrucción `break`. Cualquier salida (incluyendo espacios en blanco) entre una instrucción switch y el primer `case` dará lugar a un error de sintaxis. Por lo tanto pueden borrar los espacios en blanco y líneas vacías para reducir el número de errores. Para más información visite [sintaxis alternativa de estructuras de control](http://php.net/control-structures.alternative-syntax).

#### `case` sin `switch`

```twig
{% case EXPRESSION %}
```

Lanzará un `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

#### `switch` sin `endswitch`

```twig
{% switch EXPRESSION %}
Lanzará un `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.
```

#### `default` sin `switch`

```twig
{% default %}
```

No devolverá un error ya que `default` es una palabra reservada para filtros como `{{expresión|default(VALUE)}}` pero en este caso la expresión sólo producirá un carácter vacío, osea un ''.

#### `switch` anidados

```twig
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
```

Lanzará un `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

#### un `switch` sin expresión

```twig
{% switch %}
  {% case EXPRESSION %}
      {% break %}
{% endswitch %}
```

Lanzará un `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected token %} in ... on line ...`

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
{% for robot in robots %}
    {% if loop.first %}
        <table>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Nombre</th>
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

## Asignaciones

Las variables se pueden cambiar en una plantilla con la instrucción 'set':

```twig
{% set fruits = ['Manzana', 'Banana', 'Naranja'] %}

{% set name = robot.name %}
```

Se permiten las asignaciones múltiples en la misma instrucción:

```twig
{% set fruits = ['Manzana', 'Banana', 'Naranja'], name = robot.name, active = true %}
```

Además, puede utilizar operadores de asignación compuestos:

```twig
{% set price += 100.00 %}

{% set age *= 5 %}
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

Volt proporciona un conjunto básico de soporte de expresión, incluidos literales y operadores comunes. Una expresión puede evaluarse e imprimirse usando los delimitadores `{{` y `}}`:

```twig
{{ (1 + 1) * 2 }}
```

Si una expresión necesita ser evaluada pero no impresa, se puede utilizar la instrucción `do`:

```twig
{% do (1 + 1) * 2 %}
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
{# Array simple #}
{{ ['Manzana', 'Banana', 'Naranja'] }}

{# Otro array simple #}
{{ ['Manzana', 1, 2.5, false, null] }}

{# Array multi dimensional #}
{{ [[1, 2], [3, 4], [5, 6]] }}

{# Array asociativo #}
{{ ['primero': 1, 'segundo': 4/2, 'tercero': '3'] }}
```

Las llaves también pueden usarse para definir matrices o arrays asociativos:

```twig
{% set myArray = {'Manzana', 'Banana', 'Naranja'} %}
{% set myHash  = {'primero': 1, 'segundo': 4/2, 'tercero': '3'} %}
```

<a name='expressions-math'></a>

### Matemáticas

Se pueden hacer cálculos en las plantillas mediante los siguientes operadores:

| Operator | Descripción                                                           |
|:--------:| --------------------------------------------------------------------- |
|   `+`    | Realiza una operación de adición. `{{2 + 3}}` devuelve 5              |
|   `-`    | Realiza una operación de resta. `{{ 2 - 3 }}` devuelve -1             |
|   `*`    | Realiza una operación de multiplicación. `{{2 * 3}}` devuelve 6       |
|   `/`    | Realizar una operación de división. `{{10 / 2}}` devuelve 5           |
|   `%`    | Calcular el resto de una división de enteros. `{{10 % 3}}` devuelve 1 |

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

| Operator          | Descripción                                                                              |
| ----------------- | ---------------------------------------------------------------------------------------- |
| `~`               | Concatena dos operandos `{{'Hola' ~ 'mundo'}}`                                           |
| `|`               | Se aplica un filtro en el operando de la derecha a la izquierda `{{ 'hola'|uppercase }}` |
| `..`              | Crea un rango `{{ 'a'..'z' }}` `{{ 1..10 }}`                                             |
| `is`              | Alias de == (igual), también realiza pruebas                                             |
| `in`              | Para comprobar si una expresión está contenida en otras expresiones `if 'a' in 'abc'`    |
| `is not`          | Alias de != (no iguales)                                                                 |
| `'a' ? 'b' : 'c'` | Operador ternario. Igual al operador ternario de PHP                                     |
| `++`              | Incrementa un valor                                                                      |
| `--`              | Decrementa un valor                                                                      |

En el ejemplo siguiente se muestra cómo utilizar operadores:

```twig
{% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

{% for index in 0..robots|length %}
    {% if robots[index] is defined %}
        {{ 'Nombre: ' ~ robots[index] }}
    {% endif %}
{% endfor %}
```

<a name='tests'></a>

## Pruebas

Pueden utilizarse las pruebas para comprobar si una variable tiene un valor esperado válido. El operador `is` se utiliza para realizar las pruebas:

```twig
{% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

{% for position, name in robots %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}
```

Las siguientes pruebas integradas están disponibles en Volt:

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

Más ejemplos:

```twig
{% if robot is defined %}
    La variable robot está definida
{% endif %}

{% if robot is empty %}
    El robot es nulo o no está definido
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

{% set world = 'hola' %}
{% if world is sameas('hola') %}
    {{ 'Es hola!' }}
{% endif %}

{% set external = false %}
{% if external is type('boolean') %}
    {{ 'External es verdadero o falso' }}
{% endif %}
```

<a name='macros'></a>

## Macros

Las macros pueden utilizarse para reutilizar la lógica de una plantilla, actúan como funciones PHP, pueden recibir parámetros y devolver valores:

```twig
{# Macro 'Mostrar una lista de enlaces a temas relacionados' #}
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

{# Imprimir enlaces relacionados #}
{{ related_bar(links) }}

<div>Este es el contenido</div>

{# Volver a imprimir los enlaces relacionados #}
{{ related_bar(links) }}
```

Al llamar a las macros, se pueden pasar parámetros por nombre:

```twig
{%- macro error_messages(message, field, type) %}
    <div>
        <span class='error-type'>{{ type }}</span>
        <span class='error-field'>{{ field }}</span>
        <span class='error-message'>{{ message }}</span>
    </div>
{%- endmacro %}

{# Llamar al macro #}
{{ error_messages('type': 'Invalido', 'message': 'El nombre es invalido', 'field': 'name') }}
```

Las macros pueden devolver valores:

```twig
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Llamar al macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

Y recibir parámetros opcionales:

```twig
{%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Llamar al macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

<a name='tag-helpers'></a>

## Usando los ayudantes de etiqueta

Volt está altamente integrado con `Phalcon\Tag`, por lo que es fácil utilizar los ayudantes proporcionados por el componente en una plantilla de Volt:

```twig
{{ javascript_include('js/jquery.js') }}

{{ form('products/save', 'method': 'post') }}

    <label for='name'>Nombre</label>
    {{ text_field('name', 'size': 32) }}

    <label for='type'>Tipo</label>
    {{ select('type', productTypes, 'using': ['id', 'name']) }}

    {{ submit_button('Enviar') }}

{{ end_form() }}
```

Se genera el siguiente código PHP:

```php
<?php echo Phalcon\Tag::javascriptInclude('js/jquery.js') ?>

<?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

    <label for='name'>Nombre</label>
    <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

    <label for='type'>Tipo</label>
    <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

    <?php echo Phalcon\Tag::submitButton('Enviar'); ?>

{{ end_form() }}
```

Para llamar a un ayudante de `Phalcon\Tag`, sólo necesita llamar una versión no camelizada del método:

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

Además, Volt está integrado con `Phalcon\Mvc\View`, puedes jugar con la jerarquía de la vista y también incluir parciales:

```twig
{{ content() }}

<!-- Inclusión simple de una vista parcial -->
<div id='footer'>{{ partial('partials/footer') }}</div>

<!-- Pasando variables adicionales -->
<div id='footer'>{{ partial('partials/footer', ['links': links]) }}</div>
```

Una vista parcial es incluida en tiempo de ejecución, Volt proporciona también `include`, este compila el contenido de una vista y devuelve su contenido como parte de la vista que se incluye:

```twig
{# Inclusión simple de una vista parcial #}
<div id='footer'>
    {% include 'partials/footer' %}
</div>

{# Pasando variables adicionales #}
<div id='footer'>
    {% include 'partials/footer' with ['links': links] %}
</div>
```

<a name='view-integration-include'></a>

### Incluir

`include` tiene un comportamiento especial que nos ayudará a mejorar un poco el rendimiento cuando se usa Volt, si especifica la extensión al incluir el archivo y existe cuando se compila la plantilla, Volt puede incrustar el contenido de la plantilla incluida en la plantilla principal donde está definida la inclusión. Las plantillas no serán incrustadas si el `include` tiene variables pasadas con `with`:

```twig
{# El contenido de 'partials/footer.volt' es compilado e incrustado #}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
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
{# templates/base.volt #}
<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel='stylesheet' href='style.css' />
        {% endblock %}

        <title>{% block title %}{% endblock %} - Mi Página Web</title>
    </head>

    <body>
        <div id='content'>{% block content %}{% endblock %}</div>

        <div id='footer'>
            {% block footer %}&copy; Copyright 2015, Todos los derechos reservados.{% endblock %}
        </div>
    </body>
</html>
```

Desde otra plantilla podríamos ampliar la plantilla base, reemplazando los bloques:

```twig
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style type='text/css'>.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class='important'>´Bienvenido a mi increíble página principal.</p>
{% endblock %}
```

No todos los bloques deben sustituirse en una plantilla hija, sólo aquellos que son necesarios. El resultado final será el siguiente:

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

Las plantillas extendidas pueden extender a otras plantillas. El siguiente ejemplo ilustra esto:

```twig
{# main.volt #}
<!DOCTYPE html>
<html>
    <head>
        <title>Título</title>
    </head>

    <body>
        {% block content %}{% endblock %}
    </body>
</html>
```

La plantilla `layout.volt` extiende de `main.volt`

```twig
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Tabla de contenidos</h1>

{% endblock %}
```

Finalmente una vista que se extiende de `layout.volt`:

```twig
{# index.volt #}
{% extends 'layout.volt' %}

{% block content %}

    {{ super() }}

    <ul>
        <li>Una opción</li>
        <li>Otra opción</li>
    </ul>

{% endblock %}
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

<div class="alert alert-warning">
    <p>
        Por defecto y por motivos de rendimiento, Volt sólo comprueba cambios en las plantillas hijas para saber cuándo debe volver a compilar y generar PHP plano otra vez, por lo que es recomendable inicializar Volt con la opción de <code>'compileAlways' => true</code>. Por lo tanto, las plantillas se compilan siempre teniendo en cuenta los cambios en las plantillas padre.
    </p>
</div>

<a name='autoescape'></a>

## Modo de Autoescape

Es posible activar el auto-escape de todas las variables en un bloque usando el modo autoescape:

```twig
Escapado manual: {{ robot.name|e }}

{% autoescape true %}
    Auto-escapado: {{ robot.name }}
    {% autoescape false %}
        Sin auto-escape: {{ robot.name }}
    {% endautoescape %}
{% endautoescape %}
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

Para registrar la función con una función anónima. En este caso utilizaremos `$resolvedArgs` para pasar los argumentos tal como se lo pasaron en los argumentos:

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

Un filtro tiene la siguiente forma en una plantilla: `expresionIzquierda|nombre(argumentos-opcionales)`. Para agregar nuevos filtros es similar a como hace con las funciones:

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

Una extensión es una clase que implementa los eventos desencadenados por Volt como métodos de sí mismo. Por ejemplo, la siguiente clase permite utilizar cualquier función PHP en Volt:

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

| Método/Evento       | Descripción                                                                                                               |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------- |
| `compileFunction`   | Es activado antes de intentar compilar cualquier llamada a una función en una plantilla                                   |
| `compileFilter`     | Es activado antes de intentar compilar cualquier llamada a un filtro en una plantilla                                     |
| `resolveExpression` | Es activado antes de intentar compilar cualquier expresión. Esto permite al desarrollador redefinir los operadores        |
| `compileStatement`  | Es activado antes de intentar compilar cualquier expresión. Esto permite al desarrollador redefinir cualquier declaración |

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

Con Volt es fácil cachear fragmentos. Este almacenamiento en caché mejora el rendimiento evitando que el contenido de un bloque sea ejecutado por PHP cada vez que se muestra la vista:

```twig
{% cache 'sidebar' %}
    <!-- Generar este contenido es lento, entonces lo vamos a cachear -->
{% endcache %}
```

Establecer un número específico de segundos:

```twig
{# Almacenar este cacheo por una hora #}
{% cache 'sidebar' 3600 %}
    <!-- Generar este contenido es lento, entonces vamos a cachearlo -->
{% endcache %}
```

Cualquier expresión válida puede utilizarse como clave del caché:

```twig
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
```

El almacenamiento en caché lo realiza el componente `Phalcon\Cache` mediante el componente de la vista. Para más información acerca de cómo funciona esta integración en la sección [almacenamiento de fragmentos de vista en cache](/[[language]]/[[version]]/views#caching-fragments).

<a name='services-in-templates'></a>

## Inyectar servicios en una plantilla

Si un contenedor de servicio (DI) está disponible para Volt, puede usar los servicios accediendo solamente el nombre del servicio en la plantilla:

```twig
{# Inyectar el servicio 'flash' #}
<div id='messages'>{{ flash.output() }}</div>

{# Inyectar el servicio 'security' #}
<input type='hidden' name='token' value='{{ security.getToken() }}'>
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