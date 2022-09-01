---
layout: default
language: 'es-es'
version: '5.0'
upgrade: ''
title: 'HTML Tag Factory'
keywords: 'html, tag factory, factory, tags'
---

# Tag Factory
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Html\TagFactory][html-tagfactory] is a component that generates HTML tags. Este componente crea una nueva clase localizador con etiquetas HTML predefinidas adjuntas a él. Cada clase etiqueta es cargada de forma perezosa para maximizar el rendimiento. To instantiate the factory and retrieve a tag helper, you need to call `newInstance()` by passing a `Phalcon\Html\Escaper` object to it.

If you are using the [Phalcon\Di\FactoryDefault][di-factorydefault] container for your application, the [Phalcon\Html\TagFactory][html-tagfactory] is already registered for you with the name `tag`.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\TagFactory;

$escaper = new Escaper();
$factory = new TagFactory($escaper);
$helper  = $factory->newInstance('a');
```

```php
<?php

use Phalcon\Di\FactoryDefault;

$container = new FactoryDefault();

$helper = $container->tag->newInstance('a');
```

Los nombres registrados para los respectivos ayudantes son:

| Nombre               | Clase                                         |
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

### Method call
If you do not wish to call `newInstance()`, you can always use the method call that corresponds to the name of the helper. Some helpers accept a `bool` `$raw` parameter, which defines whether the input will be escaped or not. This is useful when creating anchor links with images.

```php
public function a(
    string $href, 
    string $text, 
    array $attributes = [], 
    bool $raw = false
): string

public function base(
    string $href, 
    array $attributes = []
): string

public function body(
    array $attributes = []
): string

public function button(
    string $text, 
    array $attributes = [], 
    bool $raw = false
): string

public function close(
    string $tag, 
    bool $raw = false
): string

public function doctype(
    int $flag, 
    string $delimiter
): string

public function element(
    string $tag, 
    string $text, 
    array $attributes = [], 
    bool $raw = false
): string

public function form(
    array $attributes = []
): string

public function img(
    string $src, 
    array $attributes = []
): string

public function inputCheckbox(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputColor(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputDate(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputDateTime(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputDateTimeLocal(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputEmail(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputFile(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputHidden(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputImage(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputInput(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputMonth(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputNumeric(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputPassword(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputRadio(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputRange(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputSearch(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputSelect(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputSubmit(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputTel(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputText(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputTextarea(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputTime(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputUrl(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function inputWeek(
    string $name, 
    string $value = null, 
    array $attributes = []
): string

public function label(
    string $label, 
    array $attributes = [], 
    bool $raw = false
): string

public function link(
    string $indent = '    ', 
    string $delimiter = PHP_EOL
): string

public function meta(
    string $indent = '    ', 
    string $delimiter = PHP_EOL
): string

public function ol(
    string $text, 
    array $attributes = [], 
    bool $raw = false
): string

public function script(
    string $indent = '    ', 
    string $delimiter = PHP_EOL
): string

public function style(
    string $indent = '    ', 
    string $delimiter = PHP_EOL
): string

public function title(
    string $indent = '    ', 
    string $delimiter = PHP_EOL
): string

public function ul(
    string $text, 
    array $attributes = [], 
    bool $raw = false
): string

```

```php
<?php

use Phalcon\Di\FactoryDefault;

$container = new FactoryDefault();

$result = $container->tag->a('https://phalcon.io', 'Phalcon Website');

$image  = $container
    ->tag
    ->img('https://phalcon.io/img/phalcon.png')
;

$result = $container
    ->tag
    ->a(
        'https://phalcon.io', 
        $image,
        true
    )
;
```

### Ayudantes
All helpers that are used by the [Phalcon\Html\TagFactory][html-tagfactory] are located under the `Phalcon\Html\Helper` namespace. Puede crear cada una de estas clases individualmente si lo desea, o puede usar la factoría de etiquetas tal y como se muestra arriba.

> **NOTA**: El código y la salida inferior han sido formateados por legibilidad 
> 
> {: .alert .alert-info }

### `a`
[Phalcon\Html\Helper\Anchor][html-helper-anchor] creates a `<a>` (anchor) tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $href`           | The href                          |
| `string $text`           | The text to display               |
| `array $attributes = []` | Additional attributes (key/value) |
| `bool $raw = false`      | Whether to escape or not the text |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Anchor;

$escaper = new Escaper();
$helper  = new Anchor($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('/myurl', 'click<>me', $options);
// <a href="/myurl" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </a>
```

### `base`
[Phalcon\Html\Helper\Base][html-helper-base] creates a `<base>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $href`           | The href                          |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Base;

$escaper = new Escaper();
$helper  = new Base($escaper);
$options = [
    'target' => '_blank',
];

echo $helper('/myurl', $options);
// <base href="/myurl" 
//    target="_blank">
```

### `body`
[Phalcon\Html\Helper\Body][html-helper-body] creates a `<body>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Body;

$escaper = new Escaper();
$helper  = new Body($escaper);
$options = [
    'class' => 'my-class',
    'id'    => 'my-id',
];

echo $helper($options);
// <body id="my-id" class="my-class">
```
> **NOTE**: Este ayudante crear sólo la etiqueta de apertura `<body>`. Necesitarás usar el ayudante `Close` para generar la etiqueta de cierre `</body>`. 
> 
> {: .alert .alert-info }

### `button`
[Phalcon\Html\Helper\Button][html-helper-button] creates a `<button>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $text`           | The text to display               |
| `array $attributes = []` | Additional attributes (key/value) |
| `bool $raw = false`      | Whether to escape or not the text |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Button;

$escaper = new Escaper();
$helper  = new Button($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('click<>me', $options);
// <button 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </button>
```

### `close`
[Phalcon\Html\Helper\Close][html-helper-close] creates a closing tag.

| Parámetro           | Descripción                       |
| ------------------- | --------------------------------- |
| `string $text`      | The text to display               |
| `bool $raw = false` | Whether to escape or not the text |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Close;

$escaper = new Escaper();
$helper  = new Close($escaper);

echo $helper('form');
// </form>
```

### `doctype`
[Phalcon\Html\Helper\Doctype][html-helper-doctype] creates a `<doctype>` tag.

| Parámetro           | Descripción                       |
| ------------------- | --------------------------------- |
| `int $flag`         | The text to display               |
| `string $delimiter` | Whether to escape or not the text |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Doctype;

$escaper = new Escaper();
$helper  = new Doctype($escaper);

echo $helper(Doctype::XHTML11, '-:-');
// <!DOCTYPE html
//     PUBLIC "-//W3C//DTD XHTML 1.1//EN"-:-
//     "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">-:-
```

### `element`
[Phalcon\Html\Helper\Element][html-helper-element] creates a tag based on the passed `name`.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $tag`            | The href                          |
| `string $text`           | The text to display               |
| `array $attributes = []` | Additional attributes (key/value) |
| `bool $raw = false`      | Whether to escape or not the text |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Element;

$escaper = new Escaper();
$helper  = new Element($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('address', 'click<>me', $options);
// <address 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </address>
```

### `form`
[Phalcon\Html\Helper\Form][html-helper-form] creates a `<form>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Form;

$escaper = new Escaper();
$helper  = new Form($escaper);
$options = [
    'class'   => 'my-class',
    'name'    => 'my-name',
    'id'      => 'my-id',
    'method'  => 'post',
    'enctype' => 'multipart/form-data'
];

echo $helper($options);
// <form 
//    id="my-id" 
//    name="my-name" 
//    class="my-class"
//    method="post"
//    enctype="multipart/form-data">
```

> **NOTA**: Este ayudante crea solo la etiqueta de apertura `<form>`. Necesitarás usar el ayudante `Close` para generar la etiqueta de cierre `</form>`. 
> 
> {: .alert .alert-info }

### `img`
[Phalcon\Html\Helper\Img][html-helper-img] creates a `<img>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $src`            | The image source                  |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Img;

$escaper = new Escaper();
$helper  = new Img($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('/my-url', $options);
// <img 
//    src="/my-url" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputCheckbox`
\[Phalcon\Html\Helper\Checkbox\]\[html-helper-checkbox\] creates a `<input type="checkbox">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

**Métodos**

```php
public function label(array $attributes)
```
Sets the label for the checkbox

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Checkbox;

$escaper = new Escaper();
$helper  = new Checkbox($escaper);
$options = [
    'id'        => 'my-id',
    'unchecked' => 'no',
    'checked'   => 'yes',
];

$result = $helper('my-name', 'yes', $options);

echo $result;
// <hidden name="my_name" value="no">
// <label for="my_id">
//     <input type="checkbox"
//         id="my_id"
//         name="x_name"
//         value="yes"
//         checked="checked" />
//     some text
// </label>
```

### `inputColor`
\[Phalcon\Html\Helper\Color\]\[html-helper-color\] creates a `<input type="color">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Color;

$escaper = new Escaper();
$helper  = new Color($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="color"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputDate`
\[Phalcon\Html\Helper\Date\]\[html-helper-date\] creates a `<input type="date">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Date;

$escaper = new Escaper();
$helper  = new Date($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="date"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputDatetime`
\[Phalcon\Html\Helper\DateTime\]\[html-helper-datetime\] creates a `<input type="datetime">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\DateTime;

$escaper = new Escaper();
$helper  = new DateTime($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="datetime"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputDatetimeLocal`
\[Phalcon\Html\Helper\DateTimeLocal\]\[html-helper-datetime-local\] creates a `<input type="datetime-local">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\DateTimeLocal;

$escaper = new Escaper();
$helper  = new DateTimeLocal($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="datetime-local"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputEmail`
\[Phalcon\Html\Helper\Email\]\[html-helper-email\] creates a `<input type="email">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Email;

$escaper = new Escaper();
$helper  = new Email($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="email"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputFile`
\[Phalcon\Html\Helper\File\]\[html-helper-file\] creates a `<input type="file">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\File;

$escaper = new Escaper();
$helper  = new File($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="file"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputHidden`
\[Phalcon\Html\Helper\Hidden\]\[html-helper-hidden\] creates a `<input type="hidden">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Hidden;

$escaper = new Escaper();
$helper  = new Hidden($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="hidden"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputImage`
\[Phalcon\Html\Helper\Image\]\[html-helper-image\] creates a `<input type="image">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Image;

$escaper = new Escaper();
$helper  = new Image($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="image"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputMonth`
\[Phalcon\Html\Helper\Month\]\[html-helper-month\] creates a `<input type="month">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Month;

$escaper = new Escaper();
$helper  = new Month($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="month"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `input`
\[Phalcon\Html\Helper\Input\]\[html-helper-input\] creates a `<input>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

**Métodos**

```php
public function setType(string $type)
```
Establece el tipo de entrada

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Input;

$escaper = new Escaper();
$helper  = new Input($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

$result = $helper('test-name', "test-value", $options);

$result->setType('month');

echo $result;
// <input type="month"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputNumeric`
\[Phalcon\Html\Helper\Numeric\]\[html-helper-numeric\] creates a `<input type="numeric">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Numeric;

$escaper = new Escaper();
$helper  = new Numeric($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="numeric"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputPassword`
\[Phalcon\Html\Helper\Password\]\[html-helper-password\] creates a `<input type="password">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Password;

$escaper = new Escaper();
$helper  = new Password($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="password"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputRadio`
\[Phalcon\Html\Helper\Radio\]\[html-helper-radio\] creates a `<input type="radio">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

**Métodos**

```php
public function label(array $attributes)
```
Sets the label for the radio

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Radio;

$escaper = new Escaper();
$helper  = new Radio($escaper);
$options = [
    'id'        => 'my-id',
    'unchecked' => 'no',
    'checked'   => 'yes',
];

$result = $helper('my-name', 'yes', $options);

echo $result;
// <hidden name="my_name" value="no">
// <label for="my_id">
//     <input type="radio"
//         id="my_id"
//         name="x_name"
//         value="yes"
//         checked="checked" />
//     some text
// </label>
```

### `inputRange`
\[Phalcon\Html\Helper\Range\]\[html-helper-range\] creates a `<input type="range">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Range;

$escaper = new Escaper();
$helper  = new Range($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="range"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputSearch`
\[Phalcon\Html\Helper\Search\]\[html-helper-search\] creates a `<input type="search">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Search;

$escaper = new Escaper();
$helper  = new Search($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="search"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputSelect`
\[Phalcon\Html\Helper\Select\]\[html-helper-select\] creates a `<select>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |


**Métodos**

```php
public function add(
    string $text,
    string $value = null,
    array $attributes = [],
    bool $raw = false
): Select
```
Añade un elemento a la lista

```php
public function addPlaceholder(
    string $text,
    mixed $value = null,
    array $attributes = [],
    bool $raw = false
): Select
```
Add a placeholder to the element

```php
public function optGroup(
    string $label = null,
    array $attributes = []
): Select
```
Create an option group

```php
public function selected(string $selected): Select
```
Set the selected option

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Select;

$escaper = new Escaper();
$helper  = new Select($escaper);

$options = [
    'id' => 'carsList',
];

$result = $helper('    ', PHP_EOL, $options);
$result
    ->add("Ferrari", "1", ["class" => "active"])
    ->add("Ford", "2")
    ->add("Dodge", "3")
    ->add("Toyota", "4")
    ->optGroup(
        'oneLabel',
        [
            'class' => 'form-input',
        ]
    )
    ->addPlaceholder(
        'Choose & Car...',
        "0",
        [],
        true,
    )
    ->selected("3")
;

echo $result;
//
//    <select id="carsList">
//        <optgroup class="form-input" label="oneLabel">
//            <option value="0">Choose & Car...</option>
//            <option value="1" class="active">Ferrari</option>
//            <option value="2">Ford</option>
//            <option value="3" selected="selected">Dodge</option>
//            <option value="4">Toyota</option>
//        </optgroup>
//    </select>"
```

### `inputSubmit`
\[Phalcon\Html\Helper\Submit\]\[html-helper-submit\] creates a `<input type="submit">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Submit;

$escaper = new Escaper();
$helper  = new Submit($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="submit"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputTel`
\[Phalcon\Html\Helper\Tel\]\[html-helper-tel\] creates a `<input type="tel">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Tel;

$escaper = new Escaper();
$helper  = new Tel($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="tel"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputText`
\[Phalcon\Html\Helper\Text\]\[html-helper-text\] creates a `<input type="text">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Text;

$escaper = new Escaper();
$helper  = new Text($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="text"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputTextarea`
\[Phalcon\Html\Helper\TextArea\]\[html-helper-textarea\] creates a `<textarea>` tags

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\TextArea;

$escaper = new Escaper();
$helper  = new TextArea($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('click<>me', $options);
// <textarea 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </textarea>
```

### `inputTime`
\[Phalcon\Html\Helper\Time\]\[html-helper-time\] creates a `<input type="time">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Time;

$escaper = new Escaper();
$helper  = new Time($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="time"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputUrl`
\[Phalcon\Html\Helper\Url\]\[html-helper-url\] creates a `<input type="url">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Url;

$escaper = new Escaper();
$helper  = new Url($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="url"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `inputWeek`
\[Phalcon\Html\Helper\Week\]\[html-helper-week\] creates a `<input type="week">` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $name`           | The name                          |
| `string $value`          | The value                         |
| `array $attributes = []` | Additional attributes (key/value) |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Week;

$escaper = new Escaper();
$helper  = new Week($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper('test-name', "test-value", $options);
// <input type="week"
//    value="test-value" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `label`
[Phalcon\Html\Helper\Label][html-helper-label] creates a `<label>` tag.

| Parámetro                | Descripción                       |
| ------------------------ | --------------------------------- |
| `string $label`          | The label                         |
| `array $attributes = []` | Additional attributes (key/value) |
| `bool $raw = false`      | Whether to escape or not the text |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Label;

$escaper = new Escaper();
$helper  = new Label($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $helper($options);
// <label 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

> **NOTA**: Este ayudante crea solo la etiqueta de apertura `<label>`. Necesitarás usar el ayudante `Close` para generar la etiqueta de cierre `</label>`. 
> 
> {: .alert .alert-info }

### `link`
[Phalcon\Html\Helper\Link][html-helper-link] creates a `<link>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Link;

$escaper = new Escaper();
$helper  = new Link($escaper);

$result = $helper();
$result
    ->add('https://phalcon.io/page/1', ['rel' => 'prev'])
    ->add('https://phalcon.io/page/2', ['rel' => 'next'])
;

echo $result;
// <link rel="prev" href="https://phalcon.io/page/1" />
// <link rel="next" href="https://phalcon.io/page/2" />
```

### `meta`
[Phalcon\Html\Helper\Meta][html-helper-meta] creates a `<meta>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

**Métodos**
```php
public function add(array $attributes = []): Meta
```
Añade un elemento a la lista

```php
public function addHttp(string $httpEquiv, string $content): Meta
```
Adds a HTTP meta tag

```php
public function addName(string name, string content) -> <Meta>
```
Adds a name meta tag

```php
public function addProperty(string name, string content) -> <Meta>
```
Adds a property meta tag

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Meta;

$escaper = new Escaper();
$helper  = new Meta($escaper);

$result = $helper();

$result
    ->add(
        [
            "charset" => 'utf-8',
        ]
    )
    ->addHttp("X-UA-Compatible", "IE=edge")
    ->addName("generator", "Phalcon")
    ->addProperty("org:url", "https://phalcon.io")
;

echo $result;
//    <meta charset="utf-8">
//    <meta http-equiv="X-UA-Compatible" content="IE=edge">
//    <meta name="generator" content="Phalcon">
//    <meta property="org:url" content="https://phalcon.io">
```

### `ol`
[Phalcon\Html\Helper\Ol][html-helper-ol] creates a `<ol>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

**Métodos**

```php
public function add(
    string $text,
    array $attributes = [],
    bool $raw = false
): Ol
```
Añade un elemento a la lista

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Ol;

$escaper = new Escaper();
$helper  = new Ol($escaper);
$options = [
    'id' => 'carsList',
]

$result = $helper('    ', PHP_EOL, $options);

$result
    ->add("Ferrari", "1", ["class" => "active"])
    ->add("Ford", "2")
    ->add("Dodge", "3")
    ->add("Toyota", "4")
;

echo $result;
// <ol id="carsList">
//     <li class="active">Ferrari</li>
//     <li>> Ford</li>
//     <li>> Dodge</li>
//     <li>> Toyota</li>
// </ol>
```

### `script`
[Phalcon\Html\Helper\Script][html-helper-script] creates a `<script>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

**Métodos**

```php
public function add(
    string $url,
    array $attributes = []
): Script
```
Add a URL to the list

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Script;

$escaper = new Escaper();
$helper  = new Script($escaper);

$result = $helper();

$result
    ->add('/js/custom.js')
    ->add('/js/print.js', ['ie' => 'active'])
;

echo $result;
//    <script type="application/javascript" 
//            src="/js/custom.js"></script>
//    <script type="application/javascript" 
//            src="/js/print.js" ie="active"></script>
```

### `style`
[Phalcon\Html\Helper\Script][html-helper-style] creates a `<link>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

**Métodos**

```php
public function add(
    string $url,
    array $attributes = []
): Script
```
Add a URL to the list

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Script;

$escaper = new Escaper();
$helper  = new Script($escaper);

$result = $helper();

$result
    ->add('custom.css')
    ->add('print.css', ['media' => 'print'])
;

echo $result;
//    <link rel="stylesheet" type="text/css"
//        href="custom.css" media="screen" />
//    <link rel="stylesheet" type="text/css"
//        href="print.css" media="print" />
```

### `title`
[Phalcon\Html\Helper\Title][html-helper-title] creates a `<title>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

**Métodos**

```php
public function append(
    string $text, 
    bool $raw = false
): Title
```
Añade texto al título de documento actual

```php
public function get(): string
```
Devuelve el título

```php
public function set(
    string $text, 
    bool $raw = false
)): Title
```
Establece el título

```php
public function setSeparator(
    string $separator, 
    bool $raw = false
)): Title
```
Sets the separator

```php
public function prepend(
    string $text, 
    bool $raw = false
): Title
```
Antepone texto al título de documento actual

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Ul;

$escaper = new Escaper();
$helper  = new Ul($escaper);
$options = [
    'id' => 'carsList',
]

$result = $helper();

$result
    ->setSeparator(' | ')
    ->set('<Dodge>')
    ->append('< Ferrari', true)
    ->prepend('Ford <')
;

echo $result->get();
// &lt; Dodge &gt;

echo $result;
// <title>Ford > | &lt; Dodge &gt; | < Ferrari</title>
```

### `ul`
[Phalcon\Html\Helper\Ul][html-helper-ol] creates a `<ul>` tag.

| Parámetro           | Descripción   |
| ------------------- | ------------- |
| `string $indent`    | The indent    |
| `string $delimiter` | The delimiter |

**Métodos**

```php
public function add(
    string $text,
    array $attributes = [],
    bool $raw = false
): Ol
```
Añade un elemento a la lista

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Ul;

$escaper = new Escaper();
$helper  = new Ul($escaper);
$options = [
    'id' => 'carsList',
]

$result = $helper('    ', PHP_EOL, $options);

$result
    ->add("Ferrari", "1", ["class" => "active"])
    ->add("Ford", "2")
    ->add("Dodge", "3")
    ->add("Toyota", "4")
;

echo $result;
// <ul id="carsList">
//     <li class="active">Ferrari</li>
//     <li>> Ford</li>
//     <li>> Dodge</li>
//     <li>> Toyota</li>
// </ul>
```



[di-factorydefault]: api/phalcon_di#di-factorydefault
[html-helper-anchor]: api/phalcon_html#html-helper-anchor
[html-helper-base]: api/phalcon_html#html-helper-base
[html-helper-body]: api/phalcon_html#html-helper-body
[html-helper-button]: api/phalcon_html#html-helper-button
[html-helper-close]: api/phalcon_html#html-helper-close
[html-helper-doctype]: api/phalcon_html#html-helper-doctype
[html-helper-element]: api/phalcon_html#html-helper-element
[html-helper-form]: api/phalcon_html#html-helper-form
[html-helper-img]: api/phalcon_html#html-helper-img
[html-helper-label]: api/phalcon_html#html-helper-label
[html-helper-link]: api/phalcon_html#html-helper-link
[html-helper-meta]: api/phalcon_html#html-helper-meta
[html-helper-ol]: api/phalcon_html#html-helper-ol
[html-helper-ol]: api/phalcon_html#html-helper-ol
[html-helper-script]: api/phalcon_html#html-helper-script
[html-helper-style]: api/phalcon_html#html-helper-style
[html-helper-title]: api/phalcon_html#html-helper-title
[html-tagfactory]: api/phalcon_html#html-tagfactory
