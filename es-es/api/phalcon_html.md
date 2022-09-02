---
layout: default
title: 'Phalcon\Html'
---

* [Phalcon\Html\Attributes](#html-attributes)
* [Phalcon\Html\Attributes\AttributesInterface](#html-attributes-attributesinterface)
* [Phalcon\Html\Attributes\RenderInterface](#html-attributes-renderinterface)
* [Phalcon\Html\Breadcrumbs](#html-breadcrumbs)
* [Phalcon\Html\Escaper](#html-escaper)
* [Phalcon\Html\Escaper\EscaperInterface](#html-escaper-escaperinterface)
* [Phalcon\Html\Escaper\Exception](#html-escaper-exception)
* [Phalcon\Html\EscaperFactory](#html-escaperfactory)
* [Phalcon\Html\Exception](#html-exception)
* [Phalcon\Html\Helper\AbstractHelper](#html-helper-abstracthelper)
* [Phalcon\Html\Helper\AbstractList](#html-helper-abstractlist)
* [Phalcon\Html\Helper\AbstractSeries](#html-helper-abstractseries)
* [Phalcon\Html\Helper\Anchor](#html-helper-anchor)
* [Phalcon\Html\Helper\Base](#html-helper-base)
* [Phalcon\Html\Helper\Body](#html-helper-body)
* [Phalcon\Html\Helper\Button](#html-helper-button)
* [Phalcon\Html\Helper\Close](#html-helper-close)
* [Phalcon\Html\Helper\Doctype](#html-helper-doctype)
* [Phalcon\Html\Helper\Element](#html-helper-element)
* [Phalcon\Html\Helper\Form](#html-helper-form)
* [Phalcon\Html\Helper\Img](#html-helper-img)
* [Phalcon\Html\Helper\Input\AbstractInput](#html-helper-input-abstractinput)
* [Phalcon\Html\Helper\Input\Checkbox](#html-helper-input-checkbox)
* [Phalcon\Html\Helper\Input\Color](#html-helper-input-color)
* [Phalcon\Html\Helper\Input\Date](#html-helper-input-date)
* [Phalcon\Html\Helper\Input\DateTime](#html-helper-input-datetime)
* [Phalcon\Html\Helper\Input\DateTimeLocal](#html-helper-input-datetimelocal)
* [Phalcon\Html\Helper\Input\Email](#html-helper-input-email)
* [Phalcon\Html\Helper\Input\File](#html-helper-input-file)
* [Phalcon\Html\Helper\Input\Hidden](#html-helper-input-hidden)
* [Phalcon\Html\Helper\Input\Image](#html-helper-input-image)
* [Phalcon\Html\Helper\Input\Input](#html-helper-input-input)
* [Phalcon\Html\Helper\Input\Month](#html-helper-input-month)
* [Phalcon\Html\Helper\Input\Numeric](#html-helper-input-numeric)
* [Phalcon\Html\Helper\Input\Password](#html-helper-input-password)
* [Phalcon\Html\Helper\Input\Radio](#html-helper-input-radio)
* [Phalcon\Html\Helper\Input\Range](#html-helper-input-range)
* [Phalcon\Html\Helper\Input\Search](#html-helper-input-search)
* [Phalcon\Html\Helper\Input\Select](#html-helper-input-select)
* [Phalcon\Html\Helper\Input\Submit](#html-helper-input-submit)
* [Phalcon\Html\Helper\Input\Tel](#html-helper-input-tel)
* [Phalcon\Html\Helper\Input\Text](#html-helper-input-text)
* [Phalcon\Html\Helper\Input\Textarea](#html-helper-input-textarea)
* [Phalcon\Html\Helper\Input\Time](#html-helper-input-time)
* [Phalcon\Html\Helper\Input\Url](#html-helper-input-url)
* [Phalcon\Html\Helper\Input\Week](#html-helper-input-week)
* [Phalcon\Html\Helper\Label](#html-helper-label)
* [Phalcon\Html\Helper\Link](#html-helper-link)
* [Phalcon\Html\Helper\Meta](#html-helper-meta)
* [Phalcon\Html\Helper\Ol](#html-helper-ol)
* [Phalcon\Html\Helper\Script](#html-helper-script)
* [Phalcon\Html\Helper\Style](#html-helper-style)
* [Phalcon\Html\Helper\Title](#html-helper-title)
* [Phalcon\Html\Helper\Ul](#html-helper-ul)
* [Phalcon\Html\Link\AbstractLink](#html-link-abstractlink)
* [Phalcon\Html\Link\AbstractLinkProvider](#html-link-abstractlinkprovider)
* [Phalcon\Html\Link\EvolvableLink](#html-link-evolvablelink)
* [Phalcon\Html\Link\EvolvableLinkProvider](#html-link-evolvablelinkprovider)
* [Phalcon\Html\Link\Interfaces\EvolvableLinkInterface](#html-link-interfaces-evolvablelinkinterface)
* [Phalcon\Html\Link\Interfaces\EvolvableLinkProviderInterface](#html-link-interfaces-evolvablelinkproviderinterface)
* [Phalcon\Html\Link\Interfaces\LinkInterface](#html-link-interfaces-linkinterface)
* [Phalcon\Html\Link\Interfaces\LinkProviderInterface](#html-link-interfaces-linkproviderinterface)
* [Phalcon\Html\Link\Link](#html-link-link)
* [Phalcon\Html\Link\LinkProvider](#html-link-linkprovider)
* [Phalcon\Html\Link\Serializer\Header](#html-link-serializer-header)
* [Phalcon\Html\Link\Serializer\SerializerInterface](#html-link-serializer-serializerinterface)
* [Phalcon\Html\TagFactory](#html-tagfactory)

<h1 id="html-attributes">Class Phalcon\Html\Attributes</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Support\Collection, Phalcon\Html\Attributes\RenderInterface | | Extends    | Collection | | Implements | RenderInterface |

Esta clase ayuda a trabajar con atributos HTML


## Métodos

```php
public function __toString(): string;
```
Alias del método `render`


```php
public function render(): string;
```
Renderiza atributos como atributos HTML


```php
protected function renderAttributes( array $attributes ): string;
```
@todo remove this when we refactor forms. Maybe remove this class? Put it into traits




<h1 id="html-attributes-attributesinterface">Interface Phalcon\Html\Attributes\AttributesInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes/AttributesInterface.zep)

| Namespace  | Phalcon\Html\Attributes | | Uses       | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\AttributesInterface
*
* Interface Phalcon\Html\Attributes\AttributesInterface */

## Métodos

```php
public function getAttributes(): Attributes;
```
Obtiene atributos


```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```
Establece atributos




<h1 id="html-attributes-renderinterface">Interface Phalcon\Html\Attributes\RenderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes/RenderInterface.zep)

| Namespace  | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\RenderInterface
*
* Interface Phalcon\Html\Attributes\RenderInterface */

## Métodos

```php
public function render(): string;
```
Genera una representación de cadena




<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Breadcrumbs.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Di\DiInterface |

Phalcon\Html\Breadcrumbs

Este componente ofrece una forma fácil de crear migas de pan para su aplicación. El HTML resultante cuando llama a `render()` tendrá cada miga de pan encerrada en etiquetas `<dt>`, mientras que la cadena entera está encerrada en etiquetas `<dl>`.


## Propiedades
```php
/**
 * Keeps all the breadcrumbs
 *
 * @var array
 */
private elements;

/**
 * Crumb separator
 *
 * @var string
 */
private separator =  / ;

/**
 * The HTML template to use to render the breadcrumbs.
 *
 * @var string
 */
private template = <dt><a href=\"%link%\">%label%</a></dt>;

```

## Métodos

```php
public function add( string $label, string $link = string ): Breadcrumbs;
```
Añade una nueva miga.

```php
// Adding a crumb with a link
$breadcrumbs->add("Home", "/");

// Adding a crumb without a link (normally the last one)
$breadcrumbs->add("Users");
```


```php
public function clear(): void;
```
Limpia las migas

```php
$breadcrumbs->clear()
```


```php
public function getSeparator(): string
```

```php
public function remove( string $link ): void;
```
Elimina una miga por url.

```php
$breadcrumbs->remove("/admin/user/create");

// remove a crumb without an url (last link)
$breadcrumbs->remove();
```


```php
public function render(): string;
```
Renderiza y muestra las migas de pan basadas en una plantilla configurada previamente.

```php
echo $breadcrumbs->render();
```


```php
public function setSeparator( string $separator )
```

```php
public function toArray(): array;
```
Devuelve el vector de migas de pan interno




<h1 id="html-escaper">Class Phalcon\Html\Escaper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Escaper.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Html\Escaper\EscaperInterface | | Implements | EscaperInterface |

Phalcon\Html\Escaper

Escapa diferentes tipos de texto asegurándolos. Al usar este componente puede prevenir ataques XSS.

Este componente sólo trabaja con UTF-8. La extensión PREG necesita ser compilada con el soporte UTF-8.

```php
$escaper = new \Phalcon\Html\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E
```


## Propiedades
```php
/**
 * @var bool
 */
protected doubleEncode = true;

/**
 * @var string
 */
protected encoding = utf-8;

/**
 * ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401
 *
 * @var int
 */
protected flags = 11;

```

## Métodos

```php
public function attributes( string $input ): string;
```
Escapa una cadena de atributo HTML


```php
public function css( string $input ): string;
```
Escapa cadenas CSS reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada


```php
final public function detectEncoding( string $input ): string | null;
```
Detecta la codificación de caracteres de una cadena a ser gestionada por un codificador. Gestión especial para chr(172) y chr(128) a chr(159) que fallan al ser detectados por mb_detect_encoding()


```php
public function escapeCss( string $input ): string;
```
Escapa cadenas CSS reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada


```php
public function escapeHtml( string $input = null ): string;
```
Escapa una cadena HTML. Internamente usa htmlspecialchars


```php
public function escapeHtmlAttr( string $input = null ): string;
```
Escapa una cadena de atributo HTML


```php
public function escapeJs( string $input ): string;
```
Escapa cadenas JavaScript reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada


```php
public function escapeUrl( string $input ): string;
```
Escapa una URL. Internamente usa rawurlencode


```php
public function getEncoding(): string
```

```php
public function getFlags(): int
```

```php
public function html( string $input = null ): string;
```
Escapa una cadena HTML. Internamente usa htmlspecialchars


```php
public function js( string $input ): string;
```
Escapa cadenas javascript reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada


```php
final public function normalizeEncoding( string $input ): string;
```
Utilidad para normalizar la codificación de una cadena a UTF-32.


```php
public function setDoubleEncode( bool $doubleEncode ): Escaper;
```
Establece el double_encode para ser usado por el escapador

```php
$escaper->setDoubleEncode(false);
```


```php
public function setEncoding( string $encoding ): EscaperInterface;
```
Configura la codificación a ser usada por el escapador

```php
$escaper->setEncoding("utf-8");
```


```php
public function setFlags( int $flags ): EscaperInterface;
```
Establece el tipo de comillas HTML para htmlspecialchars

```php
$escaper->setFlags(ENT_XHTML);
```


```php
public function setHtmlQuoteType( int $flags ): EscaperInterface;
```
Establece el tipo de comillas HTML para htmlspecialchars

```php
$escaper->setHtmlQuoteType(ENT_XHTML);
```


```php
public function url( string $input ): string;
```
Escapa una URL. Internamente usa rawurlencode




<h1 id="html-escaper-escaperinterface">Interface Phalcon\Html\Escaper\EscaperInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Escaper/EscaperInterface.zep)

| Namespace  | Phalcon\Html\Escaper |

Interface for Phalcon\Html\Escaper


## Métodos

```php
public function attributes( string $input ): string;
```
Escapa una cadena de atributo HTML


```php
public function css( string $input ): string;
```
Escapa cadenas CSS reemplazando caracteres no alfanuméricos por su representación hexadecimal


```php
public function getEncoding(): string;
```
Devuelve la codificación interna usada por el escapador


```php
public function html( string $input ): string;
```
Escapa una cadena HTML


```php
public function js( string $input ): string;
```
Escapa cadenas Javascript reemplazando caracteres no alfanuméricos por su representación hexadecimal


```php
public function setEncoding( string $encoding ): EscaperInterface;
```
Configura la codificación a ser usada por el escapador


```php
public function setFlags( int $flags ): EscaperInterface;
```
Establece el tipo de comillas HTML para htmlspecialchars


```php
public function url( string $input ): string;
```
Escapa una URL. Internamente usa rawurlencode




<h1 id="html-escaper-exception">Class Phalcon\Html\Escaper\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Escaper/Exception.zep)

| Namespace  | Phalcon\Html\Escaper | | Extends    | \Exception |

Exceptions thrown in Phalcon\Html\Escaper will use this class



<h1 id="html-escaperfactory">Class Phalcon\Html\EscaperFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/EscaperFactory.zep)

| Namespace  | Phalcon\Html |

Class EscaperFactory


## Métodos

```php
public function newInstance(): Escaper;
```
Create a new instance of the object




<h1 id="html-exception">Class Phalcon\Html\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Exception.zep)

| Namespace  | Phalcon\Html | | Extends    | \Exception |

Phalcon\Html\Tag\Exception

Las excepciones lanzadas en Phalcon\Html\Tag usarán esta clase



<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractHelper.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Escaper\EscaperInterface, Phalcon\Html\Exception |

@property string           $delimiter @property EscaperInterface $escaper @property string           $indent @property int              $indentLevel


## Propiedades
```php
/**
 * @var string
 */
protected delimiter = ;

/**
 * @var EscaperInterface
 */
protected escaper;

/**
 * @var string
 */
protected indent =     ;

/**
 * @var int
 */
protected indentLevel = 1;

```

## Métodos

```php
public function __construct( EscaperInterface $escaper );
```
Constructor AbstractHelper.


```php
protected function close( string $tag, bool $raw = bool ): string;
```
Produce una etiqueta de cierre


```php
protected function indent(): string;
```
Replica la sangría x veces según el `indentLevel`


```php
protected function orderAttributes( array $overrides, array $attributes ): array;
```
Mantiene todos los atributos ordenados - el mismo orden todo el tomo


```php
protected function renderArrayElements( array $elements, string $delimiter ): string;
```
Recorre un vector y llama al método definido en el primer elemento con atributos como el segundo, devolviendo la cadena resultante


```php
protected function renderAttributes( array $attributes ): string;
```
Renderiza todos los atributos


```php
protected function renderElement( string $tag, array $attributes = [] ): string;
```
Renderiza un elemento


```php
protected function renderFullElement( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
```
Renderiza un elemento


```php
protected function renderTag( string $tag, array $attributes = [], string $close = string ): string;
```
Renderiza una etiqueta


```php
protected function selfClose( string $tag, array $attributes = [] ): string;
```
Produce una etiqueta de autocierre i.e. <img />




<h1 id="html-helper-abstractlist">Abstract Class Phalcon\Html\Helper\AbstractList</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractList.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class AbstractList


## Propiedades
```php
/**
 * @var array
 */
protected attributes;

/**
 * @var string
 */
protected elementTag = li;

/**
 * @var array
 */
protected store;

```

## Métodos

```php
public function __invoke( string $indent = string, string $delimiter = null, array $attributes = [] ): AbstractList;
```

```php
public function __toString();
```
Genera y devuelve el HTML para la lista.


```php
abstract protected function getTag(): string;
```
Devuelve el nombre de etiqueta.




<h1 id="html-helper-abstractseries">Abstract Class Phalcon\Html\Helper\AbstractSeries</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractSeries.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | AbstractHelper |

@property array $attributes @property array $store


## Propiedades
```php
/**
 * @var array
 */
protected attributes;

/**
 * @var array
 */
protected store;

```

## Métodos

```php
public function __invoke( string $indent = string, string $delimiter = null ): AbstractSeries;
```

```php
public function __toString();
```
Genera y devuelve el HTML para la lista.


```php
abstract protected function getTag(): string;
```
Devuelve el nombre de etiqueta.




<h1 id="html-helper-anchor">Class Phalcon\Html\Helper\Anchor</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Anchor.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Anchor


## Métodos

```php
public function __invoke( string $href, string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce a <a> tag


```php
protected function processAttributes( string $href, array $attributes ): array;
```





<h1 id="html-helper-base">Class Phalcon\Html\Helper\Base</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Base.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Base


## Métodos

```php
public function __invoke( string $href = null, array $attributes = [] ): string;
```
Produce una etiqueta `<base/>`.




<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Body.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Body


## Métodos

```php
public function __invoke( array $attributes = [] ): string;
```
Produce una etiqueta `<body>`.




<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Button.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Button


## Métodos

```php
public function __invoke( string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce una etiqueta `<button>`.




<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Close.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | AbstractHelper |

Class Close


## Métodos

```php
public function __invoke( string $tag, bool $raw = bool ): string;
```
Produce una etiqueta `</...>`.




<h1 id="html-helper-doctype">Class Phalcon\Html\Helper\Doctype</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Doctype.zep)

| Namespace  | Phalcon\Html\Helper |

Creates Doctype tags


## Constantes
```php
const HTML32 = 1;
const HTML401_FRAMESET = 4;
const HTML401_STRICT = 2;
const HTML401_TRANSITIONAL = 3;
const HTML5 = 5;
const XHTML10_FRAMESET = 8;
const XHTML10_STRICT = 6;
const XHTML10_TRANSITIONAL = 7;
const XHTML11 = 9;
const XHTML20 = 10;
const XHTML5 = 11;
```

## Propiedades
```php
/**
 * @var string
 */
private delimiter;

/**
 * @var int
 */
private flag;

```

## Métodos

```php
public function __construct();
```

```php
public function __invoke( int $flag = static-constant-access, string $delimiter = string ): Doctype;
```
Produce a <doctype> tag


```php
public function __toString(): string;
```





<h1 id="html-helper-element">Class Phalcon\Html\Helper\Element</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Element.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Element


## Métodos

```php
public function __invoke( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce una etiqueta.




<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Form.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Form


## Métodos

```php
public function __invoke( array $attributes = [] ): string;
```
Produce una etiqueta `<form>`.




<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Img.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Img


## Métodos

```php
public function __invoke( string $src, array $attributes = [] ): string;
```
Produce a <img /> tag.




<h1 id="html-helper-input-abstractinput">Abstract Class Phalcon\Html\Helper\Input\AbstractInput</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/AbstractInput.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Helper\AbstractHelper | | Extends    | AbstractHelper |

Class AbstractInput

@property array  $attributes @property string $type @property string $value


## Propiedades
```php
/**
 * @var string
 */
protected type = text;

/**
 * @var array
 */
protected attributes;

```

## Métodos

```php
public function __invoke( string $name, string $value = null, array $attributes = [] ): AbstractInput;
```

```php
public function __toString();
```
Devuelve el HTML para la entrada.


```php
public function setValue( string $value = null ): AbstractInput;
```
Establece el valor del elemento




<h1 id="html-helper-input-checkbox">Class Phalcon\Html\Helper\Input\Checkbox</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Checkbox.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Escaper\EscaperInterface | | Extends    | AbstractInput |

Class Checkbox

@property array $label


## Propiedades
```php
/**
 * @var array
 */
protected label;

/**
 * @var string
 */
protected type = checkbox;

```

## Métodos

```php
public function __construct( EscaperInterface $escaper );
```
Constructor AbstractHelper.


```php
public function __toString();
```
Devuelve el HTML para la entrada.


```php
public function label( array $attributes = [] ): Checkbox;
```
Adjunta una etiqueta al elemento




<h1 id="html-helper-input-color">Class Phalcon\Html\Helper\Input\Color</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Color.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Color


## Propiedades
```php
//
protected type = color;

```


<h1 id="html-helper-input-date">Class Phalcon\Html\Helper\Input\Date</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Date.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Date


## Propiedades
```php
//
protected type = date;

```


<h1 id="html-helper-input-datetime">Class Phalcon\Html\Helper\Input\DateTime</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/DateTime.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class DateTime


## Propiedades
```php
//
protected type = datetime;

```


<h1 id="html-helper-input-datetimelocal">Class Phalcon\Html\Helper\Input\DateTimeLocal</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/DateTimeLocal.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class DateTimeLocal


## Propiedades
```php
//
protected type = datetime-local;

```


<h1 id="html-helper-input-email">Class Phalcon\Html\Helper\Input\Email</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Email.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Email


## Propiedades
```php
//
protected type = email;

```


<h1 id="html-helper-input-file">Class Phalcon\Html\Helper\Input\File</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/File.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class File


## Propiedades
```php
//
protected type = file;

```


<h1 id="html-helper-input-hidden">Class Phalcon\Html\Helper\Input\Hidden</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Hidden.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Hidden


## Propiedades
```php
//
protected type = hidden;

```


<h1 id="html-helper-input-image">Class Phalcon\Html\Helper\Input\Image</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Image.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Image


## Propiedades
```php
//
protected type = image;

```


<h1 id="html-helper-input-input">Class Phalcon\Html\Helper\Input\Input</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Input.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Input


## Métodos

```php
public function setType( string $type ): AbstractInput;
```
Establece el tipo de entrada




<h1 id="html-helper-input-month">Class Phalcon\Html\Helper\Input\Month</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Month.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Month


## Propiedades
```php
//
protected type = month;

```


<h1 id="html-helper-input-numeric">Class Phalcon\Html\Helper\Input\Numeric</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Numeric.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Numeric


## Propiedades
```php
//
protected type = number;

```


<h1 id="html-helper-input-password">Class Phalcon\Html\Helper\Input\Password</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Password.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Password


## Propiedades
```php
//
protected type = password;

```


<h1 id="html-helper-input-radio">Class Phalcon\Html\Helper\Input\Radio</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Radio.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | Checkbox |

Class Radio


## Propiedades
```php
/**
 * @var string
 */
protected type = radio;

```


<h1 id="html-helper-input-range">Class Phalcon\Html\Helper\Input\Range</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Range.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Range


## Propiedades
```php
//
protected type = range;

```


<h1 id="html-helper-input-search">Class Phalcon\Html\Helper\Input\Search</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Search.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Search


## Propiedades
```php
//
protected type = search;

```


<h1 id="html-helper-input-select">Class Phalcon\Html\Helper\Input\Select</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Select.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Helper\AbstractList | | Extends    | AbstractList |

Clase Select

@property string $elementTag @property bool   $inOptGroup @property string $selected


## Propiedades
```php
/**
 * @var string
 */
protected elementTag = option;

/**
 * @var bool
 */
protected inOptGroup = false;

/**
 * @var string
 */
protected selected = ;

```

## Métodos

```php
public function add( string $text, string $value = null, array $attributes = [], bool $raw = bool ): Select;
```
Añade un elemento a la lista


```php
public function addPlaceholder( string $text, mixed $value = null, array $attributes = [], bool $raw = bool ): Select;
```
Add a placeholder to the element


```php
public function optGroup( string $label = null, array $attributes = [] ): Select;
```
Crea un grupo de opciones


```php
public function selected( string $selected ): Select;
```

```php
protected function getTag(): string;
```

```php
protected function optGroupEnd(): string;
```

```php
protected function optGroupStart( string $label, array $attributes ): string;
```





<h1 id="html-helper-input-submit">Class Phalcon\Html\Helper\Input\Submit</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Submit.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Submit


## Propiedades
```php
//
protected type = submit;

```


<h1 id="html-helper-input-tel">Class Phalcon\Html\Helper\Input\Tel</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Tel.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Tel


## Propiedades
```php
//
protected type = tel;

```


<h1 id="html-helper-input-text">Class Phalcon\Html\Helper\Input\Text</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Text.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Text



<h1 id="html-helper-input-textarea">Class Phalcon\Html\Helper\Input\Textarea</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Textarea.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractInput |

Class Textarea


## Propiedades
```php
/**
 * @var string
 */
protected type = textarea;

```

## Métodos

```php
public function __toString();
```
Devuelve el HTML para la entrada.




<h1 id="html-helper-input-time">Class Phalcon\Html\Helper\Input\Time</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Time.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Time


## Propiedades
```php
//
protected type = time;

```


<h1 id="html-helper-input-url">Class Phalcon\Html\Helper\Input\Url</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Url.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Url


## Propiedades
```php
//
protected type = url;

```


<h1 id="html-helper-input-week">Class Phalcon\Html\Helper\Input\Week</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Week.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Week


## Propiedades
```php
//
protected type = week;

```


<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Label.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Label


## Métodos

```php
public function __invoke( string $label, array $attributes = [], bool $raw = bool ): string;
```
Produce una etiqueta `<label>`.




<h1 id="html-helper-link">Class Phalcon\Html\Helper\Link</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Link.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | Style |

Creates <link> tags


## Métodos

```php
public function add( string $url, array $attributes = [] );
```
Añade un elemento a la lista


```php
protected function getAttributes( string $url, array $attributes ): array;
```
Devuelve los atributos necesarios


```php
protected function getTag(): string;
```





<h1 id="html-helper-meta">Class Phalcon\Html\Helper\Meta</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Meta.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractSeries |

Class Meta


## Métodos

```php
public function add( array $attributes = [] ): Meta;
```
Añade un elemento a la lista


```php
public function addHttp( string $httpEquiv, string $content ): Meta;
```

```php
public function addName( string $name, string $content ): Meta;
```

```php
public function addProperty( string $name, string $content ): Meta;
```

```php
protected function getTag(): string;
```





<h1 id="html-helper-ol">Class Phalcon\Html\Helper\Ol</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Ol.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | AbstractList |

Class Ol


## Métodos

```php
public function add( string $text, array $attributes = [], bool $raw = bool ): AbstractList;
```
Añade un elemento a la lista


```php
protected function getTag(): string;
```





<h1 id="html-helper-script">Class Phalcon\Html\Helper\Script</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Script.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractSeries |

Class Script


## Métodos

```php
public function add( string $url, array $attributes = [] );
```
Añade un elemento a la lista


```php
protected function getAttributes( string $url, array $attributes ): array;
```
Devuelve los atributos necesarios


```php
protected function getTag(): string;
```





<h1 id="html-helper-style">Class Phalcon\Html\Helper\Style</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Style.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractSeries |

Class Style


## Propiedades
```php
/**
 * @var bool
 */
private isStyle = false;

```

## Métodos

```php
public function add( string $url, array $attributes = [] );
```
Añade un elemento a la lista


```php
public function setStyle( bool $flag ): Style;
```
Sets if this is a style or link tag


```php
protected function getAttributes( string $url, array $attributes ): array;
```
Devuelve los atributos necesarios


```php
protected function getTag(): string;
```





<h1 id="html-helper-title">Class Phalcon\Html\Helper\Title</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Title.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Title

@property array  $append @property string $delimiter @property string $indent @property array  $prepend @property string $title @property string $separator


## Propiedades
```php
/**
 * @var array
 */
protected append;

/**
 * @var array
 */
protected prepend;

/**
 * @var string
 */
protected title = ;

/**
 * @var string
 */
protected separator = ;

```

## Métodos

```php
public function __invoke( string $indent = "    ", string $delimiter = null ): Title;
```
Establece el separador y devuelve el objeto de vuelta


```php
public function __toString();
```
Devuelve las etiquetas de título


```php
public function append( string $text, bool $raw = bool ): Title;
```
Añade texto al título de documento actual


```php
public function get(): string;
```
Devuelve el título


```php
public function prepend( string $text, bool $raw = bool ): Title;
```
Antepone texto al título de documento actual


```php
public function set( string $text, bool $raw = bool ): Title;
```
Establece el título


```php
public function setSeparator( string $separator, bool $raw = bool ): Title;
```
Sets the separator




<h1 id="html-helper-ul">Class Phalcon\Html\Helper\Ul</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Ul.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | Ol |

Class Ul


## Métodos

```php
protected function getTag(): string;
```





<h1 id="html-link-abstractlink">Abstract Class Phalcon\Html\Link\AbstractLink</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/AbstractLink.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Support\Collection |

@property array  $attributes @property string $href @property array  $rels @property bool   $templated


## Propiedades
```php
/**
 * @var Collection
 */
protected attributes;

/**
 * @var string
 */
protected href = ;

/**
 * @var Collection
 */
protected rels;

/**
 * @var bool
 */
protected templated = false;

```

## Métodos

```php
public function __construct( string $rel = string, string $href = string, array $attributes = [] );
```
Constructor Link.


```php
protected function doGetAttributes(): array;
```
Devuelve una lista de atributos que describen la URI de destino.


```php
protected function doGetHref(): string;
```
Devuelve el destino del enlace.

El enlace destino debe ser uno de:
- Una URI absoluta, definida en RFC 5988.
- Una URI relativa, definida en RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- Una plantilla de URI, definida en RFC 6570.

Si se devuelve una plantilla URI, isTemplated() DEBE devolver `True`.


```php
protected function doGetRels(): array;
```
Devuelve el/los tipo/s de relación del enlace.

Este método devuelve 0 o más tipos de relación para un enlace, expresado como un vector de cadenas.


```php
protected function doIsTemplated(): bool;
```
Returns whether this is a templated link.


```php
protected function doWithAttribute( string $key, mixed $value );
```

```php
protected function doWithHref( string $href );
```

```php
protected function doWithRel( string $key );
```

```php
protected function doWithoutAttribute( string $key );
```

```php
protected function doWithoutRel( string $key );
```

```php
protected function hrefIsTemplated( string $href ): bool;
```
Determina si un `href` es un enlace de plantilla o no.

@see https://tools.ietf.org/html/rfc6570




<h1 id="html-link-abstractlinkprovider">Abstract Class Phalcon\Html\Link\AbstractLinkProvider</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/AbstractLinkProvider.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\LinkInterface |

@property array $links


## Propiedades
```php
/**
 * @var array
 */
protected links;

```

## Métodos

```php
public function __construct( array $links = [] );
```
Constructor LinkProvider.


```php
protected function doGetLinks(): array;
```
Devuelve un iterable de objetos LinkInterface.

El iterable puede ser un vector o cualquier objeto `\Traversable` de PHP. Si no hay enlaces disponibles, se DEBE devolver un vector vacío o `\Travesable`.


```php
protected function doGetLinksByRel( string $rel ): array;
```
Devuelve un iterable de objetos `LinkInterface` que tienen una relación específica.

El iterable puede ser un vector o cualquier objeto `\Traversable` de PHP. Si no hay enlaces disponibles con esa relación, se DEBE devolver un vector vacío o `\Traversable`.


```php
protected function doWithLink( mixed $link );
```
Devuelve una instancia con el enlace especificado incluido.

Si el enlace especificado ya está presente, este método DEBE devolver normalmente sin errores. The link is present if $link is === identical to a link object already in the collection.


```php
protected function doWithoutLink( mixed $link );
```
Devuelve una instancia con el enlace especificado eliminado.

Si el enlace especificado no está presente, este método DEBE devolver normalmente sin errores. The link is present if $link is === identical to a link object already in the collection.


```php
protected function getKey( mixed $link ): string;
```
Devuelve la clave hash del objeto




<h1 id="html-link-evolvablelink">Class Phalcon\Html\Link\EvolvableLink</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/EvolvableLink.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\EvolvableLinkInterface | | Extends    | Link | | Implements | EvolvableLinkInterface |

Class Phalcon\Http\Link\EvolvableLink

@property array  attributes @property string href @property array  rels @property bool   templated


## Métodos

```php
public function withAttribute( mixed $attribute, mixed $value ): EvolvableLinkInterface;
```
Devuelve una instancia con el atributo especificado añadido.

Si el atributo especificado ya está presente, se sobreescribirá con el nuevo valor.


```php
public function withHref( string $href ): EvolvableLinkInterface;
```
Devuelve una instancia con el `href` especificado.


```php
public function withRel( string $rel ): EvolvableLinkInterface;
```
Devuelve una instancia con la relación especificada incluida.

Si el `rel` especificado ya está presente, este método DEBE devolver normalmente sin errores, pero sin añadir el `rel` una segunda vez.


```php
public function withoutAttribute( string $attribute ): EvolvableLinkInterface;
```
Devuelve una instancia con el atributo especificado excluido.

Si el atributo especificado no está presente, este método DEBE devolver normalmente sin errores.


```php
public function withoutRel( string $rel ): EvolvableLinkInterface;
```
Devuelve una instancia con la relación especificada excluida.

Si el `rel` especificado no está presente, este método DEBE devolver normalmente sin errores.




<h1 id="html-link-evolvablelinkprovider">Class Phalcon\Html\Link\EvolvableLinkProvider</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/EvolvableLinkProvider.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\EvolvableLinkProviderInterface, Phalcon\Html\Link\Interfaces\LinkInterface | | Extends    | LinkProvider | | Implements | EvolvableLinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links


## Métodos

```php
public function withLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Devuelve una instancia con el enlace especificado incluido.

Si el enlace especificado ya está presente, este método DEBE devolver normalmente sin errores. El enlace está presente si enlace es === idéntico al objeto enlace presente en la colección.


```php
public function withoutLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Devuelve una instancia con el enlace especificado eliminado.

Si el enlace especificado no está presente, este método DEBE devolver normalmente sin errores. El enlace está presente si enlace es === idéntico al objeto enlace presente en la colección.




<h1 id="html-link-interfaces-evolvablelinkinterface">Interface Phalcon\Html\Link\Interfaces\EvolvableLinkInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Interfaces/EvolvableLinkInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces | | Extends    | LinkInterface |

An evolvable link value object.


## Métodos

```php
public function withAttribute( string $attribute, string $value ): EvolvableLinkInterface;
```
Devuelve una instancia con el atributo especificado añadido.

Si el atributo especificado ya está presente, se sobreescribirá con el nuevo valor.


```php
public function withHref( string $href ): EvolvableLinkInterface;
```
Devuelve una instancia con el `href` especificado.


```php
public function withRel( string $rel ): EvolvableLinkInterface;
```
Devuelve una instancia con la relación especificada incluida.

Si el `rel` especificado ya está presente, este método DEBE devolver normalmente sin errores, pero sin añadir el `rel` una segunda vez.


```php
public function withoutAttribute( string $attribute ): EvolvableLinkInterface;
```
Devuelve una instancia con el atributo especificado excluido.

Si el atributo especificado no está presente, este método DEBE devolver normalmente sin errores.


```php
public function withoutRel( string $rel ): EvolvableLinkInterface;
```
Devuelve una instancia con la relación especificada excluida.

If the specified rel is already not present, this method MUST return normally without errors.




<h1 id="html-link-interfaces-evolvablelinkproviderinterface">Interface Phalcon\Html\Link\Interfaces\EvolvableLinkProviderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Interfaces/EvolvableLinkProviderInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces | | Extends    | LinkProviderInterface |

An evolvable link provider value object.


## Métodos

```php
public function withLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Devuelve una instancia con el enlace especificado incluido.

Si el enlace especificado ya está presente, este método DEBE devolver normalmente sin errores. The link is present if $link is === identical to a link object already in the collection.


```php
public function withoutLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Returns an instance with the specifed link removed.

Si el enlace especificado no está presente, este método DEBE devolver normalmente sin errores. The link is present if $link is === identical to a link object already in the collection.




<h1 id="html-link-interfaces-linkinterface">Interface Phalcon\Html\Link\Interfaces\LinkInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Interfaces/LinkInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces |

A readable link object.


## Métodos

```php
public function getAttributes(): array;
```
Devuelve una lista de atributos que describen la URI de destino.


```php
public function getHref(): string;
```
Devuelve el destino del enlace.

El enlace destino debe ser uno de:
- Una URI absoluta, definida en RFC 5988.
- Una URI relativa, definida en RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- Una plantilla de URI, definida en RFC 6570.

Si se devuelve una plantilla URI, isTemplated() DEBE devolver `True`.


```php
public function getRels(): array;
```
Devuelve el/los tipo/s de relación del enlace.

Este método devuelve 0 o más tipos de relación para un enlace, expresado como un vector de cadenas.


```php
public function isTemplated(): bool;
```
Returns whether this is a templated link.




<h1 id="html-link-interfaces-linkproviderinterface">Interface Phalcon\Html\Link\Interfaces\LinkProviderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Interfaces/LinkProviderInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces |

A link provider object.


## Métodos

```php
public function getLinks(): array;
```
Returns an array of LinkInterface objects.


```php
public function getLinksByRel( string $rel ): array;
```
Returns an array of LinkInterface objects that have a specific relationship.




<h1 id="html-link-link">Class Phalcon\Html\Link\Link</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Link.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Support\Collection, Phalcon\Support\Collection\CollectionInterface, Phalcon\Html\Link\Interfaces\LinkInterface | | Extends    | AbstractLink | | Implements | LinkInterface |

Class Phalcon\Http\Link\Link

@property array  attributes @property string href @property array  rels @property bool   templated


## Métodos

```php
public function getAttributes(): array;
```
Devuelve una lista de atributos que describen la URI de destino.


```php
public function getHref(): string;
```
Devuelve el destino del enlace.

El enlace destino debe ser uno de:
- Una URI absoluta, definida en RFC 5988.
- Una URI relativa, definida en RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- Una plantilla de URI, definida en RFC 6570.

Si se devuelve una plantilla URI, isTemplated() DEBE devolver `True`.


```php
public function getRels(): array;
```
Devuelve el/los tipo/s de relación del enlace.

Este método devuelve 0 o más tipos de relación para un enlace, expresado como un vector de cadenas.


```php
public function isTemplated(): bool;
```
Devuelve si este es un enlace de plantilla o no.




<h1 id="html-link-linkprovider">Class Phalcon\Html\Link\LinkProvider</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/LinkProvider.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\LinkInterface, Phalcon\Html\Link\Interfaces\LinkProviderInterface | | Extends    | AbstractLinkProvider | | Implements | LinkProviderInterface |

@property LinkInterface[] links


## Métodos

```php
public function getLinks(): array;
```
Devuelve un iterable de objetos LinkInterface.

El iterable puede ser un vector o cualquier objeto `\Traversable` de PHP. Si no hay enlaces disponibles, se DEBE devolver un vector vacío o `\Travesable`.


```php
public function getLinksByRel( mixed $rel ): array;
```
Devuelve un iterable de objetos `LinkInterface` que tienen una relación específica.

El iterable puede ser un vector o cualquier objeto `\Traversable` de PHP. Si no hay enlaces disponibles con esa relación, se DEBE devolver un vector vacío o `\Traversable`.




<h1 id="html-link-serializer-header">Class Phalcon\Html\Link\Serializer\Header</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Serializer/Header.zep)

| Namespace  | Phalcon\Html\Link\Serializer | | Implements | SerializerInterface |

Class Phalcon\Http\Link\Serializer\Header


## Métodos

```php
public function serialize( array $links ): string | null;
```
Serializa todos los enlaces pasados a una cabecera de enlace HTTP




<h1 id="html-link-serializer-serializerinterface">Interface Phalcon\Html\Link\Serializer\SerializerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Serializer/SerializerInterface.zep)

| Namespace  | Phalcon\Html\Link\Serializer |

Class Phalcon\Http\Link\Serializer\SerializerInterface


## Métodos

```php
public function serialize( array $links ): string | null;
```
Método serializador




<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/TagFactory.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Html\Escaper, Phalcon\Html\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory | | Extends    | AbstractFactory |

ServiceLocator implementation for Tag helpers.

Services are registered using the constructor using a key-value pair. The key is the name of the tag helper, while the value is a callable that returns the object.

The class implements `__call()` to allow calling helper objects as methods.

@property EscaperInterface $escaper @property array            $services

@method a(string $href, string $text, array $attributes = [], bool $raw = false): string @method base(string $href, array $attributes = []): string @method body(array $attributes = []): string @method button(string $text, array $attributes = [], bool $raw = false): string @method close(string $tag, bool $raw = false): string @method doctype(int $flag, string $delimiter): string @method element(string $tag, string $text, array $attributes = [], bool $raw = false): string @method form(array $attributes = []): string @method img(string $src, array $attributes = []): string @method inputCheckbox(string $name, string $value = null, array $attributes = []): string @method inputColor(string $name, string $value = null, array $attributes = []): string @method inputDate(string $name, string $value = null, array $attributes = []): string @method inputDateTime(string $name, string $value = null, array $attributes = []): string @method inputDateTimeLocal(string $name, string $value = null, array $attributes = []): string @method inputEmail(string $name, string $value = null, array $attributes = []): string @method inputFile(string $name, string $value = null, array $attributes = []): string @method inputHidden(string $name, string $value = null, array $attributes = []): string @method inputImage(string $name, string $value = null, array $attributes = []): string @method inputInput(string $name, string $value = null, array $attributes = []): string @method inputMonth(string $name, string $value = null, array $attributes = []): string @method inputNumeric(string $name, string $value = null, array $attributes = []): string @method inputPassword(string $name, string $value = null, array $attributes = []): string @method inputRadio(string $name, string $value = null, array $attributes = []): string @method inputRange(string $name, string $value = null, array $attributes = []): string @method inputSearch(string $name, string $value = null, array $attributes = []): string @method inputSelect(string $name, string $value = null, array $attributes = []): string @method inputSubmit(string $name, string $value = null, array $attributes = []): string @method inputTel(string $name, string $value = null, array $attributes = []): string @method inputText(string $name, string $value = null, array $attributes = []): string @method inputTextarea(string $name, string $value = null, array $attributes = []): string @method inputTime(string $name, string $value = null, array $attributes = []): string @method inputUrl(string $name, string $value = null, array $attributes = []): string @method inputWeek(string $name, string $value = null, array $attributes = []): string @method label(string $label, array $attributes = [], bool $raw = false): string @method link(string $indent = '    ', string $delimiter = PHP_EOL): string @method meta(string $indent = '    ', string $delimiter = PHP_EOL): string @method ol(string $text, array $attributes = [], bool $raw = false): string @method script(string $indent = '    ', string $delimiter = PHP_EOL): string @method style(string $indent = '    ', string $delimiter = PHP_EOL): string @method title(string $indent = '    ', string $delimiter = PHP_EOL): string @method ul(string $text, array $attributes = [], bool $raw = false): string


## Propiedades
```php
/**
 * @var EscaperInterface
 */
private escaper;

/**
 * @var array
 */
protected services;

```

## Métodos

```php
public function __call( string $name, array $arguments );
```
Magic call to make the helper objects available as methods.


```php
public function __construct( EscaperInterface $escaper, array $services = [] );
```
Constructor TagFactory.


```php
public function has( string $name ): bool;
```

```php
public function newInstance( string $name ): mixed;
```
Create a new instance of the object


```php
public function set( string $name, mixed $method ): void;
```

```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available services
