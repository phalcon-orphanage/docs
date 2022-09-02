---
layout: default
version: '4.0'
title: 'Phalcon\Html'
---

* [Phalcon\Html\Attributes](#html-attributes)
* [Phalcon\Html\Attributes\AttributesInterface](#html-attributes-attributesinterface)
* [Phalcon\Html\Attributes\RenderInterface](#html-attributes-renderinterface)
* [Phalcon\Html\Breadcrumbs](#html-breadcrumbs)
* [Phalcon\Html\Exception](#html-exception)
* [Phalcon\Html\Helper\AbstractHelper](#html-helper-abstracthelper)
* [Phalcon\Html\Helper\AbstractList](#html-helper-abstractlist)
* [Phalcon\Html\Helper\AbstractSeries](#html-helper-abstractseries)
* [Phalcon\Html\Helper\Anchor](#html-helper-anchor)
* [Phalcon\Html\Helper\Base](#html-helper-base)
* [Phalcon\Html\Helper\Body](#html-helper-body)
* [Phalcon\Html\Helper\Button](#html-helper-button)
* [Phalcon\Html\Helper\Close](#html-helper-close)
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
* [Phalcon\Html\Link\EvolvableLink](#html-link-evolvablelink)
* [Phalcon\Html\Link\EvolvableLinkProvider](#html-link-evolvablelinkprovider)
* [Phalcon\Html\Link\Link](#html-link-link)
* [Phalcon\Html\Link\LinkProvider](#html-link-linkprovider)
* [Phalcon\Html\Link\Serializer\Header](#html-link-serializer-header)
* [Phalcon\Html\Link\Serializer\SerializerInterface](#html-link-serializer-serializerinterface)
* [Phalcon\Html\TagFactory](#html-tagfactory)

<h1 id="html-attributes">Class Phalcon\Html\Attributes</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes.zep)

| Namespace  | Phalcon\Html |
| Uses       | Phalcon\Collection, Phalcon\Html\Attributes\RenderInterface, Phalcon\Tag |
| Extends    | Collection |
| Implements | RenderInterface |

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




<h1 id="html-attributes-attributesinterface">Interface Phalcon\Html\Attributes\AttributesInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes/AttributesInterface.zep)

| Namespace  | Phalcon\Html\Attributes |
| Uses       | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\AttributesInterface
*
* Interface Phalcon\Html\Attributes\AttributesInterface
*/

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Attributes/RenderInterface.zep)

| Namespace  | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\RenderInterface
*
* Interface Phalcon\Html\Attributes\RenderInterface
*/

## Methods

```php
public function render(): string;
```
Generate a string represetation




<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Breadcrumbs.zep)

| Namespace  | Phalcon\Html |
| Uses       | Phalcon\Di\DiInterface |

Phalcon\Html\Breadcrumbs

This component offers an easy way to create breadcrumbs for your application.
The resulting HTML when calling `render()` will have each breadcrumb enclosed
in `<dt>` tags, while the whole string is enclosed in `<dl>` tags.


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




<h1 id="html-exception">Class Phalcon\Html\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Exception.zep)

| Namespace  | Phalcon\Html |
| Extends    | \Phalcon\Exception |

Phalcon\Html\Tag\Exception

Exceptions thrown in Phalcon\Html\Tag will use this class



<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractHelper.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Escaper\EscaperInterface, Phalcon\Html\Exception |

Class AbstractHelper

@property string  $delimiter
@property Escaper $escaper
@property string  $indent
@property int     $indentLevel


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
Traverses an array and calls the method defined in the first element
with attributes as the second, returning the resulting string


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractList.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/AbstractSeries.zep)

| Namespace  | Phalcon\Html\Helper |
| Extends    | AbstractHelper |

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

## Methods

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Anchor.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Base.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Base


## Methods

```php
public function __invoke( string $href = null, array $attributes = [] ): string;
```
Produce a `<base/>` tag.




<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Body.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Body


## Methods

```php
public function __invoke( array $attributes = [] ): string;
```
Produce a `<body>` tag.




<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Button.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Button


## Methods

```php
public function __invoke( string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce a `<button>` tag.




<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Close.zep)

| Namespace  | Phalcon\Html\Helper |
| Extends    | AbstractHelper |

Class Close


## Methods

```php
public function __invoke( string $tag, bool $raw = bool ): string;
```
Produce a `</...>` tag.




<h1 id="html-helper-element">Class Phalcon\Html\Helper\Element</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Element.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Element


## Methods

```php
public function __invoke( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
```
Produce a tag.




<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Form.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Form


## Methods

```php
public function __invoke( array $attributes = [] ): string;
```
Produce a `<form>` tag.




<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Img.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Img


## Methods

```php
public function __invoke( string $src, array $attributes = [] ): string;
```
Produce a <img> tag.




<h1 id="html-helper-input-abstractinput">Abstract Class Phalcon\Html\Helper\Input\AbstractInput</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/AbstractInput.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Uses       | Phalcon\Html\Helper\AbstractHelper |
| Extends    | AbstractHelper |

Class AbstractInput

@property array  $attributes
@property string $type
@property string $value


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Checkbox.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Uses       | Phalcon\Escaper\EscaperInterface, Phalcon\Helper\Arr |
| Extends    | AbstractInput |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Color.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Color


## Properties
```php
//
protected type = color;

```


<h1 id="html-helper-input-date">Class Phalcon\Html\Helper\Input\Date</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Date.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Date


## Properties
```php
//
protected type = date;

```


<h1 id="html-helper-input-datetime">Class Phalcon\Html\Helper\Input\DateTime</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/DateTime.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class DateTime


## Properties
```php
//
protected type = datetime;

```


<h1 id="html-helper-input-datetimelocal">Class Phalcon\Html\Helper\Input\DateTimeLocal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/DateTimeLocal.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class DateTimeLocal


## Properties
```php
//
protected type = datetime-local;

```


<h1 id="html-helper-input-email">Class Phalcon\Html\Helper\Input\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Email.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Email


## Properties
```php
//
protected type = email;

```


<h1 id="html-helper-input-file">Class Phalcon\Html\Helper\Input\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/File.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class File


## Properties
```php
//
protected type = file;

```


<h1 id="html-helper-input-hidden">Class Phalcon\Html\Helper\Input\Hidden</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Hidden.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Hidden


## Properties
```php
//
protected type = hidden;

```


<h1 id="html-helper-input-image">Class Phalcon\Html\Helper\Input\Image</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Image.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Image


## Properties
```php
//
protected type = image;

```


<h1 id="html-helper-input-input">Class Phalcon\Html\Helper\Input\Input</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Input.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Input


## Methods

```php
public function setType( string $type ): AbstractInput;
```
Sets the type of the input




<h1 id="html-helper-input-month">Class Phalcon\Html\Helper\Input\Month</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Month.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Month


## Properties
```php
//
protected type = month;

```


<h1 id="html-helper-input-numeric">Class Phalcon\Html\Helper\Input\Numeric</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Numeric.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Numeric


## Properties
```php
//
protected type = numeric;

```


<h1 id="html-helper-input-password">Class Phalcon\Html\Helper\Input\Password</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Password.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Password


## Properties
```php
//
protected type = password;

```


<h1 id="html-helper-input-radio">Class Phalcon\Html\Helper\Input\Radio</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Radio.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | Checkbox |

Class Radio


## Properties
```php
/**
 * @var string
 */
protected type = radio;

```


<h1 id="html-helper-input-range">Class Phalcon\Html\Helper\Input\Range</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Range.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Range


## Properties
```php
//
protected type = range;

```


<h1 id="html-helper-input-search">Class Phalcon\Html\Helper\Input\Search</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Search.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Search


## Properties
```php
//
protected type = search;

```


<h1 id="html-helper-input-select">Class Phalcon\Html\Helper\Input\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Select.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Uses       | Phalcon\Html\Helper\AbstractList |
| Extends    | AbstractList |

Class Select

@property string $elementTag
@property bool   $inOptGroup
@property string $selected


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
Add an element to the list


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Submit.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Submit


## Properties
```php
//
protected type = submit;

```


<h1 id="html-helper-input-tel">Class Phalcon\Html\Helper\Input\Tel</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Tel.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Tel


## Properties
```php
//
protected type = tel;

```


<h1 id="html-helper-input-text">Class Phalcon\Html\Helper\Input\Text</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Text.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Text



<h1 id="html-helper-input-textarea">Class Phalcon\Html\Helper\Input\Textarea</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Textarea.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Uses       | Phalcon\Helper\Arr, Phalcon\Html\Exception |
| Extends    | AbstractInput |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Time.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Time


## Properties
```php
//
protected type = time;

```


<h1 id="html-helper-input-url">Class Phalcon\Html\Helper\Input\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Url.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Url


## Properties
```php
//
protected type = url;

```


<h1 id="html-helper-input-week">Class Phalcon\Html\Helper\Input\Week</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Input/Week.zep)

| Namespace  | Phalcon\Html\Helper\Input |
| Extends    | AbstractInput |

Class Week


## Properties
```php
//
protected type = week;

```


<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Label.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Label


## Methods

```php
public function __invoke( array $attributes = [] ): string;
```
Produce a `<label>` tag.




<h1 id="html-helper-link">Class Phalcon\Html\Helper\Link</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Link.zep)

| Namespace  | Phalcon\Html\Helper |
| Extends    | AbstractSeries |

Class Link


## Methods

```php
public function add( string $rel, string $href ): Link;
```
Add an element to the list


```php
protected function getTag(): string;
```





<h1 id="html-helper-meta">Class Phalcon\Html\Helper\Meta</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Meta.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractSeries |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Ol.zep)

| Namespace  | Phalcon\Html\Helper |
| Extends    | AbstractList |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Script.zep)

| Namespace  | Phalcon\Html\Helper |
| Extends    | Style |

Class Script


## Methods

```php
protected function getAttributes( string $src, array $attributes ): array;
```
Returns the necessary attributes


```php
protected function getTag(): string;
```





<h1 id="html-helper-style">Class Phalcon\Html\Helper\Style</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Style.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractSeries |

Class Style


## Methods

```php
public function add( string $href, array $attributes = [] );
```
Add an element to the list


```php
protected function getAttributes( string $href, array $attributes ): array;
```
Returns the necessary attributes


```php
protected function getTag(): string;
```





<h1 id="html-helper-title">Class Phalcon\Html\Helper\Title</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Title.zep)

| Namespace  | Phalcon\Html\Helper |
| Uses       | Phalcon\Html\Exception |
| Extends    | AbstractHelper |

Class Title

@property array  $append
@property string $delimiter
@property string $indent
@property array  $prepend
@property string $title
@property string $separator


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
public function __invoke( string $separator = string, string $indent = null, string $delimiter = null ): Title;
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




<h1 id="html-helper-ul">Class Phalcon\Html\Helper\Ul</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Helper/Ul.zep)

| Namespace  | Phalcon\Html\Helper |
| Extends    | Ol |

Class Ul


## Methods

```php
protected function getTag(): string;
```





<h1 id="html-link-evolvablelink">Class Phalcon\Html\Link\EvolvableLink</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/EvolvableLink.zep)

| Namespace  | Phalcon\Html\Link |
| Uses       | Psr\Link\EvolvableLinkInterface |
| Extends    | Link |
| Implements | EvolvableLinkInterface |

Class Phalcon\Http\Link\EvolvableLink

@property array  attributes
@property string href
@property array  rels
@property bool   templated


## Methods

```php
public function withAttribute( mixed $attribute, mixed $value );
```
Returns an instance with the specified attribute added.

If the specified attribute is already present, it will be overwritten
with the new value.


```php
public function withHref( mixed $href );
```
Returns an instance with the specified href.


```php
public function withRel( mixed $rel );
```
Returns an instance with the specified relationship included.

If the specified rel is already present, this method MUST return
normally without errors, but without adding the rel a second time.


```php
public function withoutAttribute( mixed $attribute );
```
Returns an instance with the specified attribute excluded.

If the specified attribute is not present, this method MUST return
normally without errors.


```php
public function withoutRel( mixed $rel );
```
Returns an instance with the specified relationship excluded.

If the specified rel is not present, this method MUST return
normally without errors.




<h1 id="html-link-evolvablelinkprovider">Class Phalcon\Html\Link\EvolvableLinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/EvolvableLinkProvider.zep)

| Namespace  | Phalcon\Html\Link |
| Uses       | Psr\Link\EvolvableLinkProviderInterface, Psr\Link\LinkInterface |
| Extends    | LinkProvider |
| Implements | EvolvableLinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links


## Methods

```php
public function withLink( LinkInterface $link );
```
Returns an instance with the specified link included.

If the specified link is already present, this method MUST return
normally without errors. The link is present if link is === identical
to a link object already in the collection.


```php
public function withoutLink( LinkInterface $link );
```
Returns an instance with the specified link removed.

If the specified link is not present, this method MUST return normally
without errors. The link is present if link is === identical to a link
object already in the collection.




<h1 id="html-link-link">Class Phalcon\Html\Link\Link</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Link.zep)

| Namespace  | Phalcon\Html\Link |
| Uses       | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Psr\Link\LinkInterface |
| Implements | LinkInterface |

Class Phalcon\Http\Link\Link

@property array  attributes
@property string href
@property array  rels
@property bool   templated


## Properties
```php
/**
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

```

## Methods

```php
public function __construct( string $rel = string, string $href = string, array $attributes = [] );
```
Link constructor.


```php
public function getAttributes();
```
Returns a list of attributes that describe the target URI.


```php
public function getHref();
```
Returns the target of the link.

The target link must be one of:
- An absolute URI, as defined by RFC 5988.
- A relative URI, as defined by RFC 5988. The base of the relative link
    is assumed to be known based on context by the client.
- A URI template as defined by RFC 6570.

If a URI template is returned, isTemplated() MUST return True.


```php
public function getRels();
```
Returns the relationship type(s) of the link.

This method returns 0 or more relationship types for a link, expressed
as an array of strings.


```php
public function isTemplated();
```
Returns whether or not this is a templated link.


```php
protected function hrefIsTemplated( string $href ): bool;
```
Determines if a href is a templated link or not.

@see https://tools.ietf.org/html/rfc6570




<h1 id="html-link-linkprovider">Class Phalcon\Html\Link\LinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/LinkProvider.zep)

| Namespace  | Phalcon\Html\Link |
| Uses       | Psr\Link\LinkInterface, Psr\Link\LinkProviderInterface |
| Implements | LinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links


## Properties
```php
/**
 * @var LinkInterface[]
 */
protected links;

```

## Methods

```php
public function __construct( array $links = [] );
```
LinkProvider constructor.


```php
public function getLinks();
```
Returns an iterable of LinkInterface objects.

The iterable may be an array or any PHP \Traversable object. If no links
are available, an empty array or \Traversable MUST be returned.


```php
public function getLinksByRel( mixed $rel );
```
Returns an iterable of LinkInterface objects that have a specific
relationship.

The iterable may be an array or any PHP \Traversable object. If no links
with that relationship are available, an empty array or \Traversable
MUST be returned.


```php
protected function getKey( LinkInterface $link ): string;
```
Returns the object hash key




<h1 id="html-link-serializer-header">Class Phalcon\Html\Link\Serializer\Header</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Serializer/Header.zep)

| Namespace  | Phalcon\Html\Link\Serializer |
| Uses       | Psr\Link\EvolvableLinkInterface |
| Implements | SerializerInterface |

Class Phalcon\Http\Link\Serializer\Header


## Methods

```php
public function serialize( array $links ): string | null;
```
Serializes all the passed links to a HTTP link header




<h1 id="html-link-serializer-serializerinterface">Interface Phalcon\Html\Link\Serializer\SerializerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/Link/Serializer/SerializerInterface.zep)

| Namespace  | Phalcon\Html\Link\Serializer |

Class Phalcon\Http\Link\Serializer\SerializerInterface


## Methods

```php
public function serialize( array $links ): string | null;
```
Serializer method




<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Html/TagFactory.zep)

| Namespace  | Phalcon\Html |
| Uses       | Phalcon\Escaper, Phalcon\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory |
| Extends    | AbstractFactory |

ServiceLocator implementation for Tag helpers


## Properties
```php
/**
 * @var EscaperInterface
 */
private escaper;

```

## Methods

```php
public function __construct( EscaperInterface $escaper, array $services = [] );
```
TagFactory constructor.


```php
public function newInstance( string $name ): mixed;
```



```php
protected function getAdapters(): array;
```
