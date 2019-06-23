---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Assets'
---

* [Phalcon\Assets\Asset](#Assets_Asset)
* [Phalcon\Assets\Asset\Css](#Assets_Asset_Css)
* [Phalcon\Assets\Asset\Js](#Assets_Asset_Js)
* [Phalcon\Assets\AssetInterface](#Assets_AssetInterface)
* [Phalcon\Assets\Collection](#Assets_Collection)
* [Phalcon\Assets\Exception](#Assets_Exception)
* [Phalcon\Assets\FilterInterface](#Assets_FilterInterface)
* [Phalcon\Assets\Filters\CssMin](#Assets_Filters_CssMin)
* [Phalcon\Assets\Filters\JsMin](#Assets_Filters_JsMin)
* [Phalcon\Assets\Filters\None](#Assets_Filters_None)
* [Phalcon\Assets\Inline](#Assets_Inline)
* [Phalcon\Assets\Inline\Css](#Assets_Inline_Css)
* [Phalcon\Assets\Inline\Js](#Assets_Inline_Js)
* [Phalcon\Assets\Manager](#Assets_Manager)

<h1 id="Assets_Asset">Class Phalcon\Assets\Asset</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/asset.zep)

| Namespace | Phalcon\Assets | | Implements | AssetInterface |

Represents an asset asset

```php
$asset = new \Phalcon\Assets\Asset("js", "javascripts/jquery.js");
```

## Properties

```php
/**
 * @var array | null
 */
protected attributes;

/**
 * @var bool
 */
protected autoVersion = false;

/**
 * @var bool
 */
protected filter;

/**
 * @var bool
 */
protected local;

/**
 * @var string
 */
protected path;

/**
 * @var string
 */
protected sourcePath;

/**
 * @var string
 */
protected targetPath;

/**
 * @var string
 */
protected targetUri;

/**
 * @var string
 */
protected type;

/**
     * Version of resource
     * @var string
     */
protected version;

```

## Methods

```php
public function __construct( string $type, string $path, bool $local = true, bool $filter = true, array $attributes, string $version, bool $autoVersion = false ): void;
```

Phalcon\Assets\Asset constructor

```php
public function getAssetKey(): string;
```

Gets the asset's key.

```php
public function getAttributes(): array | null
```

```php
public function getContent( string $basePath ): string;
```

Returns the content of the asset as an string Optionally a base path where the asset is located can be set

```php
public function getFilter(): bool
```

```php
public function getLocal(): bool
```

```php
public function getPath(): string
```

```php
public function getRealSourcePath( string $basePath ): string;
```

Returns the complete location where the asset is located

```php
public function getRealTargetPath( string $basePath ): string;
```

Returns the complete location where the asset must be written

```php
public function getRealTargetUri(): string;
```

Returns the real target uri for the generated HTML

```php
public function getSourcePath(): string
```

```php
public function getTargetPath(): string
```

```php
public function getTargetUri(): string
```

```php
public function getType(): string
```

```php
public function getVersion():   string
```

```php
public function isAutoVersion(): bool;
```

Checks if resource is using auto version

```php
public function setAttributes( array $attributes ): AssetInterface;
```

Sets extra HTML attributes

```php
public function setAutoVersion( bool $autoVersion )
```

```php
public function setFilter( bool $filter ): AssetInterface;
```

Sets if the asset must be filtered or not

```php
public function setLocal( bool $local ): AssetInterface;
```

Sets if the asset is local or external

```php
public function setPath( string $path ): AssetInterface;
```

Sets the asset's path

```php
public function setSourcePath( string $sourcePath ): AssetInterface;
```

Sets the asset's source path

```php
public function setTargetPath( string $targetPath ): AssetInterface;
```

Sets the asset's target path

```php
public function setTargetUri( string $targetUri ): AssetInterface;
```

Sets a target uri for the generated HTML

```php
public function setType( string $type ): AssetInterface;
```

Sets the asset's type

```php
public function setVersion(     string $version )
```

<h1 id="Assets_Asset_Css">Class Phalcon\Assets\Asset\Css</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/asset/css.zep)

| Namespace | Phalcon\Assets\Asset | | Uses | Phalcon\Assets\Asset | | Extends | AssetBase |

Represents CSS assets

## Methods

```php
public function __construct( string $path, bool $local = true, bool $filter = true, array $attributes, string $version, bool $autoVersion = false ): void;
```

Phalcon\Assets\Asset\Css constructor

<h1 id="Assets_Asset_Js">Class Phalcon\Assets\Asset\Js</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/asset/js.zep)

| Namespace | Phalcon\Assets\Asset | | Uses | Phalcon\Assets\Asset | | Extends | AssetBase |

Represents Javascript assets

## Methods

```php
public function __construct( string $path, bool $local = true, bool $filter = true, array $attributes, string $version, bool $autoVersion = false ): void;
```

Phalcon\Assets\Asset\Js constructor

<h1 id="Assets_AssetInterface">Interface Phalcon\Assets\AssetInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/assetinterface.zep)

| Namespace | Phalcon\Assets |

Interface for custom Phalcon\Assets reources

## Methods

```php
public function getAssetKey(): string;
```

Gets the asset's key.

```php
public function getAttributes(): array | null;
```

Gets extra HTML attributes.

```php
public function getFilter(): bool;
```

Gets if the asset must be filtered or not.

```php
public function getType(): string;
```

Gets the asset's type.

```php
public function setAttributes( array $attributes ): AssetInterface;
```

Sets extra HTML attributes.

```php
public function setFilter( bool $filter ): AssetInterface;
```

Sets if the asset must be filtered or not.

```php
public function setType( string $type ): AssetInterface;
```

Sets the asset's type.

<h1 id="Assets_Collection">Class Phalcon\Assets\Collection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

| Namespace | Phalcon\Assets | | Uses | Phalcon\Assets\Asset, Phalcon\Assets\FilterInterface, Phalcon\Assets\Inline, Phalcon\Assets\Asset\Css, Phalcon\Assets\Asset\Js, Phalcon\Assets\Inline\Js, Phalcon\Assets\Inline\Css | | Implements | \Countable, \Iterator |

Represents a collection of assets

## Properties

```php
/**
 * @var array
 */
protected assets;

/**
 * @var array
 */
protected attributes;

/**
     * Should version be determined from file modification time
     * @var bool
     */
protected autoVersion = false;

/**
 * @var array
 */
protected codes;

/**
 * @var array
 */
protected filters;

/**
 * @var array
 */
protected includedAssets;

/**
 * @var bool
 */
protected join = true;

/**
 * @var bool
 */
protected local = true;

/**
 * @var string
 */
protected prefix;

/**
 * @var int
 */
protected position;

/**
 * @var string
 */
protected sourcePath;

/**
 * @var bool
 */
protected targetLocal = true;

/**
 * @var string
 */
protected targetPath;

/**
 * @var string
 */
protected targetUri;

/**
     * Version of resource
     * @var string
     */
protected version;

```

## Methods

```php
public function __construct(): void;
```

Phalcon\Assets\Collection constructor

```php
public function add( mixed $asset ): Collection;
```

Adds a asset to the collection

```php
public function addCss( string $path, mixed $local, bool $filter = true, mixed $attributes, string $version, bool $autoVersion = false ): Collection;
```

Adds a CSS asset to the collection

```php
public function addFilter( mixed $filter ): Collection;
```

Adds a filter to the collection

```php
public function addInline( mixed $code ): Collection;
```

Adds an inline code to the collection

```php
public function addInlineCss( string $content, bool $filter = true, mixed $attributes ): Collection;
```

Adds an inline CSS to the collection

```php
public function addInlineJs( string $content, bool $filter = true, mixed $attributes ): Collection;
```

Adds an inline javascript to the collection

```php
public function addJs( string $path, mixed $local, bool $filter = true, mixed $attributes, string $version, bool $autoVersion = false ): Collection;
```

Adds a javascript asset to the collection

@param array attributes

```php
public function count(): int;
```

Returns the number of elements in the form

```php
public function current(): Asset;
```

Returns the current asset in the iterator

```php
public function getAssets(): array
```

```php
public function getAttributes(): array
```

```php
public function getCodes(): array
```

```php
public function getFilters(): array
```

```php
public function getJoin(): bool
```

```php
public function getLocal(): bool
```

```php
public function getPosition(): int
```

```php
public function getPrefix(): string
```

```php
public function getRealTargetPath( string $basePath ): string;
```

Returns the complete location where the joined/filtered collection must be written

```php
public function getSourcePath(): string
```

```php
public function getTargetLocal(): bool
```

```php
public function getTargetPath(): string
```

```php
public function getTargetUri(): string
```

```php
public function getVersion():   string
```

```php
public function has( mixed $asset ): bool;
```

Checks this the asset is added to the collection.

```php
use Phalcon\Assets\Asset;
use Phalcon\Assets\Collection;

$collection = new Collection();

$asset = new Asset("js", "js/jquery.js");

$collection->add($asset);
$collection->has($asset); // true
```

```php
public function isAutoVersion(): bool;
```

Checks if collection is using auto version

```php
public function join( bool $join ): Collection;
```

Sets if all filtered assets in the collection must be joined in a single result file

```php
public function key(): int;
```

Returns the current position/key in the iterator

```php
public function next(): void;
```

Moves the internal iteration pointer to the next position

```php
public function rewind(): void;
```

Rewinds the internal iterator

```php
public function setAttributes( array $attributes ): Collection;
```

Sets extra HTML attributes

```php
public function setAutoVersion(     bool $autoVersion )
```

```php
public function setFilters( array $filters ): Collection;
```

Sets an array of filters in the collection

```php
public function setLocal( bool $local ): Collection;
```

Sets if the collection uses local assets by default

```php
public function setPrefix( string $prefix ): Collection;
```

Sets a common prefix for all the assets

```php
public function setSourcePath( string $sourcePath ): Collection;
```

Sets a base source path for all the assets in this collection

```php
public function setTargetLocal( bool $targetLocal ): Collection;
```

Sets the target local

```php
public function setTargetPath( string $targetPath ): Collection;
```

Sets the target path of the file for the filtered/join output

```php
public function setTargetUri( string $targetUri ): Collection;
```

Sets a target uri for the generated HTML

```php
public function setVersion(     string $version )
```

```php
public function valid(): bool;
```

Check if the current element in the iterator is valid

```php
final protected function addAsset( mixed $asset ): bool;
```

Adds a asset or inline-code to the collection

<h1 id="Assets_Exception">Class Phalcon\Assets\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/exception.zep)

| Namespace | Phalcon\Assets | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Assets will use this class

<h1 id="Assets_FilterInterface">Interface Phalcon\Assets\FilterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filterinterface.zep)

| Namespace | Phalcon\Assets |

Interface for custom Phalcon\Assets filters

## Methods

```php
public function filter( string $content ): string;
```

Filters the content returning a string with the filtered content

<h1 id="Assets_Filters_CssMin">Class Phalcon\Assets\Filters\Cssmin</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/cssmin.zep)

| Namespace | Phalcon\Assets\Filters | | Uses | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Minify the css - removes comments removes newlines and line feeds keeping removes last semicolon from last property

## Methods

```php
public function filter( string $content ): string;
```

Filters the content using CSSMIN NOTE: This functionality is not currently available

<h1 id="Assets_Filters_JsMin">Class Phalcon\Assets\Filters\Jsmin</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

| Namespace | Phalcon\Assets\Filters | | Uses | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Deletes the characters which are insignificant to JavaScript. Comments will be removed. Tabs will be replaced with spaces. Carriage returns will be replaced with linefeeds. Most spaces and linefeeds will be removed.

## Methods

```php
public function filter( string $content ): string;
```

Filters the content using JSMIN NOTE: This functionality is not currently available

<h1 id="Assets_Filters_None">Class Phalcon\Assets\Filters\None</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/none.zep)

| Namespace | Phalcon\Assets\Filters | | Uses | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Returns the content without make any modification to the original source

## Methods

```php
public function filter( string $content ): string;
```

Returns the content as is

<h1 id="Assets_Inline">Class Phalcon\Assets\Inline</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

| Namespace | Phalcon\Assets | | Implements | AssetInterface |

Represents an inline asset

```php
$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");
```

## Properties

```php
/**
 * @var array | null
 */
protected attributes;

/**
 * @var string
 */
protected content;

/**
 * @var bool
 */
protected filter;

/**
 * @var string
 */
protected type;

```

## Methods

```php
public function __construct( string $type, string $content, bool $filter = true, array $attributes ): void;
```

Phalcon\Assets\Inline constructor

```php
public function getAssetKey(): string;
```

Gets the asset's key.

```php
public function getAttributes(): array | null
```

```php
public function getContent(): string
```

```php
public function getFilter(): bool
```

```php
public function getType(): string
```

```php
public function setAttributes( array $attributes ): AssetInterface;
```

Sets extra HTML attributes

```php
public function setFilter( bool $filter ): AssetInterface;
```

Sets if the asset must be filtered or not

```php
public function setType( string $type ): AssetInterface;
```

Sets the inline's type

<h1 id="Assets_Inline_Css">Class Phalcon\Assets\Inline\Css</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline/css.zep)

| Namespace | Phalcon\Assets\Inline | | Uses | Phalcon\Assets\Inline | | Extends | InlineBase |

Represents an inlined CSS

## Methods

```php
public function __construct( string $content, bool $filter = true, mixed $attributes ): void;
```

Phalcon\Assets\Inline\Css constructor

<h1 id="Assets_Inline_Js">Class Phalcon\Assets\Inline\Js</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline/js.zep)

| Namespace | Phalcon\Assets\Inline | | Uses | Phalcon\Assets\Inline | | Extends | InlineBase |

Represents an inline JavaScript

## Methods

```php
public function __construct( string $content, bool $filter = true, mixed $attributes ): void;
```

Phalcon\Assets\Inline\Js constructor

<h1 id="Assets_Manager">Class Phalcon\Assets\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/manager.zep)

| Namespace | Phalcon\Assets | | Uses | Phalcon\Tag, Phalcon\Assets\Asset, Phalcon\Assets\Collection, Phalcon\Assets\Exception, Phalcon\Assets\Asset\Js, Phalcon\Assets\Asset\Css, Phalcon\Assets\Inline\Css, Phalcon\Assets\Inline\Js, Phalcon\DiInterface, Phalcon\Di\InjectionAwareInterface | | Implements | InjectionAwareInterface |

Phalcon\Assets\Manager

Manages collections of CSS/Javascript assets

## Properties

```php
//
protected collections;

/**
 * @var DiInterface
 */
protected container;

/**
 * Options configure
 * @var array
 */
protected options;

/**
 * @var bool
 */
protected implicitOutput = true;

```

## Methods

```php
public function __construct( array $options ): void;
```

Phalcon\Assets\Manager constructor

```php
public function addAsset( mixed $asset ): Manager;
```

Adds a raw asset to the manager

```php
$assets->addAsset(
    new Phalcon\Assets\Asset("css", "css/style.css")
);
```

```php
public function addAssetByType( string $type, mixed $asset ): Manager;
```

Adds a asset by its type

```php
$assets->addAssetByType(
    "css",
    new \Phalcon\Assets\Asset\Css("css/style.css")
);
```

```php
public function addCss( string $path, mixed $local = true, bool $filter = true, mixed $attributes, string $version, bool $autoVersion = false ): Manager;
```

Adds a Css asset to the 'css' collection

   ```php
   $assets->addCss("css/bootstrap.css");
   $assets->addCss("http://bootstrap.my-cdn.com/style.css", false);
   ```

```php
public function addInlineCode( mixed $code ): Manager;
```

Adds a raw inline code to the manager

```php
public function addInlineCodeByType( string $type, mixed $code ): Manager;
```

Adds an inline code by its type

```php
public function addInlineCss( string $content, mixed $filter = true, mixed $attributes ): Manager;
```

Adds an inline Css to the 'css' collection

```php
public function addInlineJs( string $content, mixed $filter = true, mixed $attributes ): Manager;
```

Adds an inline javascript to the 'js' collection

```php
public function addJs( string $path, mixed $local = true, bool $filter = true, mixed $attributes, string $version, bool $autoVersion = false ): Manager;
```

Adds a javascript asset to the 'js' collection

```php
$assets->addJs("scripts/jquery.js");
$assets->addJs("http://jquery.my-cdn.com/jquery.js", false);
```

```php
public function collection( string $name ): Collection;
```

Creates/Returns a collection of assets

```php
public function collectionAssetsByType( array $assets, string $type ): array;
```

Creates/Returns a collection of assets by type

```php
public function exists( string $id ): bool;
```

Returns true or false if collection exists.

```php
if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}
```

```php
public function get( string $id ): Collection;
```

Returns a collection by its id.

```php
$scripts = $assets->get("js");
```

```php
public function getCollections(): Collection[];
```

Returns existing collections in the manager

```php
public function getCss(): Collection;
```

Returns the CSS collection of assets

```php
public function getDI(): DiInterface;
```

Returns the internal dependency injector

```php
public function getJs(): Collection;
```

Returns the CSS collection of assets

```php
public function getOptions(): array;
```

Returns the manager options

```php
public function output( mixed $collection, mixed $callback, mixed $type ): string | null;
```

Traverses a collection calling the callback to generate its HTML

@param callback callback @param string type

```php
public function outputCss( string $collectionName ): string;
```

Prints the HTML for CSS assets

```php
public function outputInline( mixed $collection, mixed $type ): string;
```

Traverses a collection and generate its HTML

@param string type

```php
public function outputInlineCss( string $collectionName ): string;
```

Prints the HTML for inline CSS

```php
public function outputInlineJs( string $collectionName ): string;
```

Prints the HTML for inline JS

```php
public function outputJs( string $collectionName ): string;
```

Prints the HTML for JS assets

```php
public function set( string $id, mixed $collection ): Manager;
```

Sets a collection in the Assets Manager

```php
$assets->set("js", $collection);
```

```php
public function setDI( mixed $container ): void;
```

Sets the dependency injector

```php
public function setOptions( array $options ): Manager;
```

Sets the manager options

```php
public function useImplicitOutput( bool $implicitOutput ): Manager;
```

Sets if the HTML generated must be directly printed or returned