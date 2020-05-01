---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Assets'
---

* [Phalcon\Assets\Asset](#assets-asset)
* [Phalcon\Assets\Asset\Css](#assets-asset-css)
* [Phalcon\Assets\Asset\Js](#assets-asset-js)
* [Phalcon\Assets\AssetInterface](#assets-assetinterface)
* [Phalcon\Assets\Collection](#assets-collection)
* [Phalcon\Assets\Exception](#assets-exception)
* [Phalcon\Assets\FilterInterface](#assets-filterinterface)
* [Phalcon\Assets\Filters\CssMin](#assets-filters-cssmin)
* [Phalcon\Assets\Filters\JsMin](#assets-filters-jsmin)
* [Phalcon\Assets\Filters\None](#assets-filters-none)
* [Phalcon\Assets\Inline](#assets-inline)
* [Phalcon\Assets\Inline\Css](#assets-inline-css)
* [Phalcon\Assets\Inline\Js](#assets-inline-js)
* [Phalcon\Assets\Manager](#assets-manager)

<h1 id="assets-asset">Class Phalcon\Assets\Asset</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset.zep)

| Namespace  | Phalcon\Assets |
| Implements | AssetInterface |

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

Phalcon\Assets\Asset constructor
```php
public function __construct( string $type, string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```

Gets the asset's key.
```php
public function getAssetKey(): string;
```


```php
public function getAttributes(): array | null
```

Returns the content of the asset as an string
Optionally a base path where the asset is located can be set
```php
public function getContent( string $basePath = null ): string;
```


```php
public function getFilter(): bool
```


```php
public function getLocal(): bool
```


```php
public function getPath(): string
```

Returns the complete location where the asset is located
```php
public function getRealSourcePath( string $basePath = null ): string;
```

Returns the complete location where the asset must be written
```php
public function getRealTargetPath( string $basePath = null ): string;
```

Returns the real target uri for the generated HTML
```php
public function getRealTargetUri(): string;
```


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
public function getVersion(): 	string
```

Checks if resource is using auto version
```php
public function isAutoVersion(): bool;
```

Sets extra HTML attributes
```php
public function setAttributes( array $attributes ): AssetInterface;
```


```php
public function setAutoVersion( bool $autoVersion )
```

Sets if the asset must be filtered or not
```php
public function setFilter( bool $filter ): AssetInterface;
```

Sets if the asset is local or external
```php
public function setLocal( bool $local ): AssetInterface;
```

Sets the asset's path
```php
public function setPath( string $path ): AssetInterface;
```

Sets the asset's source path
```php
public function setSourcePath( string $sourcePath ): AssetInterface;
```

Sets the asset's target path
```php
public function setTargetPath( string $targetPath ): AssetInterface;
```

Sets a target uri for the generated HTML
```php
public function setTargetUri( string $targetUri ): AssetInterface;
```

Sets the asset's type
```php
public function setType( string $type ): AssetInterface;
```


```php
public function setVersion( 	string $version )
```



<h1 id="assets-asset-css">Class Phalcon\Assets\Asset\Css</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset/Css.zep)

| Namespace  | Phalcon\Assets\Asset |
| Uses       | Phalcon\Assets\Asset |
| Extends    | AssetBase |

Represents CSS assets


## Methods

Phalcon\Assets\Asset\Css constructor
```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```



<h1 id="assets-asset-js">Class Phalcon\Assets\Asset\Js</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset/Js.zep)

| Namespace  | Phalcon\Assets\Asset |
| Uses       | Phalcon\Assets\Asset |
| Extends    | AssetBase |

Represents JavaScript assets


## Methods

Phalcon\Assets\Asset\Js constructor
```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```



<h1 id="assets-assetinterface">Interface Phalcon\Assets\AssetInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/AssetInterface.zep)

| Namespace  | Phalcon\Assets |

Interface for custom Phalcon\Assets resources


## Methods

Gets the asset's key.
```php
public function getAssetKey(): string;
```

Gets extra HTML attributes.
```php
public function getAttributes(): array | null;
```

Gets if the asset must be filtered or not.
```php
public function getFilter(): bool;
```

Gets the asset's type.
```php
public function getType(): string;
```

Sets extra HTML attributes.
```php
public function setAttributes( array $attributes ): AssetInterface;
```

Sets if the asset must be filtered or not.
```php
public function setFilter( bool $filter ): AssetInterface;
```

Sets the asset's type.
```php
public function setType( string $type ): AssetInterface;
```



<h1 id="assets-collection">Class Phalcon\Assets\Collection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Collection.zep)

| Namespace  | Phalcon\Assets |
| Uses       | Countable, Iterator, Phalcon\Assets\Asset\Css, Phalcon\Assets\Asset\Js, Phalcon\Assets\Inline\Js, Phalcon\Assets\Inline\Css |
| Implements | Countable, Iterator |

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
protected position = 0;

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

Phalcon\Assets\Collection constructor
```php
public function __construct();
```

Adds a asset to the collection
```php
public function add( AssetInterface $asset ): Collection;
```

Adds a CSS asset to the collection
```php
public function addCss( string $path, mixed $local = null, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Collection;
```

Adds a filter to the collection
```php
public function addFilter( FilterInterface $filter ): Collection;
```

Adds an inline code to the collection
```php
public function addInline( Inline $code ): Collection;
```

Adds an inline CSS to the collection
```php
public function addInlineCss( string $content, bool $filter = bool, mixed $attributes = null ): Collection;
```

Adds an inline JavaScript to the collection
```php
public function addInlineJs( string $content, bool $filter = bool, mixed $attributes = null ): Collection;
```

Adds a JavaScript asset to the collection
```php
public function addJs( string $path, mixed $local = null, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Collection;
```

Returns the number of elements in the form
```php
public function count(): int;
```

Returns the current asset in the iterator
```php
public function current(): Asset;
```


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

Returns the complete location where the joined/filtered collection must
be written
```php
public function getRealTargetPath( string $basePath ): string;
```


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
public function getVersion(): 	string
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
public function has( AssetInterface $asset ): bool;
```

Checks if collection is using auto version
```php
public function isAutoVersion(): bool;
```

Sets if all filtered assets in the collection must be joined in a single
result file
```php
public function join( bool $join ): Collection;
```

Returns the current position/key in the iterator
```php
public function key(): int;
```

Moves the internal iteration pointer to the next position
```php
public function next(): void;
```

Rewinds the internal iterator
```php
public function rewind(): void;
```

Sets extra HTML attributes
```php
public function setAttributes( array $attributes ): Collection;
```


```php
public function setAutoVersion( 	bool $autoVersion )
```

Sets an array of filters in the collection
```php
public function setFilters( array $filters ): Collection;
```

Sets if the collection uses local assets by default
```php
public function setLocal( bool $local ): Collection;
```

Sets a common prefix for all the assets
```php
public function setPrefix( string $prefix ): Collection;
```

Sets a base source path for all the assets in this collection
```php
public function setSourcePath( string $sourcePath ): Collection;
```

Sets the target local
```php
public function setTargetLocal( bool $targetLocal ): Collection;
```

Sets the target path of the file for the filtered/join output
```php
public function setTargetPath( string $targetPath ): Collection;
```

Sets a target uri for the generated HTML
```php
public function setTargetUri( string $targetUri ): Collection;
```


```php
public function setVersion( 	string $version )
```

Check if the current element in the iterator is valid
```php
public function valid(): bool;
```

Adds a asset or inline-code to the collection
```php
final protected function addAsset( AssetInterface $asset ): bool;
```



<h1 id="assets-exception">Class Phalcon\Assets\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Exception.zep)

| Namespace  | Phalcon\Assets |
| Extends    | \Phalcon\Exception |

Exceptions thrown in Phalcon\Assets will use this class



<h1 id="assets-filterinterface">Interface Phalcon\Assets\FilterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/FilterInterface.zep)

| Namespace  | Phalcon\Assets |

Interface for custom Phalcon\Assets filters


## Methods

Filters the content returning a string with the filtered content
```php
public function filter( string $content ): string;
```



<h1 id="assets-filters-cssmin">Class Phalcon\Assets\Filters\Cssmin</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/CssMin.zep)

| Namespace  | Phalcon\Assets\Filters |
| Uses       | Phalcon\Assets\FilterInterface |
| Implements | FilterInterface |

Minify the CSS - removes comments removes newlines and line feeds keeping
removes last semicolon from last property


## Methods

Filters the content using CSSMIN
NOTE: This functionality is not currently available
```php
public function filter( string $content ): string;
```



<h1 id="assets-filters-jsmin">Class Phalcon\Assets\Filters\Jsmin</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/JsMin.zep)

| Namespace  | Phalcon\Assets\Filters |
| Uses       | Phalcon\Assets\FilterInterface |
| Implements | FilterInterface |

Deletes the characters which are insignificant to JavaScript. Comments will
be removed. Tabs will be replaced with spaces. Carriage returns will be
replaced with linefeeds. Most spaces and linefeeds will be removed.


## Methods

Filters the content using JSMIN
NOTE: This functionality is not currently available
```php
public function filter( string $content ): string;
```



<h1 id="assets-filters-none">Class Phalcon\Assets\Filters\None</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/None.zep)

| Namespace  | Phalcon\Assets\Filters |
| Uses       | Phalcon\Assets\FilterInterface |
| Implements | FilterInterface |

Returns the content without make any modification to the original source


## Methods

Returns the content as is
```php
public function filter( string $content ): string;
```



<h1 id="assets-inline">Class Phalcon\Assets\Inline</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline.zep)

| Namespace  | Phalcon\Assets |
| Implements | AssetInterface |

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

Phalcon\Assets\Inline constructor
```php
public function __construct( string $type, string $content, bool $filter = bool, array $attributes = [] );
```

Gets the asset's key.
```php
public function getAssetKey(): string;
```


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

Sets extra HTML attributes
```php
public function setAttributes( array $attributes ): AssetInterface;
```

Sets if the asset must be filtered or not
```php
public function setFilter( bool $filter ): AssetInterface;
```

Sets the inline's type
```php
public function setType( string $type ): AssetInterface;
```



<h1 id="assets-inline-css">Class Phalcon\Assets\Inline\Css</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline/Css.zep)

| Namespace  | Phalcon\Assets\Inline |
| Uses       | Phalcon\Assets\Inline |
| Extends    | InlineBase |

Represents an inlined CSS


## Methods

Phalcon\Assets\Inline\Css constructor
```php
public function __construct( string $content, bool $filter = bool, mixed $attributes = null );
```



<h1 id="assets-inline-js">Class Phalcon\Assets\Inline\Js</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline/Js.zep)

| Namespace  | Phalcon\Assets\Inline |
| Uses       | Phalcon\Assets\Inline |
| Extends    | InlineBase |

Represents an inline JavaScript


## Methods

Phalcon\Assets\Inline\Js constructor
```php
public function __construct( string $content, bool $filter = bool, mixed $attributes = null );
```



<h1 id="assets-manager">Class Phalcon\Assets\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Manager.zep)

| Namespace  | Phalcon\Assets |
| Uses       | Phalcon\Tag, Phalcon\Assets\Asset\Js, Phalcon\Assets\Asset\Css, Phalcon\Assets\Inline\Css, Phalcon\Assets\Inline\Js, Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware |
| Extends    | AbstractInjectionAware |

Phalcon\Assets\Manager

Manages collections of CSS/JavaScript assets


## Properties
```php
//
protected collections;

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

Phalcon\Assets\Manager constructor
```php
public function __construct( array $options = [] );
```

Adds a raw asset to the manager

```php
$assets->addAsset(
    new Phalcon\Assets\Asset("css", "css/style.css")
);
```
```php
public function addAsset( Asset $asset ): Manager;
```

Adds a asset by its type

```php
$assets->addAssetByType(
    "css",
    new \Phalcon\Assets\Asset\Css("css/style.css")
);
```
```php
public function addAssetByType( string $type, Asset $asset ): Manager;
```

   Adds a CSS asset to the 'css' collection
   
   ```php
   $assets->addCss("css/bootstrap.css");
   $assets->addCss("http://bootstrap.my-cdn.com/style.css", false);
   ```
   
```php
public function addCss( string $path, mixed $local = bool, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Manager;
```

Adds a raw inline code to the manager
```php
public function addInlineCode( Inline $code ): Manager;
```

Adds an inline code by its type
```php
public function addInlineCodeByType( string $type, Inline $code ): Manager;
```

Adds an inline CSS to the 'css' collection
```php
public function addInlineCss( string $content, mixed $filter = bool, mixed $attributes = null ): Manager;
```

Adds an inline JavaScript to the 'js' collection
```php
public function addInlineJs( string $content, mixed $filter = bool, mixed $attributes = null ): Manager;
```

Adds a JavaScript asset to the 'js' collection

```php
$assets->addJs("scripts/jquery.js");
$assets->addJs("http://jquery.my-cdn.com/jquery.js", false);
```
```php
public function addJs( string $path, mixed $local = bool, bool $filter = bool, mixed $attributes = null, string $version = null, bool $autoVersion = bool ): Manager;
```

Creates/Returns a collection of assets
```php
public function collection( string $name ): Collection;
```

Creates/Returns a collection of assets by type
```php
public function collectionAssetsByType( array $assets, string $type ): array;
```

Returns true or false if collection exists.

```php
if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}
```
```php
public function exists( string $id ): bool;
```

Returns a collection by its id.

```php
$scripts = $assets->get("js");
```
```php
public function get( string $id ): Collection;
```

Returns existing collections in the manager
```php
public function getCollections(): Collection[];
```

Returns the CSS collection of assets
```php
public function getCss(): Collection;
```

Returns the CSS collection of assets
```php
public function getJs(): Collection;
```

Returns the manager options
```php
public function getOptions(): array;
```

Traverses a collection calling the callback to generate its HTML
```php
public function output( Collection $collection, mixed $callback, mixed $type ): string | null;
```

Prints the HTML for CSS assets
```php
public function outputCss( string $collectionName = null ): string;
```

Traverses a collection and generate its HTML
```php
public function outputInline( Collection $collection, mixed $type ): string;
```

Prints the HTML for inline CSS
```php
public function outputInlineCss( string $collectionName = null ): string;
```

Prints the HTML for inline JS
```php
public function outputInlineJs( string $collectionName = null ): string;
```

Prints the HTML for JS assets
```php
public function outputJs( string $collectionName = null ): string;
```

Sets a collection in the Assets Manager

```php
$assets->set("js", $collection);
```
```php
public function set( string $id, Collection $collection ): Manager;
```

Sets the manager options
```php
public function setOptions( array $options ): Manager;
```

Sets if the HTML generated must be directly printed or returned
```php
public function useImplicitOutput( bool $implicitOutput ): Manager;
```

