---
layout: default
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Html'
---

- [Phalcon\Html\Attributes](#html-attributes)
- [Phalcon\Html\Attributes\AttributesInterface](#html-attributes-attributesinterface)
- [Phalcon\Html\Attributes\RenderInterface](#html-attributes-renderinterface)
- [Phalcon\Html\Breadcrumbs](#html-breadcrumbs)
- [Phalcon\Html\Exception](#html-exception)
- [Phalcon\Html\Helper\AbstractHelper](#html-helper-abstracthelper)
- [Phalcon\Html\Helper\Anchor](#html-helper-anchor)
- [Phalcon\Html\Helper\AnchorRaw](#html-helper-anchorraw)
- [Phalcon\Html\Helper\Body](#html-helper-body)
- [Phalcon\Html\Helper\Button](#html-helper-button)
- [Phalcon\Html\Helper\Close](#html-helper-close)
- [Phalcon\Html\Helper\Element](#html-helper-element)
- [Phalcon\Html\Helper\ElementRaw](#html-helper-elementraw)
- [Phalcon\Html\Helper\Form](#html-helper-form)
- [Phalcon\Html\Helper\Img](#html-helper-img)
- [Phalcon\Html\Helper\Label](#html-helper-label)
- [Phalcon\Html\Helper\TextArea](#html-helper-textarea)
- [Phalcon\Html\Link\EvolvableLink](#html-link-evolvablelink)
- [Phalcon\Html\Link\EvolvableLinkProvider](#html-link-evolvablelinkprovider)
- [Phalcon\Html\Link\Link](#html-link-link)
- [Phalcon\Html\Link\LinkProvider](#html-link-linkprovider)
- [Phalcon\Html\Link\Serializer\Header](#html-link-serializer-header)
- [Phalcon\Html\Link\Serializer\SerializerInterface](#html-link-serializer-serializerinterface)
- [Phalcon\Html\TagFactory](#html-tagfactory)

<h1 id="html-attributes">Class Phalcon\Html\Attributes</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Attributes.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Collection, Phalcon\Html\Attributes\RenderInterface, Phalcon\Tag | | Extends | Collection | | Implements | RenderInterface |

This class helps to work with HTML Attributes

## Methods

Alias of the render method

```php
public function __toString(): string;
```

Render attributes as HTML attributes

```php
public function render(): string;
```

<h1 id="html-attributes-attributesinterface">Interface Phalcon\Html\Attributes\AttributesInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Attributes/AttributesInterface.zep)

| Namespace | Phalcon\Html\Attributes | | Uses | Phalcon\Html\Attributes |

- Phalcon\Html\Attributes\AttributesInterface
- 
- Interface Phalcon\Html\Attributes\AttributesInterface */

## Methods

Get Attributes

```php
public function getAttributes(): Attributes;
```

Set Attributes

```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```

<h1 id="html-attributes-renderinterface">Interface Phalcon\Html\Attributes\RenderInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Attributes/RenderInterface.zep)

| Namespace | Phalcon\Html\Attributes |

- Phalcon\Html\Attributes\RenderInterface
- 
- Interface Phalcon\Html\Attributes\RenderInterface */

## Methods

Generate a string represetation

```php
public function render(): string;
```

<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Breadcrumbs.zep)

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

Adds a new crumb.

```php
// Adding a crumb with a link
$breadcrumbs->add("Home", "/");

// Adding a crumb without a link (normally the last one)
$breadcrumbs->add("Users");
```

```php
public function add( string $label, string $link = string ): Breadcrumbs;
```

Clears the crumbs

```php
$breadcrumbs->clear()
```

```php
public function clear(): void;
```

```php
public function getSeparator(): string
```

Removes crumb by url.

```php
$breadcrumbs->remove("/admin/user/create");

// remove a crumb without an url (last link)
$breadcrumbs->remove();
```

```php
public function remove( string $link ): void;
```

Renders and outputs breadcrumbs based on previously set template.

```php
echo $breadcrumbs->render();
```

```php
public function render(): string;
```

```php
public function setSeparator( string $separator )
```

Returns the internal breadcrumbs array

```php
public function toArray(): array;
```

<h1 id="html-exception">Class Phalcon\Html\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Exception.zep)

| Namespace | Phalcon\Html | | Extends | \Phalcon\Exception |

Phalcon\Html\Tag\Exception

Exceptions thrown in Phalcon\Html\Tag will use this class

<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/AbstractHelper.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception, Phalcon\Escaper\EscaperInterface |

Phalcon\Html\Helper\AbstractHelper

Abstract class for all HTML helpers

## Properties

```php
/**
 * @var EscaperInterface
 */
protected escaper;

```

## Methods

Constructor

```php
public function __construct( EscaperInterface $escaper );
```

Keeps all the attributes sorted - same order all the tome

```php
protected function orderAttributes( array $overrides, array $attributes ): array;
```

Renders all the attributes

```php
protected function renderAttributes( array $attributes ): string;
```

Renders an element

```php
protected function renderElement( string $tag, array $attributes = [] ): string;
```

Renders an element

```php
protected function renderFullElement( string $tag, string $text, array $attributes = [], bool $raw = bool ): string;
```

Produces a self close tag i.e. <img />

```php
protected function selfClose( string $tag, array $attributes = [] ): string;
```

<h1 id="html-helper-anchor">Class Phalcon\Html\Helper\Anchor</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Anchor.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Anchor

Creates an anchor

## Methods

@var string href The href tag @var string text The text for the anchor @var array attributes Any additional attributes

```php
public function __invoke( string $href, string $text, array $attributes = [] ): string;
```

<h1 id="html-helper-anchorraw">Class Phalcon\Html\Helper\AnchorRaw</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/AnchorRaw.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\AnchorRaw

Creates a raw anchor

## Methods

@var string href The href tag @var string text The text for the anchor @var array attributes Any additional attributes

```php
public function __invoke( string $href, string $text, array $attributes = [] ): string;
```

<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Body.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Body

Creates a body tag

## Methods

@var array attributes Any additional attributes

```php
public function __invoke( array $attributes = [] ): string;
```

<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Button.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Button

Creates a button tag

## Methods

@var string text The text for the anchor @var array attributes Any additional attributes

```php
public function __invoke( string $text, array $attributes = [] ): string;
```

<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Close.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Close

Creates a closing tag

## Methods

```php
public function __invoke( string $tag ): string;
```

<h1 id="html-helper-element">Class Phalcon\Html\Helper\Element</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Element.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Address

Creates an element

## Methods

@var string tag The tag name @var string text The text for the anchor @var array attributes Any additional attributes

```php
public function __invoke( string $tag, string $text, array $attributes = [] ): string;
```

<h1 id="html-helper-elementraw">Class Phalcon\Html\Helper\ElementRaw</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/ElementRaw.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\ElementRaw

Creates an element raw

## Methods

```php
public function __invoke( string $tag, string $text, array $attributes = [] ): string;
```

<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Form.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Form

Creates a form opening tag

## Methods

@var array attributes Any additional attributes

```php
public function __invoke( array $attributes = [] ): string;
```

<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Img.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\Img

Creates am img tag

## Methods

```php
public function __invoke( string $src, array $attributes = [] ): string;
```

<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/Label.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\Label

Creates a label

## Methods

```php
public function __invoke( array $attributes = [] ): string;
```

<h1 id="html-helper-textarea">Class Phalcon\Html\Helper\TextArea</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Helper/TextArea.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\TextArea

Creates a textarea tag

## Methods

@var string text The text for the anchor @var array attributes Any additional attributes

```php
public function __invoke( string $text, array $attributes = [] ): string;
```

<h1 id="html-link-evolvablelink">Class Phalcon\Html\Link\EvolvableLink</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Link/EvolvableLink.zep)

| Namespace | Phalcon\Html\Link | | Uses | Psr\Link\EvolvableLinkInterface | | Extends | Link | | Implements | EvolvableLinkInterface |

Class Phalcon\Http\Link\EvolvableLink

@property array attributes @property string href @property array rels @property bool templated

## Methods

Returns an instance with the specified attribute added.

If the specified attribute is already present, it will be overwritten with the new value.

```php
public function withAttribute( mixed $attribute, mixed $value );
```

Returns an instance with the specified href.

```php
public function withHref( mixed $href );
```

Returns an instance with the specified relationship included.

If the specified rel is already present, this method MUST return normally without errors, but without adding the rel a second time.

```php
public function withRel( mixed $rel );
```

Returns an instance with the specified attribute excluded.

If the specified attribute is not present, this method MUST return normally without errors.

```php
public function withoutAttribute( mixed $attribute );
```

Returns an instance with the specified relationship excluded.

If the specified rel is already not present, this method MUST return normally without errors.

```php
public function withoutRel( mixed $rel );
```

<h1 id="html-link-evolvablelinkprovider">Class Phalcon\Html\Link\EvolvableLinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Link/EvolvableLinkProvider.zep)

| Namespace | Phalcon\Html\Link | | Uses | Psr\Link\EvolvableLinkProviderInterface, Psr\Link\LinkInterface | | Extends | LinkProvider | | Implements | EvolvableLinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links

## Methods

Returns an instance with the specified link included.

If the specified link is already present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.

```php
public function withLink( LinkInterface $link );
```

Returns an instance with the specified link removed.

If the specified link is not present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.

```php
public function withoutLink( LinkInterface $link );
```

<h1 id="html-link-link">Class Phalcon\Html\Link\Link</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Link/Link.zep)

| Namespace | Phalcon\Html\Link | | Uses | Phalcon\Collection, Psr\Link\LinkInterface | | Implements | LinkInterface |

Class Phalcon\Http\Link\Link

@property array attributes @property string href @property array rels @property bool templated

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

Link constructor.

```php
public function __construct( string $rel = string, string $href = string, array $attributes = [] );
```

Returns a list of attributes that describe the target URI.

```php
public function getAttributes();
```

Returns the target of the link.

The target link must be one of:

- An absolute URI, as defined by RFC 5988.
- A relative URI, as defined by RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- A URI template as defined by RFC 6570.

If a URI template is returned, isTemplated() MUST return True.

```php
public function getHref();
```

Returns the relationship type(s) of the link.

This method returns 0 or more relationship types for a link, expressed as an array of strings.

```php
public function getRels();
```

Returns whether or not this is a templated link.

```php
public function isTemplated();
```

Determines if a href is a templated link or not.

@see https://tools.ietf.org/html/rfc6570

```php
protected function hrefIsTemplated( string $href ): bool;
```

<h1 id="html-link-linkprovider">Class Phalcon\Html\Link\LinkProvider</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Link/LinkProvider.zep)

| Namespace | Phalcon\Html\Link | | Uses | Psr\Link\LinkInterface, Psr\Link\LinkProviderInterface | | Implements | LinkProviderInterface |

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

LinkProvider constructor.

```php
public function __construct( array $links = [] );
```

Returns an iterable of LinkInterface objects.

The iterable may be an array or any PHP \Traversable object. If no links are available, an empty array or \Traversable MUST be returned.

```php
public function getLinks();
```

Returns an iterable of LinkInterface objects that have a specific relationship.

The iterable may be an array or any PHP \Traversable object. If no links with that relationship are available, an empty array or \Traversable MUST be returned.

```php
public function getLinksByRel( mixed $rel );
```

Returns the object hash key

```php
protected function getKey( LinkInterface $link ): string;
```

<h1 id="html-link-serializer-header">Class Phalcon\Html\Link\Serializer\Header</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Link/Serializer/Header.zep)

| Namespace | Phalcon\Html\Link\Serializer | | Uses | Psr\Link\EvolvableLinkInterface | | Implements | SerializerInterface |

Class Phalcon\Http\Link\Serializer\Header

## Methods

Serializes all the passed links to a HTTP link header

```php
public function serialize( array $links ): string | null;
```

<h1 id="html-link-serializer-serializerinterface">Interface Phalcon\Html\Link\Serializer\SerializerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/Link/Serializer/SerializerInterface.zep)

| Namespace | Phalcon\Html\Link\Serializer |

Class Phalcon\Http\Link\Serializer\SerializerInterface

## Methods

Serializer method

```php
public function serialize( array $links ): string | null;
```

<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Html/TagFactory.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Escaper, Phalcon\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory | | Extends | AbstractFactory |

ServiceLocator implementation for Tag helpers

## Properties

```php
/**
 * @var EscaperInterface
 */
private escaper;

```

## Methods

TagFactory constructor.

```php
public function __construct( EscaperInterface $escaper, array $services = [] );
```

```php
public function newInstance( string $name ): mixed;
```

```php
protected function getAdapters(): array;
```