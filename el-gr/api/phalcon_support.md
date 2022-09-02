---
layout: default
title: 'Phalcon\Support'
---

* [Phalcon\Support\Collection](#support-collection)
* [Phalcon\Support\Collection\CollectionInterface](#support-collection-collectioninterface)
* [Phalcon\Support\Collection\Exception](#support-collection-exception)
* [Phalcon\Support\Collection\ReadOnlyCollection](#support-collection-readonlycollection)
* [Phalcon\Support\Debug](#support-debug)
* [Phalcon\Support\Debug\Dump](#support-debug-dump)
* [Phalcon\Support\Debug\Exception](#support-debug-exception)
* [Phalcon\Support\Exception](#support-exception)
* [Phalcon\Support\Helper\Arr\AbstractArr](#support-helper-arr-abstractarr)
* [Phalcon\Support\Helper\Arr\Blacklist](#support-helper-arr-blacklist)
* [Phalcon\Support\Helper\Arr\Chunk](#support-helper-arr-chunk)
* [Phalcon\Support\Helper\Arr\Filter](#support-helper-arr-filter)
* [Phalcon\Support\Helper\Arr\First](#support-helper-arr-first)
* [Phalcon\Support\Helper\Arr\FirstKey](#support-helper-arr-firstkey)
* [Phalcon\Support\Helper\Arr\Flatten](#support-helper-arr-flatten)
* [Phalcon\Support\Helper\Arr\Get](#support-helper-arr-get)
* [Phalcon\Support\Helper\Arr\Group](#support-helper-arr-group)
* [Phalcon\Support\Helper\Arr\Has](#support-helper-arr-has)
* [Phalcon\Support\Helper\Arr\IsUnique](#support-helper-arr-isunique)
* [Phalcon\Support\Helper\Arr\Last](#support-helper-arr-last)
* [Phalcon\Support\Helper\Arr\LastKey](#support-helper-arr-lastkey)
* [Phalcon\Support\Helper\Arr\Order](#support-helper-arr-order)
* [Phalcon\Support\Helper\Arr\Pluck](#support-helper-arr-pluck)
* [Phalcon\Support\Helper\Arr\Set](#support-helper-arr-set)
* [Phalcon\Support\Helper\Arr\SliceLeft](#support-helper-arr-sliceleft)
* [Phalcon\Support\Helper\Arr\SliceRight](#support-helper-arr-sliceright)
* [Phalcon\Support\Helper\Arr\Split](#support-helper-arr-split)
* [Phalcon\Support\Helper\Arr\ToObject](#support-helper-arr-toobject)
* [Phalcon\Support\Helper\Arr\ValidateAll](#support-helper-arr-validateall)
* [Phalcon\Support\Helper\Arr\ValidateAny](#support-helper-arr-validateany)
* [Phalcon\Support\Helper\Arr\Whitelist](#support-helper-arr-whitelist)
* [Phalcon\Support\Helper\Exception](#support-helper-exception)
* [Phalcon\Support\Helper\File\Basename](#support-helper-file-basename)
* [Phalcon\Support\Helper\Json\Decode](#support-helper-json-decode)
* [Phalcon\Support\Helper\Json\Encode](#support-helper-json-encode)
* [Phalcon\Support\Helper\Number\IsBetween](#support-helper-number-isbetween)
* [Phalcon\Support\Helper\Str\AbstractStr](#support-helper-str-abstractstr)
* [Phalcon\Support\Helper\Str\Camelize](#support-helper-str-camelize)
* [Phalcon\Support\Helper\Str\Concat](#support-helper-str-concat)
* [Phalcon\Support\Helper\Str\CountVowels](#support-helper-str-countvowels)
* [Phalcon\Support\Helper\Str\Decapitalize](#support-helper-str-decapitalize)
* [Phalcon\Support\Helper\Str\Decrement](#support-helper-str-decrement)
* [Phalcon\Support\Helper\Str\DirFromFile](#support-helper-str-dirfromfile)
* [Phalcon\Support\Helper\Str\DirSeparator](#support-helper-str-dirseparator)
* [Phalcon\Support\Helper\Str\Dynamic](#support-helper-str-dynamic)
* [Phalcon\Support\Helper\Str\EndsWith](#support-helper-str-endswith)
* [Phalcon\Support\Helper\Str\FirstBetween](#support-helper-str-firstbetween)
* [Phalcon\Support\Helper\Str\Friendly](#support-helper-str-friendly)
* [Phalcon\Support\Helper\Str\Humanize](#support-helper-str-humanize)
* [Phalcon\Support\Helper\Str\Includes](#support-helper-str-includes)
* [Phalcon\Support\Helper\Str\Increment](#support-helper-str-increment)
* [Phalcon\Support\Helper\Str\Interpolate](#support-helper-str-interpolate)
* [Phalcon\Support\Helper\Str\IsAnagram](#support-helper-str-isanagram)
* [Phalcon\Support\Helper\Str\IsLower](#support-helper-str-islower)
* [Phalcon\Support\Helper\Str\IsPalindrome](#support-helper-str-ispalindrome)
* [Phalcon\Support\Helper\Str\IsUpper](#support-helper-str-isupper)
* [Phalcon\Support\Helper\Str\KebabCase](#support-helper-str-kebabcase)
* [Phalcon\Support\Helper\Str\Len](#support-helper-str-len)
* [Phalcon\Support\Helper\Str\Lower](#support-helper-str-lower)
* [Phalcon\Support\Helper\Str\PascalCase](#support-helper-str-pascalcase)
* [Phalcon\Support\Helper\Str\Prefix](#support-helper-str-prefix)
* [Phalcon\Support\Helper\Str\Random](#support-helper-str-random)
* [Phalcon\Support\Helper\Str\ReduceSlashes](#support-helper-str-reduceslashes)
* [Phalcon\Support\Helper\Str\SnakeCase](#support-helper-str-snakecase)
* [Phalcon\Support\Helper\Str\StartsWith](#support-helper-str-startswith)
* [Phalcon\Support\Helper\Str\Suffix](#support-helper-str-suffix)
* [Phalcon\Support\Helper\Str\Ucwords](#support-helper-str-ucwords)
* [Phalcon\Support\Helper\Str\Uncamelize](#support-helper-str-uncamelize)
* [Phalcon\Support\Helper\Str\Underscore](#support-helper-str-underscore)
* [Phalcon\Support\Helper\Str\Upper](#support-helper-str-upper)
* [Phalcon\Support\HelperFactory](#support-helperfactory)
* [Phalcon\Support\Registry](#support-registry)
* [Phalcon\Support\Version](#support-version)

<h1 id="support-collection">Class Phalcon\Support\Collection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Collection.zep)

| Namespace  | Phalcon\Support | | Uses       | ArrayAccess, ArrayIterator, Countable, IteratorAggregate, InvalidArgumentException, JsonSerializable, Phalcon\Support\Collection\CollectionInterface, Serializable, Traversable | | Implements | ArrayAccess, CollectionInterface, Countable, IteratorAggregate, JsonSerializable, Serializable |

`Phalcon\Support\Collection` is a supercharged object oriented array. It implements:
- [ArrayAccess](https://www.php.net/manual/en/class.arrayaccess.php)
- [Countable](https://www.php.net/manual/en/class.countable.php)
- [IteratorAggregate](https://www.php.net/manual/en/class.iteratoraggregate.php)
- [JsonSerializable](https://www.php.net/manual/en/class.jsonserializable.php)
- [Serializable](https://www.php.net/manual/en/class.serializable.php)

It can be used in any part of the application that needs collection of data Such implementations are for instance accessing globals `$_GET`, `$_POST` etc.


## Properties
```php
/**
 * @var array
 */
protected data;

/**
 * @var bool
 */
protected insensitive = true;

/**
 * @var array
 */
protected lowerKeys;

```

## Methods

```php
public function __construct( array $data = [], bool $insensitive = bool );
```
Collection constructor.


```php
public function __get( string $element ): mixed;
```
Magic getter to get an element from the collection


```php
public function __isset( string $element ): bool;
```
Magic isset to check whether an element exists or not


```php
public function __serialize(): array;
```

```php
public function __set( string $element, mixed $value ): void;
```
Magic setter to assign values to an element


```php
public function __unserialize( array $data ): void;
```

```php
public function __unset( string $element ): void;
```
Magic unset to remove an element from the collection


```php
public function clear(): void;
```
Clears the internal collection


```php
public function count(): int;
```
Count elements of an object. See [count](https://php.net/manual/en/countable.count.php)


```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```
Get the element from the collection


```php
public function getIterator(): Traversable;
```
Returns the iterator of the class


```php
public function getKeys( bool $insensitive = bool ): array;
```
Return the keys as an array


```php
public function getValues(): array;
```
Return the values as an array


```php
public function has( string $element ): bool;
```
Determines whether an element is present in the collection.


```php
public function init( array $data = [] ): void;
```
Initialize internal array


```php
public function jsonSerialize(): array;
```
Specify data which should be serialized to JSON See [jsonSerialize](https://php.net/manual/en/jsonserializable.jsonserialize.php)


```php
public function offsetExists( mixed $element ): bool;
```
Whether a offset exists See [offsetExists](https://php.net/manual/en/arrayaccess.offsetexists.php)


```php
public function offsetGet( mixed $element ): mixed;
```
Offset to retrieve See [offsetGet](https://php.net/manual/en/arrayaccess.offsetget.php)


```php
public function offsetSet( mixed $element, mixed $value ): void;
```
Offset to set See [offsetSet](https://php.net/manual/en/arrayaccess.offsetset.php)


```php
public function offsetUnset( mixed $element ): void;
```
Offset to unset See [offsetUnset](https://php.net/manual/en/arrayaccess.offsetunset.php)


```php
public function remove( string $element ): void;
```
Delete the element from the collection


```php
public function serialize(): string;
```
String representation of object See [serialize](https://php.net/manual/en/serializable.serialize.php)


```php
public function set( string $element, mixed $value ): void;
```
Set an element in the collection


```php
public function toArray(): array;
```
Returns the object in an array format


```php
public function toJson( int $options = int ): string;
```
Returns the object in a JSON format

The default string uses the following options for json_encode

`JSON_HEX_TAG`, `JSON_HEX_APOS`, `JSON_HEX_AMP`, `JSON_HEX_QUOT`, `JSON_UNESCAPED_SLASHES`

See [rfc4627](https://www.ietf.org/rfc/rfc4627.txt)


```php
public function unserialize( string $serialized ): void;
```
Constructs the object See [unserialize](https://php.net/manual/en/serializable.unserialize.php)


```php
protected function phpJsonEncode( mixed $value, int $flags = int, int $depth = int );
```
@todo to be removed when we get traits


```php
protected function processKey( string $element ): string;
```
Checks if we need insensitive keys and if so, converts the element to lowercase


```php
protected function setData( string $element, mixed $value ): void;
```
Internal method to set data




<h1 id="support-collection-collectioninterface">Interface Phalcon\Support\Collection\CollectionInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Collection/CollectionInterface.zep)

| Namespace  | Phalcon\Support\Collection |

Phalcon\Support\Collection\CollectionInterface

Interface for Phalcon\Support\Collection class


## Methods

```php
public function __get( string $element ): mixed;
```

```php
public function __isset( string $element ): bool;
```

```php
public function __set( string $element, mixed $value ): void;
```

```php
public function __unset( string $element ): void;
```

```php
public function clear(): void;
```

```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```

```php
public function getKeys( bool $insensitive = bool ): array;
```

```php
public function getValues(): array;
```

```php
public function has( string $element ): bool;
```

```php
public function init( array $data = [] ): void;
```

```php
public function remove( string $element ): void;
```

```php
public function set( string $element, mixed $value ): void;
```

```php
public function toArray(): array;
```

```php
public function toJson( int $options = int ): string;
```





<h1 id="support-collection-exception">Class Phalcon\Support\Collection\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Collection/Exception.zep)

| Namespace  | Phalcon\Support\Collection | | Uses       | Throwable | | Extends    | \Exception |

Exceptions for the Collection object



<h1 id="support-collection-readonlycollection">Class Phalcon\Support\Collection\ReadOnlyCollection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Collection/ReadOnlyCollection.zep)

| Namespace  | Phalcon\Support\Collection | | Uses       | Phalcon\Support\Collection | | Extends    | Collection |

A read only Collection object


## Methods

```php
public function remove( string $element ): void;
```
Delete the element from the collection


```php
public function set( string $element, mixed $value ): void;
```
Set an element in the collection




<h1 id="support-debug">Class Phalcon\Support\Debug</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Debug.zep)

| Namespace  | Phalcon\Support | | Uses       | ErrorException, Phalcon\Support\Debug\Exception, ReflectionClass, ReflectionException, ReflectionFunction, Throwable |

Provides debug capabilities to Phalcon applications


## Properties
```php
/**
 * @var array
 */
protected blacklist;

/**
 * @var array
 */
protected data;

/**
 * @var bool
 */
protected hideDocumentRoot = false;

/**
 * @var bool
 */
protected static isActive = false;

/**
 * @var bool
 */
protected showBackTrace = true;

/**
 * @var bool
 */
protected showFileFragment = false;

/**
 * @var bool
 */
protected showFiles = true;

/**
 * @var string
    */
protected uri = https://assets.phalcon.io/debug/5.0.x/;

```

## Methods

```php
public function clearVars(): Debug;
```
Clears are variables added previously


```php
public function debugVar( mixed $varz ): Debug;
```
Adds a variable to the debug output


```php
public function getCssSources(): string;
```
Returns the CSS sources


```php
public function getJsSources(): string;
```
Returns the JavaScript sources


```php
public function getVersion(): string;
```
Generates a link to the current version documentation


```php
public function halt(): void;
```
Halts the request showing a backtrace

@throws Exception


```php
public function listen( bool $exceptions = bool, bool $lowSeverity = bool ): Debug;
```
Listen for uncaught exceptions and non silent notices or warnings


```php
public function listenExceptions(): Debug;
```
Listen for uncaught exceptions


```php
public function listenLowSeverity(): Debug;
```
Listen for non silent notices or warnings


```php
public function onUncaughtException( \Throwable $exception ): bool;
```
Handles uncaught exceptions


```php
public function onUncaughtLowSeverity( mixed $severity, mixed $message, mixed $file, mixed $line, mixed $context ): void;
```
Throws an exception when a notice or warning is raised


```php
public function renderHtml( \Throwable $exception ): string;
```
Render exception to html format.


```php
public function setBlacklist( array $blacklist ): Debug;
```
Sets if files the exception's backtrace must be showed


```php
public function setShowBackTrace( bool $showBackTrace ): Debug;
```
Sets if files the exception's backtrace must be showed


```php
public function setShowFileFragment( bool $showFileFragment ): Debug;
```
Sets if files must be completely opened and showed in the output or just the fragment related to the exception


```php
public function setShowFiles( bool $showFiles ): Debug;
```
Set if files part of the backtrace must be shown in the output


```php
public function setUri( string $uri ): Debug;
```
Change the base URI for static resources


```php
protected function escapeString( string $value ): string;
```
Escapes a string with htmlentities


```php
protected function getArrayDump( array $argument, mixed $n = int ): string | null;
```
Produces a recursive representation of an array


```php
protected function getVarDump( mixed $variable ): string;
```
Produces an string representation of a variable


```php
final protected function showTraceItem( int $n, array $trace ): string;
```
Shows a backtrace item




<h1 id="support-debug-dump">Class Phalcon\Support\Debug\Dump</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Debug/Dump.zep)

| Namespace  | Phalcon\Support\Debug | | Uses       | InvalidArgumentException, Phalcon\Di\Di, Reflection, ReflectionClass, ReflectionProperty, stdClass |

Dumps information about a variable(s)

```php
$foo = 123;

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");
```

```php
$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);
```


## Properties
```php
/**
 * @var bool
 */
protected detailed = false;

/**
 * @var array
 */
protected methods;

/**
 * @var array
 */
protected styles;

```

## Methods

```php
public function __construct( array $styles = [], bool $detailed = bool );
```
Phalcon\Debug\Dump constructor


```php
public function all(): string;
```
Alias of variables() method


```php
public function getDetailed(): bool
```

```php
public function one( mixed $variable, string $name = null ): string;
```
Alias of variable() method


```php
public function setDetailed( bool $detailed )
```

```php
public function setStyles( array $styles = [] ): array;
```
Set styles for vars type


```php
public function toJson( mixed $variable ): string;
```
Returns an JSON string of information about a single variable.

```php
$foo = [
    "key" => "value",
];

echo (new \Phalcon\Debug\Dump())->toJson($foo);

$foo = new stdClass();
$foo->bar = "buz";

echo (new \Phalcon\Debug\Dump())->toJson($foo);
```


```php
public function variable( mixed $variable, string $name = null ): string;
```
Returns an HTML string of information about a single variable.

```php
echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");
```


```php
public function variables(): string;
```
Returns an HTML string of debugging information about any number of variables, each wrapped in a "pre" tag.

```php
$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);
```


```php
protected function getStyle( string $type ): string;
```
Get style for type


```php
protected function output( mixed $variable, string $name = null, int $tab = int ): string;
```
Prepare an HTML string of information about a single variable.




<h1 id="support-debug-exception">Class Phalcon\Support\Debug\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Debug/Exception.zep)

| Namespace  | Phalcon\Support\Debug | | Extends    | \Exception |

Exceptions thrown in Phalcon\Debug will use this class



<h1 id="support-exception">Class Phalcon\Support\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Exception.zep)

| Namespace  | Phalcon\Support | | Extends    | \Exception |

Phalcon\Support\Exception



<h1 id="support-helper-arr-abstractarr">Abstract Class Phalcon\Support\Helper\Arr\AbstractArr</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/AbstractArr.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Abstract class offering methods to help with the Arr namespace. This can be moved to a trait once Zephir supports it.

@todo move to trait when there is support for it


## Methods

```php
protected function toFilter( array $collection, mixed $method = null ): array;
```
Helper method to filter the collection




<h1 id="support-helper-arr-blacklist">Class Phalcon\Support\Helper\Arr\Blacklist</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Blacklist.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Black list filter by key: exclude elements of an array by the keys obtained from the elements of a blacklist


## Methods

```php
public function __invoke( array $collection, array $blackList ): array;
```





<h1 id="support-helper-arr-chunk">Class Phalcon\Support\Helper\Arr\Chunk</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Chunk.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Chunks an array into smaller arrays of a specified size.


## Methods

```php
public function __invoke( array $collection, int $size, bool $preserveKeys = bool ): array;
```





<h1 id="support-helper-arr-filter">Class Phalcon\Support\Helper\Arr\Filter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Filter.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Filters a collection using array_filter and using the callable (if defined)


## Methods

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-first">Class Phalcon\Support\Helper\Arr\First</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/First.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns the first element of the collection. If a callable is passed, the element returned is the first that validates true


## Methods

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-firstkey">Class Phalcon\Support\Helper\Arr\FirstKey</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/FirstKey.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns the key of the first element of the collection. If a callable is passed, the element returned is the first that validates true


## Methods

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-flatten">Class Phalcon\Support\Helper\Arr\Flatten</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Flatten.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Flattens an array up to the one level depth, unless `$deep` is set to `true`


## Methods

```php
public function __invoke( array $collection, bool $deep = bool ): array;
```





<h1 id="support-helper-arr-get">Class Phalcon\Support\Helper\Arr\Get</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Get.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Gets an array element by key and if it does not exist returns the default. It also allows for casting the returned value to a specific type using `settype` internally


## Methods

```php
public function __invoke( array $collection, mixed $index, mixed $defaultValue = null, string $cast = null ): mixed;
```





<h1 id="support-helper-arr-group">Class Phalcon\Support\Helper\Arr\Group</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Group.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Groups the elements of an array based on the passed callable


## Methods

```php
public function __invoke( array $collection, mixed $method ): array;
```





<h1 id="support-helper-arr-has">Class Phalcon\Support\Helper\Arr\Has</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Has.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Checks an array if it has an element with a specific key and returns `true`/`false` accordingly


## Methods

```php
public function __invoke( array $collection, mixed $index ): bool;
```





<h1 id="support-helper-arr-isunique">Class Phalcon\Support\Helper\Arr\IsUnique</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/IsUnique.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Checks a flat list for duplicate values. Returns true if duplicate values exist and false if values are all unique.


## Methods

```php
public function __invoke( array $collection ): bool;
```





<h1 id="support-helper-arr-last">Class Phalcon\Support\Helper\Arr\Last</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Last.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns the last element of the collection. If a callable is passed, the element returned is the first that validates true


## Methods

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-lastkey">Class Phalcon\Support\Helper\Arr\LastKey</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/LastKey.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns the key of the last element of the collection. If a callable is passed, the element returned is the first that validates true


## Methods

```php
public function __invoke( array $collection, mixed $method = null ): mixed;
```





<h1 id="support-helper-arr-order">Class Phalcon\Support\Helper\Arr\Order</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Order.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Sorts a collection of arrays or objects by an attribute of the object. It supports ascending/descending sorts but also flags that are identical to the ones used by `ksort` and `krsort`


## Constants
```php
const ORDER_ASC = 1;
const ORDER_DESC = 2;
```

## Methods

```php
public function __invoke( array $collection, mixed $attribute, int $order = static-constant-access, int $flags = int ): array;
```





<h1 id="support-helper-arr-pluck">Class Phalcon\Support\Helper\Arr\Pluck</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Pluck.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns a subset of the collection based on the values of the collection


## Methods

```php
public function __invoke( array $collection, string $element ): array;
```





<h1 id="support-helper-arr-set">Class Phalcon\Support\Helper\Arr\Set</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Set.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Sets an array element. Using a key is optional


## Methods

```php
public function __invoke( array $collection, mixed $value, mixed $index = null ): array;
```





<h1 id="support-helper-arr-sliceleft">Class Phalcon\Support\Helper\Arr\SliceLeft</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/SliceLeft.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns a new array with n elements removed from the left.


## Methods

```php
public function __invoke( array $collection, int $elements = int ): array;
```





<h1 id="support-helper-arr-sliceright">Class Phalcon\Support\Helper\Arr\SliceRight</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/SliceRight.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns a new array with n elements removed from the right.


## Methods

```php
public function __invoke( array $collection, int $elements = int ): array;
```





<h1 id="support-helper-arr-split">Class Phalcon\Support\Helper\Arr\Split</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Split.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns a new array with keys of the collection as one element and values as another


## Methods

```php
public function __invoke( array $collection ): array;
```





<h1 id="support-helper-arr-toobject">Class Phalcon\Support\Helper\Arr\ToObject</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/ToObject.zep)

| Namespace  | Phalcon\Support\Helper\Arr |

Returns the passed array as an object.


## Methods

```php
public function __invoke( array $collection ): object;
```





<h1 id="support-helper-arr-validateall">Class Phalcon\Support\Helper\Arr\ValidateAll</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/ValidateAll.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns `true` if the provided function returns `true` for all elements of the collection, `false` otherwise.


## Methods

```php
public function __invoke( array $collection, mixed $method ): bool;
```





<h1 id="support-helper-arr-validateany">Class Phalcon\Support\Helper\Arr\ValidateAny</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/ValidateAny.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

Returns `true` if the provided function returns `true` for at least one element of the collection, `false` otherwise.


## Methods

```php
public function __invoke( array $collection, mixed $method ): bool;
```





<h1 id="support-helper-arr-whitelist">Class Phalcon\Support\Helper\Arr\Whitelist</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Arr/Whitelist.zep)

| Namespace  | Phalcon\Support\Helper\Arr | | Extends    | AbstractArr |

White list filter by key: obtain elements of an array filtering by the keys obtained from the elements of a whitelist


## Methods

```php
public function __invoke( array $collection, array $whiteList ): array;
```





<h1 id="support-helper-exception">Class Phalcon\Support\Helper\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Exception.zep)

| Namespace  | Phalcon\Support\Helper | | Extends    | \Exception |

* Phalcon\Support\Exception */


<h1 id="support-helper-file-basename">Class Phalcon\Support\Helper\File\Basename</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/File/Basename.zep)

| Namespace  | Phalcon\Support\Helper\File |

Gets the filename from a given path, Same as PHP's `basename()` but has non-ASCII support. PHP's `basename()` does not properly support streams or filenames beginning with a non-US-ASCII character.


## Methods

```php
public function __invoke( string $uri, string $suffix = null ): string;
```
@see https://bugs.php.net/bug.php?id=37738




<h1 id="support-helper-json-decode">Class Phalcon\Support\Helper\Json\Decode</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Json/Decode.zep)

| Namespace  | Phalcon\Support\Helper\Json | | Uses       | InvalidArgumentException |

Decodes a string using `json_decode` and throws an exception if the JSON data cannot be decoded


## Methods

```php
public function __invoke( string $data, bool $associative = bool, int $depth = int, int $options = int );
```





<h1 id="support-helper-json-encode">Class Phalcon\Support\Helper\Json\Encode</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Json/Encode.zep)

| Namespace  | Phalcon\Support\Helper\Json | | Uses       | JsonException |

Encodes a string using `json_encode` and throws an exception if the JSON data cannot be encoded

The following options are used if none specified for json_encode

JSON_HEX_TAG, JSON_HEX_APOS, JSON_HEX_AMP, JSON_HEX_QUOT, JSON_UNESCAPED_SLASHES, JSON_THROW_ON_ERROR

@see  https://www.ietf.org/rfc/rfc4627.txt


## Methods

```php
public function __invoke( mixed $data, int $options = int, int $depth = int ): string;
```





<h1 id="support-helper-number-isbetween">Class Phalcon\Support\Helper\Number\IsBetween</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Number/IsBetween.zep)

| Namespace  | Phalcon\Support\Helper\Number |

Checks if a number is within a range


## Methods

```php
public function __invoke( int $value, int $start, int $end ): bool;
```





<h1 id="support-helper-str-abstractstr">Abstract Class Phalcon\Support\Helper\Str\AbstractStr</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/AbstractStr.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Abstract class offering methods to help with the Str namespace. This can be moved to a trait once Zephir supports it.

@todo move to trait when there is support for it


## Methods

```php
protected function toEndsWith( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```
Check if a string ends with a given string


```php
protected function toInterpolate( string $input, array $context = [], string $left = string, string $right = string ): string;
```
Interpolates context values into the message placeholders

@see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message


```php
protected function toLower( string $text, string $encoding = string ): string;
```
Lowercases a string using mbstring


```php
protected function toStartsWith( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```
Check if a string starts with a given string


```php
protected function toUpper( string $text, string $encoding = string ): string;
```
Uppercases a string using mbstring




<h1 id="support-helper-str-camelize">Class Phalcon\Support\Helper\Str\Camelize</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Camelize.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | PascalCase |

Converts strings to upperCamelCase or lowerCamelCase


## Methods

```php
public function __invoke( string $text, string $delimiters = null, bool $lowerFirst = bool ): string;
```





<h1 id="support-helper-str-concat">Class Phalcon\Support\Helper\Str\Concat</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Concat.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Uses       | Phalcon\Support\Helper\Exception | | Extends    | AbstractStr |

Concatenates strings using the separator only once without duplication in places concatenation


## Methods

```php
public function __invoke(): string;
```





<h1 id="support-helper-str-countvowels">Class Phalcon\Support\Helper\Str\CountVowels</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/CountVowels.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Returns number of vowels in provided string. Uses a regular expression to count the number of vowels (A, E, I, O, U) in a string.


## Methods

```php
public function __invoke( string $text ): int;
```





<h1 id="support-helper-str-decapitalize">Class Phalcon\Support\Helper\Str\Decapitalize</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Decapitalize.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Decapitalizes the first letter of the string and then adds it with rest of the string. Omit the upperRest parameter to keep the rest of the string intact, or set it to true to convert to uppercase.


## Methods

```php
public function __invoke( string $text, bool $upperRest = bool, string $encoding = string ): string;
```





<h1 id="support-helper-str-decrement">Class Phalcon\Support\Helper\Str\Decrement</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Decrement.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Removes a number from the end of a string or decrements that number if it is already defined


## Methods

```php
public function __invoke( string $text, string $separator = string ): string;
```





<h1 id="support-helper-str-dirfromfile">Class Phalcon\Support\Helper\Str\DirFromFile</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/DirFromFile.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Accepts a file name (without extension) and returns a calculated directory structure with the filename in the end


## Methods

```php
public function __invoke( string $file ): string;
```





<h1 id="support-helper-str-dirseparator">Class Phalcon\Support\Helper\Str\DirSeparator</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/DirSeparator.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Accepts a directory name and ensures that it ends with DIRECTORY_SEPARATOR


## Methods

```php
public function __invoke( string $directory ): string;
```





<h1 id="support-helper-str-dynamic">Class Phalcon\Support\Helper\Str\Dynamic</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Dynamic.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Uses       | RuntimeException |

Generates random text in accordance with the template. The template is defined by the left and right delimiter and it can contain values separated by the separator


## Methods

```php
public function __invoke( string $text, string $leftDelimiter = string, string $rightDelimiter = string, string $separator = string ): string;
```





<h1 id="support-helper-str-endswith">Class Phalcon\Support\Helper\Str\EndsWith</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/EndsWith.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Check if a string ends with a given string


## Methods

```php
public function __invoke( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```





<h1 id="support-helper-str-firstbetween">Class Phalcon\Support\Helper\Str\FirstBetween</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/FirstBetween.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Returns the first string there is between the strings from the parameter start and end.


## Methods

```php
public function __invoke( string $text, string $start, string $end ): string;
```





<h1 id="support-helper-str-friendly">Class Phalcon\Support\Helper\Str\Friendly</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Friendly.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Uses       | Phalcon\Support\Helper\Exception | | Extends    | AbstractStr |

Changes a text to a URL friendly one. Replaces commonly known accented characters with their Latin equivalents. If a `replace` string or array is passed, it will also be used to replace those characters with a space.


## Methods

```php
public function __invoke( string $text, string $separator = string, bool $lowercase = bool, mixed $replace = null ): string;
```





<h1 id="support-helper-str-humanize">Class Phalcon\Support\Helper\Str\Humanize</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Humanize.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Makes an underscored or dashed text human-readable


## Methods

```php
public function __invoke( string $text ): string;
```





<h1 id="support-helper-str-includes">Class Phalcon\Support\Helper\Str\Includes</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Includes.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Determines whether a string includes another string or not.


## Methods

```php
public function __invoke( string $haystack, string $needle ): bool;
```





<h1 id="support-helper-str-increment">Class Phalcon\Support\Helper\Str\Increment</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Increment.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Adds a number to the end of a string or increments that number if it is already defined


## Methods

```php
public function __invoke( string $text, string $separator = string ): string;
```





<h1 id="support-helper-str-interpolate">Class Phalcon\Support\Helper\Str\Interpolate</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Interpolate.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Interpolates context values into the message placeholders. By default, the right and left tokens are `%`

@see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message


## Methods

```php
public function __invoke( string $message, array $context = [], string $leftToken = string, string $rightToken = string ): string;
```





<h1 id="support-helper-str-isanagram">Class Phalcon\Support\Helper\Str\IsAnagram</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/IsAnagram.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Compare two strings and returns `true` if both strings are anagram, `false` otherwise.


## Methods

```php
public function __invoke( string $first, string $second ): bool;
```





<h1 id="support-helper-str-islower">Class Phalcon\Support\Helper\Str\IsLower</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/IsLower.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Returns `true` if the given string is in lower case, `false` otherwise.


## Methods

```php
public function __invoke( string $text, string $encoding = string ): bool;
```





<h1 id="support-helper-str-ispalindrome">Class Phalcon\Support\Helper\Str\IsPalindrome</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/IsPalindrome.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Returns `true` if the given string is a palindrome, `false` otherwise.


## Methods

```php
public function __invoke( string $text ): bool;
```





<h1 id="support-helper-str-isupper">Class Phalcon\Support\Helper\Str\IsUpper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/IsUpper.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Returns `true` if the given string is in upper case, `false` otherwise.


## Methods

```php
public function __invoke( string $text, string $encoding = string ): bool;
```





<h1 id="support-helper-str-kebabcase">Class Phalcon\Support\Helper\Str\KebabCase</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/KebabCase.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | PascalCase |

Converts strings to kebab-case style


## Methods

```php
public function __invoke( string $text, string $delimiters = null ): string;
```





<h1 id="support-helper-str-len">Class Phalcon\Support\Helper\Str\Len</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Len.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Calculates the length of the string using `mb_strlen`


## Methods

```php
public function __invoke( string $text, string $encoding = string ): int;
```





<h1 id="support-helper-str-lower">Class Phalcon\Support\Helper\Str\Lower</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Lower.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Converts a string to lowercase using mbstring


## Methods

```php
public function __invoke( string $text, string $encoding = string ): string;
```





<h1 id="support-helper-str-pascalcase">Class Phalcon\Support\Helper\Str\PascalCase</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/PascalCase.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Converts strings to PascalCase style


## Methods

```php
public function __invoke( string $text, string $delimiters = null ): string;
```

```php
protected function processArray( string $text, string $delimiters = null ): array;
```





<h1 id="support-helper-str-prefix">Class Phalcon\Support\Helper\Str\Prefix</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Prefix.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Prefixes the text with the supplied prefix


## Methods

```php
public function __invoke( mixed $text, string $prefix ): string;
```





<h1 id="support-helper-str-random">Class Phalcon\Support\Helper\Str\Random</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Random.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Generates a random string based on the given type. Type is one of the RANDOM_* constants


## Constants
```php
const RANDOM_ALNUM = 0;
const RANDOM_ALPHA = 1;
const RANDOM_DISTINCT = 5;
const RANDOM_HEXDEC = 2;
const RANDOM_NOZERO = 4;
const RANDOM_NUMERIC = 3;
```

## Methods

```php
public function __invoke( int $type = static-constant-access, int $length = int ): string;
```





<h1 id="support-helper-str-reduceslashes">Class Phalcon\Support\Helper\Str\ReduceSlashes</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/ReduceSlashes.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Reduces multiple slashes in a string to single slashes


## Methods

```php
public function __invoke( string $text ): string;
```





<h1 id="support-helper-str-snakecase">Class Phalcon\Support\Helper\Str\SnakeCase</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/SnakeCase.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | PascalCase |

Converts strings to snake_case style


## Methods

```php
public function __invoke( string $text, string $delimiters = null ): string;
```





<h1 id="support-helper-str-startswith">Class Phalcon\Support\Helper\Str\StartsWith</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/StartsWith.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Check if a string starts with a given string


## Methods

```php
public function __invoke( string $haystack, string $needle, bool $ignoreCase = bool ): bool;
```





<h1 id="support-helper-str-suffix">Class Phalcon\Support\Helper\Str\Suffix</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Suffix.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Suffixes the text with the supplied suffix


## Methods

```php
public function __invoke( mixed $text, string $suffix ): string;
```





<h1 id="support-helper-str-ucwords">Class Phalcon\Support\Helper\Str\Ucwords</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Ucwords.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Capitalizes the first letter of each word


## Methods

```php
public function __invoke( string $text, string $encoding = string ): string;
```





<h1 id="support-helper-str-uncamelize">Class Phalcon\Support\Helper\Str\Uncamelize</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Uncamelize.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Converts strings to non camelized style


## Methods

```php
public function __invoke( string $text, string $delimiter = string ): string;
```





<h1 id="support-helper-str-underscore">Class Phalcon\Support\Helper\Str\Underscore</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Underscore.zep)

| Namespace  | Phalcon\Support\Helper\Str |

Makes a text underscored instead of spaced


## Methods

```php
public function __invoke( string $text ): string;
```





<h1 id="support-helper-str-upper">Class Phalcon\Support\Helper\Str\Upper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Helper/Str/Upper.zep)

| Namespace  | Phalcon\Support\Helper\Str | | Extends    | AbstractStr |

Converts a string to uppercase using mbstring


## Methods

```php
public function __invoke( string $text, string $encoding = string ): string;
```





<h1 id="support-helperfactory">Class Phalcon\Support\HelperFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/HelperFactory.zep)

| Namespace  | Phalcon\Support | | Uses       | Phalcon\Factory\AbstractFactory | | Extends    | AbstractFactory |

ServiceLocator implementation for helpers

@method array  blacklist(array $collection, array $blackList) @method array  chunk(array $collection, int $size, bool $preserveKeys = false) @method mixed  first(array $collection, callable $method = null) @method mixed  firstKey(array $collection, callable $method = null) @method array  flatten(array $collection, bool $deep = false) @method mixed  get(array $collection, $index, $defaultValue = null, string $cast = null) @method array  group(array $collection, $method) @method bool   has(array $collection, $index) @method bool   isUnique(array $collection) @method mixed  last(array $collection, callable $method = null) @method mixed  lastKey(array $collection, callable $method = null) @method array  order(array $collection, $attribute, string $order = 'asc') @method array  pluck(array $collection, string $element) @method array  set(array $collection, $value, $index = null) @method array  sliceLeft(array $collection, int $elements = 1) @method array  sliceRight(array $collection, int $elements = 1) @method array  split(array $collection) @method object toObject(array $collection) @method bool   validateAll(array $collection, callable $method) @method bool   validateAny(array $collection, callable $method) @method array  whitelist(array $collection, array $whiteList) @method string basename(string $uri, string $suffix = null) @method string decode(string $data, bool $associative = false, int $depth = 512, int $options = 0) @method string encode($data, int $options = 0, int $depth = 512) @method bool   between(int $value, int $start, int $end) @method string camelize(string $text, string $delimiters = null, bool $lowerFirst = false) @method string concat(string $delimiter, string $first, string $second, string ...$arguments) @method int    countVowels(string $text) @method string decapitalize(string $text, bool $upperRest = false, string $encoding = 'UTF-8') @method string decrement(string $text, string $separator = '_') @method string dirFromFile(string $file) @method string dirSeparator(string $directory) @method bool   endsWith(string $haystack, string $needle, bool $ignoreCase = true) @method string firstBetween(string $text, string $start, string $end) @method string friendly(string $text, string $separator = '-', bool $lowercase = true, $replace = null) @method string humanize(string $text) @method bool   includes(string $haystack, string $needle) @method string increment(string $text, string $separator = '_') @method bool   isAnagram(string $first, string $second) @method bool   isLower(string $text, string $encoding = 'UTF-8') @method bool   isPalindrome(string $text) @method bool   isUpper(string $text, string $encoding = 'UTF-8') @method string kebabCase(string $text, string $delimiters = null) @method int    len(string $text, string $encoding = 'UTF-8') @method string lower(string $text, string $encoding = 'UTF-8') @method string pascalCase(string $text, string $delimiters = null) @method string prefix($text, string $prefix) @method string random(int $type = 0, int $length = 8) @method string reduceSlashes(string $text) @method bool   startsWith(string $haystack, string $needle, bool $ignoreCase = true) @method string snakeCase(string $text, string $delimiters = null) @method string suffix($text, string $suffix) @method string ucwords(string $text, string $encoding = 'UTF-8') @method string uncamelize(string $text, string $delimiters = '_') @method string underscore(string $text) @method string upper(string $text, string $encoding = 'UTF-8')


## Methods

```php
public function __call( string $name, array $arguments );
```

```php
public function __construct( array $services = [] );
```
FactoryTrait constructor.


```php
public function newInstance( string $name );
```

```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available adapters




<h1 id="support-registry">Final Class Phalcon\Support\Registry</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Registry.zep)

| Namespace  | Phalcon\Support | | Uses       | Phalcon\Support\Collection, Traversable | | Extends    | Collection |

Phalcon\Registry

A registry is a container for storing objects and values in the application space. By storing the value in a registry, the same object is always available throughout your application.

```php
$registry = new \Phalcon\Registry();

// Set value
$registry->something = "something";
// or
$registry["something"] = "something";

// Get value
$value = $registry->something;
// or
$value = $registry["something"];

// Check if the key exists
$exists = isset($registry->something);
// or
$exists = isset($registry["something"]);

// Unset
unset($registry->something);
// or
unset($registry["something"]);
```

In addition to ArrayAccess, Phalcon\Registry also implements Countable (count($registry) will return the number of elements in the registry), Serializable and Iterator (you can iterate over the registry using a foreach loop) interfaces. For PHP 5.4 and higher, JsonSerializable interface is implemented.

Phalcon\Registry is very fast (it is typically faster than any userspace implementation of the registry); however, this comes at a price: Phalcon\Registry is a final class and cannot be inherited from.

Though Phalcon\Registry exposes methods like __get(), offsetGet(), count() etc, it is not recommended to invoke them manually (these methods exist mainly to match the interfaces the registry implements): $registry->__get("property") is several times slower than $registry->property.

Internally all the magic methods (and interfaces except JsonSerializable) are implemented using object handlers or similar techniques: this allows to bypass relatively slow method calls.


## Methods

```php
final public function __construct( array $data = [] );
```
Κατασκευαστής


```php
final public function __get( string $element ): mixed;
```
Magic getter to get an element from the collection


```php
final public function __isset( string $element ): bool;
```
Magic isset to check whether an element exists or not


```php
final public function __set( string $element, mixed $value ): void;
```
Magic setter to assign values to an element


```php
final public function __unset( string $element ): void;
```
Magic unset to remove an element from the collection


```php
final public function clear(): void;
```
Clears the internal collection


```php
final public function count(): int;
```
Count elements of an object

@link https://php.net/manual/en/countable.count.php


```php
final public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```
Get the element from the collection


```php
final public function getIterator(): Traversable;
```
Returns the iterator of the class


```php
final public function has( string $element ): bool;
```
Determines whether an element is present in the collection.


```php
final public function init( array $data = [] ): void;
```
Initialize internal array


```php
final public function jsonSerialize(): array;
```
Specify data which should be serialized to JSON

@link https://php.net/manual/en/jsonserializable.jsonserialize.php


```php
final public function offsetExists( mixed $element ): bool;
```
Whether a offset exists

@link https://php.net/manual/en/arrayaccess.offsetexists.php


```php
final public function offsetGet( mixed $element ): mixed;
```
Offset to retrieve

@link https://php.net/manual/en/arrayaccess.offsetget.php


```php
final public function offsetSet( mixed $element, mixed $value ): void;
```
Offset to set

@link https://php.net/manual/en/arrayaccess.offsetset.php


```php
final public function offsetUnset( mixed $element ): void;
```
Offset to unset

@link https://php.net/manual/en/arrayaccess.offsetunset.php


```php
final public function remove( string $element ): void;
```
Delete the element from the collection


```php
final public function serialize(): string;
```
String representation of object

@link https://php.net/manual/en/serializable.serialize.php


```php
final public function set( string $element, mixed $value ): void;
```
Set an element in the collection


```php
final public function toArray(): array;
```
Returns the object in an array format


```php
final public function toJson( int $options = int ): string;
```
Returns the object in a JSON format

The default string uses the following options for json_encode

JSON_HEX_TAG, JSON_HEX_APOS, JSON_HEX_AMP, JSON_HEX_QUOT, JSON_UNESCAPED_SLASHES

@see https://www.ietf.org/rfc/rfc4627.txt


```php
final public function unserialize( mixed $serialized ): void;
```
Constructs the object

@link https://php.net/manual/en/serializable.unserialize.php




<h1 id="support-version">Class Phalcon\Support\Version</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Support/Version.zep)

| Namespace  | Phalcon\Support |

This class allows to get the installed version of the framework


## Constants
```php
const VERSION_MAJOR = 0;
const VERSION_MEDIUM = 1;
const VERSION_MINOR = 2;
const VERSION_SPECIAL = 3;
const VERSION_SPECIAL_NUMBER = 4;
```

## Methods

```php
public function get(): string;
```
Returns the active version (string)

```php
echo (new Phalcon\Version())->get();
```


```php
public function getId(): string;
```
Returns the numeric active version

```php
echo (new Phalcon\Version())->getId();
```


```php
public function getPart( int $part ): string;
```
Returns a specific part of the version. If the wrong parameter is passed it will return the full version

```php
echo (new Phalcon\Version())->getPart(Phalcon\Version::VERSION_MAJOR);
```


```php
protected function getVersion(): array;
```
Area where the version number is set. The format is as follows: ABBCCDE

A - Major version B - Med version (two digits) C - Min version (two digits) D - Special release: 1 = alpha, 2 = beta, 3 = RC, 4 = stable E - Special release version i.e. RC1, Beta2 etc.
