---
layout: default
language: 'de-de'
version: '4.0'
title: 'Phalcon\Tag'
---

* [Phalcon\Tag](#Tag)
* [Phalcon\Tag\Exception](#Tag_Exception)
* [Phalcon\Tag\Select](#Tag_Select)

<h1 id="Tag">Class Phalcon\Tag</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/tag.zep)

| Namespace | Phalcon | | Uses | Phalcon\Tag\Select, Phalcon\Tag\Exception, Phalcon\UrlInterface |

Phalcon\Tag is designed to simplify building of HTML tags. It provides a set of helpers to generate HTML in a dynamic way. This component is an abstract class that you can extend to add more helpers.

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
 * Framework Dispatcher
 */
protected static container;

/**
 * Pre-assigned values for components
 */
protected static displayValues;

//
protected static dispatcherService;

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

```php
static final protected function inputField( string $type, mixed $parameters, bool $asValue = bool ): string;
```

Builds generic INPUT tags

@param array parameters

```php
static final protected function inputFieldChecked( string $type, mixed $parameters ): string;
```

Builds INPUT tags that implements the checked attribute

@param array parameters

<h1 id="Tag_Exception">Class Phalcon\Tag\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/tag/exception.zep)

| Namespace | Phalcon\Tag | | Extends | \Phalcon\Exception |

Phalcon\Tag\Exception

Exceptions thrown in Phalcon\Tag will use this class

<h1 id="Tag_Select">Abstract Class Phalcon\Tag\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/tag/select.zep)

| Namespace | Phalcon\Tag | | Uses | Phalcon\Tag\Exception, Phalcon\Tag, Phalcon\EscaperInterface, Phalcon\Mvc\Model\ResulsetInterface |

Phalcon\Tag\Select

Generates a SELECT html tag using a static array of values or a Phalcon\Mvc\Model resultset