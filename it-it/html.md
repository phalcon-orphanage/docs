---
layout: default
language: 'it-it'
version: '4.0'
title: 'Html'
keywords: 'html, attributes, tag, tag factory'
---

# HTML Helpers
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
This namespace contains components that help with the generation of HTML.

## Attributes
The [Phalcon\Html\Attributes](api/phalcon_html#html-attributes) is a wrapper of [Phalcon\Collection](collection). It also contains two more methods `render()` and `__toString()`. `render()` uses [Phalcon\Tag](tag) internally to render the attributes that a HTML element has. These HTML attributes are defined in the object itself.

The component can be used on its own if you want to collect HTML attributes in an object and then _render) them (return them as a string) in a `key=value` format.

This component is used internally by [Phalcon\Forms\Form](forms) to store the attributes of form elements.

## Breadcrumbs
A common piece of HTML that is present in many web applications is the breadcrumbs. These are links separated by a space or by the `/` character usually, that represent the tree structure of an application. The purpose is to give users another easy visual way to navigate throughout the application.

An example is an application that has an `admin` module, an `invoices` area and a `view invoice` page. Usually, you would select the the `admin` module, then from the links you will choose `invoices` (list) and then clicking on one of the invoices in the list, you can view it. To represent this tree like structure, the breadcrumbs displayed could be:

```php
Home / Admin / Invoices / Viewing Invoice [1234]
```
Each of the words above (apart from the last one) are links to the respective pages. This way the user can quickly navigate back to a different area without having to click the back button or use another menu.

[Phalcon\Html\Breadcrumbs](api/phalcon_html#html-breadcrumbs) offers functionality to add text and URLs. The resulting HTML when calling `render()` will have each breadcrumb enclosed in `<dt>` tags, while the whole string is enclosed in `<dl>` tags.

### Methods
```php
public function add(
    string $label, 
    string $link = ""
): Breadcrumbs
```
Adds a new crumb.

In the example below, add a crumb with a link and then add a crumb without a link (normally the last one)

```php
$breadcrumbs
    ->add("Home", "/")
    ->add("Users")
;
```

```
public function clear(): void
```
Clears the crumbs

```php
$breadcrumbs->clear()
```

```php
public function getSeparator(): string
```
Returns the separator used for the breadcrumbs

```
public function remove(string $link): void
```
Removes crumb by url.

In the example below remove a crumb by URL and also remove a crumb without an url (last link)

```php
$breadcrumbs->remove("/admin/user/create");
$breadcrumbs->remove();
```

```php
public function render(): string
```
Renders and outputs breadcrumbs HTML. The template used is:

```
<dl>
    <dt><a href="Hyperlink">Text</a></dt> / 
    <dt><a href="Hyperlink">Text</a></dt> / 
    <dt>Text</dt>
</dl>
```
The last set crumb will not have a link and will only have its text displayed. Each crumb is wrapped in `<dt></dt>` tags. The whole collection is wrapped in `<dl></dl>` tags. You can use them in conjunction with CSS to format the crumbs on screen according to the needs of your application.

```php
echo $breadcrumbs->render();
```

```
public function setSeparator(string $separator)
```
The default separator between the crumbs is `/`. You can set a different one if you wish using this method.

```php
$breadcrumbs->setSeparator('-');
```

```php
public function toArray(): array
```
Returns the internal breadcrumbs array

## TagFactory
[Phalcon\Html\TagFactory](api/phalcon_html#html-tagfactory) is a component that generates HTML tags. This component creates a new class locator with predefined HTML tag classes attached to it. Each tag class is lazy loaded for maximum performance. To instantiate the factory and retrieve a tag helper, you need to call `newInstance()`.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\TagFactory;

$escaper = new Escaper();
$factory = new TagFactory($escaper);
$anchor  = $factory->newInstance('a');
```
The registered names for respective helpers are:

| Name         | Description                                                                                       |
| ------------ | ------------------------------------------------------------------------------------------------- |
| `a`          | [Phalcon\Html\Helper\Anchor](api/phalcon_html#html-helper-anchor) - `<a>` tag            |
| `aRaw`       | [Phalcon\Html\Helper\AnchorRaw](api/phalcon_html#html-helper-anchorraw) - `<a>` tag raw  |
| `body`       | [Phalcon\Html\Helper\Body](api/phalcon_html#html-helper-body) - `<body>` tag             |
| `button`     | [Phalcon\Html\Helper\Button](api/phalcon_html#html-helper-button) - `<button>` tag       |
| `close`      | [Phalcon\Html\Helper\Close](api/phalcon_html#html-helper-close) - close tag                    |
| `element`    | [Phalcon\Html\Helper\Element](api/phalcon_html#html-helper-element) - any tag                  |
| `elementRaw` | [Phalcon\Html\Helper\ElementRaw](api/phalcon_html#html-helper-elementraw) - any tag raw        |
| `form`       | [Phalcon\Html\Helper\Form](api/phalcon_html#html-helper-form) - `<form>` tag             |
| `img`        | [Phalcon\Html\Helper\Img](api/phalcon_html#html-helper-img) - `<img>` tag                |
| `label`      | [Phalcon\Html\Helper\Label](api/phalcon_html#html-helper-label) - `<label>` tag          |
| `textarea`   | [Phalcon\Html\Helper\TextArea](api/phalcon_html#html-helper-textarea) - `<textarea>` tag |

### Helpers
All helpers that are used by the [Phalcon\Html\TagFactory](api/phalcon_html#html-tagfactory) are located under the `Phalcon\Html\Helper` namespace. You can create each of these classes individually if you wish to, or you can use the tag factory as shown above. Other than the `*Raw` helpers, if text is required by the helper, it will be automatically escaped using [Phalcon\Escaper](escaper).

> **NOTE**: The code and output below has been formatted for readability 
> 
> {: .alert .alert-info }

### `a`
[Phalcon\Html\Helper\Anchor](api/phalcon_html#html-helper-anchor) creates anchor HTML tags. The component accepts the `href` as a string, the `text` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Anchor;

$escaper = new Escaper();
$anchor  = new Anchor($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('/myurl', 'click<>me', $options);
// <a href="/myurl" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </a>
```

### `aRaw`
[Phalcon\Html\Helper\AchorRaw](api/phalcon_html#html-helper-anchorraw) creates raw anchor HTML tags, i.e. the text will not be escaped. The component accepts the `href` as a string, the `text` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\AnchorRaw;

$escaper = new Escaper();
$anchor  = new AnchorRaw($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('/myurl', 'click<>me', $options);
// <a href="/myurl" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click<>me
// </a>
```

### `body`
[Phalcon\Html\Helper\Body](api/phalcon_html#html-helper-body) creates a `<body>` tag. The component accepts optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Body;

$escaper = new Escaper();
$anchor  = new Body($escaper);
$options = [
    'class' => 'my-class',
    'id'    => 'my-id',
];

echo $anchor($options);
// <body id="my-id" class="my-class">
```
> **NOTE**: This helper creates only the opening `<body>` tag. You will need to use the `Close` helper to generate the closing `</body>` tag. 
> 
> {: .alert .alert-info }

### `button`
[Phalcon\Html\Helper\Button](api/phalcon_html#html-helper-button) creates `<button>` HTML tags. The component accepts the `text` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Button;

$escaper = new Escaper();
$anchor  = new Button($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('click<>me', $options);
// <button 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </button>
```

### `close`
[Phalcon\Html\Helper\Close](api/phalcon_html#html-helper-close) creates the closing HTML tags. The component accepts the `name` of the tag to close.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Close;

$escaper = new Escaper();
$anchor  = new Close($escaper);

echo $anchor('form');
// </form>
```

### `element`
[Phalcon\Html\Helper\Element](api/phalcon_html#html-helper-element) creates HTML tags based on the passed `name` parameter. The component accepts the `name` as a string, the `text` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Element;

$escaper = new Escaper();
$anchor  = new Element($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('address', 'click<>me', $options);
// <address 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </address>
```

### `elementRaw`
[Phalcon\Html\Helper\ElementRaw](api/phalcon_html#html-helper-elementraw) creates raw HTML tags, i.e. the text will not be escaped. The tag created is based on the passed `name` parameter. The component accepts the `name` as a string, the `text` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\ElementRaw;

$escaper = new Escaper();
$anchor  = new ElementRaw($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('address', 'click<>me', $options);
// <address 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click<>me
// </address>
```

### `form`
[Phalcon\Html\Helper\Form](api/phalcon_html#html-helper-form) creates `<form>` HTML tags. The component accepts an array with all the attributes that the anchor needs. By default the form has its `method` to `post` and `enctype` to `multipart/form-data`.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Form;

$escaper = new Escaper();
$anchor  = new Form($escaper);
$options = [
    'class'   => 'my-class',
    'name'    => 'my-name',
    'id'      => 'my-id',
    'method'  => 'post',
    'enctype' => 'multipart/form-data'
];

echo $anchor($options);
// <form 
//    id="my-id" 
//    name="my-name" 
//    class="my-class"
//    method="post"
//    enctype="multipart/form-data">
```

> **NOTE**: This helper creates only the opening `<form>` tag. You will need to use the `Close` helper to generate the closing `</form>` tag. 
> 
> {: .alert .alert-info }

### `img`
[Phalcon\Html\Helper\Img](api/phalcon_html#html-helper-img) creates `<img>` HTML tags. The component accepts the `src` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Img;

$escaper = new Escaper();
$anchor  = new Img($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('/my-url', $options);
// <img 
//    src="/my-url" 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

### `label`
[Phalcon\Html\Helper\Label](api/phalcon_html#html-helper-label) creates `<label>` HTML tags. The component accepts optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\Label;

$escaper = new Escaper();
$anchor  = new Label($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor($options);
// <label 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
```

> **NOTE**: This helper creates only the opening `<label>` tag. You will need to use the `Close` helper to generate the closing `</label>` tag. 
> 
> {: .alert .alert-info }

### `textarea`
[Phalcon\Html\Helper\TextArea](api/phalcon_html#html-helper-textarea) creates `<textarea>` HTML tags. The component accepts the `text` as a string and optionally an array with all the attributes that the anchor needs.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\Helper\TextArea;

$escaper = new Escaper();
$anchor  = new TextArea($escaper);
$options = [
    'class' => 'my-class',
    'name'  => 'my-name',
    'id'    => 'my-id',
];

echo $anchor('click<>me', $options);
// <textarea 
//    id="my-id" 
//    name="my-name" 
//    class="my-class">
//     click&lt;&gt;me
// </textarea>
```

> **NOTE**: More helpers will become available in future versions of Phalcon. The goal is to completely replace the [Phalcon\Tag](tag) object with small HTML helper classes. 
> 
> {: .alert .alert-info }
