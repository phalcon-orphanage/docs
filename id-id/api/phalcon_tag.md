---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Tag'
---

* [Phalcon\Tag](#tag)
* [Phalcon\Tag\Exception](#tag-exception)
* [Phalcon\Tag\Select](#tag-select)

<h1 id="tag">Class Phalcon\Tag</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Tag.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\DiInterface, Phalcon\Escaper\EscaperInterface, Phalcon\Tag\Select, Phalcon\Tag\Exception, Phalcon\Url\UrlInterface |

Phalcon\Tag is designed to simplify building of HTML tags. It provides a set of helpers to generate HTML in a dynamic way. This component is a class that you can extend to add more helpers.

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
//
protected static autoEscape = true;

/**
 * DI Container
 */
protected static container;

/**
 * Pre-assigned values for components
 */
protected static displayValues;

//
protected static documentAppendTitle;

//
protected static documentPrependTitle;

/**
 * HTML document title
 */
protected static documentTitle;

//
protected static documentTitleSeparator;

//
protected static documentType = 11;

//
protected static escaperService;

//
protected static urlService;

```

## Methods

Appends a text to current document title

```php
public static function appendTitle( mixed $title ): void;
```

Builds a HTML input[type="check"] tag

```php
public static function checkField( mixed $parameters ): string;
```

Builds a HTML input[type="color"] tag

```php
public static function colorField( mixed $parameters ): string;
```

Builds a HTML input[type="date"] tag

```php
public static function dateField( mixed $parameters ): string;
```

Builds a HTML input[type="datetime"] tag

```php
public static function dateTimeField( mixed $parameters ): string;
```

Builds a HTML input[type="datetime-local"] tag

```php
public static function dateTimeLocalField( mixed $parameters ): string;
```

Alias of Phalcon\Tag::setDefault()

```php
public static function displayTo( string $id, mixed $value ): void;
```

Builds a HTML input[type="email"] tag

```php
public static function emailField( mixed $parameters ): string;
```

Builds a HTML close FORM tag

```php
public static function endForm(): string;
```

Builds a HTML input[type="file"] tag

```php
public static function fileField( mixed $parameters ): string;
```

Builds a HTML FORM tag

```php
public static function form( mixed $parameters ): string;
```

Converts texts into URL-friendly titles

```php
public static function friendlyTitle( string $text, string $separator = string, bool $lowercase = bool, mixed $replace = null ): string;
```

Internally gets the request dispatcher

```php
public static function getDI(): DiInterface;
```

Get the document type declaration of content

```php
public static function getDocType(): string;
```

Obtains the 'escaper' service if required

```php
public static function getEscaper( array $params ): EscaperInterface | null;
```

Returns an Escaper service from the default DI

```php
public static function getEscaperService(): EscaperInterface;
```

Gets the current document title. The title will be automatically escaped.

```php
public static function getTitle( bool $prepend = bool, bool $append = bool ): string;
```

Gets the current document title separator

```php
public static function getTitleSeparator(): string;
```

Returns a URL service from the default DI

```php
public static function getUrlService(): UrlInterface;
```

Every helper calls this function to check whether a component has a predefined value using Phalcon\Tag::setDefault() or value from $_POST

```php
public static function getValue( mixed $name, array $params = [] );
```

Check if a helper has a default value set using Phalcon\Tag::setDefault() or value from $_POST

```php
public static function hasValue( mixed $name ): bool;
```

Builds a HTML input[type="hidden"] tag

```php
public static function hiddenField( mixed $parameters ): string;
```

Builds HTML IMG tags

```php
public static function image( mixed $parameters = null, bool $local = bool ): string;
```

Builds a HTML input[type="image"] tag

```php
public static function imageInput( mixed $parameters ): string;
```

Builds a SCRIPT[type="javascript"] tag

```php
public static function javascriptInclude( mixed $parameters = null, bool $local = bool ): string;
```

Builds a HTML A tag using framework conventions

```php
public static function linkTo( mixed $parameters, mixed $text = null, mixed $local = bool ): string;
```

Builds a HTML input[type="month"] tag

```php
public static function monthField( mixed $parameters ): string;
```

Builds a HTML input[type="number"] tag

```php
public static function numericField( mixed $parameters ): string;
```

Builds a HTML input[type="password"] tag

```php
public static function passwordField( mixed $parameters ): string;
```

Prepends a text to current document title

```php
public static function prependTitle( mixed $title ): void;
```

Builds a HTML input[type="radio"] tag

```php
public static function radioField( mixed $parameters ): string;
```

Builds a HTML input[type="range"] tag

```php
public static function rangeField( mixed $parameters ): string;
```

Renders parameters keeping order in their HTML attributes

```php
public static function renderAttributes( string $code, array $attributes ): string;
```

Renders the title with title tags. The title is automatically escaped

```php
public static function renderTitle( bool $prepend = bool, bool $append = bool ): string;
```

Resets the request and internal values to avoid those fields will have any default value.

@deprecated Will be removed in 4.0.0

```php
deprecated public static function resetInput(): void;
```

Builds a HTML input[type="search"] tag

```php
public static function searchField( mixed $parameters ): string;
```

Builds a HTML SELECT tag using a Phalcon\Mvc\Model resultset as options

```php
public static function select( mixed $parameters, mixed $data = null ): string;
```

Builds a HTML SELECT tag using a PHP array for options

```php
public static function selectStatic( mixed $parameters, mixed $data = null ): string;
```

Set autoescape mode in generated HTML

```php
public static function setAutoescape( bool $autoescape ): void;
```

Sets the dependency injector container.

```php
public static function setDI( DiInterface $container ): void;
```

Assigns default values to generated tags by helpers

```php
public static function setDefault( string $id, mixed $value ): void;
```

Assigns default values to generated tags by helpers

```php
public static function setDefaults( array $values, bool $merge = bool ): void;
```

Set the document type of content

```php
public static function setDocType( int $doctype ): void;
```

Set the title of view content

```php
public static function setTitle( string $title ): void;
```

Set the title separator of view content

```php
public static function setTitleSeparator( string $titleSeparator ): void;
```

Builds a LINK[rel="stylesheet"] tag

```php
public static function stylesheetLink( mixed $parameters = null, bool $local = bool ): string;
```

Builds a HTML input[type="submit"] tag

```php
public static function submitButton( mixed $parameters ): string;
```

Builds a HTML tag

```php
public static function tagHtml( string $tagName, mixed $parameters = null, bool $selfClose = bool, bool $onlyStart = bool, bool $useEol = bool ): string;
```

Builds a HTML tag closing tag

```php
public static function tagHtmlClose( string $tagName, bool $useEol = bool ): string;
```

Builds a HTML input[type="tel"] tag

```php
public static function telField( mixed $parameters ): string;
```

Builds a HTML TEXTAREA tag

@paraym array parameters = [ 'id' => '', 'name' => '', 'value' => '', 'class' => '' ]

```php
public static function textArea( mixed $parameters ): string;
```

Builds a HTML input[type="text"] tag

```php
public static function textField( mixed $parameters ): string;
```

Builds a HTML input[type="time"] tag

```php
public static function timeField( mixed $parameters ): string;
```

Builds a HTML input[type="url"] tag

```php
public static function urlField( mixed $parameters ): string;
```

Builds a HTML input[type="week"] tag

```php
public static function weekField( mixed $parameters ): string;
```

Builds generic INPUT tags

```php
static final protected function inputField( string $type, mixed $parameters, bool $asValue = bool ): string;
```

Builds INPUT tags that implements the checked attribute

```php
static final protected function inputFieldChecked( string $type, mixed $parameters ): string;
```

<h1 id="tag-exception">Class Phalcon\Tag\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Tag/Exception.zep)

| Namespace | Phalcon\Tag | | Extends | \Phalcon\Exception |

Phalcon\Tag\Exception

Exceptions thrown in Phalcon\Tag will use this class

<h1 id="tag-select">Abstract Class Phalcon\Tag\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Tag/Select.zep)

| Namespace | Phalcon\Tag | | Uses | Phalcon\Tag, Phalcon\Escaper\EscaperInterface, Phalcon\Mvc\Model\ResultsetInterface |

Phalcon\Tag\Select

Generates a SELECT HTML tag using a static array of values or a Phalcon\Mvc\Model resultset

## Methods

Generates a SELECT tag

```php
public static function selectField( mixed $parameters, mixed $data = null ): string;
```