---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/attributes.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Collection, Phalcon\Html\Attributes\RenderInterface, Phalcon\Tag | | Extends | Collection | | Implements | RenderInterface |

This class helps to work with HTML Attributes

## Métodos

```php
public function __toString(): string;
```

Alias of the render method

```php
public function render(): string;
```

Render attributes as HTML attributes

<h1 id="html-attributes-attributesinterface">Interface Phalcon\Html\Attributes\AttributesInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/attributes/attributesinterface.zep)

| Namespace | Phalcon\Html\Attributes | | Uses | Phalcon\Html\Attributes |

- Phalcon\Html\Attributes\AttributesInterface
- 
- Interface Phalcon\Html\Attributes\AttributesInterface */

## Métodos

```php
public function getAttributes(): Attributes;
```

Get Attributes

```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```

Set Attributes

<h1 id="html-attributes-renderinterface">Interface Phalcon\Html\Attributes\RenderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/attributes/renderinterface.zep)

| Namespace | Phalcon\Html\Attributes |

- Phalcon\Html\Attributes\RenderInterface
- 
- Interface Phalcon\Html\Attributes\RenderInterface */

## Métodos

```php
public function render(): string;
```

Generate a string represetation

<h1 id="html-breadcrumbs">Class Phalcon\Html\Breadcrumbs</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/breadcrumbs.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Di\DiInterface |

Phalcon\Html\Breadcrumbs

This component offers an easy way to create breadcrumbs for your application. The resulting HTML when calling `render()` will have each breadcrumb enclosed in `<dt>` tags, while the whole string is enclosed in `<dl>` tags.

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/exception.zep)

| Namespace | Phalcon\Html | | Extends | \Phalcon\Exception |

Phalcon\Html\Tag\Exception

Exceptions thrown in Phalcon\Html\Tag will use this class

<h1 id="html-helper-abstracthelper">Abstract Class Phalcon\Html\Helper\AbstractHelper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/abstracthelper.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception, Phalcon\Escaper\EscaperInterface |

Phalcon\Html\Helper\AbstractHelper

Abstract class for all html helpers

## Propiedades

```php
/**
 * @var EscaperInterface
 */
protected escaper;

```

## Métodos

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/anchor.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Anchor

Creates an anchor

## Métodos

```php
public function __invoke( string $href, string $text, array $attributes = [] ): string;
```

@var string href The href tag @var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-anchorraw">Class Phalcon\Html\Helper\AnchorRaw</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/anchorraw.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\AnchorRaw

Creates a raw anchor

## Métodos

```php
public function __invoke( string $href, string $text, array $attributes = [] ): string;
```

@var string href The href tag @var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-body">Class Phalcon\Html\Helper\Body</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/body.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Body

Creates a body tag

## Métodos

```php
public function __invoke( array $attributes = [] ): string;
```

@var array attributes Any additional attributes

<h1 id="html-helper-button">Class Phalcon\Html\Helper\Button</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/button.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Button

Creates a button tag

## Métodos

```php
public function __invoke( string $text, array $attributes = [] ): string;
```

@var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-close">Class Phalcon\Html\Helper\Close</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/close.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Close

Creates a closing tag

## Métodos

```php
public function __invoke( string $tag ): string;
```

@return string

<h1 id="html-helper-element">Class Phalcon\Html\Helper\Element</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/element.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Address

Creates an element

## Métodos

```php
public function __invoke( string $tag, string $text, array $attributes = [] ): string;
```

@var string tag The tag name @var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-helper-elementraw">Class Phalcon\Html\Helper\ElementRaw</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/elementraw.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\ElementRaw

Creates an element raw

## Métodos

```php
public function __invoke( string $tag, string $text, array $attributes = [] ): string;
```

@return string @throws Exception

<h1 id="html-helper-form">Class Phalcon\Html\Helper\Form</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/form.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\Form

Creates a form opening tag

## Métodos

```php
public function __invoke( array $attributes = [] ): string;
```

@var array attributes Any additional attributes

<h1 id="html-helper-img">Class Phalcon\Html\Helper\Img</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/img.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\Img

Creates am img tag

## Métodos

```php
public function __invoke( string $src, array $attributes = [] ): string;
```

@return string @throws Exception

<h1 id="html-helper-label">Class Phalcon\Html\Helper\Label</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/label.zep)

| Namespace | Phalcon\Html\Helper | | Uses | Phalcon\Html\Exception | | Extends | AbstractHelper |

Phalcon\Html\Helper\Label

Creates a label

## Métodos

```php
public function __invoke( array $attributes = [] ): string;
```

@return string @throws Exception

<h1 id="html-helper-textarea">Class Phalcon\Html\Helper\TextArea</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/helper/textarea.zep)

| Namespace | Phalcon\Html\Helper | | Extends | AbstractHelper |

Phalcon\Html\Helper\TextArea

Creates a textarea tag

## Métodos

```php
public function __invoke( string $text, array $attributes = [] ): string;
```

@var string text The text for the anchor @var array attributes Any additional attributes

<h1 id="html-link-evolvablelink">Class Phalcon\Html\Link\EvolvableLink</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/link/evolvablelink.zep)

| Namespace | Phalcon\Html\Link | | Uses | Psr\Link\EvolvableLinkInterface | | Extends | Link | | Implements | EvolvableLinkInterface |

Class Phalcon\Http\Link\EvolvableLink

@property array attributes @property string href @property array rels @property bool templated

## Métodos

```php
public function withAttribute( mixed $attribute, mixed $value );
```

Returns an instance with the specified attribute added.

If the specified attribute is already present, it will be overwritten with the new value.

@return static

```php
public function withHref( mixed $href );
```

Returns an instance with the specified href.

      The href value to include.  It must be one of:
    
      - An absolute URI, as defined by RFC 5988.
      - A relative URI, as defined by RFC 5988. The base of the relative
      link is assumed to be known based on context by the client.
      - A URI template as defined by RFC 6570.
      - An object implementing __toString() that produces one of the
      above values.
    

An implementing library SHOULD evaluate a passed object to a string immediately rather than waiting for it to be returned later.

@return static

```php
public function withRel( mixed $rel );
```

Returns an instance with the specified relationship included.

If the specified rel is already present, this method MUST return normally without errors, but without adding the rel a second time.

The relationship value to add.

@return static

```php
public function withoutAttribute( mixed $attribute );
```

Returns an instance with the specified attribute excluded.

If the specified attribute is not present, this method MUST return normally without errors.

The attribute to remove.

@return static

```php
public function withoutRel( mixed $rel );
```

Returns an instance with the specified relationship excluded.

If the specified rel is already not present, this method MUST return normally without errors.

The relationship value to exclude.

@return static

<h1 id="html-link-evolvablelinkprovider">Class Phalcon\Html\Link\EvolvableLinkProvider</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/link/evolvablelinkprovider.zep)

| Namespace | Phalcon\Html\Link | | Uses | Psr\Link\EvolvableLinkProviderInterface, Psr\Link\LinkInterface | | Extends | LinkProvider | | Implements | EvolvableLinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links

## Métodos

```php
public function withLink( LinkInterface $link );
```

Returns an instance with the specified link included.

If the specified link is already present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.

A link object that should be included in this collection.

@return static

```php
public function withoutLink( LinkInterface $link );
```

Returns an instance with the specified link removed.

If the specified link is not present, this method MUST return normally without errors. The link is present if link is === identical to a link object already in the collection.

The link to remove.

@return static

<h1 id="html-link-link">Class Phalcon\Html\Link\Link</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/link/link.zep)

| Namespace | Phalcon\Html\Link | | Uses | Phalcon\Collection, Psr\Link\LinkInterface | | Implements | LinkInterface |

Class Phalcon\Http\Link\Link

@property array attributes @property string href @property array rels @property bool templated

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

Link constructor.

```php
public function getAttributes();
```

Returns a list of attributes that describe the target URI.

@return array A key-value list of attributes, where the key is a string and the value is either a PHP primitive or an array of PHP strings. If no values are found an empty array MUST be returned.

```php
public function getHref();
```

Returns the target of the link.

The target link must be one of:

- An absolute URI, as defined by RFC 5988.
- A relative URI, as defined by RFC 5988. The base of the relative link is assumed to be known based on context by the client.
- A URI template as defined by RFC 6570.

If a URI template is returned, isTemplated() MUST return True.

@return string

```php
public function getRels();
```

Returns the relationship type(s) of the link.

This method returns 0 or more relationship types for a link, expressed as an array of strings.

@return string[]

```php
public function isTemplated();
```

Returns whether or not this is a templated link.

@return bool True if this link object is templated, False otherwise.

```php
protected function hrefIsTemplated( string $href ): bool;
```

Determines if a href is a templated link or not.

@see https://tools.ietf.org/html/rfc6570

@return bool

<h1 id="html-link-linkprovider">Class Phalcon\Html\Link\LinkProvider</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/link/linkprovider.zep)

| Namespace | Phalcon\Html\Link | | Uses | Psr\Link\LinkInterface, Psr\Link\LinkProviderInterface | | Implements | LinkProviderInterface |

Class Phalcon\Http\Link\LinkProvider

@property LinkInterface[] links

## Propiedades

```php
/**
 * @var LinkInterface[]
 */
protected links;

```

## Métodos

```php
public function __construct( array $links = [] );
```

LinkProvider constructor.

```php
public function getLinks();
```

Returns an iterable of LinkInterface objects.

The iterable may be an array or any PHP \Traversable object. If no links are available, an empty array or \Traversable MUST be returned.

@return LinkInterface[]|\Traversable

```php
public function getLinksByRel( mixed $rel );
```

Returns an iterable of LinkInterface objects that have a specific relationship.

The iterable may be an array or any PHP \Traversable object. If no links with that relationship are available, an empty array or \Traversable MUST be returned.

@return LinkInterface[]|Traversable

```php
protected function getKey( LinkInterface $link ): string;
```

Returns the object hash key

@return string

<h1 id="html-link-serializer-header">Class Phalcon\Html\Link\Serializer\Header</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/link/serializer/header.zep)

| Namespace | Phalcon\Html\Link\Serializer | | Uses | Psr\Link\EvolvableLinkInterface | | Implements | SerializerInterface |

Class Phalcon\Http\Link\Serializer\Header

## Métodos

```php
public function serialize( array $links ): string | null;
```

Serializes all the passed links to a HTTP link header

<h1 id="html-link-serializer-serializerinterface">Interface Phalcon\Html\Link\Serializer\SerializerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/link/serializer/serializerinterface.zep)

| Namespace | Phalcon\Html\Link\Serializer |

Class Phalcon\Http\Link\Serializer\SerializerInterface

## Métodos

```php
public function serialize( array $links ): string | null;
```

Serializer method

<h1 id="html-tagfactory">Class Phalcon\Html\TagFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/html/tagfactory.zep)

| Namespace | Phalcon\Html | | Uses | Phalcon\Escaper, Phalcon\Escaper\EscaperInterface, Phalcon\Factory\AbstractFactory | | Extends | AbstractFactory |

ServiceLocator implementation for Tag helpers

## Propiedades

```php
/**
 * @var EscaperInterface
 */
private escaper;

```

## Métodos

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