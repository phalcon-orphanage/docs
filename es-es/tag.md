---
layout: default
language: 'es-es'
version: '5.0'
title: 'Tag'
keywords: 'etiqueta, ayudantes, ayudantes vista, generadores html'
---

# Etiqueta (Ayudantes Vista)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

> **NOTE** `Phalcon\Tag` will be removed in a future Phalcon version. The functionality is offered by the [Phalcon\Html\TagFactory][tagfactory] component. 
> 
> {: .alert .alert-danger }

## Resumen
Escribir y mantener código HTML puede convertirse rápidamente en una tarea tediosa a causa de las convenciones de nombre y numerosos atributos que se deben tener en consideración. Phalcon se ocupa de esta complejidad ofreciendo el componente [Phalcon\Tag](api/Phalcon_Tag) que a su vez ofrece ayudantes para generar marcado HTML.

Este componente se puede usar en una vista plana HTML+PHP o en una plantilla [Volt](volt).

> **NOTE**: This offers the same functionality as `Phalcon\Html\TagFactory`. En versiones futuras, este componente será remplazado por el `TagFactory`. La razón de ambos componentes es ofrecer tanto tiempo como sea posible a los desarrolladores para que adapten su código, ya que la generación HTML toca muchas áreas de la aplicación, la vista en particular. 
> 
> {: .alert .alert-warning }

## DocType
Puede establecer el *doctype* de su página usando `setDocType()`. El método acepta una de las constantes disponibles, generando el HTML `<doctype>` necesario. El método devuelve el componente `Tag` y por lo tanto la llamada se puede encadenar.

- `HTML32`
- `HTML401_STRICT`
- `HTML401_TRANSITIONAL`
- `HTML401_FRAMESET`
- `HTML5`
- `XHTML10_STRICT`
- `XHTML10_TRANSITIONAL`
- `XHTML10_FRAMESET`
- `XHTML11`
- `XHTML20`
- `XHTML5`

```php
<?php

use Phalcon\Tag;

Tag::setDocType(Tag::XHTML20);

echo Tag::getDocType(); 
```

El siguiente ejemplo producirá:

```html
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 2.0//EN'
    'http://www.w3.org/MarkUp/DTD/xhtml2.dtd'>
```

El valor predeterminado es `HTML5` que genera:

```html
<!DOCTYPE html>
```

Puede mostrar el *doctype* usando `getDocType()` en sus vistas:

```php
<?php echo $this->tag->getDocType(); ?>
```

o en Volt:

```twig
{% raw %}{{ get_doctype() }}{% endraw %}
```

## Título
[Phalcon\Tag][tag] offers methods to set the tag of the resulting page or HTML sent to the user. Hay varios métodos disponibles:

### `appendTitle()`
Añade texto al título actual. Este método acepta un `string` o un `array`.

> **NOTE**: If a `string` is supplied, it will be added to the internal collection holding the append title text. Si por el contrario proporciona un `array` se reemplazará la colección interna. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Tag;

Tag::setTitle('Phalcon');

echo Tag::getTitle(); // 'Phalcon'

Tag::appendTitle(' Framework');
Tag::appendTitle(' Rocks');

echo Tag::getTitle(); // 'Phalcon Framework Rocks'

Tag::appendTitle('Will be replaced');
Tag::appendTitle(
    [
        ' Framework',
        ' Rocks',
    ]
);

echo Tag::getTitle(); // 'Phalcon Framework Rocks'
```

### `friendlyTitle()`
Convierte texto a cadenas amigables con URL. It accepts the following parameters:
- `text` - The text to be processed
- `parameters` - Array of parameters to generate the friendly title

The parameters can be:
- `lowercase` - `bool` Whether to convert everything to lowercase or not
- `separator` - `string` - The separator. Defaults to `-`
- `replace` - `array` - Key value array to replace characters with others. Esto usa \[str_replace\]\[str_replace\] internamente para este reemplazo

```php
<?php

use Phalcon\Tag;

echo Tag::friendlyTitle('Phalcon Framework'); 
// 'Phalcon-Framework';

echo Tag::friendlyTitle(
    'Phalcon Framework',
    [
        'separator' => '_',
        'lowercase' => true,
    ]
); // 'phalcon_framework

echo Tag::friendlyTitle(
    'Phalcon Framework',
    [
        'separator' => '_',
        'lowercase' => true,
        'replace'   => [
            'a' => 'x',
            'e' => 'x',
            'o' => 'x',
        ] 
    ]
); // 'phxlcxn_frxmxwxrk
```

### `getTitle()`
Devuelve el título actual. El título se escapa automáticamente. The method accepts two parameters:
 - `prepend` - `bool` Whether to output any text set with `prependTitle()`
 - `append` - `bool` Whether to output any text set with `appendTitle()`

 Ambos parámetros son `true` por defecto.

```php
<?php

use Phalcon\Tag;

Tag::setTitleSeparator(' ');

Tag::prependTitle('Hello');
Tag::setTitle('World');
Tag::appendTitle('from Phalcon');

echo Tag::getTitle();             // 'Hello World from Phalcon';
echo Tag::getTitle(false);        // 'World from Phalcon';
echo Tag::getTitle(true, false);  // 'Hello World';
echo Tag::getTitle(false, false); // 'World';
```

### `getTitleSeparator()`
Devuelve el separador de título actual. El valor por defecto es una cadena vacía.

```php
<?php

use Phalcon\Tag;

echo Tag::getTitleSeparator(); // ''
```

### `prependTitle()`
Antepone texto al título actual. Este método acepta un `string` o un `array`.

> **NOTE**: If a `string` is supplied, it will be added to the internal collection holding the prepend title text. Si por el contrario proporciona un `array` se reemplazará la colección interna. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Tag;

Tag::setTitle('Rocks');

echo Tag::getTitle(); // 'Rocks'

Tag::prependTitle('Phalcon ');
Tag::prependTitle('Framework ');

echo Tag::getTitle(); // 'Phalcon Framework Rocks'

Tag::prependTitle('Will be replaced');
Tag::prependTitle(
    [
        'Phalcon ',
        'Framework ',
    ]
);

echo Tag::getTitle(); // 'Phalcon Framework Rocks'
```

### `renderTitle()`
Devuelve el título actual envuelto en etiquetas `<title>`. El título se escapa automáticamente. The method accepts two parameters:
 - `prepend` - `bool` Whether to output any text set with `prependTitle()`
 - `append` - `bool` Whether to output any text set with `appendTitle()`

 Ambos parámetros son `true` por defecto.

```php
<?php

use Phalcon\Tag;

Tag::setTitleSeparator(' ');

Tag::prependTitle('Hello');
Tag::setTitle('World');
Tag::appendTitle('from Phalcon');

echo Tag::renderTitle();             
// '<title>Hello World from Phalcon</title>';
echo Tag::renderTitle(false);        
// '<title>World from Phalcon</title>';
echo Tag::renderTitle(true, false);  
// '<title>Hello World</title>';
echo Tag::renderTitle(false, false); 
// '<title>World</title>';
```

### `setTitle()`
Establece el texto del título.

```php
<?php

use Phalcon\Tag;

Tag::setTitle('World');
```

### `setTitleSeparator()`
Establece el separador del título.

```php
<?php

use Phalcon\Tag;

Tag::setTitleSeparator(' ');
```

## Entrada
### `checkField()`
Construye una etiqueta HTML `input[type='check']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::checkField(
    [
        'terms',
        'value' => 'Y',
    ]
);

// <input type='checkbox' id='terms' name='terms' value='Y' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->checkField(
    [
        'terms', 
        'value' => 'Y',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ check_field('terms', 'value': 'Y') }}{% endraw %}
```

### `colorField()`
Construye una etiqueta HTML `input[type='color']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::colorField(
    [
        'background',
        'class' => 'myclass',
    ]
);

// <input type='color' id='background' name='background' class='myclass' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->colorField(
    [
        'background',
        'class' => 'myclass',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ color_field('background', 'class': 'myclass') }}{% endraw %}
```

### `dateField()`
Construye una etiqueta HTML `input[type='date']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::dateField(
    [
        'born',
        'value' => '1980-01-01',
    ]
);

// <input type='date' id='born' name='born' value='1980-01-01' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->dateField(
    [
        'born',
        'value' => '1980-01-01',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ date_field('born', 'value': '1980-01-01') }}{% endraw %}
```

### `dateTimeField()`
Construye una etiqueta HTML `input[type='datetime']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::dateTimeField(
    [
        'born',
        'value' => '1980-01-01 01:02:03',
    ]
);

// <input type='datetime' id='born' name='born' 
//        value='1980-01-01 01:02:03' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->dateTimeField(
    [
        'born',
        'value' => '1980-01-01 01:02:03',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ date_time_field('born', 'value': '1980-01-01') }}{% endraw %}
```

### `dateTimeLocalField()`
Construye una etiqueta HTML `input[type='datetime-local']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::dateTimeLocalField(
    [
        'born',
        'value' => '1980-01-01 01:02:03',
    ]
);

// <input type='datetime-local' id='born' name='born' 
//        value='1980-01-01 01:02:03' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->dateTimeLocalField(
    [
        'born',
        'value' => '1980-01-01 01:02:03',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ date_time_local_field('born', 'value': '1980-01-01 01:02:03') }}{% endraw %}
```

### `fileField()`
Construye una etiqueta HTML `input[type='file']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::fileField(
    [
        'document',
        'class' => 'input',
    ]
);

// <input type='file' id='document' name='document' class='input' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->fileField(
    [
        'document',
        'class' => 'input',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ file_field('document', 'class': 'input') }}{% endraw %}
```

### `hiddenField()`
Construye una etiqueta HTML `input[type='hidden']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::hiddenField(
    [
        'id',
        'value' => '1234',
    ]
);

// <input type='hidden' id='id' name='id' value='1234' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->hiddenField(
    [
        'id',
        'value' => '1234',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ hidden_field('id', 'value': '1234') }}{% endraw %}
```

### `imageInput()`
Construye una etiqueta HTML `input[type='image']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::imageInput(
    [
        'src' => '/img/button.png',
    ]
);

// <input type='image' src='/img/button.png' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->imageInput(
    [
        'src' => '/img/button.png',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ image_input('src': '/img/button.png') }}{% endraw %}
```

### `monthField()`
Construye una etiqueta HTML `input[type='month']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::monthField(
    [
        'month',
        'value' => '04',
    ]
);

// <input type='month' id='month' name='month' value='04' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->monthField(
    [
        'month',
        'value' => '04',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ month_field('month', 'value': '04') }}{% endraw %}
```

### `numericField()`
Construye una etiqueta HTML `input[type='number']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::numericField(
    [
        'price',
        'min' => '1',
        'max' => '5',
    ]
);

// <input type='number' id='price' name='price' min='1' max='5' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->numericField(
    [
       'price',
       'min' => '1',
       'max' => '5',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ numeric_field('price', 'min': '1', 'max': '5') }}{% endraw %}
```

### `radioField()`
Construye una etiqueta HTML `input[type='radio']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::radioField(
    [
        'gender',
        'value' => 'Male',
    ]
);

// <input type='radio' id='gender' name='gender' value='Male' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->radioField(
    [
        'gender',
        'value' => 'Male',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ radio_field('gender', 'value': 'Male') }}{% endraw %}
```

### `rangeField()`
Construye una etiqueta HTML `input[type='range']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::rangeField(
    [
        'points',
        'min' => '0',
        'max' => '10',
    ]
);

// <input type='range' id='points' name='points' min='0' max='10' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->rangeField(
    [
        'points',
        'min' => '0',
        'max' => '10',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ range_field('points', 'min': '0', 'max': '10') }}{% endraw %}
```

### `searchField()`
Construye una etiqueta HTML `input[type='search']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::searchField(
    [
        'search',
        'q' => 'startpage',
    ]
);

// <input type='search' id='search' name='search' q='startpage' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->searchField(
    [
        'search',
        'q' => 'startpage',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ search_field('search', 'q': 'startsearch') }}{% endraw %}
```

### `submitButton()`
Construye una etiqueta HTML `input[type='submit']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::submitButton(
    [
        'Save',
    ]
);

// <input type='submit' value='Save' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->submitButton(
    [
       'Save',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ submit_button('Save') }}{% endraw %}
```

### `telField()`
Construye una etiqueta HTML `input[type='tel']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::telField(
    [
        'mobile',
        'size' => '12',
    ]
);

// <input type='tel' id='mobile' name='mobile' size='12' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->telField(
    [
       'mobile',
       'size' => '12',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ tel_field('mobile', 'size': '12') }}{% endraw %}
```

### `passwordField()`
Construye una etiqueta HTML `input[type='text']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::textField(
    [
        'name',
        'size' => '30',
    ]
);

// <input type='text' id='name' name='name' size='30' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->textField(
    [
       'name',
       'size' => '30',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ text_field('name', 'size': '30') }}{% endraw %}
```

### `timeField()`
Construye una etiqueta HTML `input[type='time']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::timeField(
    [
        'start',
        'size' => '5',
    ]
);

// <input type='time' id='start' name='start' size='5' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->timeField(
    [
       'start',
       'size' => '5',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ time_field('start', 'size': '5') }}{% endraw %}
```

### `urlField()`
Construye una etiqueta HTML `input[type='url']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::urlField(
    [
        'homepage',
    ]
);

// <input type='url' id='homepage' name='homepage' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->urlField(
    [
       'homepage',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ url_field('homepage') }}{% endraw %}
```

### `weekField()`
Construye una etiqueta HTML `input[type='week']`. Acepta un vector con los atributos del elemento. El primer elemento del vector es el nombre del elemento.

```php
<?php

use Phalcon\Tag;

echo Tag::weekField(
    [
        'week',
        'size' => '2',
    ]
);

// <input type='week' id='week' name='week' size='2' />
```

Sintaxis HTML:
```php
<?php echo $this->tag->weekField(
    [
       'week',
       'size' => '2',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ week_field('week', 'size': '2') }}{% endraw %}
```

## Elementos

### `image()`
Construye una etiqueta HTML de imagen. Acepta un vector con los atributos del elemento. El primer elemento del vector es el `src` del elemento. El método acepta un segundo parámetro booleano, que indica si el recurso es local o no.

```php
<?php

use Phalcon\Tag;

echo Tag::image(
    [
       'img/hello.gif',
       'alt' => 'alternative text',
    ]
);

// <img alt='alternative text' src='/your-app/img/hello.gif'>

echo Tag::image(
   'http://static.mywebsite.com/img/bg.png',
    false
);

// <img src='http://static.mywebsite.com/img/bg.png'>
```

Sintaxis HTML:
```php
<?php echo $this->tag->image(
    [
       'img/hello.gif',
       'alt' => 'alternative text',
    ]
); ?>

<?php echo $this->tag->image(
   'http://static.mywebsite.com/img/bg.png',
    false
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ image('img/hello.gif', 'alt': 'alternative text') }}
{{ image('http://static.mywebsite.com/img/bg.png', false) }}{% endraw %}
```

### `select()`
`select()` es un ayudante que le permite crear un elemento `<select>` basado en un conjunto de resultados `Phalcon\Mvc\Model`. Necesitará tener una configuración de conexión de base de datos válida en su contenedor DI para que este método produzca HTML correcto. El componente requiere parámetros y datos para funcionar.
- `parameters` - `string`/`array`. Si se pasa una cadena, será el nombre del elemento. Si se pasa un vector, el primer elemento será el nombre del elemento. There available parameters are:
    - `id` - `string` - sets the id of the element
    - `using` - `array` - **required** a two element array defining the key and value fields of the model to populate the select
    - `useEmpty` - `bool` - defaults to `false`. If set, it will add an _empty_ option to the select box
    - `emptyText` - `string` - the text to display for the _empty_ option (i.e. _Choose an option_)
    - `emptyValue` - `string`/`number` - the value to assign for the _empty_ option
    - any additional HTML attributes in a key/value format
- `data` - `Resultset` the resultset from the model operation.

```php
<?php

use MyApp\Constants\Status;
use MyApp\Models\Invoices;
use Phalcon\Tag;

$resultset = Invoices::find(
    [
        'conditions' => 'inv_status_flag = :status:',
        'bind'       => [
            'status' => Status::UNPAID,
        ]
    ]
);

echo Tag::select(
    [
        'invoiceId',
        $resultset,
        'using'      => [
            'inv_id', 
            'inv_title',
        ],
        'useEmpty'   => true,
        'emptyText'  => 'Choose an Invoice to pay',
        'emptyValue' => '0',
    ]
);

// <select id='invoiceId' name='invoiceId'>
//     <option value='0'>Choose an Invoice to pay</option>
//     <option value='24'>Chocolates 24oz box</option>
//     <option value='77'>Sugar 1 bag</option>
// </select>
```

Sintaxis HTML:
```php
<?php echo $this->tag->select(
    [
        'invoiceId',
        $resultset,
        'using'      => [
            'inv_id', 
            'inv_title',
        ],
        'useEmpty'   => true,
        'emptyText'  => 'Choose an Invoice to pay',
        'emptyValue' => '0',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ select(
    [
        'invoiceId',
        $resultset,
        'using'      : [
            'inv_id', 
            'inv_title',
        ],
        'useEmpty'   : true,
        'emptyText'  : 'Choose an Invoice to pay',
        'emptyValue' : '0',
    ]
) }}{% endraw %}
```

### `selectStatic()`
Este ayudante es similar a `select()`, pero usa un vector PHP como fuente. El componente requiere parámetros y datos para funcionar.
- `parameters` - `string`/`array`. Si se pasa una cadena, será el nombre del elemento. Si se pasa un vector, el primer elemento será el nombre del elemento. There available parameters are:
    - `id` - `string` - sets the id of the element
    - `useEmpty` - `bool` - defaults to `false`. If set, it will add an _empty_ option to the select box
    - `emptyText` - `string` - the text to display for the _empty_ option (i.e. _Choose an option_)
    - `emptyValue` - `string`/`number` - the value to assign for the _empty_ option
    - any additional HTML attributes in a key/value format
- `data` - `array` the array of data with key as the id and value as the text

```php
<?php

use MyApp\Constants\Status;
use MyApp\Models\Invoices;
use Phalcon\Tag;

$resultset = [
    24 => 'Chocolates 24oz box',
    77 => 'Sugar 1 bag',
];

echo Tag::selectStatic(
    [
        'invoiceId',
        $resultset,
        'useEmpty'   => true,
        'emptyText'  => 'Choose an Invoice to pay',
        'emptyValue' => '0',
    ]
);

// <select id='invoiceId' name='invoiceId'>
//     <option value='0'>Choose an Invoice to pay</option>
//     <option value='24'>Chocolates 24oz box</option>
//     <option value='77'>Sugar 1 bag</option>
// </select>
```

Sintaxis HTML:
```php
<?php echo $this->tag->selectStatic(
    [
        'invoiceId',
        $resultset,
        'useEmpty'   => true,
        'emptyText'  => 'Choose an Invoice to pay',
        'emptyValue' => '0',
    ]
); ?>
```

Sintaxis Volt:
```twig
{% raw %}{{ select(
    [
        'invoiceId',
        $resultset,
        'useEmpty'   : true,
        'emptyText'  : 'Choose an Invoice to pay',
        'emptyValue' : '0',
    ]
) }}{% endraw %}
```

### `tagHtml()`
Phalcon ofrece un ayudante HTML genérico que permite la generación de cualquier tipo de elemento HTML. Corresponde al desarrollador producir un nombre de elemento HTML válido para el ayudante. The accompanying `tagHtmlClose()` can be used to _close_ the tag if necessary.

The `tagHtml()` accepts the following parameters
- `name` - `string` - the name of the element
- `attributes` - `array` - any attributes
- `selfClose` - `bool` - whether this is a self closing element or not
- `onlyStart` - `bool` - whether to produce only the _opening_ part of the tag (i.e. `<tag>` vs. `<tag></tag>`)
- `useEol` - `bool` - add a `PHP_EOL` at the end of the generated string or not

```php
<?php

use Phalcon\Tag;

echo Tag::tagHtml(
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

echo 'This is my canvas';
echo Tag::tagHtmlClose('canvas');

// <canvas id='canvas1' width='300' class='cnvclass'>
// This is my canvas
// </canvas>
```

Sintaxis HTML:
```php
<?php 

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

echo 'This is my canvas';
echo $this->tag->tagHtmlClose('canvas'); 

?>
```

Sintaxis Volt:
```twig
{% raw %}
{{ tag_html('canvas', ['id': 'canvas1', width': '300', 'class': 'cnvclass'], false, true, true) }}
    This is my canvas
{{ tag_html_close('canvas') }}
{% endraw %}
```
## Recursos Activos
[Phalcon\Tag][tag] offers helper methods to generate stylesheet and javascript HTML tags.

### `stylesheetLink()`
El primer parámetro `string` o `array` son los parámetros necesarios para construir el elemento. El segundo parámetro es un booleano, que indica si el enlace apunta a un recurso local o remoto.

```php
<?php

use Phalcon\Tag;

echo Tag::stylesheetLink('css/style.css');
// <link rel='stylesheet' href='/css/style.css'>

echo Tag::stylesheetLink(
    'https://fonts.googleapis.com/css?family=Rosario',
    false
);
// <link rel='stylesheet' 
//       href='https://fonts.googleapis.com/css?family=Rosario' 
//       type='text/css'>

echo Tag::stylesheetLink(
    [
        'href'  => 'https://fonts.googleapis.com/css?family=Rosario',
        'class' => 'some-class',
    ],
    false
);
// <link rel='stylesheet' 
//       href='https://fonts.googleapis.com/css?family=Rosario' 
//       type='text/css'>
```

Sintaxis HTML

```php
<?php echo $this->tag->stylesheetLink('css/style.css'); ?>

<?php 

echo $this->tag->stylesheetLink(
    'https://fonts.googleapis.com/css?family=Rosario',
    false
); ?>

<?php 

echo $this->tag->stylesheetLink(
    [
        'href'  => 'https://fonts.googleapis.com/css?family=Rosario',
        'class' => 'some-class',
    ],
    false
); ?>
```

Sintaxis Volt:

```php
{% raw %}{{ stylesheet_link('css/style.css') }}
{{ stylesheet_link(
        'https://fonts.googleapis.com/css?family=Rosario', 
        false
    ) 
}}
{{ stylesheet_link(
        [
            'href'  : 'https://fonts.googleapis.com/css?family=Rosario',
            'class' : 'some-class',
        ],
        false
    ) 
}}{% endraw %}
```

### `javascriptInclude()`
El primer parámetro `string` o `array` son los parámetros necesarios para construir el elemento. El segundo parámetro es un booleano, que indica si el enlace apunta a un recurso local o remoto.

```php
<?php

use Phalcon\Tag;

echo Tag::javascriptInclude('js/jquery.js');
// <script src='/js/jquery.js' type='text/javascript'></script>

echo Tag::javascriptInclude(
    'https://code.jquery.com/jquery/jquery.min.js',
    false
);
// <script src='https://code.jquery.com/jquery/jquery.min.js' 
//         type='text/javascript'></script>

echo Tag::javascriptInclude(
    [
        'src'  => 'https://code.jquery.com/jquery/jquery.min.js',
        'type' => 'application/javascript',
    ],
    false
);
// <script src='https://code.jquery.com/jquery/jquery.min.js' 
//         type='application/javascript'></script>
```

Sintaxis HTML

```php
<?php echo $this->tag->javascriptInclude('js/jquery.js'); ?>

<?php 

echo $this->tag->javascriptInclude(
    'https://fonts.googleapis.com/css?family=Rosario',
    false
); ?>

<?php 

echo $this->tag->javascriptInclude(
    [
        'src'  => 'https://code.jquery.com/jquery/jquery.min.js',
        'type' => 'application/javascript',
    ],
    false
); ?>
```

Sintaxis Volt:

```php
{% raw %}{{ javascript_include('js/jquery.js') }}
{{ javascript_include(
        'https://code.jquery.com/jquery/jquery.min.js', 
        false
    ) 
}}
{{ javascript_include(
        [
            'src'  : 'https://code.jquery.com/jquery/jquery.min.js',
            'type' : 'application/javascript',
        ],
        false
    ) 
}}{% endraw %}
```

## Enlaces
Una tarea común en cualquier aplicación web es mostrar enlaces que ayudan con la navegación de un área a otra. [Phalcon\Tag][tag] offers `linkTo()` to help with this task. El método acepta tres parámetros.
- `parameters` - `array`/`string` - The attributes and parameters of the element. Si se pasa una cadena se tratará como URL destino del enlace. If an array is passed, the following elements can be sent:
    - `action` - the URL. If the `action` is an array, you can reference a named route defined in your routes using the `for` element
    - `query` - the base query for the URL
    - `text` - the text of the link
    - `local` - whether this is a local or remote link
    - additional key/value attributes for the link
- `text` - `string` - the text of the link
- `local` - `bool` - whether this is a local or remote link


```php
<?php

use Phalcon\Tag;

echo Tag::linkTo('signup/register', 'Register Here!');

// <a href='/signup/register'>Register Here!</a>
echo Tag::linkTo(
    [
        'signup/register',
        'Register Here!',
        'class' => 'btn-primary',
    ]
);
// <a href='/signup/register' class='btn-primary'>Register Here!</a>

echo Tag::linkTo('https://phalcon.io/', 'Phalcon', false);
// <a href='https://phalcon.io/'>Phalcon</a>

 echo Tag::linkTo(
    [
        'https://phalcon.io/',
        'Phalcon Home',
        false,
    ]
);
// <a href='https://phalcon.io/'>Phalcon Home</a>
```

Sintaxis HTML:
```php
<?php 

echo $this->tag->linkTo('signup/register', 'Register Here!');

echo $this->tag->linkTo(
    [
        'signup/register',
        'Register Here!',
        'class' => 'btn-primary',
    ]
);

echo $this->tag->linkTo('https://phalcon.io/', 'Phalcon', false);

 echo $this->tag->linkTo(
    [
        'https://phalcon.io/',
        'Phalcon Home',
        false,
    ]
);

?>
```

Sintaxis Volt:
```twig
{% raw %}
{{ link_to('signup/register', 'Register Here!') }}
{{ link_to(
    'signup/register',
    'Register Here!',
    'class': 'btn-primary'
) }}

{{ link_to('https://phalcon.io/', 'Phalcon', false) }}

{{ link_to(
    'https://phalcon.io/',
    'Phalcon Home',
    false
) }}{% endraw %}
```

Si tiene rutas nombradas, puede usar la palabra clave `for` en su vector de parámetros para referenciarla. [Phalcon\Tag][tag] will resolve the route internally and produce the correct URL using [Phalcon\Url](mvc-url).

```php
<?php

use Phalcon\Tag;

echo Tag::linkTo(
    [
        [   
            'for'   => 'invoice-view', 
            'title' => 12345, 
            'name'  => 'invoice-12345'
        ], 
        'Show Invoice'
    ]
);
```

Sintaxis HTML:
```php
<?php 

echo $this->tag->linkTo(
    [
        [   
            'for'   => 'invoice-view', 
            'title' => 12345, 
            'name'  => 'invoice-12345'
        ], 
        'Show Invoice'
    ]
);

?>
```

Sintaxis Volt:
```twig
{% raw %}
{{ link_to('signup/register', 'Register Here!') }}
{{ link_to(
    [   
        'for'   : 'invoice-view', 
        'title' : 12345, 
        'name'  : 'invoice-12345'
    ], 
    'Show Invoice',
    'class': 'edit-btn'
) }}{% endraw %}
```

## Formularios
Los formularios juegan un rol importante en las aplicaciones web, ya que se usan para recoger datos del usuario. [Phalcon\Tag][tag] offers the `form()` and `endForm()` methods, which create `<form>` elements.

```php
<?php

use Phalcon\Tag;

echo Tag::form(
    [
        '/admin/invoices/create', 
        'method' => 'post',
        'class'  => 'input'
    ]
);

// <form action='admin/invoices/create' method='post' class='input'>

// ...

echo Tag::endForm();

// </form>
```

Sintaxis HTML:
```php
<?php 

echo $this->tag->form(
    [
        '/admin/invoices/create', 
        'method' => 'post',
        'class'  => 'input'
    ]
);

// ...

echo $this->tag->endForm();
?>
```

Sintaxis Volt:
```twig
{% raw %}
{{ form(
    [
        '/admin/invoices/create', 
        'method' : 'post',
        'class'  : 'input'
    ]
);

{{ end_form() }}{% endraw %}
```

Phalcon también proporciona un [constructor de formularios](forms) para crear formularios de una forma orientada a objetos.

## Datos
### `setDefault()`
You can use `setDefault()` to pre populate values for elements generated by [Phalcon\Tag][tag]. Los ayudantes de este componente conservarán los valores entre peticiones. De esta forma, puede fácilmente mostrar mensajes de validación sin perder los datos introducidos. Cada ayudante de formulario soporta el parámetro `value`. Con esto, puede especificar un valor para el ayudante directamente. Cuando el parámetro está presente, cualquier valor preestablecido usando `setDefault()` o vía petición serán ignorados.

```php
<?php

use Phalcon\Tag;

Tag::setDefault('framework', 'Phalcon');

echo Tag::textField(
    [
        'framework', 
        'class'  => 'input'
    ]
);

// <input type='text' id='framework' name='framework' 
//        value='Phalcon' class='class' />
```

### `setDefaults()`
`setDefaults()` le permite especificar más de un valor para establecerlo en los elementos de su formulario, pasando un vector clave valor. El método se puede llamar más de una vez y cada vez que se llama sobreescribirá los datos establecidos en la llamada previa. Sin embargo, puede especificar el segundo parámetro como `true` para que los valores sean fusionados.

```php
<?php

use Phalcon\Tag;

Tag::setDefaults(
    [
        'framework' => 'Phalcon',
        'version'   => '4.0',
    ]
);

echo Tag::textField(
    [
        'framework', 
        'class'  => 'input'
    ]
);

// <input type='text' id='framework' name='framework' 
//        value='Phalcon' class='class' />

echo Tag::textField(
    [
        'version', 
        'class'  => 'input'
    ]
);

// <input type='text' id='version' name='version' 
//        value='4.0' class='class' />
```

### `getValue()`
Este método se llama desde cualquier ayudante de este componente, para encontrar si un valor se ha establecido para un elemento usando `setDefault()` antes o en el superglobal `$_POST`.

```php
<?php

use Phalcon\Tag;

Tag::setDefaults(
    [
        'framework' => 'Phalcon',
        'version'   => '4.0',
    ]
);

echo Tag::getValue('framework'); // 'Phalcon'

$_POST = [
    'framework' => 'Phalcon',
    'version'   => '4.0',
];

echo Tag::getValue('framework'); // 'Phalcon'
```

### `hasValue()`
Este método comprueba si un `valor` de un elemento ya se ha establecido usando `setDefault()` o está en el superglobal `$_POST`.

```php
<?php

use Phalcon\Tag;

Tag::setDefaults(
    [
        'framework' => 'Phalcon',
        'version'   => '4.0',
    ]
);

echo Tag::hasValue('framework'); // 'true'

$_POST = [
    'framework' => 'Phalcon',
    'version'   => '4.0',
];

echo Tag::hasValue('framework'); // 'true'
```

## Escape
[Phalcon\Tag][tag] automatically escapes text supplied for its helpers. Si la aplicación lo requiere, puede deshabilitar el escape automático usando `setAutoEscape()`.

```php
<?php

use Phalcon\Tag;

echo Tag::textField(
    [
        'framework',
        'value' => '<h1>hello</h1>', 
    ]
);

// <input type="text" id="framework" name="framework" 
//        value="&lt;h1&gt;hello&lt;/h1&gt;" />

Tag::setAutoescape(false);

echo Tag::textField(
    [
        'framework',
        'value' => '<h1>hello</h1>', 
    ]
);

// <input type="text" id="framework" name="framework" 
//        value="<h1>hello</h1>" />
```

## Inyección de Dependencias
If you use the [Phalcon\Di\FactoryDefault][factorydefault] container, the [Phalcon\Tag][tag] is already registered for you with the name `tag`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

**Direct**

```php
<?php

use Phalcon\Di;
use Phalcon\Tag;

$container = new Di();

$container->set(
    'tag',
    function () use  {
        return new Tag();
    }
);
```

Siempre puede implementar su propio ayudante `tag` y registrarlo en el lugar de `tag` en el contenedor Di.

Accessing the service from any component that implements the [Phalcon\Di\Injectable][injectable] is as simple as accessing the `tag` property.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

/**
 * @property Tag $tag
 */
class SessionController extends Controller
{
    public function indexAction()
    {
        $this->tag->setTitle('Phalcon Framework');
    }
}
```

## Personalizado
Fácilmente puede extender esta funcionalidad y crear sus propios ayudantes.

- Primero cree un nuevo directorio en el sistema de ficheros de su aplicación donde se almacenarán los ficheros del ayudante.
- Nómbrelo con algo que lo represente. Por ejemplo en este ejemplo usamos `customhelpers`.
- Cree un fichero llamado `MyTags.php` en su directorio `customhelpers`.
- Extend the [Phalcon\Tag][tag] class and implement your own methods.

```php
<?php

namespace MyApp;

use Phalcon\Tag;

class MyTags extends Tag
{
    /**
     * Generates a widget to show a HTML5 audio tag
     *
     * @param array
     * @return string
     */
    public static function audioField($parameters)
    {
        // Converting parameters to array if it is not
        if (true !== is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Determining attributes 'id' and 'name'
        $parameters[0]      = $parameters[0] ?? $parameters['id'];
        $id                 = $parameters[0];
        $parameters['name'] = $parameters['name'] ?? $id;

        // Determining widget value,
        // \Phalcon\Tag::setDefault() allows to set the widget value
        if (true === isset($parameters['value'])) {
            $value = $parameters['value'];

            unset($parameters['value']);
        } else {
            $value = self::getValue($id);
        }

        // Generate the tag code
        $code = sprintf(
            '<audio id="%s" value="%s" ',
            $id,
            $value
        );

        foreach ($parameters as $key => $attributeValue) {
            if (!is_integer($key)) {
                $code .= sprintf('%s="%s" ', $key, $attributeValue);
            }
        }

        $code.=' />';

        return $code;
    }
}
```

Después de crear nuestro ayudante personalizado, autocargaremos el nuevo directorio que contiene nuestra clase ayudante desde nuestro `index.php` ubicado en el directorio público.

```php
<?php

use Phalcon\Loader\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault();
use Phalcon\Exception as PhalconException;

try {
    $loader = new Loader();

    $loader->registerDirs(
        [
            '../app/controllers',
            '../app/models',
            '../app/customhelpers', // Add the new helpers folder
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Assign our new tag a definition so we can call it
    $di->set(
        'MyTags',
        function () {
            return new MyTags();
        }
    );

    $application = new Application($di);

    $response = $application->handle(
        $_SERVER['REQUEST_URI']
    );

    $response->send();
} catch (PhalconException $e) {
    echo 'PhalconException: ', $e->getMessage();
}
```

Ahora está listo para usar su nuevo ayudante en sus vistas:

```php
<?php

echo MyTags::audioField(
    [
        'name' => 'test',
        'id'   => 'audio_test',
        'src'  => '/path/to/audio.mp3',
    ]
);

?>
```

You can also check out [Volt](volt) a faster template engine for PHP, where you can use a more developer friendly syntax for helpers provided by [Phalcon\Tag][tag].

[factorydefault]: api/phalcon_di#di-factorydefault
[injectable]: api/phalcon_di#di-injectable
[tag]: api/phalcon_tag
[tagfactory]: api/phalcon_html#html-tagfactory
