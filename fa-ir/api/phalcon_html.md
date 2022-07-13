---
layout: default
language: 'fa-ir'
version: '5.0'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Attributes.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Support\Collection, Phalcon\Html\Attributes\RenderInterface | | Extends    | Collection | | Implements | RenderInterface |

This class helps to work with HTML Attributes


## Methods

```php
public function __toString(): string;
```
Alias of the render method


```php
public function render(): string;
```
Render attributes as HTML attributes


```php
protected function renderAttributes( array $attributes ): string;
```
@todo remove this when we refactor forms. Maybe remove this class? Put it into traits




<h1 id="html-attributes-attributesinterface">Interface Phalcon\Html\Attributes\AttributesInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Attributes/AttributesInterface.zep)

| Namespace  | Phalcon\Html\Attributes | | Uses       | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\AttributesInterface
*
* Interface Phalcon\Html\Attributes\AttributesInterface */

## Methods

```php
public function getAttributes(): Attributes;
```
Get Attributes


```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```
Set Attributes




<h1 id="html-attributes-renderinterface">Interface Phalcon\Html\Attributes\RenderInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Attributes/RenderInterface.zep)

| Namespace  | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\RenderInterface
*
* Interface Phalcon\Html\Attributes\RenderInterface */

## Methods

```php
public function render(): string;
```
Generate a string represetation




<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Breadcrumbs.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Di\DiInterface |

Phalcon\Html\Breadcrumbs

This component offers an easy way to create breadcrumbs for your application. The resulting HTML when calling `render()` will have each breadcrumb enclosed in `<dt>` tags, while the whole string is enclosed in `<dl>` tags.


## Properties
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

## Methods

```php
public function add( string $label, string $link = string ): Breadcrumbs;
```
Adds a new crumb.

```php
// Adding a crumb with a link
$breadcrumbs->add("Home", "/");

// Adding a crumb without a link (normally the last one)
$breadcrumbs->add("Users");
```


```php
public function clear(): void;
```
Clears the crumbs

```php
$breadcrumbs->clear()
```


```php
public function getSeparator(): string
```

```php
public function remove( string $link ): void;
```
Removes crumb by url.

```php
$breadcrumbs->remove("/admin/user/create");

// remove a crumb without an url (last link)
$breadcrumbs->remove();
```


```php
public function render(): string;
```
Renders and outputs breadcrumbs based on previously set template.

```php
echo $breadcrumbs->render();
```


```php
public function setSeparator( string $separator )
```

```php
public function toArray(): array;
```
Returns the internal breadcrumbs array




<h1 id="html-escaper">Class Phalcon\Html\Escaper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Escaper.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Html\Escaper\EscaperInterface | | Implements | EscaperInterface |

Phalcon\Html\Escaper

Escapes different kinds of text securing them. By using this component you may prevent XSS attacks.

This component only works with UTF-8. The PREG extension needs to be compiled with UTF-8 support.

```php
$escaper = new \Phalcon\Html\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E
```


## Properties
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

## Methods

```php
public function attributes( string $input ): string;
```
Escapes a HTML attribute string


```php
public function css( string $input ): string;
```
Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal escaped representation


```php
final public function detectEncoding( string $input ): string | null;
```
Detect the character encoding of a string to be handled by an encoder. Special-handling for chr(172) and chr(128) to chr(159) which fail to be detected by mb_detect_encoding()


```php
public function escapeCss( string $input ): string;
```
Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal escaped representation


```php
public function escapeHtml( string $input = null ): string;
```
Escapes a HTML string. Internally uses htmlspecialchars


```php
public function escapeHtmlAttr( string $input = null ): string;
```
Escapes a HTML attribute string


```php
public function escapeJs( string $input ): string;
```
Escape JavaScript strings by replacing non-alphanumeric chars by their hexadecimal escaped representation


```php
public function escapeUrl( string $input ): string;
```
Escapes a URL. Internally uses rawurlencode


```php
public function getEncoding(): string
```

```php
public function getFlags(): int
```

```php
public function html( string $input = null ): string;
```
Escapes a HTML string. Internally uses htmlspecialchars


```php
public function js( string $input ): string;
```
Escape javascript strings by replacing non-alphanumeric chars by their hexadecimal escaped representation


```php
final public function normalizeEncoding( string $input ): string;
```
Utility to normalize a string's encoding to UTF-32.


```php
public function setDoubleEncode( bool $doubleEncode ): Escaper;
```
Sets the double_encode to be used by the escaper

```php
$escaper->setDoubleEncode(false);
```


```php
public function setEncoding( string $encoding ): EscaperInterface;
```
Sets the encoding to be used by the escaper

```php
$escaper->setEncoding("utf-8");
```


```php
public function setFlags( int $flags ): EscaperInterface;
```
Sets the HTML quoting type for htmlspecialchars

```php
$escaper->setFlags(ENT_XHTML);
```


```php
public function setHtmlQuoteType( int $flags ): EscaperInterface;
```
Sets the HTML quoting type for htmlspecialchars

```php
$escaper->setHtmlQuoteType(ENT_XHTML);
```


```php
public function url( string $input ): string;
```
Escapes a URL. Internally uses rawurlencode




<h1 id="html-escaper-escaperinterface">Interface Phalcon\Html\Escaper\EscaperInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Escaper/EscaperInterface.zep)

| Namespace  | Phalcon\Html\Escaper |

Interface for Phalcon\Html\Escaper


## Methods

```php
public function attributes( string $input ): string;
```
Escapes a HTML attribute string


```php
public function css( string $input ): string;
```
Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal representation


```php
public function getEncoding(): string;
```
Returns the internal encoding used by the escaper


```php
public function html( string $input ): string;
```
Escapes a HTML string


```php
public function js( string $input ): string;
```
Escape Javascript strings by replacing non-alphanumeric chars by their hexadecimal representation


```php
public function setEncoding( string $encoding ): EscaperInterface;
```
Sets the encoding to be used by the escaper


```php
public function setFlags( int $flags ): EscaperInterface;
```
Sets the HTML quoting type for htmlspecialchars


```php
public function url( string $input ): string;
```
Escapes a URL. Internally uses rawurlencode




<h1 id="html-escaper-exception">Class Phalcon\Html\Escaper\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Escaper/Exception.zep)

| Namespace  | Phalcon\Html\Escaper | | Extends    | \Exception |

Exceptions thrown in Phalcon\Html\Escaper will use this class



<h1 id="html-escaperfactory">Class Phalcon\Html\EscaperFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/EscaperFactory.zep)

| Namespace  | Phalcon\Html |

Class EscaperFactory


## Methods

```php
public function newInstance(): Escaper;
```
Create a new instance of the object




<h1 id="html-exception">Class Phalcon\Html\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Exception.zep)

| Namespace  | Phalcon\Html | | Extends    | \Exception |

Phalcon\Html\Tag\Exception

Exceptions thrown in Phalcon\Html\Tag will use this class



<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/AbstractHelper.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Escaper\EscaperInterface, Phalcon\Html\Exception |

@property string           $delimiter @property EscaperInterface $escaper @property string           $indent @property int              $indentLevel


## Properties
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

## Methods

```php
public function __construct( EscaperInterface $escaper );
```
AbstractHelper constructor.


```php
protected function close( string $tag, bool $raw = bool ): string;
```
Produces a closing tag


```php
protected function indent(): string;
```
Replicates the indent x times as per indentLevel


```php
protected function orderAttributes( array $overrides, array $attributes ): array;
```
Keeps all the attributes sorted - same order all the tome


```php
protected function renderArrayElements( array $elements, string $delimiter ): string;
```
Traverses an array and calls the method defined in the first element with attributes as the second, returning the resulting string


```php
protected function renderAttributes( array $attributes ): string;
```
Renders all the attributes


```php
protected function renderElement( string $tag, array $attributes = [] ): string;
```
Renders an element


```php
protected function renderFullElement( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
```
Renders an element


```php
protected function renderTag( string $tag, array $attributes = [], string $close = string ): string;
```
Renders a tag


```php
protected function selfClose( string $tag, array $attributes = [] ): string;
```
Produces a self close tag i.e. <img />




<h1 id="html-helper-abstractlist">Abstract Class Phalcon\Html\Helper\AbstractList</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/AbstractList.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class AbstractList


## Properties
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

## Methods

```php
public function __invoke( string $indent = string, string $delimiter = null, array $attributes = [] ): AbstractList;
```

```php
public function __toString();
```
Generates and returns the HTML for the list.


```php
abstract protected function getTag(): string;
```
Returns the tag name.




<h1 id="html-helper-abstractseries">Abstract Class Phalcon\Html\Helper\AbstractSeries</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/AbstractSeries.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | AbstractHelper |

@property array $attributes @property array $store


## Properties
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

## Methods

```php
public function __invoke( string $indent = string, string $delimiter = null ): AbstractSeries;
```

```php
public function __toString();
```
Generates and returns the HTML for the list.


```php
abstract protected function getTag(): string;
```
Returns the tag name.




<h1 id="html-helper-anchor">Class Phalcon\Html\Helper\Anchor</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Anchor.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Anchor


## Methods

```php
public function __invoke( string $href, string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce a <a> tag


```php
protected function processAttributes( string $href, array $attributes ): array;
```





<h1 id="html-helper-base">Class Phalcon\Html\Helper\Base</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Base.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Base


## Methods

```php
public function __invoke( string $href = null, array $attributes = [] ): string;
```
Produce a `<base/>` tag.




<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Body.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Body


## Methods

```php
public function __invoke( array $attributes = [] ): string;
```
Produce a `<body>` tag.




<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Button.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Button


## Methods

```php
public function __invoke( string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce a `<button>` tag.




<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Close.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | AbstractHelper |

Class Close


## Methods

```php
public function __invoke( string $tag, bool $raw = bool ): string;
```
Produce a `</...>` tag.




<h1 id="html-helper-doctype">Class Phalcon\Html\Helper\Doctype</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Doctype.zep)

| Namespace  | Phalcon\Html\Helper |

Creates Doctype tags


## Constants
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

## Properties
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

## Methods

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Element.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Element


## Methods

```php
public function __invoke( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce a tag.




<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Form.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Form


## Methods

```php
public function __invoke( array $attributes = [] ): string;
```
Produce a `<form>` tag.




<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Img.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Img


## Methods

```php
public function __invoke( string $src, array $attributes = [] ): string;
```
Produce a <img /> tag.




<h1 id="html-helper-input-abstractinput">Abstract Class Phalcon\Html\Helper\Input\AbstractInput</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/AbstractInput.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Helper\AbstractHelper | | Extends    | AbstractHelper |

Class AbstractInput

@property array  $attributes @property string $type @property string $value


## Properties
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

## Methods

```php
public function __invoke( string $name, string $value = null, array $attributes = [] ): AbstractInput;
```

```php
public function __toString();
```
Returns the HTML for the input.


```php
public function setValue( string $value = null ): AbstractInput;
```
Sets the value of the element




<h1 id="html-helper-input-checkbox">Class Phalcon\Html\Helper\Input\Checkbox</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Checkbox.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Escaper\EscaperInterface | | Extends    | AbstractInput |

Class Checkbox

@property array $label


## Properties
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

## Methods

```php
public function __construct( EscaperInterface $escaper );
```
AbstractHelper constructor.


```php
public function __toString();
```
Returns the HTML for the input.


```php
public function label( array $attributes = [] ): Checkbox;
```
Attaches a label to the element




<h1 id="html-helper-input-color">Class Phalcon\Html\Helper\Input\Color</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Color.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Color


## Properties
```php
//
protected type = color;

```


<h1 id="html-helper-input-date">Class Phalcon\Html\Helper\Input\Date</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Date.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Date


## Properties
```php
//
protected type = date;

```


<h1 id="html-helper-input-datetime">Class Phalcon\Html\Helper\Input\DateTime</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/DateTime.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class DateTime


## Properties
```php
//
protected type = datetime;

```


<h1 id="html-helper-input-datetimelocal">Class Phalcon\Html\Helper\Input\DateTimeLocal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/DateTimeLocal.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class DateTimeLocal


## Properties
```php
//
protected type = datetime-local;

```


<h1 id="html-helper-input-email">Class Phalcon\Html\Helper\Input\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Email.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Email


## Properties
```php
//
protected type = email;

```


<h1 id="html-helper-input-file">Class Phalcon\Html\Helper\Input\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/File.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class File


## Properties
```php
//
protected type = file;

```


<h1 id="html-helper-input-hidden">Class Phalcon\Html\Helper\Input\Hidden</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Hidden.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Hidden


## Properties
```php
//
protected type = hidden;

```


<h1 id="html-helper-input-image">Class Phalcon\Html\Helper\Input\Image</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Image.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Image


## Properties
```php
//
protected type = image;

```


<h1 id="html-helper-input-input">Class Phalcon\Html\Helper\Input\Input</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Input.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Input


## Methods

```php
public function setType( string $type ): AbstractInput;
```
Sets the type of the input




<h1 id="html-helper-input-month">Class Phalcon\Html\Helper\Input\Month</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Month.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Month


## Properties
```php
//
protected type = month;

```


<h1 id="html-helper-input-numeric">Class Phalcon\Html\Helper\Input\Numeric</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Numeric.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Numeric


## Properties
```php
//
protected type = number;

```


<h1 id="html-helper-input-password">Class Phalcon\Html\Helper\Input\Password</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Password.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Password


## Properties
```php
//
protected type = password;

```


<h1 id="html-helper-input-radio">Class Phalcon\Html\Helper\Input\Radio</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Radio.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | Checkbox |

Class Radio


## Properties
```php
/**
 * @var string
 */
protected type = radio;

```


<h1 id="html-helper-input-range">Class Phalcon\Html\Helper\Input\Range</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Range.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Range


## Properties
```php
//
protected type = range;

```


<h1 id="html-helper-input-search">Class Phalcon\Html\Helper\Input\Search</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Search.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Search


## Properties
```php
//
protected type = search;

```


<h1 id="html-helper-input-select">Class Phalcon\Html\Helper\Input\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Select.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Helper\AbstractList | | Extends    | AbstractList |

Class Select

@property string $elementTag @property bool   $inOptGroup @property string $selected


## Properties
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

## Methods

```php
public function add( string $text, string $value = null, array $attributes = [], bool $raw = bool ): Select;
```
Add an element to the list


```php
public function addPlaceholder( string $text, mixed $value = null, array $attributes = [], bool $raw = bool ): Select;
```
Add a placeholder to the element


```php
public function optGroup( string $label = null, array $attributes = [] ): Select;
```
Creates an option group


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Submit.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Submit


## Properties
```php
//
protected type = submit;

```


<h1 id="html-helper-input-tel">Class Phalcon\Html\Helper\Input\Tel</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Tel.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Tel


## Properties
```php
//
protected type = tel;

```


<h1 id="html-helper-input-text">Class Phalcon\Html\Helper\Input\Text</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Text.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Text



<h1 id="html-helper-input-textarea">Class Phalcon\Html\Helper\Input\Textarea</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Textarea.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractInput |

Class Textarea


## Properties
```php
/**
 * @var string
 */
protected type = textarea;

```

## Methods

```php
public function __toString();
```
Returns the HTML for the input.




<h1 id="html-helper-input-time">Class Phalcon\Html\Helper\Input\Time</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Time.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Time


## Properties
```php
//
protected type = time;

```


<h1 id="html-helper-input-url">Class Phalcon\Html\Helper\Input\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Url.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Url


## Properties
```php
//
protected type = url;

```


<h1 id="html-helper-input-week">Class Phalcon\Html\Helper\Input\Week</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Input/Week.zep)

| Namespace  | Phalcon\Html\Helper\Input | | Extends    | AbstractInput |

Class Week


## Properties
```php
//
protected type = week;

```


<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Label.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Label


## Methods

```php
public function __invoke( string $label, array $attributes = [], bool $raw = bool ): string;
```
Produce a `<label>` tag.




<h1 id="html-helper-link">Class Phalcon\Html\Helper\Link</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Link.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | Style |

Creates <link> tags


## Methods

```php
public function add( string $url, array $attributes = [] );
```
Add an element to the list


```php
protected function getAttributes( string $url, array $attributes ): array;
```
Returns the necessary attributes


```php
protected function getTag(): string;
```





<h1 id="html-helper-meta">Class Phalcon\Html\Helper\Meta</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Meta.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractSeries |

Class Meta


## Methods

```php
public function add( array $attributes = [] ): Meta;
```
Add an element to the list


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Ol.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | AbstractList |

Class Ol


## Methods

```php
public function add( string $text, array $attributes = [], bool $raw = bool ): AbstractList;
```
Add an element to the list


```php
protected function getTag(): string;
```





<h1 id="html-helper-script">Class Phalcon\Html\Helper\Script</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Script.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractSeries |

Class Script


## Methods

```php
public function add( string $url, array $attributes = [] );
```
Add an element to the list


```php
protected function getAttributes( string $url, array $attributes ): array;
```
Returns the necessary attributes


```php
protected function getTag(): string;
```





<h1 id="html-helper-style">Class Phalcon\Html\Helper\Style</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Style.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractSeries |

Class Style


## Properties
```php
/**
 * @var bool
 */
private isStyle = false;

```

## Methods

```php
public function add( string $url, array $attributes = [] );
```
Add an element to the list


```php
public function setStyle( bool $flag ): Style;
```
Sets if this is a style or link tag


```php
protected function getAttributes( string $url, array $attributes ): array;
```
Returns the necessary attributes


```php
protected function getTag(): string;
```





<h1 id="html-helper-title">Class Phalcon\Html\Helper\Title</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Title.zep)

| Namespace  | Phalcon\Html\Helper | | Uses       | Phalcon\Html\Exception | | Extends    | AbstractHelper |

Class Title

@property array  $append @property string $delimiter @property string $indent @property array  $prepend @property string $title @property string $separator


## Properties
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

## Methods

```php
public function __invoke( string $indent = "    ", string $delimiter = null ): Title;
```
Sets the separator and returns the object back


```php
public function __toString();
```
Returns the title tags


```php
public function append( string $text, bool $raw = bool ): Title;
```
Appends text to current document title


```php
public function get(): string;
```
Returns the title


```php
public function prepend( string $text, bool $raw = bool ): Title;
```
Prepends text to current document title


```php
public function set( string $text, bool $raw = bool ): Title;
```
Sets the title


```php
public function setSeparator( string $separator, bool $raw = bool ): Title;
```
Sets the separator




<h1 id="html-helper-ul">Class Phalcon\Html\Helper\Ul</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Helper/Ul.zep)

| Namespace  | Phalcon\Html\Helper | | Extends    | Ol |

Class Ul


## Methods

```php
protected function getTag(): string;
```





<h1 id="html-link-abstractlink">Abstract Class Phalcon\Html\Link\AbstractLink</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/AbstractLink.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Support\Collection |

@property array  $attributes @property string $href @property array  $rels @property bool   $templated


## Properties
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

## Methods

```php
public function __construct( string $rel = string, string $href = string, array $attributes = [] );
```
Link constructor.


```php
protected function doGetAttributes(): array;
```
Returns a list of attributes that describe the target URI.


```php
protected function doGetHref(): string;
```
Returns the target of the link.

The target link must be one of:
- An absolute URI, as defined by RFC 5988.
- A relative URI, as defined by RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- A URI template as defined by RFC 6570.

If a URI template is returned, isTemplated() MUST return True.


```php
protected function doGetRels(): array;
```
Returns the relationship type(s) of the link.

This method returns 0 or more relationship types for a link, expressed as an array of strings.


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
Determines if a href is a templated link or not.

@see https://tools.ietf.org/html/rfc6570




<h1 id="html-link-abstractlinkprovider">Abstract Class Phalcon\Html\Link\AbstractLinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/AbstractLinkProvider.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\LinkInterface |

@property array $links


## Properties
```php
/**
 * @var array
 */
protected links;

```

## Methods

```php
public function __construct( array $links = [] );
```
LinkProvider constructor.


```php
protected function doGetLinks(): array;
```
Returns an iterable of LinkInterface objects.

The iterable may be an array or any PHP \Traversable object. If no links are available, an empty array or \Traversable MUST be returned.


```php
protected function doGetLinksByRel( string $rel ): array;
```
Returns an iterable of LinkInterface objects that have a specific relationship.

The iterable may be an array or any PHP \Traversable object. If no links with that relationship are available, an empty array or \Traversable MUST be returned.


```php
protected function doWithLink( mixed $link );
```
Returns an instance with the specified link included.

If the specified link is already present, this method MUST return normally without errors. The link is present if $link is === identical to a link object already in the collection.


```php
protected function doWithoutLink( mixed $link );
```
Returns an instance with the specified link removed.

If the specified link is not present, this method MUST return normally without errors. The link is present if $link is === identical to a link object already in the collection.


```php
protected function getKey( mixed $link ): string;
```
Returns the object hash key




<h1 id="html-link-evolvablelink">Class Phalcon\Html\Link\EvolvableLink</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/EvolvableLink.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\EvolvableLinkInterface | | Extends    | Link | | Implements | EvolvableLinkInterface |

Class Phalcon\Http\Link\EvolvableLink

@property array  attributes @property string href @property array  rels @property bool   templated


## Methods

```php
public function withAttribute( mixed $attribute, mixed $value ): EvolvableLinkInterface;
```
Returns an instance with the specified attribute added.

If the specified attribute is already present, it will be overwritten with the new value.


```php
public function withHref( string $href ): EvolvableLinkInterface;
```
Returns an instance with the specified href.


```php
public function withRel( string $rel ): EvolvableLinkInterface;
```
Returns an instance with the specified relationship included.

If the specified rel is already present, this method MUST return normally without errors, but without adding the rel a second time.


```php
public function withoutAttribute( string $attribute ): EvolvableLinkInterface;
```
Returns an instance with the specified attribute excluded.

If the specified attribute is not present, this method MUST return normally without errors.


```php
public function withoutRel( string $rel ): EvolvableLinkInterface;
```
Returns an instance with the specified relationship excluded.

If the specified rel is not present, this method MUST return normally without errors.




<h1 id="html-link-evolvablelinkprovider">Class Phalcon\Html\Link\EvolvableLinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/EvolvableLinkProvider.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\EvolvableLinkProviderInterface, Phalcon\Html\Link\Interfaces\LinkInterface | | Extends    | LinkProvider | | Implements | EvolvableLinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links


## Methods

```php
public function withLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Returns an instance with the specified link included.

If the specified link is already present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.


```php
public function withoutLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Returns an instance with the specified link removed.

If the specified link is not present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.




<h1 id="html-link-interfaces-evolvablelinkinterface">Interface Phalcon\Html\Link\Interfaces\EvolvableLinkInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Interfaces/EvolvableLinkInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces | | Extends    | LinkInterface |

An evolvable link value object.


## Methods

```php
public function withAttribute( string $attribute, string $value ): EvolvableLinkInterface;
```
Returns an instance with the specified attribute added.

If the specified attribute is already present, it will be overwritten with the new value.


```php
public function withHref( string $href ): EvolvableLinkInterface;
```
Returns an instance with the specified href.


```php
public function withRel( string $rel ): EvolvableLinkInterface;
```
Returns an instance with the specified relationship included.

If the specified rel is already present, this method MUST return normally without errors, but without adding the rel a second time.


```php
public function withoutAttribute( string $attribute ): EvolvableLinkInterface;
```
Returns an instance with the specified attribute excluded.

If the specified attribute is not present, this method MUST return normally without errors.


```php
public function withoutRel( string $rel ): EvolvableLinkInterface;
```
Returns an instance with the specified relationship excluded.

If the specified rel is already not present, this method MUST return normally without errors.




<h1 id="html-link-interfaces-evolvablelinkproviderinterface">Interface Phalcon\Html\Link\Interfaces\EvolvableLinkProviderInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Interfaces/EvolvableLinkProviderInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces | | Extends    | LinkProviderInterface |

An evolvable link provider value object.


## Methods

```php
public function withLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Returns an instance with the specified link included.

If the specified link is already present, this method MUST return normally without errors. The link is present if $link is === identical to a link object already in the collection.


```php
public function withoutLink( LinkInterface $link ): EvolvableLinkProviderInterface;
```
Returns an instance with the specifed link removed.

If the specified link is not present, this method MUST return normally without errors. The link is present if $link is === identical to a link object already in the collection.




<h1 id="html-link-interfaces-linkinterface">Interface Phalcon\Html\Link\Interfaces\LinkInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Interfaces/LinkInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces |

A readable link object.


## Methods

```php
public function getAttributes(): array;
```
Returns a list of attributes that describe the target URI.


```php
public function getHref(): string;
```
Returns the target of the link.

The target link must be one of:
- An absolute URI, as defined by RFC 5988.
- A relative URI, as defined by RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- A URI template as defined by RFC 6570.

If a URI template is returned, isTemplated() MUST return True.


```php
public function getRels(): array;
```
Returns the relationship type(s) of the link.

This method returns 0 or more relationship types for a link, expressed as an array of strings.


```php
public function isTemplated(): bool;
```
Returns whether this is a templated link.




<h1 id="html-link-interfaces-linkproviderinterface">Interface Phalcon\Html\Link\Interfaces\LinkProviderInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Interfaces/LinkProviderInterface.zep)

| Namespace  | Phalcon\Html\Link\Interfaces |

A link provider object.


## Methods

```php
public function getLinks(): array;
```
Returns an array of LinkInterface objects.


```php
public function getLinksByRel( string $rel ): array;
```
Returns an array of LinkInterface objects that have a specific relationship.




<h1 id="html-link-link">Class Phalcon\Html\Link\Link</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Link.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Support\Collection, Phalcon\Support\Collection\CollectionInterface, Phalcon\Html\Link\Interfaces\LinkInterface | | Extends    | AbstractLink | | Implements | LinkInterface |

Class Phalcon\Http\Link\Link

@property array  attributes @property string href @property array  rels @property bool   templated


## Methods

```php
public function getAttributes(): array;
```
Returns a list of attributes that describe the target URI.


```php
public function getHref(): string;
```
Returns the target of the link.

The target link must be one of:
- An absolute URI, as defined by RFC 5988.
- A relative URI, as defined by RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- A URI template as defined by RFC 6570.

If a URI template is returned, isTemplated() MUST return True.


```php
public function getRels(): array;
```
Returns the relationship type(s) of the link.

This method returns 0 or more relationship types for a link, expressed as an array of strings.


```php
public function isTemplated(): bool;
```
Returns whether or not this is a templated link.




<h1 id="html-link-linkprovider">Class Phalcon\Html\Link\LinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/LinkProvider.zep)

| Namespace  | Phalcon\Html\Link | | Uses       | Phalcon\Html\Link\Interfaces\LinkInterface, Phalcon\Html\Link\Interfaces\LinkProviderInterface | | Extends    | AbstractLinkProvider | | Implements | LinkProviderInterface |

@property LinkInterface[] links


## Methods

```php
public function getLinks(): array;
```
Returns an iterable of LinkInterface objects.

The iterable may be an array or any PHP \Traversable object. If no links are available, an empty array or \Traversable MUST be returned.


```php
public function getLinksByRel( mixed $rel ): array;
```
Returns an iterable of LinkInterface objects that have a specific relationship.

The iterable may be an array or any PHP \Traversable object. If no links with that relationship are available, an empty array or \Traversable MUST be returned.




<h1 id="html-link-serializer-header">Class Phalcon\Html\Link\Serializer\Header</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Serializer/Header.zep)

| Namespace  | Phalcon\Html\Link\Serializer | | Implements | SerializerInterface |

Class Phalcon\Http\Link\Serializer\Header


## Methods

```php
public function serialize( array $links ): string | null;
```
Serializes all the passed links to a HTTP link header




<h1 id="html-link-serializer-serializerinterface">Interface Phalcon\Html\Link\Serializer\SerializerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/Link/Serializer/SerializerInterface.zep)

| Namespace  | Phalcon\Html\Link\Serializer |

Class Phalcon\Http\Link\Serializer\SerializerInterface


## Methods

```php
public function serialize( array $links ): string | null;
```
Serializer method




<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Html/TagFactory.zep)

| Namespace  | Phalcon\Html | | Uses       | Phalcon\Html\Escaper, Phalcon\Html\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory | | Extends    | AbstractFactory |

ServiceLocator implementation for Tag helpers.

Services are registered using the constructor using a key-value pair. The key is the name of the tag helper, while the value is a callable that returns the object.

The class implements `__call()` to allow calling helper objects as methods.

@property EscaperInterface $escaper @property array            $services

@method a(string $href, string $text, array $attributes = [], bool $raw = false): string @method base(string $href, array $attributes = []): string @method body(array $attributes = []): string @method button(string $text, array $attributes = [], bool $raw = false): string @method close(string $tag, bool $raw = false): string @method doctype(int $flag, string $delimiter): string @method element(string $tag, string $text, array $attributes = [], bool $raw = false): string @method form(array $attributes = []): string @method img(string $src, array $attributes = []): string @method inputCheckbox(string $name, string $value = null, array $attributes = []): string @method inputColor(string $name, string $value = null, array $attributes = []): string @method inputDate(string $name, string $value = null, array $attributes = []): string @method inputDateTime(string $name, string $value = null, array $attributes = []): string @method inputDateTimeLocal(string $name, string $value = null, array $attributes = []): string @method inputEmail(string $name, string $value = null, array $attributes = []): string @method inputFile(string $name, string $value = null, array $attributes = []): string @method inputHidden(string $name, string $value = null, array $attributes = []): string @method inputImage(string $name, string $value = null, array $attributes = []): string @method inputInput(string $name, string $value = null, array $attributes = []): string @method inputMonth(string $name, string $value = null, array $attributes = []): string @method inputNumeric(string $name, string $value = null, array $attributes = []): string @method inputPassword(string $name, string $value = null, array $attributes = []): string @method inputRadio(string $name, string $value = null, array $attributes = []): string @method inputRange(string $name, string $value = null, array $attributes = []): string @method inputSearch(string $name, string $value = null, array $attributes = []): string @method inputSelect(string $name, string $value = null, array $attributes = []): string @method inputSubmit(string $name, string $value = null, array $attributes = []): string @method inputTel(string $name, string $value = null, array $attributes = []): string @method inputText(string $name, string $value = null, array $attributes = []): string @method inputTextarea(string $name, string $value = null, array $attributes = []): string @method inputTime(string $name, string $value = null, array $attributes = []): string @method inputUrl(string $name, string $value = null, array $attributes = []): string @method inputWeek(string $name, string $value = null, array $attributes = []): string @method label(string $label, array $attributes = [], bool $raw = false): string @method link(string $indent = '    ', string $delimiter = PHP_EOL): string @method meta(string $indent = '    ', string $delimiter = PHP_EOL): string @method ol(string $text, array $attributes = [], bool $raw = false): string @method script(string $indent = '    ', string $delimiter = PHP_EOL): string @method style(string $indent = '    ', string $delimiter = PHP_EOL): string @method title(string $indent = '    ', string $delimiter = PHP_EOL): string @method ul(string $text, array $attributes = [], bool $raw = false): string


## Properties
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

## Methods

```php
public function __call( string $name, array $arguments );
```
Magic call to make the helper objects available as methods.


```php
public function __construct( EscaperInterface $escaper, array $services = [] );
```
TagFactory constructor.


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


