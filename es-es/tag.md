---
layout: default
language: 'es-es'
version: '4.0'
title: 'Tag'
keywords: 'etiqueta, ayudantes, ayudantes vista, generadores html'
---

# Etiqueta (Ayudantes Vista)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Escribir y mantener código HTML puede convertirse rápidamente en una tarea tediosa a causa de las convenciones de nombre y numerosos atributos que se deben tener en consideración. Phalcon se ocupa de esta complejidad ofreciendo el componente [Phalcon\Tag](api/Phalcon_Tag) que a su vez ofrece ayudantes para generar marcado HTML.

Este componente se puede usar en una vista plana HTML+PHP o en una plantilla [Volt](volt).

> **NOTA**: Esto ofrece la misma funcionalidad que `Phalcon\Html\TagFactory`. En versiones futuras, este componente será remplazado por el `TagFactory`. La razón de ambos componentes es ofrecer tanto tiempo como sea posible a los desarrolladores para que adapten su código, ya que la generación HTML toca muchas áreas de la aplicación, la vista en particular.
{: .alert .alert-warning } 

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

[Phalcon\Tag](api/phalcon_tag) ofrece métodos para establecer la etiqueta de la página resultante o HTML enviado al usuario. Hay varios métodos disponibles:

### `appendTitle()`

Añade texto al título actual. Este método acepta un `string` o un `array`.

> **NOTA**: Si se proporciona un `string`, lo añadirá a la colección interna manteniendo el texto del título adjunto. Si por el contrario proporciona un `array` se reemplazará la colección interna.
{: .alert .alert-info }

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

Convierte texto a cadenas amigables con URL. Acepta los siguientes parámetros: - `text` - Texto a procesar - `parameters` - Vector de parámetros para generar el título amigable

Los parámetros pueden ser: - `lowercase` - `bool` Si convertir todo a minúsculas o no - `separator` - `string` - El separador. Por defecto `-` - `replace` - `array` - Vector clave valor para reemplazar caracteres por otros. Esto usa \[str_replace\]\[str_replace\] internamente para este reemplazo

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

Devuelve el título actual. El título se escapa automáticamente. El método acepta dos parámetros: - `prepend` - `bool` Si mostrar cualquier texto establecido con `prependTitle()` - `append` - `bool` Si mostrar cualquier texto establecido con `appendTitle()`

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

> **NOTA**: Si se proporciona un `string`, se añadirá a la colección interna manteniendo el texto de título antepuesto. Si por el contrario proporciona un `array` se reemplazará la colección interna.
{: .alert .alert-info }

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

Devuelve el título actual envuelto en etiquetas `<title>`. El título se escapa automáticamente. El método acepta dos parámetros: - `prepend` - `bool` Si mostrar cualquier texto establecido con `prependTitle()` - `append` - `bool` Si mostrar cualquier texto establecido con `appendTitle()`

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

`select()` es un ayudante que le permite crear un elemento `<select>` basado en un conjunto de resultados `Phalcon\Mvc\Model`. Necesitará tener una configuración de conexión de base de datos válida en su contenedor DI para que este método produzca HTML correcto. El componente requiere parámetros y datos para funcionar. - `parameters` - `string`/`array`. Si se pasa una cadena, será el nombre del elemento. Si se pasa un vector, el primer elemento será el nombre del elemento. Los parámetros disponibles son: - `id` - `string` - establece el id del elemento - `using` - `array` - **required** un vector de dos elementos que definen campos clave y valor del modelo para rellenar la selección - `useEmpty` - `bool` - defaults to `false`. Si se establece, añadirá una opción *vacía* a la caja de la selección - `emptyText` - `string` - texto a mostrar para la opción *vacía* (ej. *Elija una opción*) - `emptyValue` - `string`/`number` - el valor a asignar para la opción *vacía* - cualquier atributo HTML adicional en formato clave/valor - `data` - `Resultset` el conjunto de resultados de la operación del modelo.

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

Este ayudante es similar a `select()`, pero usa un vector PHP como fuente. El componente requiere parámetros y datos para funcionar. - `parameters` - `string`/`array`. Si se pasa una cadena, será el nombre del elemento. Si se pasa un vector, el primer elemento será el nombre del elemento. Los parámetros disponibles son: - `id` - `string` - establece el id del elemento - `useEmpty` - `bool` - por defecto `false`. Si se establece, añadirá una opción *vacía* a la caja de selección - `emptyText` - `string` - el texto a mostrar para la opción *vacía* (ej. *Elija una opción*) - `emptyValue` - `string`/`number` - el valor a asignar para la opción *vacía* - cualquier atributo HTML adicional en formato clave/valor - `data` - `array` el vector de datos con clave como el id y el valor como el texto

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

Phalcon ofrece un ayudante HTML genérico que permite la generación de cualquier tipo de elemento HTML. Corresponde al desarrollador producir un nombre de elemento HTML válido para el ayudante. Si se necesita, se puede usar el acompañante `tagHtmlClose()` para *cerrar*.

`tagHtml()` acepta los siguientes parámetros - `name` - `string` - el nombre del elemento - `attributes` - `array` - cualquier atributo - `selfClose` - `bool` - si es un elemento de autocierre o no - `onlyStart` - `bool` - si producir sólo la parte de *apertura* de la etiqueta (ej. `<tag>` vs. `<tag></tag>`) - `useEol` - `bool` - añade un `PHP_EOL` al final de la cadena generada o no

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

[Phalcon\Tag](api/phalcon_tag) ofrece métodos ayudantes para generar etiquetas HTML de hojas de estilos y javascript.

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

Una tarea común en cualquier aplicación web es mostrar enlaces que ayudan con la navegación de un área a otra. [Phalcon\Tag](api/phalcon_tag) ofrece `linkTo()` para ayudar con esta tarea. El método acepta tres parámetros. - `parameters` - `array`/`string` - Los atributos y parámetros del elemento. Si se pasa una cadena se tratará como URL destino del enlace. Si se pasa un vector, se pueden enviar los siguientes elementos: - `action` - la URL. Si la `action` es un vector, puede referenciar una ruta nombrada definida en sus rutas usando el elemento `for` - `query` - la consulta base para la URL - `text` - el texto del enlace - `local` - si es un enlace local o remoto - atributos clave/valor adicionales para el enlace - `text` - `string` - el texto del enlace - `local` - `bool` - si es un enlace local o remoto

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

Si tiene rutas nombradas, puede usar la palabra clave `for` en su vector de parámetros para referenciarla. [Phalcon\Tag](api/phalcon_tag) resolverá la ruta internamente y producirá la URL correcta usando [Phalcon\Url](url).

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

Los formularios juegan un rol importante en las aplicaciones web, ya que se usan para recoger datos del usuario. [Phalcon\Tag](api/phalcon_tag) ofrece los métodos `form()` y `endForm()`, que crean elementos `<form>`.

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

Puede usar `setDefault()` para pre rellenar valores para los elementos generados con [Phalcon\Tag](api/phalcon_tag). Los ayudantes de este componente conservarán los valores entre peticiones. De esta forma, puede fácilmente mostrar mensajes de validación sin perder los datos introducidos. Cada ayudante de formulario soporta el parámetro `value`. Con esto, puede especificar un valor para el ayudante directamente. Cuando el parámetro está presente, cualquier valor preestablecido usando `setDefault()` o vía petición serán ignorados.

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

[Phalcon\Tag](api/phalcon_tag) escapa automáticamente el texto proporcionado por sus ayudantes. Si la aplicación lo requiere, puede deshabilitar el escape automático usando `setAutoEscape()`.

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

Si usa el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), [Phalcon\Tag](api/phalcon_tag) ya está registrado para usted con el nombre `tag`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

**Directo**

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

Acceder al servicio desde cualquier componente que implemente [Phalcon\Di\Injectable](api/phalcon_di#di-injectable) es tan simple como acceder a la propiedad `tag`.

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
- Extienda la clase [Phalcon\Tag](api/phalcon_tag) e implemente sus propios métodos.

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

También puede revisar [Volt](volt), un motor de plantillas más rápido para PHP, donde puede usar una sintaxis más amigable con el desarrollador para los ayudantes proporcionados por [Phalcon\Tag](api/phalcon_tag).
