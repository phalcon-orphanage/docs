---
layout: default
language: 'th-th'
version: '4.0'
title: 'Phalcon\Html'
---

* [Phalcon\Html\Attributes](#html-attributes)
* [Phalcon\Html\Attributes\AttributesInterface](#html-attributes-attributesinterface)
* [Phalcon\Html\Attributes\RenderInterface](#html-attributes-renderinterface)
* [Phalcon\Html\Breadcrumbs](#html-breadcrumbs)
* [Phalcon\Html\Exception](#html-exception)
* [Phalcon\Html\Helper\AbstractHelper](#html-helper-abstracthelper)
* [Phalcon\Html\Helper\Anchor](#html-helper-anchor)
* [Phalcon\Html\Helper\AnchorRaw](#html-helper-anchorraw)
* [Phalcon\Html\Helper\Body](#html-helper-body)
* [Phalcon\Html\Helper\Button](#html-helper-button)
* [Phalcon\Html\Helper\Close](#html-helper-close)
* [Phalcon\Html\Helper\Element](#html-helper-element)
* [Phalcon\Html\Helper\ElementRaw](#html-helper-elementraw)
* [Phalcon\Html\Helper\Form](#html-helper-form)
* [Phalcon\Html\Helper\Img](#html-helper-img)
* [Phalcon\Html\Helper\Label](#html-helper-label)
* [Phalcon\Html\Helper\TextArea](#html-helper-textarea)
* [Phalcon\Html\TagFactory](#html-tagfactory)

<h1 id="html-attributes">Class Phalcon\Html\Attributes</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/attributes.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Collection, Phalcon\Html\Attributes\RenderInterface, Phalcon\Tag | | Extends | Collection | | Implements | RenderInterface |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/attributes/attributesinterface.zep)

| Namespace | Phalcon\Html\Attributes | | Uses | Phalcon\Html\Attributes |

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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/attributes/renderinterface.zep)

| Namespace | Phalcon\Html\Attributes |

* Phalcon\Html\Attributes\RenderInterface
* 
* Interface Phalcon\Html\Attributes\RenderInterface */

## Methods

```php
public function render(): string;
```

Generate a string represetation

<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/breadcrumbs.zep)

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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/exception.zep)

| Namespace | Phalcon\Html | | Extends | \Phalcon\Exception |

Phalcon\Html\Tag\Exception

Exceptions thrown in Phalcon\Html\Tag will use this class

<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/abstracthelper.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception, Phalcon\Escaper\EscaperInterface |

Phalcon\Html\Helper\AbstractHelper

Abstract class for all html helpers

## Properties

```php
/**
 * @var <EscaperInterface>
 */
protected escaper;

```

## Methods

```php
public function __construct( EscaperInterface $escaper );
```

Constructor

```php
protected function orderAttributes( array $overrides, array $attributes ): array;
```

Keeps all the attributes sorted - same order all the tome

@return array

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
protected function selfClose( string $tag, array $attributes = [] ): string;
```

Produces a self close tag i.e. <img />

<h1 id="html-helper-anchor">Class Phalcon\Html\Helper\Anchor</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/anchor.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Anchor

Creates an anchor

## Methods

```php
public function __invoke( string $href, string $text, array $attributes = [] ): string;
```

@var string href The href tag @var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-anchorraw">Class Phalcon\Html\Helper\AnchorRaw</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/anchorraw.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\AnchorRaw

Creates a raw anchor

## Methods

```php
public function __invoke( string $href, string $text, array $attributes = [] ): string;
```

@var string href The href tag @var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/body.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Body

Creates a body tag

## Methods

```php
public function __invoke( array $attributes = [] ): string;
```

@var array attributes Any additional attributes

<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/button.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Button

Creates a button tag

## Methods

```php
public function __invoke( string $text, array $attributes = [] ): string;
```

@var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/close.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Close

Creates a closing tag

## Methods

```php
public function __invoke( string $tag ): string;
```

@return string

<h1 id="html-helper-element">Class Phalcon\Html\Helper\Element</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/element.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Address

Creates an element

## Methods

```php
public function __invoke( string $tag, string $text, array $attributes = [] ): string;
```

@var string tag The tag name @var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-elementraw">Class Phalcon\Html\Helper\ElementRaw</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/elementraw.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\ElementRaw

Creates an element raw

## Methods

```php
public function __invoke( string $tag, string $text, array $attributes = [] ): string;
```

@return string @throws Exception

<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/form.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Form

Creates a form opening tag

## Methods

```php
public function __invoke( array $attributes = [] ): string;
```

@var array attributes Any additional attributes

<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/img.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\Img

Creates am img tag

## Methods

```php
public function __invoke( string $src, array $attributes = [] ): string;
```

@return string @throws Exception

<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/label.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\Label

Creates a label

## Methods

```php
public function __invoke( array $attributes = [] ): string;
```

@return string @throws Exception

<h1 id="html-helper-textarea">Class Phalcon\Html\Helper\TextArea</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/textarea.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Helper\AbstractHelper | | Extends | AbstractHelper |

Phalcon\Html\Helper\TextArea

Creates a textarea tag

## Methods

```php
public function __invoke( string $text, array $attributes = [] ): string;
```

@var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/tagfactory.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Escaper, Phalcon\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory | | Extends | AbstractFactory |

ServiceLocator implementation for Tag helpers

## Properties

```php
/**
 * @var <EscaperInterface>
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

@return mixed @throws Exception

```php
protected function getAdapters(): array;
```

//