---
layout: default
language: 'en'
version: '5.0'
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

| Namespace  | Phalcon\Assets | | Implements | AssetInterface |

Represents an asset

```php
$asset = new \Phalcon\Assets\Asset("js", "js/jquery.js");
```

@property array       $attributes @property bool        $isAutoVersion @property bool        $filter @property bool        $isLocal @property string      $path @property string      $sourcePath @property string      $targetPath @property string      $targetUri @property string      $type @property string|null $version



## Properties
```php
/**
 * @var array
 */
protected attributes;

/**
 * @var bool
 */
protected isAutoVersion = false;

/**
 * @var bool
 */
protected filter;

/**
 * @var bool
 */
protected isLocal;

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
 *
 * @var string|null
 */
protected version;

```

## Methods

```php
public function __construct( string $type, string $path, bool $isLocal = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $isAutoVersion = bool );
```
Asset constructor.


```php
public function getAssetKey(): string;
```
Gets the asset's key.


```php
public function getAttributes(): array;
```
Gets extra HTML attributes.


```php
public function getContent( string $basePath = null ): string;
```
Returns the content of the asset as an string Optionally a base path where the asset is located can be set


```php
public function getFilter(): bool
```

```php
public function getPath(): string
```

```php
public function getRealSourcePath( string $basePath = null ): string;
```
Returns the complete location where the asset is located


```php
public function getRealTargetPath( string $basePath = null ): string;
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
public function getVersion(): string|null
```

```php
public function isAutoVersion(): bool;
```
Checks if the asset is using auto version


```php
public function isLocal(): bool;
```
Checks if the asset is local or not


```php
public function setAttributes( array $attributes ): AssetInterface;
```
Sets extra HTML attributes


```php
public function setAutoVersion( bool $flag ): AssetInterface;
```

```php
public function setFilter( bool $filter ): AssetInterface;
```
Sets if the asset must be filtered or not


```php
public function setIsLocal( bool $flag ): AssetInterface;
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
public function setVersion( string $version ): AssetInterface;
```
Sets the asset's version


```php
protected function phpFileExists( string $filename ): bool;
```
@todo to be removed when we get traits


```php
protected function phpFileGetContents( string $filename );
```





<h1 id="assets-asset-css">Class Phalcon\Assets\Asset\Css</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset/Css.zep)

| Namespace  | Phalcon\Assets\Asset | | Uses       | Phalcon\Assets\Asset | | Extends    | AssetBase |

Represents CSS assets


## Methods

```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```
Phalcon\Assets\Asset\Css constructor




<h1 id="assets-asset-js">Class Phalcon\Assets\Asset\Js</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Asset/Js.zep)

| Namespace  | Phalcon\Assets\Asset | | Uses       | Phalcon\Assets\Asset | | Extends    | AssetBase |

Represents JavaScript assets


## Methods

```php
public function __construct( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool );
```
Phalcon\Assets\Asset\Js constructor




<h1 id="assets-assetinterface">Interface Phalcon\Assets\AssetInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/AssetInterface.zep)

| Namespace  | Phalcon\Assets |

Interface for custom Phalcon\Assets resources


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




<h1 id="assets-collection">Class Phalcon\Assets\Collection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Collection.zep)

| Namespace  | Phalcon\Assets | | Uses       | ArrayIterator, Countable, IteratorAggregate | | Implements | Countable, IteratorAggregate |

Collection of asset objects

@property array  $assets @property array  $attributes @property bool   $autoVersion @property array  $codes @property array  $filters @property bool   $join @property bool   $isLocal @property string $prefix @property string $sourcePath @property bool   $targetIsLocal @property string $targetPath @property string $targetUri @property string $version


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
 *
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
 * @var bool
 */
protected join = true;

/**
 * @var bool
 */
protected isLocal = true;

/**
 * @var string
 */
protected prefix = ;

/**
 * @var string
 */
protected sourcePath = ;

/**
 * @var bool
 */
protected targetIsLocal = true;

/**
 * @var string
 */
protected targetPath = ;

/**
 * @var string
 */
protected targetUri = ;

/**
 * @var string
 */
protected version = ;

```

## Methods

```php
public function add( AssetInterface $asset ): Collection;
```
Adds an asset to the collection


```php
public function addCss( string $path, mixed $isLocal = null, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Collection;
```
Adds a CSS asset to the collection


```php
public function addFilter( FilterInterface $filter ): Collection;
```
Adds a filter to the collection


```php
public function addInline( Inline $code ): Collection;
```
Adds an inline code to the collection


```php
public function addInlineCss( string $content, bool $filter = bool, array $attributes = [] ): Collection;
```
Adds an inline CSS to the collection


```php
public function addInlineJs( string $content, bool $filter = bool, array $attributes = [] ): Collection;
```
Adds an inline JavaScript to the collection


```php
public function addJs( string $path, mixed $isLocal = null, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Collection;
```
Adds a JavaScript asset to the collection


```php
public function count(): int;
```
Return the count of the assets


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
public function getIterator(): \Traversable;
```
Returns the generator of the class

@link https://php.net/manual/en/iteratoraggregate.getiterator.php


```php
public function getJoin(): bool
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
public function getTargetIsLocal(): bool
```

```php
public function getTargetPath(): string
```

```php
public function getTargetUri(): string
```

```php
public function getVersion(): string
```

```php
public function has( AssetInterface $asset ): bool;
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
public function isLocal(): bool;
```

```php
public function join( bool $flag ): Collection;
```
Sets if all filtered assets in the collection must be joined in a single result file


```php
public function setAttributes( array $attributes ): Collection;
```
Sets extra HTML attributes


```php
public function setAutoVersion( bool $flag ): Collection;
```

```php
public function setFilters( array $filters ): Collection;
```
Sets an array of filters in the collection


```php
public function setIsLocal( bool $flag ): Collection;
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
public function setTargetIsLocal( bool $flag ): Collection;
```
Sets if the target local or not


```php
public function setTargetPath( string $targetPath ): Collection;
```
Sets the target path of the file for the filtered/join output


```php
public function setTargetUri( string $targetUri ): Collection;
```
Sets a target uri for the generated HTML


```php
public function setVersion( string $version ): Collection;
```
Sets the version


```php
final protected function addAsset( AssetInterface $asset ): bool;
```
Adds an asset or inline-code to the collection




<h1 id="assets-exception">Class Phalcon\Assets\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Exception.zep)

| Namespace  | Phalcon\Assets | | Extends    | \Exception |

Exceptions thrown in Phalcon\Assets will use this class



<h1 id="assets-filterinterface">Interface Phalcon\Assets\FilterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/FilterInterface.zep)

| Namespace  | Phalcon\Assets |

Interface for custom Phalcon\Assets filters


## Methods

```php
public function filter( string $content ): string;
```
Filters the content returning a string with the filtered content




<h1 id="assets-filters-cssmin">Class Phalcon\Assets\Filters\Cssmin</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/CssMin.zep)

| Namespace  | Phalcon\Assets\Filters | | Uses       | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Minify the CSS - removes comments removes newlines and line feeds keeping removes last semicolon from last property


## Methods

```php
public function filter( string $content ): string;
```
Filters the content using CSSMIN NOTE: This functionality is not currently available




<h1 id="assets-filters-jsmin">Class Phalcon\Assets\Filters\Jsmin</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/JsMin.zep)

| Namespace  | Phalcon\Assets\Filters | | Uses       | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Deletes the characters which are insignificant to JavaScript. Comments will be removed. Tabs will be replaced with spaces. Carriage returns will be replaced with linefeeds. Most spaces and linefeeds will be removed.


## Methods

```php
public function filter( string $content ): string;
```
Filters the content using JSMIN NOTE: This functionality is not currently available




<h1 id="assets-filters-none">Class Phalcon\Assets\Filters\None</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Filters/None.zep)

| Namespace  | Phalcon\Assets\Filters | | Uses       | Phalcon\Assets\FilterInterface | | Implements | FilterInterface |

Returns the content without make any modification to the original source


## Methods

```php
public function filter( string $content ): string;
```
Returns the content as is




<h1 id="assets-inline">Class Phalcon\Assets\Inline</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline.zep)

| Namespace  | Phalcon\Assets | | Implements | AssetInterface |

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
public function __construct( string $type, string $content, bool $filter = bool, array $attributes = [] );
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




<h1 id="assets-inline-css">Class Phalcon\Assets\Inline\Css</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline/Css.zep)

| Namespace  | Phalcon\Assets\Inline | | Uses       | Phalcon\Assets\Inline | | Extends    | InlineBase |

Represents an inlined CSS


## Methods

```php
public function __construct( string $content, bool $filter = bool, array $attributes = [] );
```
Phalcon\Assets\Inline\Css constructor




<h1 id="assets-inline-js">Class Phalcon\Assets\Inline\Js</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Inline/Js.zep)

| Namespace  | Phalcon\Assets\Inline | | Uses       | Phalcon\Assets\Inline | | Extends    | InlineBase |

Represents an inline JavaScript


## Methods

```php
public function __construct( string $content, bool $filter = bool, array $attributes = [] );
```
Phalcon\Assets\Inline\Js constructor




<h1 id="assets-manager">Class Phalcon\Assets\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Assets/Manager.zep)

| Namespace  | Phalcon\Assets | | Uses       | Phalcon\Assets\Asset\Css, Phalcon\Assets\Asset\Js, Phalcon\Assets\Inline\Css, Phalcon\Assets\Inline\Js, Phalcon\Di\AbstractInjectionAware, Phalcon\Html\Helper\Element, Phalcon\Html\Helper\Link, Phalcon\Html\Helper\Script, Phalcon\Html\TagFactory | | Extends    | AbstractInjectionAware |

Manages collections of CSS/JavaScript assets

@property array      $collections @property bool       $implicitOutput @property array      $options @property TagFactory $tagFactory


## Properties
```php
/**
 * @var array
 */
protected collections;

/**
 * @var bool
 */
protected implicitOutput = true;

/**
 * @var array
 */
protected options;

/**
 * @var TagFactory
 */
protected tagFactory;

```

## Methods

```php
public function __construct( TagFactory $tagFactory, array $options = [] );
```
Manager constructor.


```php
public function addAsset( Asset $asset ): Manager;
```
Adds a raw asset to the manager


```php
public function addAssetByType( string $type, Asset $asset ): Manager;
```
Adds a asset by its type


```php
public function addCss( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Manager;
```
Adds a CSS asset to the 'css' collection


```php
public function addInlineCode( Inline $code ): Manager;
```
Adds a raw inline code to the manager


```php
public function addInlineCodeByType( string $type, Inline $code ): Manager;
```
Adds an inline code by its type


```php
public function addInlineCss( string $content, bool $filter = bool, array $attributes = [] ): Manager;
```
Adds an inline CSS to the 'css' collection


```php
public function addInlineJs( string $content, bool $filter = bool, array $attributes = [] ): Manager;
```
Adds an inline JavaScript to the 'js' collection


```php
public function addJs( string $path, bool $local = bool, bool $filter = bool, array $attributes = [], string $version = null, bool $autoVersion = bool ): Manager;
```
Adds a JavaScript asset to the 'js' collection

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
public function exists( string $name ): bool;
```
Returns true or false if collection exists.

```php
if ($manager->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $manager->get("jsHeader");
}
```


```php
public function get( string $name ): Collection;
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
public function getJs(): Collection;
```
Returns the CSS collection of assets


```php
public function getOptions(): array;
```
Returns the manager options


```php
public function has( string $name ): bool;
```
Returns true or false if collection exists.

```php
if ($manager->has("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $manager->get("jsHeader");
}
```


```php
public function output( Collection $collection, string $type ): string | null;
```
Traverses a collection calling the callback to generate its HTML


```php
public function outputCss( string $name = null ): string;
```
Prints the HTML for CSS assets


```php
public function outputInline( Collection $collection, mixed $type ): string;
```
Traverses a collection and generate its HTML


```php
public function outputInlineCss( string $name = null ): string;
```
Prints the HTML for inline CSS


```php
public function outputInlineJs( string $name = null ): string;
```
Prints the HTML for inline JS


```php
public function outputJs( string $name = null ): string;
```
Prints the HTML for JS assets


```php
public function set( string $name, Collection $collection ): Manager;
```
Sets a collection in the Assets Manager

```php
$assets->set("js", $collection);
```


```php
public function setOptions( array $options ): Manager;
```
Sets the manager options


```php
public function useImplicitOutput( bool $implicitOutput ): Manager;
```
Sets if the HTML generated must be directly printed or returned


