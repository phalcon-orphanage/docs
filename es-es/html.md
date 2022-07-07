---
layout: default
language: 'es-es'
version: '5.0'
title: 'Html'
keywords: 'html, attributes, tag, factoría tag'
---

# Ayudantes HTML
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Este espacio de nombres contiene componentes que ayudan a generar HTML.

## Atributos
The [Phalcon\Html\Attributes][html-attributes] is a wrapper of [Phalcon\Collection](support-collection). Además contiene dos métodos más `render()` y `__toString()`. `render()` usa [Phalcon\Tag](tag) internamente para renderizar los atributos que tiene un elemento HTML. Estos atributos HTML son definidos en el propio objeto.

El componente se puede usar por si mismo si quieres recopilar atributos HTML en un objeto y luego renderizarlos (devolviéndolos como una cadena) en un formato `clave=valor`.

Este componente se usa internamente por [Phalcon\Forms\Form](forms) para almacenar los atributos de elementos de formulario.

## Migas de Pan
Una pieza común de HTML que está presente en muchas aplicaciones web son las migas de pan. Son enlaces separados normalmente por un espacio o por el carácter `/`, que representa la estructura jerárquica de una aplicación. El propósito es dar a los usuarios otra forma visual sencilla para navegar por la aplicación.

Un ejemplo es una aplicación que tiene un módulo `admin`, un área `facturas` y una página `ver factura`. Usualmente, seleccionarías el módulo `admin`, entonces desde los enlaces seleccionarías `facturas` (lista) y entonces pulsando sobre una de las facturas de la lista, podrías verla. Para representar esta estructura jerárquica, las migas de pan mostradas podrían ser:

```php
Inicio / Admin / Facturas / Viendo Factura [1234]
```
Cada una de las palabras anteriores (excepto la última) son enlaces a sus respectivas páginas. De esta forma, el usuario puede navegar rápidamente hacia las diferentes áreas sin tener que volver atrás o usar otro menú.

[Phalcon\Html\Breadcrumbs][html-breadcrumbs] offers functionality to add text and URLs. El HTML resultante cuando se llama a `render()` tendrá cada miga de pan encerrada en etiquetas `<dt>`, mientras que la cadena global lo estará en etiquetas `<dl>`.

### Métodos
```php
public function add(
    string $label, 
    string $link = ""
): Breadcrumbs
```
Añade una nueva miga.

En el ejemplo posterior, añade una miga con un enlace y luego añade una miga sin enlace (normalmente el último)

```php
$breadcrumbs
    ->add("Home", "/")
    ->add("Users")
;
```

```
public function clear(): void
```
Limpia las migas

```php
$breadcrumbs->clear()
```

```php
public function getSeparator(): string
```
Devuelve el separador usado para las migas de pan

```
public function remove(string $link): void
```
Elimina una miga por url.

En el ejemplo posterior elimina una miga mediante URL y también elimina una miga sin url (último enlace)

```php
$breadcrumbs->remove("/admin/user/create");
$breadcrumbs->remove();
```

```php
public function render(): string
```
Renderiza y muestra las migas de pan HTML. La plantilla usada es:

```
<dl>
    <dt><a href="Hyperlink">Texto</a></dt> / 
    <dt><a href="Hyperlink">Texto</a></dt> / 
    <dt>Texto</dt>
</dl>
```
El último conjunto de migas no tendrá enlace y sólo mostrará su texto. Cada miga está envuelta en etiquetas `<dt></dt>`. La colección entera está envuelta en etiquetas `<dl></dl>`. Puede usarlas en conjunto con CSS para formatear las migas en pantalla acorde a las necesidades de su aplicación.

```php
echo $breadcrumbs->render();
```

```
public function setSeparator(string $separator)
```
El separador por defecto entre las migas es `/`. Puede configurar uno diferente si lo desea usando este método.

```php
$breadcrumbs->setSeparator('-');
```

```php
public function toArray(): array
```
Devuelve el vector de migas de pan interno

## TagFactory
[Phalcon\Html\TagFactory][html-tagfactory] is a component that generates HTML tags. Este componente crea una nueva clase localizador con etiquetas HTML predefinidas adjuntas a él. Cada clase etiqueta es cargada de forma perezosa para maximizar el rendimiento. Para instanciar la factoría y obtener un ayudante etiqueta, necesita llamar a `newInstance()`.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\TagFactory;

$escaper = new Escaper();
$factory = new TagFactory($escaper);
$anchor  = $factory->newInstance('a');
```
Los nombres registrados para los respectivos ayudantes son:

| Nombre       | Descripción                                                                      |
| ------------ | -------------------------------------------------------------------------------- |
| `a`          | [Phalcon\Html\Helper\Anchor][html-helper-anchor] - `<a>` tag            |
| `aRaw`       | [Phalcon\Html\Helper\AnchorRaw][html-helper-anchorraw] - `<a>` tag raw  |
| `body`       | [Phalcon\Html\Helper\Body][html-helper-body] - `<body>` tag             |
| `button`     | [Phalcon\Html\Helper\Button][html-helper-button] - `<button>` tag       |
| `close`      | [Phalcon\Html\Helper\Close][html-helper-close] - close tag                    |
| `element`    | [Phalcon\Html\Helper\Element][html-helper-element] - any tag                  |
| `elementRaw` | [Phalcon\Html\Helper\ElementRaw][html-helper-elementraw] - any tag raw        |
| `form`       | [Phalcon\Html\Helper\Form][html-helper-form] - `<form>` tag             |
| `img`        | [Phalcon\Html\Helper\Img][html-helper-img] - `<img>` tag                |
| `label`      | [Phalcon\Html\Helper\Label][html-helper-label] - `<label>` tag          |
| `textarea`   | [Phalcon\Html\Helper\TextArea][html-helper-textarea] - `<textarea>` tag |

### Ayudantes
All helpers that are used by the [Phalcon\Html\TagFactory][html-tagfactory] are located under the `Phalcon\Html\Helper` namespace. Puede crear cada una de estas clases individualmente si lo desea, o puede usar la factoría de etiquetas tal y como se muestra arriba. Other than the `*Raw` helpers, if text is required by the helper, it will be automatically escaped using [Phalcon\Escaper](html-escaper).

> **NOTA**: El código y la salida inferior han sido formateados por legibilidad 
> 
> {: .alert .alert-info }

### `a`
[Phalcon\Html\Helper\Anchor][html-helper-anchor] creates anchor HTML tags. El componente acepta `href` como una cadena, `text` como una cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\AchorRaw][html-helper-anchorraw] creates raw anchor HTML tags, i.e. the text will not be escaped. El componente acepta `href` como una cadena, `text` como una cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Body][html-helper-body] creates a `<body>` tag. El componente acepta opcionalmente un vector con todos los atributos que necesita el ancla.

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
> **NOTE**: Este ayudante crear sólo la etiqueta de apertura `<body>`. Necesitarás usar el ayudante `Close` para generar la etiqueta de cierre `</body>`. 
> 
> {: .alert .alert-info }

### `button`
[Phalcon\Html\Helper\Button][html-helper-button] creates `<button>` HTML tags. El component acepta `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Close][html-helper-close] creates the closing HTML tags. El componente acepta el `name` de la etiqueta a cerrar.

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
[Phalcon\Html\Helper\Element][html-helper-element] creates HTML tags based on the passed `name` parameter. El componente acepta `name` como cadena, `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\ElementRaw][html-helper-elementraw] creates raw HTML tags, i.e. the text will not be escaped. La etiqueta creada se basa en el parámetro `name` indicado. El componente acepta `name` como cadena, `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Form][html-helper-form] creates `<form>` HTML tags. El componente acepta un vector con todos los atributos que necesita el ancla. Por defecto el formulario tiene `method` `post` y `enctype` `multipart/form-data`.

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

> **NOTA**: Este ayudante crea solo la etiqueta de apertura `<form>`. Necesitarás usar el ayudante `Close` para generar la etiqueta de cierre `</form>`. 
> 
> {: .alert .alert-info }

### `img`
[Phalcon\Html\Helper\Img][html-helper-img] creates `<img>` HTML tags. El componente acepta `src` como una cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Label][html-helper-label] creates `<label>` HTML tags. El componente acepta opcionalmente un vector con todos los atributos que necesita el ancla.

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

> **NOTA**: Este ayudante crea solo la etiqueta de apertura `<label>`. Necesitarás usar el ayudante `Close` para generar la etiqueta de cierre `</label>`. 
> 
> {: .alert .alert-info }

### `textarea`
[Phalcon\Html\Helper\TextArea][html-helper-textarea] creates `<textarea>` HTML tags. El component acepta `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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

> **NOTA**: Habrá más ayudantes disponibles en futuras versiones de Phalcon. El objetivo es reemplazar totalmente el objeto [Phalcon\Tag](tag) con pequeñas clases de ayuda HTML. 
> 
> {: .alert .alert-info }

[html-attributes]: api/phalcon_html#html-attributes
[html-breadcrumbs]: api/phalcon_html#html-breadcrumbs
[html-helper-anchor]: api/phalcon_html#html-helper-anchor
[html-helper-anchorraw]: api/phalcon_html#html-helper-anchorraw
[html-helper-anchorraw]: api/phalcon_html#html-helper-anchorraw
[html-helper-body]: api/phalcon_html#html-helper-body
[html-helper-button]: api/phalcon_html#html-helper-button
[html-helper-close]: api/phalcon_html#html-helper-close
[html-helper-element]: api/phalcon_html#html-helper-element
[html-helper-elementraw]: api/phalcon_html#html-helper-elementraw
[html-helper-form]: api/phalcon_html#html-helper-form
[html-helper-img]: api/phalcon_html#html-helper-img
[html-helper-label]: api/phalcon_html#html-helper-label
[html-helper-textarea]: api/phalcon_html#html-helper-textarea
[html-tagfactory]: api/phalcon_html#html-tagfactory
