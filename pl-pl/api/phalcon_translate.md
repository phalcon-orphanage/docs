---
layout: default
title: 'Phalcon\Translate'
---

* [Phalcon\Translate\Adapter\AbstractAdapter](#translate-adapter-abstractadapter)
* [Phalcon\Translate\Adapter\AdapterInterface](#translate-adapter-adapterinterface)
* [Phalcon\Translate\Adapter\Csv](#translate-adapter-csv)
* [Phalcon\Translate\Adapter\Gettext](#translate-adapter-gettext)
* [Phalcon\Translate\Adapter\NativeArray](#translate-adapter-nativearray)
* [Phalcon\Translate\Exception](#translate-exception)
* [Phalcon\Translate\Interpolator\AssociativeArray](#translate-interpolator-associativearray)
* [Phalcon\Translate\Interpolator\IndexedArray](#translate-interpolator-indexedarray)
* [Phalcon\Translate\Interpolator\InterpolatorInterface](#translate-interpolator-interpolatorinterface)
* [Phalcon\Translate\InterpolatorFactory](#translate-interpolatorfactory)
* [Phalcon\Translate\TranslateFactory](#translate-translatefactory)

<h1 id="translate-adapter-abstractadapter">Abstract Class Phalcon\Translate\Adapter\AbstractAdapter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Translate\Adapter | | Uses       | Phalcon\Support\Helper\Arr\Get, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Implements | AdapterInterface |

Class AbstractAdapter

@package Phalcon\Translate\Adapter

@property string              $defaultInterpolator @property InterpolatorFactory $interpolatorFactory


## Properties
```php
/**
 * @var string
 */
protected defaultInterpolator = ;

/**
    * @var InterpolatorFactory
    */
protected interpolatorFactory;

```

## Metody

```php
public function __construct( InterpolatorFactory $interpolator, array $options = [] );
```
AbstractAdapter constructor.


```php
public function _( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation string of the given key (alias of method 't')


```php
public function offsetExists( mixed $translateKey ): bool;
```
Check whether a translation key exists


```php
public function offsetGet( mixed $translateKey ): mixed;
```
Returns the translation related to the given key


```php
public function offsetSet( mixed $offset, mixed $value ): void;
```
Sets a translation value


```php
public function offsetUnset( mixed $offset ): void;
```
Unsets a translation from the dictionary


```php
public function t( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation string of the given key


```php
protected function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```
Replaces placeholders by the values passed




<h1 id="translate-adapter-adapterinterface">Interface Phalcon\Translate\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Translate\Adapter |

Phalcon\Translate\Adapter\AdapterInterface

Interface for Phalcon\Translate adapters


## Metody

```php
public function has( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function query( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation related to the given key


```php
public function t( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation string of the given key




<h1 id="translate-adapter-csv">Class Phalcon\Translate\Adapter\Csv</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/Csv.zep)

| Namespace  | Phalcon\Translate\Adapter | | Uses       | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends    | AbstractAdapter | | Implements | ArrayAccess |

Class Csv

@package Phalcon\Translate\Adapter

@property array $translate


## Properties
```php
/**
 * @var array
 */
protected translate;

```

## Metody

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```
Csv constructor.


```php
public function exists( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function has( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function query( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation related to the given key


```php
public function toArray(): array;
```
Returns the internal array


```php
protected function phpFopen( string $filename, string $mode );
```
@todo to be removed when we get traits




<h1 id="translate-adapter-gettext">Class Phalcon\Translate\Adapter\Gettext</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/Gettext.zep)

| Namespace  | Phalcon\Translate\Adapter | | Uses       | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends    | AbstractAdapter | | Implements | ArrayAccess |

Phalcon\Translate\Adapter\Gettext

```php
use Phalcon\Translate\Adapter\Gettext;

$adapter = new Gettext(
    [
        "locale"        => "de_DE.UTF-8",
        "defaultDomain" => "translations",
        "directory"     => "/path/to/application/locales",
        "category"      => LC_MESSAGES,
    ]
);
```

Allows translate using gettext

@property int          $category @property string       $defaultDomain @property string|array $directory @property string|false $locale


## Properties
```php
/**
 * @var int
 */
protected category;

/**
 * @var string
 */
protected defaultDomain;

/**
 * @var string|array
 */
protected directory;

/**
 * @var string
 */
protected locale;

```

## Metody

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```
Gettext constructor.


```php
public function exists( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function getCategory(): int
```

```php
public function getDefaultDomain(): string
```

```php
public function getDirectory(): string|array
```

```php
public function getLocale(): string
```

```php
public function has( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function nquery( string $msgid1, string $msgid2, int $count, array $placeholders = [], string $domain = null ): string;
```
The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.


```php
public function query( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation related to the given key.

```php
$translator->query("你好 %name%！", ["name" => "Phalcon"]);
```


```php
public function resetDomain(): string;
```
Sets the default domain


```php
public function setDefaultDomain( string $domain ): void;
```
Sets the domain default to search within when calls are made to gettext()


```php
public function setDirectory( mixed $directory ): void;
```
Sets the path for a domain

```php
// Set the directory path
$gettext->setDirectory("/path/to/the/messages");

// Set the domains and directories path
$gettext->setDirectory(
    [
        "messages" => "/path/to/the/messages",
        "another"  => "/path/to/the/another",
    ]
);
```


```php
public function setDomain( string $domain = null ): string;
```
Changes the current domain (i.e. the translation file)


```php
public function setLocale( int $category, array $localeArray = [] ): string | bool;
```
Sets locale information

```php
// Set locale to Dutch
$gettext->setLocale(LC_ALL, "nl_NL");

// Try different possible locale names for German
$gettext->setLocale(LC_ALL, "de_DE@euro", "de_DE", "de", "ge");
```


```php
protected function getOptionsDefault(): array;
```
Gets default options


```php
protected function phpFunctionExists( string $name ): bool;
```
@todo to be removed when we get traits


```php
protected function prepareOptions( array $options ): void;
```
Validator for constructor




<h1 id="translate-adapter-nativearray">Class Phalcon\Translate\Adapter\NativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Adapter/NativeArray.zep)

| Namespace  | Phalcon\Translate\Adapter | | Uses       | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends    | AbstractAdapter | | Implements | ArrayAccess |

Class NativeArray

Defines translation lists using PHP arrays

@package Phalcon\Translate\Adapter

@property array $translate @property bool  $triggerError


## Properties
```php
/**
 * @var array
 */
private translate;

/**
 * @var bool
 */
private triggerError = false;

```

## Metody

```php
public function __construct( InterpolatorFactory $interpolator, array $options );
```
NativeArray constructor.


```php
public function exists( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function has( string $index ): bool;
```
Check whether is defined a translation key in the internal array


```php
public function notFound( string $index ): string;
```
Whenever a key is not found this method will be called


```php
public function query( string $translateKey, array $placeholders = [] ): string;
```
Returns the translation related to the given key


```php
public function toArray(): array;
```
Returns the internal array




<h1 id="translate-exception">Class Phalcon\Translate\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Exception.zep)

| Namespace  | Phalcon\Translate | | Extends    | \Exception |

Phalcon\Translate\Exception

Class for exceptions thrown by Phalcon\Translate



<h1 id="translate-interpolator-associativearray">Class Phalcon\Translate\Interpolator\AssociativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Interpolator/AssociativeArray.zep)

| Namespace  | Phalcon\Translate\Interpolator | | Uses       | Phalcon\Support\Helper\Str\Interpolate | | Implements | InterpolatorInterface |

Class AssociativeArray

@package Phalcon\Translate\Interpolator


## Metody

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```
Replaces placeholders by the values passed




<h1 id="translate-interpolator-indexedarray">Class Phalcon\Translate\Interpolator\IndexedArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Interpolator/IndexedArray.zep)

| Namespace  | Phalcon\Translate\Interpolator | | Implements | InterpolatorInterface |

Class IndexedArray

@package Phalcon\Translate\Interpolator


## Metody

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```
Replaces placeholders by the values passed




<h1 id="translate-interpolator-interpolatorinterface">Interface Phalcon\Translate\Interpolator\InterpolatorInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/Interpolator/InterpolatorInterface.zep)

| Namespace  | Phalcon\Translate\Interpolator |

Phalcon\Translate\InterpolatorInterface

Interface for Phalcon\Translate interpolators


## Metody

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```
Replaces placeholders by the values passed




<h1 id="translate-interpolatorfactory">Class Phalcon\Translate\InterpolatorFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/InterpolatorFactory.zep)

| Namespace  | Phalcon\Translate | | Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Translate\Interpolator\InterpolatorInterface | | Extends    | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Metody

```php
public function __construct( array $services = [] );
```
InterpolatorFactor constructor.


```php
public function newInstance( string $name ): InterpolatorInterface;
```
Create a new instance of the adapter


```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available adapters




<h1 id="translate-translatefactory">Class Phalcon\Translate\TranslateFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Translate/TranslateFactory.zep)

| Namespace  | Phalcon\Translate | | Uses       | Phalcon\Config\ConfigInterface, Phalcon\Factory\AbstractFactory, Phalcon\Translate\Adapter\AdapterInterface | | Extends    | AbstractFactory |

Class TranslateFactory

@package Phalcon\Translate

@property InterpolatorFactory $interpolator


## Properties
```php
/**
 * @var InterpolatorFactory
 */
private interpolator;

```

## Metody

```php
public function __construct( InterpolatorFactory $interpolator, array $services = [] );
```
AdapterFactory constructor.


```php
public function load( mixed $config ): AdapterInterface;
```
Factory to create an instance from a Config object


```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```
Create a new instance of the adapter


```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available adapters
