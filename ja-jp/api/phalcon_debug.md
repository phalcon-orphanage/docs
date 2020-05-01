---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Debug'
---

* [Phalcon\Debug](#debug)
* [Phalcon\Debug\Dump](#debug-dump)
* [Phalcon\Debug\Exception](#debug-exception)

<h1 id="debug">Class Phalcon\Debug</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Debug.zep)

| Namespace | Phalcon | | Uses | ErrorException, Phalcon\Helper\Arr, Phalcon\Version, Phalcon\Tag, ReflectionClass, ReflectionFunction |

Provides debug capabilities to Phalcon applications

## Properties

```php
/**
 * @var array
    */
protected blacklist;

//
protected data;

/**
 * @var bool
 */
protected hideDocumentRoot = false;

/**
 * @var bool
 */
protected static isActive;

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
protected uri = https://assets.phalcon.io/debug/4.0.x/;

```

## メソッド

Clears are variables added previously

```php
public function clearVars(): Debug;
```

Adds a variable to the debug output

```php
public function debugVar( mixed $varz, string $key = null ): Debug;
```

Returns the CSS sources

```php
public function getCssSources(): string;
```

Returns the JavaScript sources

```php
public function getJsSources(): string;
```

Generates a link to the current version documentation

```php
public function getVersion(): string;
```

Halts the request showing a backtrace

```php
public function halt(): void;
```

Listen for uncaught exceptions and unsilent notices or warnings

```php
public function listen( bool $exceptions = bool, bool $lowSeverity = bool ): Debug;
```

Listen for uncaught exceptions

```php
public function listenExceptions(): Debug;
```

Listen for unsilent notices or warnings

```php
public function listenLowSeverity(): Debug;
```

Handles uncaught exceptions

```php
public function onUncaughtException( \Throwable $exception ): bool;
```

Throws an exception when a notice or warning is raised

```php
public function onUncaughtLowSeverity( mixed $severity, mixed $message, mixed $file, mixed $line, mixed $context ): void;
```

Sets if files the exception's backtrace must be showed

```php
public function setBlacklist( array $blacklist ): Debug;
```

Sets if files the exception's backtrace must be showed

```php
public function setShowBackTrace( bool $showBackTrace ): Debug;
```

Sets if files must be completely opened and showed in the output or just the fragment related to the exception

```php
public function setShowFileFragment( bool $showFileFragment ): Debug;
```

Set if files part of the backtrace must be shown in the output

```php
public function setShowFiles( bool $showFiles ): Debug;
```

Change the base URI for static resources

```php
public function setUri( string $uri ): Debug;
```

Escapes a string with htmlentities

```php
protected function escapeString( mixed $value ): string;
```

Produces a recursive representation of an array

```php
protected function getArrayDump( array $argument, mixed $n = int ): string | null;
```

Produces an string representation of a variable

```php
protected function getVarDump( mixed $variable ): string;
```

Shows a backtrace item

```php
final protected function showTraceItem( int $n, array $trace ): string;
```

<h1 id="debug-dump">Class Phalcon\Debug\Dump</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Debug/Dump.zep)

| Namespace | Phalcon\Debug | | Uses | Phalcon\Di, Phalcon\Helper\Json, Reflection, ReflectionClass, ReflectionProperty, stdClass |

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

## メソッド

Phalcon\Debug\Dump constructor

```php
public function __construct( array $styles = [], bool $detailed = bool );
```

Alias of variables() method

```php
public function all(): string;
```

```php
public function getDetailed(): bool
```

Alias of variable() method

```php
public function one( mixed $variable, string $name = null ): string;
```

```php
public function setDetailed( bool $detailed )
```

Set styles for vars type

```php
public function setStyles( array $styles = [] ): array;
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
public function toJson( mixed $variable ): string;
```

Returns an HTML string of information about a single variable.

```php
echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");
```

```php
public function variable( mixed $variable, string $name = null ): string;
```

Returns an HTML string of debugging information about any number of variables, each wrapped in a "pre" tag.

```php
$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);
```

```php
public function variables(): string;
```

Get style for type

```php
protected function getStyle( string $type ): string;
```

Prepare an HTML string of information about a single variable.

```php
protected function output( mixed $variable, string $name = null, int $tab = int ): string;
```

<h1 id="debug-exception">Class Phalcon\Debug\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Debug/Exception.zep)

| Namespace | Phalcon\Debug | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Debug will use this class