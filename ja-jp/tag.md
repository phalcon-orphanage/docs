---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Tag'
keywords: 'tag, helpers, view helpers, html generators'
---

# Tag (View Helpers)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Writing and maintaining HTML markup can quickly become a tedious task because of the naming conventions and numerous attributes that have to be taken into consideration. Phalcon deals with this complexity by offering the [Phalcon\Tag](api/Phalcon_Tag) component which in turn offers view helpers to generate HTML markup.

This component can be used in a plain HTML+PHP view or in a [Volt](volt) template.

> **NOTE**: This offers the same functionality as `Phalcon\Html\TagFactory`. In future versions, this component will be replaced by the `TagFactory` one. The reason for both components is to offer as much time as possible to developers to adapt their code, since HTML generation touches a lot of areas of the application, the view in particular.
{: .alert .alert-warning } 

## DocType

You can set the doctype for your page using `setDocType()`. The method accepts one of the available constants, generating the necessary `<doctype>` HTML. The method returns the `Tag` component and thus the call can be chained.

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

The above example will produce:

```html
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 2.0//EN'
    'http://www.w3.org/MarkUp/DTD/xhtml2.dtd'>
```

The default value is `HTML5` which generates:

```html
<!DOCTYPE html>
```

You can output the doctype using `getDocType()` in your views:

```php
<?php echo $this->tag->getDocType(); ?>
```

or in Volt:

```twig
{% raw %}{{ get_doctype() }}{% endraw %}
```

## Title

[Phalcon\Tag](api/phalcon_tag) offers methods to set the tag of the resulting page or HTML sent to the user. There are several methods available:

### `appendTitle()`

Appends text to the current title. The method accepts either a `string` or an `array`.

> **NOTE**: If a `string` is supplied, it will be added to the internal collection holding the append title text. If however you supply an `array` the internal collection will be replaced.
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

Converts text to URL-friendly strings. It accepts the following parameters: - `text` - The text to be processed - `parameters` - Array of parameters to generate the friendly title

The parameters can be: - `lowercase` - `bool` Whether to convert everything to lowercase or not - `separator` - `string` - The separator. Defaults to `-` - `replace` - `array` - Key value array to replace characters with others. This uses \[str_replace\]\[str_replace\] internally for this replacement

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

Returns the current title. The title is automatically escaped. The method accepts two parameters: - `prepend` - `bool` Whether to output any text set with `prependTitle()` - `append` - `bool` Whether to output any text set with `appendTitle()`

Both parameters are `true` by default.

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

Returns the current title separator. The default value is an empty string.

```php
<?php

use Phalcon\Tag;

echo Tag::getTitleSeparator(); // ''
```

### `prependTitle()`

Prepends text to the current title. The method accepts either a `string` or an `array`.

> **NOTE**: If a `string` is supplied, it will be added to the internal collection holding the prepend title text. If however you supply an `array` the internal collection will be replaced.
{: .alert .alert-info }

```php
<?php

use Phalcon\Tag;

Tag::setTitle('Rocks');

echo Tag::getTitle(); // 'Phalcon'

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

Returns the current title wrapped in `<title>` tags. The title is automatically escaped. The method accepts two parameters: - `prepend` - `bool` Whether to output any text set with `prependTitle()` - `append` - `bool` Whether to output any text set with `appendTitle()`

Both parameters are `true` by default.

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

Sets the title text.

```php
<?php

use Phalcon\Tag;

Tag::setTitle('World');
```

### `setTitleSeparator()`

Set the separator of the title.

```php
<?php

use Phalcon\Tag;

Tag::setTitleSeparator(' ');
```

## Input

### `checkField()`

Builds a HTML `input[type='check']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->checkField(
    [
        'terms', 
        'value' => 'Y',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ check_field('terms', 'value': 'Y') }}{% endraw %}
```

### `colorField()`

Builds a HTML `input[type='color']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->colorField(
    [
        'background',
        'class' => 'myclass',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ color_field('background', 'class': 'myclass') }}{% endraw %}
```

### `dateField()`

Builds a HTML `input[type='date']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->dateField(
    [
        'born',
        'value' => '1980-01-01',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ date_field('born', 'value': '1980-01-01') }}{% endraw %}
```

### `dateTimeField()`

Builds a HTML `input[type='datetime']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->dateTimeField(
    [
        'born',
        'value' => '1980-01-01 01:02:03',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ date_time_field('born', 'value': '1980-01-01') }}{% endraw %}
```

### `dateTimeLocalField()`

Builds a HTML `input[type='datetime-local']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->dateTimeLocalField(
    [
        'born',
        'value' => '1980-01-01 01:02:03',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ date_time_local_field('born', 'value': '1980-01-01 01:02:03') }}{% endraw %}
```

### `fileField()`

Builds a HTML `input[type='file']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->fileField(
    [
        'document',
        'class' => 'input',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ file_field('document', 'class': 'input') }}{% endraw %}
```

### `hiddenField()`

Builds a HTML `input[type='hidden']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->hiddenField(
    [
        'id',
        'value' => '1234',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ hidden_field('id', 'value': '1234') }}{% endraw %}
```

### `imageInput()`

Builds a HTML `input[type='image']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->imageInput(
    [
        'src' => '/img/button.png',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ image_input('src': '/img/button.png') }}{% endraw %}
```

### `monthField()`

Builds a HTML `input[type='month']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->monthField(
    [
        'month',
        'value' => '04',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ month_field('month', 'value': '04') }}{% endraw %}
```

### `numericField()`

Builds a HTML `input[type='number']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->numericField(
    [
       'price',
       'min' => '1',
       'max' => '5',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ numeric_field('price', 'min': '1', 'max': '5') }}{% endraw %}
```

### `radioField()`

Builds a HTML `input[type='radio']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->radioField(
    [
        'gender',
        'value' => 'Male',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ radio_field('gender', 'value': 'Male') }}{% endraw %}
```

### `rangeField()`

Builds a HTML `input[type='range']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->rangeField(
    [
        'points',
        'min' => '0',
        'max' => '10',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ range_field('points', 'min': '0', 'max': '10') }}{% endraw %}
```

### `searchField()`

Builds a HTML `input[type='search']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->searchField(
    [
        'search',
        'q' => 'startpage',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ search_field('search', 'q': 'startsearch') }}{% endraw %}
```

### `submitButton()`

Builds a HTML `input[type='submit']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->submitButton(
    [
       'Save',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ submit_button('Save') }}{% endraw %}
```

### `telField()`

Builds a HTML `input[type='tel']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->telField(
    [
       'mobile',
       'size' => '12',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ tel_field('mobile', 'size': '12') }}{% endraw %}
```

### `passwordField()`

Builds a HTML `input[type='text']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->textField(
    [
       'name',
       'size' => '30',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ text_field('name', 'size': '30') }}{% endraw %}
```

### `timeField()`

Builds a HTML `input[type='time']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->timeField(
    [
       'start',
       'size' => '5',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ time_field('start', 'size': '5') }}{% endraw %}
```

### `urlField()`

Builds a HTML `input[type='url']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->urlField(
    [
       'homepage',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ url_field('homepage') }}{% endraw %}
```

### `weekField()`

Builds a HTML `input[type='week']` tag. Accepts an array with the attributes of the element. The first element of the array is the name of the element.

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

HTML syntax:

```php
<?php echo $this->tag->weekField(
    [
       'week',
       'size' => '2',
    ]
); ?>
```

Volt syntax:

```twig
{% raw %}{{ week_field('week', 'size': '2') }}{% endraw %}
```

## Elements

### `image()`

Builds a HTML image tag. Accepts an array with the attributes of the element. The first element of the array is the src of the element. The method accepts a second boolean parameter, signifying whether this resource is local or not.

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

HTML syntax:

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

Volt syntax:

```twig
{% raw %}{{ image('img/hello.gif', 'alt': 'alternative text') }}
{{ image('http://static.mywebsite.com/img/bg.png', false) }}{% endraw %}
```

### `select()`

`select()` is a helper that allows you to create a `<select>` element based on a `Phalcon\Mvc\Model` resultset. You will need to have a valid database connection set up in your DI container for this method to produce the correct HTML. The component requires parameters and data to operate. - `parameters` - `string`/`array`. If a string is passed, it will be the name of the element. If an array is passed, the first element will be the name of the element. There available parameters are: - `id` - `string` - sets the id of the element - `using` - `array` - **required** a two element array defining the key and value fields of the model to populate the select - `useEmpty` - `bool` - defaults to `false`. If set, it will add an *empty* option to the select box - `emptyText` - `string` - the text to display for the *empty* option (i.e. *Choose an option*) - `emptyValue` - `string`/`number` - the value to assign for the *empty* option - any additional HTML attributes in a key/value format - `data` - `Resultset` the resultset from the model operation.

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

HTML syntax:

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

Volt syntax:

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

This helper is similar to `select()`, but it uses a PHP array as the source. The component requires parameters and data to operate. - `parameters` - `string`/`array`. If a string is passed, it will be the name of the element. If an array is passed, the first element will be the name of the element. There available parameters are: - `id` - `string` - sets the id of the element - `useEmpty` - `bool` - defaults to `false`. If set, it will add an *empty* option to the select box - `emptyText` - `string` - the text to display for the *empty* option (i.e. *Choose an option*) - `emptyValue` - `string`/`number` - the value to assign for the *empty* option - any additional HTML attributes in a key/value format - `data` - `array` the array of data with key as the id and value as the text

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

HTML syntax:

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

Volt syntax:

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

Phalcon offers a generic HTML helper that allows the generation of any kind of HTML element. It is up to the developer to produce a valid HTML element name to the helper. The accompanying `tagHtmlClose()` can be used to *close* the tag if necessary.

The `tagHtml()` accepts the following parameters - `name` - `string` - the name of the element - `attributes` - `array` - any attributes - `selfClose` - `bool` - whether this is a self closing element or not - `onlyStart` - `bool` - whether to produce only the *opening* part of the tag (i.e. `<tag>` vs. `<tag></tag>`) - `useEol` - `bool` - add a `PHP_EOL` at the end of the generated string or not

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

HTML syntax:

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

Volt syntax:

```twig
{% raw %}
{{ tag_html('canvas', ['id': 'canvas1', width': '300', 'class': 'cnvclass'], false, true, true) }}
    This is my canvas
{{ tag_html_close('canvas') }}
{% endraw %}
```

## アセット

[Phalcon\Tag](api/phalcon_tag) offers helper methods to generate stylesheet and javascript HTML tags.

### `stylesheetLink()`

The first parameter a `string` or an `array` is the parameters necessary to construct the element. The second parameter is a boolean, dictating whether the link is pointing to a local asset or a remote.

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

HTML syntax

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

Volt Syntax:

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

The first parameter a `string` or an `array` is the parameters necessary to construct the element. The second parameter is a boolean, dictating whether the link is pointing to a local asset or a remote.

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

HTML syntax

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

Volt Syntax:

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

## Links

A common task in any web application is to show links that help with the navigation from one area to another. [Phalcon\Tag](api/phalcon_tag) offers `linkTo()` to help with this task. The method accepts three parameters. - `parameters` - `array`/`string` - The attributes and parameters of the element. If a string is passed it will be treated as the target URL for the link. If an array is passed, the following elements can be sent: - `action` - the URL. If the `action` is an array, you can reference a named route defined in your routes using the `for` element - `query` - the base query for the URL - `text` - the text of the link - `local` - whether this is a local or remote link - additional key/value attributes for the link - `text` - `string` - the text of the link - `local` - `bool` - whether this is a local or remote link

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

echo Tag::linkTo('http://phalcon.io/', 'Phalcon', false);
// <a href='http://phalcon.io/'>Phalcon</a>

 echo Tag::linkTo(
    [
        'http://phalcon.io/',
        'Phalcon Home',
        false,
    ]
);
// <a href='http://phalcon.io/'>Phalcon Home</a>
```

HTML syntax:

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

echo $this->tag->linkTo('http://phalcon.io/', 'Phalcon', false);

 echo $this->tag->linkTo(
    [
        'http://phalcon.io/',
        'Phalcon Home',
        false,
    ]
);

?>
```

Volt syntax:

```twig
{% raw %}
{{ link_to('signup/register', 'Register Here!') }}
{{ link_to(
    'signup/register',
    'Register Here!',
    'class': 'btn-primary'
) }}

{{ link_to('http://phalcon.io/', 'Phalcon', false) }}

{{ link_to(
    'http://phalcon.io/',
    'Phalcon Home',
    false
) }}{% endraw %}
```

If you have named routes, you can use the `for` keyword in your parameter array to reference it. [Phalcon\Tag](api/phalcon_tag) will resolve the route internally and produce the correct URL using [Phalcon\Url](url).

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

HTML syntax:

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

Volt syntax:

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

## Forms

Forms play an important role in any web application, since they are used to collect input from the user. [Phalcon\Tag](api/phalcon_tag) offers the `form()` and `endForm()` methods, which create `<form>` elements.

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

HTML syntax:

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

Volt syntax:

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

Phalcon also provides a [form builder](forms) to create forms in an object-oriented manner.

## Data

### `setDefault()`

You can use `setDefault()` to pre populate values for elements generated by [Phalcon\Tag](api/phalcon_tag). The helpers of this component will retain the values between requests. This way you can easily show validation messages without losing entered data. Every form helper supports the parameter `value`. With it you can specify a value for the helper directly. When the parameter is present, any preset value using `setDefault()` or via request will be ignored.

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

`setDefaults()` allows you to specify more than one value to be set in elements of your form, by passing a key value array. The method can be called more than one time and each time it is called it will overwrite the data set in the previous call. You can however specify the second parameter as `true` so that the values are merged.

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

This method is called from every helper in this component, to find whether a value has been set for an element wither by having used `setDefault()` before or in the `$_POST` superglobal.

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

This method checks if a `value` in an element has already been set using `setDefault()` or is in the `$_POST` superglobal.

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

## Escaping

[Phalcon\Tag](api/phalcon_tag) automatically escapes text supplied for its helpers. If your application requires it, you can disable automatic escaping by using `setAutoEscape()`.

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

## 依存性の注入

If you use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, the [Phalcon\Tag](api/phalcon_tag) is already registered for you with the name `tag`.

An example of the registration of the service as well as accessing it is below:

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

You can always implement your own `tag` helper and register it in the place of `tag` in the Di container.

Accessing the service from any component that implements the [Phalcon\Di\Injectable](api/phalcon_di#di-injectable) is as simple as accessing the `tag` property.

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

## Custom

You can easily extend this functionality and create your own helpers.

- First create a new directory in your application's file system that the helper files will be stored.
- Name it something that will represent it. For instance in this example we use `customhelpers`.
- Create a file called `MyTags.php` in your `customhelpers` directory.
- Extend the [Phalcon\Tag](api/phalcon_tag) class and implement your own methods.

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

After creating our custom helper, we will autoload the new directory that contains our helper class from our `index.php` located in the public directory.

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

Now you are ready to use your new helper within your views:

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

You can also check out [Volt](volt) a faster template engine for PHP, where you can use a more developer friendly syntax for helpers provided by [Phalcon\Tag](api/phalcon_tag).