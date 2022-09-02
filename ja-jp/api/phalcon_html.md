---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Html'
---

- [Phalcon\Html\Attributes](#html-attributes)
- [Phalcon\Html\Attributes\AttributesInterface](#html-attributes-attributesinterface)
- [Phalcon\Html\Attributes\RenderInterface](#html-attributes-renderinterface)
- [Phalcon\Html\Breadcrumbs](#html-breadcrumbs)
- [Phalcon\Html\Exception](#html-exception)
- [Phalcon\Html\Helper\AbstractHelper](#html-helper-abstracthelper)
- [Phalcon\Html\Helper\AbstractList](#html-helper-abstractlist)
- [Phalcon\Html\Helper\AbstractSeries](#html-helper-abstractseries)
- [Phalcon\Html\Helper\Anchor](#html-helper-anchor)
- [Phalcon\Html\Helper\Base](#html-helper-base)
- [Phalcon\Html\Helper\Body](#html-helper-body)
- [Phalcon\Html\Helper\Button](#html-helper-button)
- [Phalcon\Html\Helper\Close](#html-helper-close)
- [Phalcon\Html\Helper\Element](#html-helper-element)
- [Phalcon\Html\Helper\Form](#html-helper-form)
- [Phalcon\Html\Helper\Img](#html-helper-img)
- [Phalcon\Html\Helper\Input\AbstractInput](#html-helper-input-abstractinput)
- [Phalcon\Html\Helper\Input\Checkbox](#html-helper-input-checkbox)
- [Phalcon\Html\Helper\Input\Color](#html-helper-input-color)
- [Phalcon\Html\Helper\Input\Date](#html-helper-input-date)
- [Phalcon\Html\Helper\Input\DateTime](#html-helper-input-datetime)
- [Phalcon\Html\Helper\Input\DateTimeLocal](#html-helper-input-datetimelocal)
- [Phalcon\Html\Helper\Input\Email](#html-helper-input-email)
- [Phalcon\Html\Helper\Input\File](#html-helper-input-file)
- [Phalcon\Html\Helper\Input\Hidden](#html-helper-input-hidden)
- [Phalcon\Html\Helper\Input\Image](#html-helper-input-image)
- [Phalcon\Html\Helper\Input\Input](#html-helper-input-input)
- [Phalcon\Html\Helper\Input\Month](#html-helper-input-month)
- [Phalcon\Html\Helper\Input\Numeric](#html-helper-input-numeric)
- [Phalcon\Html\Helper\Input\Password](#html-helper-input-password)
- [Phalcon\Html\Helper\Input\Radio](#html-helper-input-radio)
- [Phalcon\Html\Helper\Input\Range](#html-helper-input-range)
- [Phalcon\Html\Helper\Input\Search](#html-helper-input-search)
- [Phalcon\Html\Helper\Input\Select](#html-helper-input-select)
- [Phalcon\Html\Helper\Input\Submit](#html-helper-input-submit)
- [Phalcon\Html\Helper\Input\Tel](#html-helper-input-tel)
- [Phalcon\Html\Helper\Input\Text](#html-helper-input-text)
- [Phalcon\Html\Helper\Input\Textarea](#html-helper-input-textarea)
- [Phalcon\Html\Helper\Input\Time](#html-helper-input-time)
- [Phalcon\Html\Helper\Input\Url](#html-helper-input-url)
- [Phalcon\Html\Helper\Input\Week](#html-helper-input-week)
- [Phalcon\Html\Helper\Label](#html-helper-label)
- [Phalcon\Html\Helper\Link](#html-helper-link)
- [Phalcon\Html\Helper\Meta](#html-helper-meta)
- [Phalcon\Html\Helper\Ol](#html-helper-ol)
- [Phalcon\Html\Helper\Script](#html-helper-script)
- [Phalcon\Html\Helper\Style](#html-helper-style)
- [Phalcon\Html\Helper\Title](#html-helper-title)
- [Phalcon\Html\Helper\Ul](#html-helper-ul)
- [Phalcon\Html\Link\EvolvableLink](#html-link-evolvablelink)
- [Phalcon\Html\Link\EvolvableLinkProvider](#html-link-evolvablelinkprovider)
- [Phalcon\Html\Link\Link](#html-link-link)
- [Phalcon\Html\Link\LinkProvider](#html-link-linkprovider)
- [Phalcon\Html\Link\Serializer\Header](#html-link-serializer-header)
- [Phalcon\Html\Link\Serializer\SerializerInterface](#html-link-serializer-serializerinterface)
- [Phalcon\Html\TagFactory](#html-tagfactory)

<h1 id="html-attributes">Class Phalcon\Html\Attributes</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Collection, Phalcon\Html\Attributes\RenderInterface, Phalcon\Tag | | Extends | Collection | | Implements | RenderInterface |

This class helps to work with HTML Attributes

## メソッド

```php
public function __toString(): string;
```

Alias of the render method

```php
public function render(): string;
```

Render attributes as HTML attributes

<h1 id="html-attributes-attributesinterface">Interface Phalcon\Html\Attributes\AttributesInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes/AttributesInterface.zep)

| Namespace | Phalcon\Html\Attributes | | Uses | Phalcon\Html\Attributes |

- Phalcon\Html\Attributes\AttributesInterface
- 
- Interface Phalcon\Html\Attributes\AttributesInterface */

## メソッド

```php
public function getAttributes(): Attributes;
```

Get Attributes

```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```

Set Attributes

<h1 id="html-attributes-renderinterface">Interface Phalcon\Html\Attributes\RenderInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes/RenderInterface.zep)

| Namespace | Phalcon\Html\Attributes |

- Phalcon\Html\Attributes\RenderInterface
- 
- Interface Phalcon\Html\Attributes\RenderInterface */

## メソッド

```php
public function render(): string;
```

Generate a string represetation

<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Breadcrumbs.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Di\DiInterface |

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

## メソッド

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

<h1 id="html-exception">Class Phalcon\Html\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Exception.zep)

| Namespace | Phalcon\Html | | Extends | \Phalcon\Exception |

Phalcon\Html\Tag\Exception

Exceptions thrown in Phalcon\Html\Tag will use this class

<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractHelper.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Escaper\EscaperInterface, Phalcon\Html\Exception |

Class AbstractHelper

@property string $delimiter @property Escaper $escaper @property string $indent @property int $indentLevel

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

## メソッド

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

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractList.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

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

## メソッド

```php
public function __invoke( string $indent = null, string $delimiter = null, array $attributes = [] ): AbstractList;
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

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractSeries.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Class AbstractSeries

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

## メソッド

```php
public function __invoke( string $indent = null, string $delimiter = null ): AbstractSeries;
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

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Anchor.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Class Anchor

## メソッド

```php
public function __invoke( string $href, string $text, array $attributes = [], bool $raw = bool ): string;
```

Produce a <a> tag</p> 

<pre><code class="php">protected function processAttributes( string $href, array $attributes ): array;
</code></pre>

<h1 id="html-helper-base">Class Phalcon\Html\Helper\Base</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Base.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Base
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $href = null, array $attributes = [] ): string;
</code></pre>

<p>
  Produce a <code>&lt;base/&gt;</code> tag.
</p>

<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Body.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Body
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( array $attributes = [] ): string;
</code></pre>

<p>
  Produce a <code>&lt;body&gt;</code> tag.
</p>

<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Button.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Button
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $text, array $attributes = [], bool $raw = bool ): string;
</code></pre>

<p>
  Produce a <code>&lt;button&gt;</code> tag.
</p>

<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Close.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |
</p>

<p>
  Class Close
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $tag, bool $raw = bool ): string;
</code></pre>

<p>
  Produce a <code>&lt;/...&gt;</code> tag.
</p>

<h1 id="html-helper-element">Class Phalcon\Html\Helper\Element</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Element.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Element
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
</code></pre>

<p>
  Produce a tag.
</p>

<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Form.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Form
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( array $attributes = [] ): string;
</code></pre>

<p>
  Produce a <code>&lt;form&gt;</code> tag.
</p>

<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Img.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Img
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $src, array $attributes = [] ): string;
</code></pre>

<p>
  Produce a <img /> tag.
</p>

<h1 id="html-helper-input-abstractinput">Abstract Class Phalcon\Html\Helper\Input\AbstractInput</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/AbstractInput.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |
</p>

<p>
  Class AbstractInput
</p>

<p>
  @property array $attributes @property string $type @property string $value
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var string
 */
protected type = text;

/**
 * @var array
 */
protected attributes;

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $name, string $value = null, array $attributes = [] ): AbstractInput;
</code></pre>

<pre><code class="php">public function __toString();
</code></pre>

<p>
  Returns the HTML for the input.
</p>

<pre><code class="php">public function setValue( string $value = null ): AbstractInput;
</code></pre>

<p>
  Sets the value of the element
</p>

<h1 id="html-helper-input-checkbox">Class Phalcon\Html\Helper\Input\Checkbox</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Checkbox.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Uses | Phalcon\Escaper\EscaperInterface, Phalcon\Helper\Arr | | Extends | AbstractInput |
</p>

<p>
  Class Checkbox
</p>

<p>
  @property array $label
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var array
 */
protected label;

/**
 * @var string
 */
protected type = checkbox;

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __construct( EscaperInterface $escaper );
</code></pre>

<p>
  AbstractHelper constructor.
</p>

<pre><code class="php">public function __toString();
</code></pre>

<p>
  Returns the HTML for the input.
</p>

<pre><code class="php">public function label( array $attributes = [] ): Checkbox;
</code></pre>

<p>
  Attaches a label to the element
</p>

<h1 id="html-helper-input-color">Class Phalcon\Html\Helper\Input\Color</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Color.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Color
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = color;

</code></pre>

<h1 id="html-helper-input-date">Class Phalcon\Html\Helper\Input\Date</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Date.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Date
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = date;

</code></pre>

<h1 id="html-helper-input-datetime">Class Phalcon\Html\Helper\Input\DateTime</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/DateTime.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class DateTime
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = datetime;

</code></pre>

<h1 id="html-helper-input-datetimelocal">Class Phalcon\Html\Helper\Input\DateTimeLocal</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/DateTimeLocal.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class DateTimeLocal
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = datetime-local;

</code></pre>

<h1 id="html-helper-input-email">Class Phalcon\Html\Helper\Input\Email</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Email.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Email
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = email;

</code></pre>

<h1 id="html-helper-input-file">Class Phalcon\Html\Helper\Input\File</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/File.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class File
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = file;

</code></pre>

<h1 id="html-helper-input-hidden">Class Phalcon\Html\Helper\Input\Hidden</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Hidden.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Hidden
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = hidden;

</code></pre>

<h1 id="html-helper-input-image">Class Phalcon\Html\Helper\Input\Image</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Image.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Image
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = image;

</code></pre>

<h1 id="html-helper-input-input">Class Phalcon\Html\Helper\Input\Input</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Input.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Input
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function setType( string $type ): AbstractInput;
</code></pre>

<p>
  Sets the type of the input
</p>

<h1 id="html-helper-input-month">Class Phalcon\Html\Helper\Input\Month</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Month.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Month
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = month;

</code></pre>

<h1 id="html-helper-input-numeric">Class Phalcon\Html\Helper\Input\Numeric</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Numeric.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Numeric
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = numeric;

</code></pre>

<h1 id="html-helper-input-password">Class Phalcon\Html\Helper\Input\Password</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Password.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Password
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = password;

</code></pre>

<h1 id="html-helper-input-radio">Class Phalcon\Html\Helper\Input\Radio</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Radio.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | Checkbox |
</p>

<p>
  Class Radio
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var string
 */
protected type = radio;

</code></pre>

<h1 id="html-helper-input-range">Class Phalcon\Html\Helper\Input\Range</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Range.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Range
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = range;

</code></pre>

<h1 id="html-helper-input-search">Class Phalcon\Html\Helper\Input\Search</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Search.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Search
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = search;

</code></pre>

<h1 id="html-helper-input-select">Class Phalcon\Html\Helper\Input\Select</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Select.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Uses | Phalcon\Html\Helper\AbstractList | | Extends | AbstractList |
</p>

<p>
  Class Select
</p>

<p>
  @property string $elementTag @property bool $inOptGroup @property string $selected
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
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

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function add( string $text, string $value = null, array $attributes = [], bool $raw = bool ): Select;
</code></pre>

<p>
  Add an element to the list
</p>

<pre><code class="php">public function addPlaceholder( string $text, mixed $value = null, array $attributes = [], bool $raw = bool ): Select;
</code></pre>

<p>
  Add an element to the list
</p>

<pre><code class="php">public function optGroup( string $label = null, array $attributes = [] ): Select;
</code></pre>

<p>
  Creates an option group
</p>

<pre><code class="php">public function selected( string $selected ): Select;
</code></pre>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<pre><code class="php">protected function optGroupEnd(): string;
</code></pre>

<pre><code class="php">protected function optGroupStart( string $label, array $attributes ): string;
</code></pre>

<h1 id="html-helper-input-submit">Class Phalcon\Html\Helper\Input\Submit</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Submit.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Submit
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = submit;

</code></pre>

<h1 id="html-helper-input-tel">Class Phalcon\Html\Helper\Input\Tel</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Tel.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Tel
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = tel;

</code></pre>

<h1 id="html-helper-input-text">Class Phalcon\Html\Helper\Input\Text</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Text.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Text
</p>

<h1 id="html-helper-input-textarea">Class Phalcon\Html\Helper\Input\Textarea</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Textarea.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Uses | Phalcon\Helper\Arr, Phalcon\Html\Exception | | Extends | AbstractInput |
</p>

<p>
  Class Textarea
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var string
 */
protected type = textarea;

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __toString();
</code></pre>

<p>
  Returns the HTML for the input.
</p>

<h1 id="html-helper-input-time">Class Phalcon\Html\Helper\Input\Time</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Time.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Time
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = time;

</code></pre>

<h1 id="html-helper-input-url">Class Phalcon\Html\Helper\Input\Url</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Url.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Url
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = url;

</code></pre>

<h1 id="html-helper-input-week">Class Phalcon\Html\Helper\Input\Week</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Week.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper\Input | | Extends | AbstractInput |
</p>

<p>
  Class Week
</p>

<h2>
  Properties
</h2>

<pre><code class="php">//
protected type = week;

</code></pre>

<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Label.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Label
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( array $attributes = [] ): string;
</code></pre>

<p>
  Produce a <code>&lt;label&gt;</code> tag.
</p>

<h1 id="html-helper-link">Class Phalcon\Html\Helper\Link</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Link.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Extends | AbstractSeries |
</p>

<p>
  Class Link
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function add( string $rel, string $href ): Link;
</code></pre>

<p>
  Add an element to the list
</p>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<h1 id="html-helper-meta">Class Phalcon\Html\Helper\Meta</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Meta.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractSeries |
</p>

<p>
  Class Meta
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function add( array $attributes = [] ): Meta;
</code></pre>

<p>
  Add an element to the list
</p>

<pre><code class="php">public function addHttp( string $httpEquiv, string $content ): Meta;
</code></pre>

<pre><code class="php">public function addName( string $name, string $content ): Meta;
</code></pre>

<pre><code class="php">public function addProperty( string $name, string $content ): Meta;
</code></pre>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<h1 id="html-helper-ol">Class Phalcon\Html\Helper\Ol</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Ol.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Extends | AbstractList |
</p>

<p>
  Class Ol
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function add( string $text, array $attributes = [], bool $raw = bool ): AbstractList;
</code></pre>

<p>
  Add an element to the list
</p>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<h1 id="html-helper-script">Class Phalcon\Html\Helper\Script</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Script.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Extends | Style |
</p>

<p>
  Class Script
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">protected function getAttributes( string $src, array $attributes ): array;
</code></pre>

<p>
  Returns the necessary attributes
</p>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<h1 id="html-helper-style">Class Phalcon\Html\Helper\Style</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Style.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractSeries |
</p>

<p>
  Class Style
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function add( string $href, array $attributes = [] );
</code></pre>

<p>
  Add an element to the list
</p>

<pre><code class="php">protected function getAttributes( string $href, array $attributes ): array;
</code></pre>

<p>
  Returns the necessary attributes
</p>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<h1 id="html-helper-title">Class Phalcon\Html\Helper\Title</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Title.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |
</p>

<p>
  Class Title
</p>

<p>
  @property array $append @property string $delimiter @property string $indent @property array $prepend @property string $title @property string $separator
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
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

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __invoke( string $separator = string, string $indent = null, string $delimiter = null ): Title;
</code></pre>

<p>
  Sets the separator and returns the object back
</p>

<pre><code class="php">public function __toString();
</code></pre>

<p>
  Returns the title tags
</p>

<pre><code class="php">public function append( string $text, bool $raw = bool ): Title;
</code></pre>

<p>
  Appends text to current document title
</p>

<pre><code class="php">public function get(): string;
</code></pre>

<p>
  Returns the title
</p>

<pre><code class="php">public function prepend( string $text, bool $raw = bool ): Title;
</code></pre>

<p>
  Prepends text to current document title
</p>

<pre><code class="php">public function set( string $text, bool $raw = bool ): Title;
</code></pre>

<p>
  Sets the title
</p>

<h1 id="html-helper-ul">Class Phalcon\Html\Helper\Ul</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Ul.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Helper | | Extends | Ol |
</p>

<p>
  Class Ul
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">protected function getTag(): string;
</code></pre>

<h1 id="html-link-evolvablelink">Class Phalcon\Html\Link\EvolvableLink</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/EvolvableLink.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Link | | Uses | Psr\Link\EvolvableLinkInterface | | Extends | Link | | Implements | EvolvableLinkInterface |
</p>

<p>
  Class Phalcon\Http\Link\EvolvableLink
</p>

<p>
  @property array attributes @property string href @property array rels @property bool templated
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function withAttribute( mixed $attribute, mixed $value );
</code></pre>

<p>
  Returns an instance with the specified attribute added.
</p>

<p>
  If the specified attribute is already present, it will be overwritten with the new value.
</p>

<pre><code class="php">public function withHref( mixed $href );
</code></pre>

<p>
  Returns an instance with the specified href.
</p>

<pre><code class="php">public function withRel( mixed $rel );
</code></pre>

<p>
  Returns an instance with the specified relationship included.
</p>

<p>
  If the specified rel is already present, this method MUST return normally without errors, but without adding the rel a second time.
</p>

<pre><code class="php">public function withoutAttribute( mixed $attribute );
</code></pre>

<p>
  Returns an instance with the specified attribute excluded.
</p>

<p>
  If the specified attribute is not present, this method MUST return normally without errors.
</p>

<pre><code class="php">public function withoutRel( mixed $rel );
</code></pre>

<p>
  Returns an instance with the specified relationship excluded.
</p>

<p>
  If the specified rel is not present, this method MUST return normally without errors.
</p>

<h1 id="html-link-evolvablelinkprovider">Class Phalcon\Html\Link\EvolvableLinkProvider</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/EvolvableLinkProvider.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Link | | Uses | Psr\Link\EvolvableLinkProviderInterface, Psr\Link\LinkInterface | | Extends | LinkProvider | | Implements | EvolvableLinkProviderInterface |
</p>

<p>
  Class Phalcon\Http\Link\LinkProvider
</p>

<p>
  @property LinkInterface[] links
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function withLink( LinkInterface $link );
</code></pre>

<p>
  Returns an instance with the specified link included.
</p>

<p>
  If the specified link is already present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.
</p>

<pre><code class="php">public function withoutLink( LinkInterface $link );
</code></pre>

<p>
  Returns an instance with the specified link removed.
</p>

<p>
  If the specified link is not present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.
</p>

<h1 id="html-link-link">Class Phalcon\Html\Link\Link</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Link.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Link | | Uses | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Psr\Link\LinkInterface | | Implements | LinkInterface |
</p>

<p>
  Class Phalcon\Http\Link\Link
</p>

<p>
  @property array attributes @property string href @property array rels @property bool templated
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var Collection|CollectionInterface
 */
protected attributes;

/**
 * @var string
 */
protected href = ;

/**
 * @var Collection|CollectionInterface
 */
protected rels;

/**
 * @var bool
 */
protected templated = false;

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __construct( string $rel = string, string $href = string, array $attributes = [] );
</code></pre>

<p>
  Link constructor.
</p>

<pre><code class="php">public function getAttributes();
</code></pre>

<p>
  Returns a list of attributes that describe the target URI.
</p>

<pre><code class="php">public function getHref();
</code></pre>

<p>
  Returns the target of the link.
</p>

<p>
  The target link must be one of:
</p>

<ul>
  <li>
    An absolute URI, as defined by RFC 5988.
  </li>
  <li>
    A relative URI, as defined by RFC 5988. The base of the relative link is assumed to be known based on context by the client.
  </li>
  <li>
    A URI template as defined by RFC 6570.
  </li>
</ul>

<p>
  If a URI template is returned, isTemplated() MUST return True.
</p>

<pre><code class="php">public function getRels();
</code></pre>

<p>
  Returns the relationship type(s) of the link.
</p>

<p>
  This method returns 0 or more relationship types for a link, expressed as an array of strings.
</p>

<pre><code class="php">public function isTemplated();
</code></pre>

<p>
  Returns whether or not this is a templated link.
</p>

<pre><code class="php">protected function hrefIsTemplated( string $href ): bool;
</code></pre>

<p>
  Determines if a href is a templated link or not.
</p>

<p>
  @see https://tools.ietf.org/html/rfc6570
</p>

<h1 id="html-link-linkprovider">Class Phalcon\Html\Link\LinkProvider</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/LinkProvider.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Link | | Uses | Psr\Link\LinkInterface, Psr\Link\LinkProviderInterface | | Implements | LinkProviderInterface |
</p>

<p>
  Class Phalcon\Http\Link\LinkProvider
</p>

<p>
  @property LinkInterface[] links
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var LinkInterface[]
 */
protected links;

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __construct( array $links = [] );
</code></pre>

<p>
  LinkProvider constructor.
</p>

<pre><code class="php">public function getLinks();
</code></pre>

<p>
  Returns an iterable of LinkInterface objects.
</p>

<p>
  The iterable may be an array or any PHP \Traversable object. If no links are available, an empty array or \Traversable MUST be returned.
</p>

<pre><code class="php">public function getLinksByRel( mixed $rel );
</code></pre>

<p>
  Returns an iterable of LinkInterface objects that have a specific relationship.
</p>

<p>
  The iterable may be an array or any PHP \Traversable object. If no links with that relationship are available, an empty array or \Traversable MUST be returned.
</p>

<pre><code class="php">protected function getKey( LinkInterface $link ): string;
</code></pre>

<p>
  Returns the object hash key
</p>

<h1 id="html-link-serializer-header">Class Phalcon\Html\Link\Serializer\Header</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Serializer/Header.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Link\Serializer | | Uses | Psr\Link\EvolvableLinkInterface | | Implements | SerializerInterface |
</p>

<p>
  Class Phalcon\Http\Link\Serializer\Header
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function serialize( array $links ): string | null;
</code></pre>

<p>
  Serializes all the passed links to a HTTP link header
</p>

<h1 id="html-link-serializer-serializerinterface">Interface Phalcon\Html\Link\Serializer\SerializerInterface</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Serializer/SerializerInterface.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html\Link\Serializer |
</p>

<p>
  Class Phalcon\Http\Link\Serializer\SerializerInterface
</p>

<h2>
  メソッド
</h2>

<pre><code class="php">public function serialize( array $links ): string | null;
</code></pre>

<p>
  Serializer method
</p>

<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

<p>
  <a href="https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/TagFactory.zep">GitHub上のソース</a>
</p>

<p>
  | Namespace | Phalcon\Html | | Uses | Phalcon\Escaper, Phalcon\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory | | Extends | AbstractFactory |
</p>

<p>
  ServiceLocator implementation for Tag helpers
</p>

<h2>
  Properties
</h2>

<pre><code class="php">/**
 * @var EscaperInterface
 */
private escaper;

</code></pre>

<h2>
  メソッド
</h2>

<pre><code class="php">public function __construct( EscaperInterface $escaper, array $services = [] );
</code></pre>

<p>
  TagFactory constructor.
</p>

<pre><code class="php">public function newInstance( string $name ): mixed;
</code></pre>

<pre><code class="php">protected function getAdapters(): array;
</code></pre>
