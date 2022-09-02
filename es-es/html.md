---
layout: default
language: 'es-es'
version: '4.0'
title: 'Html'
keywords: 'html, attributes, tag, factoría tag'
---

# Ayudantes HTML
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
Este espacio de nombres contiene componentes que ayudan a generar HTML.

## Atributos
[Phalcon\Html\Attributes](api/phalcon_html#html-attributes) es un contenedor de [Phalcon\Collection](collection). Además contiene dos métodos más `render()` y `__toString()`. `render()` usa [Phalcon\Tag](tag) internamente para renderizar los atributos que tiene un elemento HTML. Estos atributos HTML son definidos en el propio objeto.

El componente se puede usar por si mismo si quieres recopilar atributos HTML en un objeto y luego renderizarlos (devolviéndolos como una cadena) en un formato `clave=valor`.

Este componente se usa internamente por [Phalcon\Forms\Form](forms) para almacenar los atributos de elementos de formulario.

## Migas de Pan
Una pieza común de HTML que está presente en muchas aplicaciones web son las migas de pan. Son enlaces separados normalmente por un espacio o por el carácter `/`, que representa la estructura jerárquica de una aplicación. El propósito es dar a los usuarios otra forma visual sencilla para navegar por la aplicación.

Un ejemplo es una aplicación que tiene un módulo `admin`, un área `facturas` y una página `ver factura`. Usualmente, seleccionarías el módulo `admin`, entonces desde los enlaces seleccionarías `facturas` (lista) y entonces pulsando sobre una de las facturas de la lista, podrías verla. Para representar esta estructura jerárquica, las migas de pan mostradas podrían ser:

```php
Inicio / Admin / Facturas / Viendo Factura [1234]
```
Cada una de las palabras anteriores (excepto la última) son enlaces a sus respectivas páginas. De esta forma, el usuario puede navegar rápidamente hacia las diferentes áreas sin tener que volver atrás o usar otro menú.

[Phalcon\Html\Breadcrumbs](api/phalcon_html#html-breadcrumbs) ofrece funcionalidad para añadir texto y URLs. El HTML resultante cuando se llama a `render()` tendrá cada miga de pan encerrada en etiquetas `<dt>`, mientras que la cadena global lo estará en etiquetas `<dl>`.

### Métodos
```php
public function add(
    string $label, 
    string $link = ""
): Breadcrumbs
```
Añade una nueva miga de pan.

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
Elimina migas mediante url.

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
[Phalcon\Html\TagFactory](api/phalcon_html#html-tagfactory) es un componente que genera etiquetas HTML. Este componente crea una nueva clase localizador con etiquetas HTML predefinidas adjuntas a él. Cada clase etiqueta es cargada de forma perezosa para maximizar el rendimiento. Para instanciar la factoría y obtener un ayudante etiqueta, necesita llamar a `newInstance()`.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Html\TagFactory;

$escaper = new Escaper();
$factory = new TagFactory($escaper);
$anchor  = $factory->newInstance('a');
```
Los nombres registrados para los respectivos ayudantes son:

| Nombre       | Descripción                                                                                                |
| ------------ | ---------------------------------------------------------------------------------------------------------- |
| `a`          | [Phalcon\Html\Helper\Anchor](api/phalcon_html#html-helper-anchor) - etiqueta `<a>`                |
| `aRaw`       | [Phalcon\Html\Helper\AnchorRaw](api/phalcon_html#html-helper-anchorraw) - etiqueta en bruto `<a>` |
| `body`       | [Phalcon\Html\Helper\Body](api/phalcon_html#html-helper-body) - etiqueta `<body>`                 |
| `button`     | [Phalcon\Html\Helper\Button](api/phalcon_html#html-helper-button) - etiqueta `<button>`           |
| `close`      | [Phalcon\Html\Helper\Close](api/phalcon_html#html-helper-close) - etiqueta de cierre                    |
| `element`    | [Phalcon\Html\Helper\Element](api/phalcon_html#html-helper-element) - cualquier elemento                |
| `elementRaw` | [Phalcon\Html\Helper\ElementRaw](api/phalcon_html#html-helper-elementraw) - cualquier etiqueta en bruto |
| `form`       | [Phalcon\Html\Helper\Form](api/phalcon_html#html-helper-form) - etiqueta `<form>`                 |
| `img`        | [Phalcon\Html\Helper\Img](api/phalcon_html#html-helper-img) - etiqueta `<img>`                    |
| `label`      | [Phalcon\Html\Helper\Label](api/phalcon_html#html-helper-label) - etiqueta `<label>`              |
| `textarea`   | [Phalcon\Html\Helper\TextArea](api/phalcon_html#html-helper-textarea) - etiqueta `<textarea>`     |

### Ayudantes
Todas los ayudantes usados por [Phalcon\Html\TagFactory](api/phalcon_html#html-tagfactory) se localizan bajo el espacio de nombres `Phalcon\Html\Helper`. Puede crear cada una de estas clases individualmente si lo desea, o puede usar la factoría de etiquetas tal y como se muestra arriba. Además de los ayudantes `*Raw`, si el ayudante requiere texto, automáticamente será escapado usando [Phalcon\Escaper](escaper).

> **NOTA**: El código y la salida inferior han sido formateados por legibilidad 
> 
> {: .alert .alert-info }

### `a`
[Phalcon\Html\Helper\Anchor](api/phalcon_html#html-helper-anchor) crea una etiqueta HTML ancla. El componente acepta `href` como cadena, `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\AchorRaw](api/phalcon_html#html-helper-anchorraw) crea etiquetas ancla HTML en bruto, es decir, el texto no será escapado. El componente acepta `href` como una cadena, `text` como una cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Body](api/phalcon_html#html-helper-body) crea una etiqueta `<body>`. El componente acepta opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Button](api/phalcon_html#html-helper-button) crea etiquetas HTML `<button>`. El component acepta `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Close](api/phalcon_html#html-helper-close) crea las etiquetas de cierre. El componente acepta el `name` de la etiqueta a cerrar.

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
[Phalcon\Html\Helper\Element](api/phalcon_html#html-helper-element) crea etiquetas HTML basadas en el parámetro `name` indicado. El componente acepta `name` como cadena, `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\ElementRaw](api/phalcon_html#html-helper-elementraw) crea etiquetas HTML en bruto, es decir, el texto no será escapado. La etiqueta creada se basa en el parámetro `name` indicado. El componente acepta `name` como cadena, `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Form](api/phalcon_html#html-helper-form) crea etiquetas HTML `<form>`. El componente acepta un vector con todos los atributos que necesita el ancla. Por defecto el formulario tiene `method` `post` y `enctype` `multipart/form-data`.

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
[Phalcon\Html\Helper\Img](api/phalcon_html#html-helper-img) crea etiquetas HTML `<img>`. El componente acepta `src` como una cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\Label](api/phalcon_html#html-helper-label) crea etiquetas HTML `<label>`. El componente acepta opcionalmente un vector con todos los atributos que necesita el ancla.

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
[Phalcon\Html\Helper\TextArea](api/phalcon_html#html-helper-textarea) crea etiquetas HTML `<textarea>`. El component acepta `text` como cadena y opcionalmente un vector con todos los atributos que necesita el ancla.

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
