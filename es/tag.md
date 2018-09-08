<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Ayudantes de vistas (etiquetas)</a> 
      <ul>
        <li>
          <a href="#document-type">Tipo de Documento de Contenido</a>
        </li>
        <li>
          <a href="#generating-links">Generando enlaces</a>
        </li>        
        <li>
          <a href="#creating-forms">Creando Formularios</a>
        </li>
        <li>
          <a href="#helpers-for-form-elements">Ayudantes para Generar Elementos de Formulario</a>
        </li>
        <li>
          <a href="#select-boxes">Armando Cajas de Selección</a>
        </li>
        <li>
          <a href="#html-attributes">Asignando Atributos HTML</a>
        </li>
        <li>
          <a href="#helper-values">Estableciendo los Valores del Ayudante</a> 
          <ul>
            <li>
              <a href="#helper-values-form-controllers">Desde los controladores</a>
            </li>
            <li>
              <a href="#helper-values-from-request">Desde la consulta</a>
            </li>
            <li>
              <a href="#helper-values-directly">Especificando valores directamente</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#changing-document-title-dynamically">Cambiando dinámicamente el título del documento</a>
        </li>
        <li>
          <a href="#static-content-helpers">Ayudantes de contenidos estáticos</a> 
          <ul>
            <li>
              <a href="#static-content-helpers-images">Imágenes</a>
            </li>
            <li>
              <a href="#static-content-helpers-stylesheets">Hojas de estilo</a>
            </li>
            <li>
              <a href="#static-content-helpers-javascript">Javascript</a>
            </li>
            <li>
              <a href="#static-content-helpers-html5">Elementos HTML5 - Ayudante HTML genérico</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#tag-helpers">Servicio Tag (Etiquetas)</a>
        </li>
        <li>
          <a href="#custom-helpers">Creando tus propios ayudantes</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Ayudantes de vistas (etiquetas)

Escribir y mantener código HTML pueden convertirse rápidamente en una tarea tediosa debido a las convenciones de nomenclatura y numerosos atributos que han de tenerse en cuenta. Phalcon aborda esta complejidad ofreciendo el componente `Phalcon\Tag` que a su vez ofrece ayudantes de vistas para generar código HTML.

Este componente puede utilizarse en una vista HTML + PHP o en una plantilla de [Volt](/[[language]]/[[version]]/volt).

<div class="alert alert-warning">
    <p>
        Esta guía no pretende ser una documentación completa de ayudantes disponibles y sus argumentos. Por favor visite la página <a href="/[[language]]/[[version]]/api/Phalcon_Tag">Phalcon\Tag</a> en la API para una referencia completa.
    </p>
</div>

<a name='document-type'></a>

## Tipo de Documento de Contenido

Phalcon ofrece el ayudante `Phalcon\Tag::setDoctype()` para establecer el tipo de documento de los contenidos. La configuración de tipo de documento puede afectar la salida HTML producida por otros ayudantes de etiquetas. Por ejemplo, si define la familia de tipo de documento XHTML, los ayudantes que retornen o generen salidas de etiquetas HTML producirán etiquetas de auto-cierre para seguir el estándar XHTML válido.

Las constantes de tipo de documento disponibles en el espacio de nombres de `Phalcon\Tag` son:

| Constante            | Tipo de documento      |
| -------------------- | ---------------------- |
| HTML32               | HTML 3.2               |
| HTML401_STRICT       | HTML 4.01 Strict       |
| HTML401_TRANSITIONAL | HTML 4.01 Transitional |
| HTML401_FRAMESET     | HTML 4.01 Frameset     |
| HTML5                | HTML 5                 |
| XHTML10_STRICT       | XHTML 1.0 Strict       |
| XHTML10_TRANSITIONAL | XHTML 1.0 Transitional |
| XHTML10_FRAMESET     | XHTML 1.0 Frameset     |
| XHTML11              | XHTML 1.1              |
| XHTML20              | XHTML 2.0              |
| XHTML5               | XHTML 5                |

Estableciendo el tipo de documento.

```php
<?php

use Phalcon\Tag;

$this->tag->setDoctype(Tag::HTML401_STRICT);
```

Obteniendo el tipo de documento.

```php
<?= $this->tag->getDoctype() ?>
<html>
<!-- tu código HTML -->
</html>
```

Se producirá el siguiente código HTML.

```html
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'
        'http://www.w3.org/TR/html4/strict.dtd'>
<html>
<!-- tu código HTML -->
</html>
```

Sintaxis Volt:

```twig
{{ get_doctype() }}
<html>
<!-- tu código HTML -->
</html>
```

<a name='generating-links'></a>

## Generando enlaces

Una tarea realmente común en cualquier aplicación web o sitio web es generar enlaces que nos permitan navegar de una página a otra. Cuando son direcciones URL internas los podemos crear de la siguiente manera:

```php
<!-- para el router por defecto -->
<?= $this->tag->linkTo('products/search', 'Buscar') ?>

<!-- con atributos CSS -->
<?= $this->tag->linkTo(['products/edit/10', 'Editar', 'class' => 'edit-btn']) ?>

<!-- para un router con nombre -->
<?= $this->tag->linkTo([['for' => 'show-product', 'title' => 123, 'name' => 'carrots'], 'Ver']) ?>
```

En realidad, todas las URLs producidas son generadas por el componente `Phalcon\Mvc\Url`. También pueden generarse los mismos enlaces con Volt:

```twig
<!-- para el router por defecto -->
{{ link_to('products/search', 'Buscar') }}

<!-- para un router con nombre -->
{{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Ver') }}

<!-- para un router con nombre y una clase HTML -->
{{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Ver', 'class': 'edit-btn') }}
```

<a name='creating-forms'></a>

## Creando Formularios

Los formularios en las aplicaciones web juegan un papel esencial en la recuperación de entradas del usuario. En el ejemplo siguiente se muestra cómo implementar un formulario de búsqueda simple usando ayudantes de vistas:

```php
<!-- Enviando el formulario por el método POST -->
<?= $this->tag->form('products/search') ?>
    <label for='q'>Buscar:</label>

    <?= $this->tag->textField('q') ?>

    <?= $this->tag->submitButton('Buscar') ?>
<?= $this->tag->endForm() ?>

<!-- Especificando otro método o atributos para la etiqueta FORM -->
<?= $this->tag->form(['products/search', 'method' => 'get']); ?>
    <label for='q'>Buscar:</label>

    <?= $this->tag->textField('q'); ?>

    <?= $this->tag->submitButton('Buscar'); ?>
<?= $this->tag->endForm() ?>
```

El código anterior generará el siguiente código HTML:

```html
<form action='/store/products/search/' method='get'>
    <label for='q'>Buscar:</label>

    <input type='text' id='q' value='' name='q' />

    <input type='submit' value='Buscar' />
</form>
```

El mismo formulario generado en Volt:

```twig
<!-- Especificando otro método y atributos a la etiqueta FORM -->
{{ form('products/search', 'method': 'get') }}
    <label for='q'>Buscar:</label>

    {{ text_field('q') }}

    {{ submit_button('Buscar') }}
{{ endForm() }}
```

Phalcon también ofrece un [constructor de formularios](/[[language]]/[[version]]/forms) para crear formularios de una manera orientada a objetos.

<a name='helpers-for-form-elements'></a>

## Ayudantes para Generar Elementos de Formulario

Phalcon proporciona una serie de ayudantes para generar elementos de formulario como campos de texto, botones y más. El primer parámetro de cada ayudante es siempre el nombre del elemento a generar. Cuando el formulario es enviado, el nombre se pasará junto con los datos del formulario. En un controlador puede obtener estos valores utilizando el mismo nombre mediante los métodos `getPost()` y `getQuery()` en el objeto de la petición (`$this->request`).

```php
<?php echo $this->tag->textField('username') ?>

<?php echo $this->tag->textArea(
    [
        'comment',
        'Este es el contenido del textarea',
        'cols' => '6',
        'rows' => 20,
    ]
) ?>

<?php echo $this->tag->passwordField(
    [
        'password',
        'size' => 30,
    ]
) ?>

<?php echo $this->tag->hiddenField(
    [
        'parent_id',
        'value' => '5',
    ]
) ?>
```

Sintaxis Volt:

```twig
{{ text_field('username') }}

{{ text_area('comment', 'Este es el contenido del textarea', 'cols': '6', 'rows': 20) }}

{{ password_field('password', 'size': 30) }}

{{ hidden_field('parent_id', 'value': '5') }}
```

<a name='select-boxes'></a>

## Armando Cajas de Selección

Generar cajas de selección, combos select, input select o como desee llamarlos, es fácil, especialmente si los datos relacionados está almacenados en arreglos asociativos de PHP. Los helpers para los elementos select son `Phalcon\Tag::select()` y `Phalcon\Tag::selectStatic()`. `Phalcon\Tag::select()` ha sido fue diseñado específicamente para trabajar con los [modelos](/[[language]]/[[version]]/db-models) (`Phalcon\Mvc\Model`), mientras que `Phalcon\Tag::selectStatic()` con los arreglos de PHP.

```php
<?php

$products = Products::find("type = 'vegetables'");

// Usando datos desde un Resultset
echo $this->tag->select(
    [
        'productId',
        $products,
        'using' => [
            'id',
            'name',
        ]
    ]
);

// Usando datos desde un array
echo $this->tag->selectStatic(
    [
        'status',
        [
            'A' => 'Active',
            'I' => 'Inactive',
        ]
    ]
);
```

Se producirá el siguiente código HTML:

```html
    <select id='productId' name='productId'>
        <option value='101'>Tomato</option>
        <option value='102'>Lettuce</option>
        <option value='103'>Beans</option>
    </select>

    <select id='status' name='status'>
        <option value='A'>Active</option>
        <option value='I'>Inactive</option>
    </select>
```

Puede añadir una opción vacía con el valor `useEmpty` en el HTML generado:

```php
    <?php

    $products = Products::find("type = 'vegetables'");

    // Creando una etiqueta select con una opción vacía
    echo $this->tag->select(
        [
            'productId',
            $products,
            'using'    => [
                'id',
                'name',
            ],
            'useEmpty' => true,
        ]
    );
```

Produce este HTML:

```html
<select id='productId' name='productId'>
    <option value=''>Choose..</option>
    <option value='101'>Tomato</option>
    <option value='102'>Lettuce</option>
    <option value='103'>Beans</option>
</select>
```

```php
<?php

$products = Products::find("type = 'vegetables'");

// Creando una etiqueta Select con una opción vacía y un texto por defecto
echo $this->tag->select(
    [
        'productId',
        $products,
        'using'      => [
            'id',
            'name',
        ],
        'useEmpty'   => true,
        'emptyText'  => 'Por favor, seleccionar una opción...',
        'emptyValue' => '@',
    ]
);
```

```html
<select id='productId' name='productId'>
    <option value='@'>Por favor, seleccione una opción..</option>
    <option value='101'>Tomato</option>
    <option value='102'>Lettuce</option>
    <option value='103'>Beans</option>
</select>
```

La sintaxis Volt del anterior ejemplo sería:

```twig
    {# Creando una etiqueta Select con una opción vacía y un texto por defecto #}
    {{ select('productId', products, 'using': ['id', 'name'],
        'useEmpty': true, 'emptyText': 'Por favor, seleccione una opción...', 'emptyValue': '@') }}
```

<a name='html-attributes'></a>

## Asignando Atributos HTML

Todos los helpers aceptan un arreglo como su primer parámetro, el cual puede contener atributos HTML adicionales para el elemento generado.

```php
<?php $this->tag->textField(
    [
        'price',
        'size'        => 20,
        'maxlength'   => 30,
        'placeholder' => 'Ingrese el precio',
    ]
) ?>
```

o utilizando Volt:

```twig
{{ text_field('price', 'size': 20, 'maxlength': 30, 'placeholder': 'Ingrese el precio') }}
```

Se producirá el siguiente código HTML:

```html
<input type='text' name='price' id='price' size='20' maxlength='30'
       placeholder='Ingrese el precio' />
```

<a name='helper-values'></a>

## Estableciendo los valores del Ayudante

<a name='helper-values-form-controllers'></a>

### Desde los controladores

Es un buen principio de programación para frameworks MVC especificar los valores para cada uno de los elementos del formulario en la vista. Se pueden establecer estos valores directamente en el controlador usando `Phalcon\Tag::setDefault()`. Este ayudante precarga un valor para cualquier ayudante presente en la vista. Si ningún ayudante en la vista tiene un nombre que coincide con el valor precargado, se utilizará este, a menos que directamente se asigne un valor en el ayudante de la vista.

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {
        $this->tag->setDefault('color', 'Azul');
    }
}
```

En la vista, un ayudante selectStatic coincide con el mismo índice que se utiliza para preestablecer el valor. En este caso `color`:

```php
<?php

echo $this->tag->selectStatic(
    [
        'color',
        [
            'Amarillo' => 'Amarillo',
            'Azul'     => 'Azul',
            'Rojo'     => 'Rojo',
        ]
    ]
);
```

Esto generará la siguiente etiqueta select con el valor 'Azul' seleccionado:

```html
<select id='color' name='color'>
    <option value='Amarillo'>Amarillo</option>
    <option value='Azul' selected='selected'>Azul</option>
    <option value='Rojo'>Rojo</option>
</select>
```

<a name='helper-values-from-request'></a>

### Desde la consulta

Una característica especial que los ayudantes de `Phalcon\Tag` es mantener los valores de los ayudantes del formulario entre las solicitudes. De esta manera puede fácilmente mostrar mensajes de validación sin perder los datos introducidos.

<a name='helper-values-directly'></a>

### Especificando valores directamente

Cada ayudante de formulario soporta el parámetro 'value'. Con este es posible especificar directamente el valor al ayudante. Cuando este parámetro es presentado, cualquier valor utilizado en el método `setDefault()` o a través de la consulta, serán ignorados.

<a name='changing-document-title-dynamically'></a>

## Cambiando dinámicamente el título del documento

`Phalcon\Tag` ofrece ayudantes para cambiar dinámicamente el título del documento desde el controlador. En el ejemplo siguiente se muestra justamente esto:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle('Tu sitio Web');
    }

    public function indexAction()
    {
        $this->tag->prependTitle('Indice de los Posts - ');
    }
}
```

```php
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <body>

    </body>
</html>
```

Se producirá el siguiente código HTML:

```php
<html>
    <head>
        <title>Indice de los Posts - Tu sitio Web</title>
    </head>

    <body>

    </body>
</html>
```

<a name='static-content-helpers'></a>

## Ayudantes de contenidos estáticos

`Phalcon\Tag` también provee ayudantes para generar etiquetas tales como script, link o img. Estos ayudan en la generación rápida y sencilla de los recursos estáticos de tu aplicación

<a name='static-content-helpers-images'></a>

### Imágenes

```php
<?php

// Genera <img src='/your-app/img/hello.gif'>
echo $this->tag->image('img/hello.gif');

// Genera <img alt='texto alternativo' src='/your-app/img/hello.gif'>
echo $this->tag->image(
    [
       'img/hello.gif',
       'alt' => 'texto alternativo',
    ]
);
```

Sintaxis Volt:

```twig
{# Genera <img src='/your-app/img/hello.gif'> #}
{{ image('img/hello.gif') }}

{# Genera <img alt='texto alternativo' src='/your-app/img/hello.gif'> #}
{{ image('img/hello.gif', 'alt': 'texto alternativo') }}
```

<a name='static-content-helpers-stylesheets'></a>

### Hojas de estilo

```php
<?php

// Genera <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Rosario' type='text/css'>
echo $this->tag->stylesheetLink('http://fonts.googleapis.com/css?family=Rosario', false);

// Genera <link rel='stylesheet' href='/your-app/css/styles.css' type='text/css'>
echo $this->tag->stylesheetLink('css/styles.css');
```

Sintaxis Volt:

```twig
{# Genera <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Rosario' type='text/css'> #}
{{ stylesheet_link('http://fonts.googleapis.com/css?family=Rosario', false) }}

{# Genera <link rel='stylesheet' href='/your-app/css/styles.css' type='text/css'> #}
{{ stylesheet_link('css/styles.css') }}
```

<a name='static-content-helpers-javascript'></a>

### Javascript

```php
<?php

// Genera <script src='http://localhost/javascript/jquery.min.js' type='text/javascript'></script>
echo $this->tag->javascriptInclude('http://localhost/javascript/jquery.min.js', false);

// Genera <script src='/your-app/javascript/jquery.min.js' type='text/javascript'></script>
echo $this->tag->javascriptInclude('javascript/jquery.min.js');
```

Sintaxis Volt:

```twig
{# Genera <script src='http://localhost/javascript/jquery.min.js' type='text/javascript'></script> #}
{{ javascript_include('http://localhost/javascript/jquery.min.js', false) }}

{# Genera <script src='/your-app/javascript/jquery.min.js' type='text/javascript'></script> #}
{{ javascript_include('javascript/jquery.min.js') }}
```

<a name='static-content-helpers-html5'></a>

### Elementos HTML5 - Ayudante HTML genérico

Phalcon ofrece un ayudante HTML genérico que permite la generación de cualquier tipo de elemento HTML. Depende del desarrollador producir un nombre de elemento HTML válido para el ayudante.

```php
<?php

// Genera
// <canvas id='canvas1' width='300' class='cnvclass'>
// Este es mi lienzo
// </canvas>
echo $this->tag->tagHtml(
    'canvas', 
    [
        'id'    => 'canvas1', 
        'width' => '300', 
        'class' => 'cnvclass',
    ], 
    false, 
    true, 
    true
);
echo 'Este es mi lienzo';
echo $this->tag->tagHtmlClose('canvas');
```

Sintaxis Volt:

```php
{# Genera
<canvas id='canvas1' width='300' class='cnvclass'>
Ese es mi lienzo
</canvas> #}
{{ tag_html('canvas', ['id': 'canvas1', width': '300', 'class': 'cnvclass'], false, true, true) }}
    Este es mi lienzo
{{ tag_html_close('canvas') }}
```

<a name='tag-helpers'></a>

## Servicio Tag (Etiquetas)

`Phalcon\Tag` está disponible mediante el servicio [tag](/[[language]]/[[version]]/tag), esto significa que se puede acceder desde cualquier parte de la aplicación donde se encuentre el contenedor de servicios:

```php
<?php echo $this->tag->linkTo('pages/about', 'Acerca de') ?>
```

Puedes agregar fácilmente nuevos ayudantes a un componente personalizado reemplazando el servicio 'tag' en el contenedor de servicios:

```php
<?php

use Phalcon\Tag;

class MyTags extends Tag
{
    // ...

    // Crear un nuevo ayudante
    public static function myAmazingHelper($parameters)
    {
        // ...
    }

    // Sobrecargar un método existente
    public static function textField($parameters)
    {
        // ...
    }
}
```

Luego puedes cambiar la definición del servicio [tag](/[[language]]/[[version]]/tag):

```php
<?php

$di['tag'] = function () {
    return new MyTags();
};
```

<a name='custom-helpers'></a>

## Creando tus propios ayudantes

Usted puede crear fácilmente sus propios ayudantes. En primer lugar, empiece por crear una nueva carpeta dentro del mismo directorio como para sus controladores y modelos. Darle un título que tenga relación con lo que se está creando. Para nuestro ejemplo podemos llamarlo 'customhelpers'. A continuación vamos a crear un nuevo archivo titulado `MyTags.php` dentro de este nuevo directorio. En este punto, tenemos una estructura similar a: `/app/customhelpers/MyTags.php`. `MyTags.php`, extenderá de `Phalcon\Tag` e implementaremos su propio ayudante. A continuación está un ejemplo simple de un ayudante personalizado:

```php
<?php

use Phalcon\Tag;

class MyTags extends Tag
{
    /**
     * Generamos un widget para mostrar la etiqueta audio de HTML5
     *
     * @param array
     * @return string
     */
    public static function audioField($parameters)
    {
        // Convirtimos los parámetros en array si no lo son
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Determinamos el atributo 'id' y 'name'
        if (!isset($parameters[0])) {
            $parameters[0] = $parameters['id'];
        }

        $id = $parameters[0];

        if (!isset($parameters['name'])) {
            $parameters['name'] = $id;
        } else {
            if (!$parameters['name']) {
                $parameters['name'] = $id;
            }
        }

        // Determinamos el valor de widget,
        // \Phalcon\Tag::setDefault() permite establecer el valor del mismo
        if (isset($parameters['value'])) {
            $value = $parameters['value'];
            unset($parameters['value']);
        } else {
            $value = self::getValue($id);
        }

        // Generamos el código de la etiqueta
        $code = '<audio id="' . $id . '" value="' . $value . '" ';

        foreach ($parameters as $key => $attributeValue) {
            if (!is_integer($key)) {
                $code.= $key . '="' . $attributeValue . '" ';
            }
        }

        $code.=' />';

        return $code;
    }
}
```

Después de crear nuestro ayudante personalizado, vamos a cargar automáticamente el nuevo directorio que contiene nuestra clase auxiliar desde nuestro `index.php` que se encuentra en el directorio público.

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault();
use Phalcon\Exception as PhalconException;

try {
    $loader = new Loader();

    $loader->registerDirs(
        [
            '../app/controllers',
            '../app/models',
            '../app/customhelpers', // Agregamos la nueva carpeta de ayudantes
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Asignamos la nueva definición de etiquetas para que podamos llamarla
    $di->set(
        'MyTags',
        function () {
            return new MyTags();
        }
    );

    $application = new Application($di);

    $response = $application->handle();

    $response->send();
} catch (PhalconException $e) {
    echo 'Excepción de Phalcon: ', $e->getMessage();
}
```

Ahora estás listo para usar tu nuevo ayudante en tus vistas:

```php
<body>

    <?php

    echo MyTags::audioField(
        [
            'name' => 'test',
            'id'   => 'audio_test',
            'src'  => '/path/to/audio.mp3',
        ]
    );

    ?>

</body>
```

Puede también darle un vistazo a [Volt](/[[language]]/[[version]]/volt) un motor rápido de plantillas de PHP, donde se puede utilizar una sintaxis amigable con el desarrollador para usar con los ayudantes proporcionados por `Phalcon\Tag`.