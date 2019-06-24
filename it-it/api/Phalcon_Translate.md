---
layout: default
language: 'it-it'
version: '4.0'
title: 'Phalcon\Translate'
---

* [Phalcon\Translate\Adapter\AbstractAdapter](#Translate_Adapter_AbstractAdapter)
* [Phalcon\Translate\Adapter\AdapterInterface](#Translate_Adapter_AdapterInterface)
* [Phalcon\Translate\Adapter\Csv](#Translate_Adapter_Csv)
* [Phalcon\Translate\Adapter\Gettext](#Translate_Adapter_Gettext)
* [Phalcon\Translate\Adapter\NativeArray](#Translate_Adapter_NativeArray)
* [Phalcon\Translate\Exception](#Translate_Exception)
* [Phalcon\Translate\Interpolator\AssociativeArray](#Translate_Interpolator_AssociativeArray)
* [Phalcon\Translate\Interpolator\IndexedArray](#Translate_Interpolator_IndexedArray)
* [Phalcon\Translate\Interpolator\InterpolatorInterface](#Translate_Interpolator_InterpolatorInterface)
* [Phalcon\Translate\InterpolatorFactory](#Translate_InterpolatorFactory)
* [Phalcon\Translate\TranslateFactory](#Translate_TranslateFactory)

<h1 id="Translate_Adapter_AbstractAdapter">Abstract Class Phalcon\Translate\Adapter\AbstractAdapter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/abstractadapter.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Translate\Exception, Phalcon\Translate\Adapter\AdapterInterface, Phalcon\Translate\InterpolatorFactory | | Implements | AdapterInterface |

Phalcon\Translate\Adapter

Base class for Phalcon\Translate adapters

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

## Methods

```php
public function __construct( mixed $interpolator, array $options );
```

//

```php
public function _( string $translateKey, mixed $placeholders = null ): string;
```

Returns the translation string of the given key (alias of method 't')

@param array placeholders

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

@param string value

```php
public function offsetUnset( mixed $offset ): void;
```

Unsets a translation from the dictionary

```php
public function t( string $translateKey, mixed $placeholders = null ): string;
```

Returns the translation string of the given key

@param array placeholders

```php
protected function replacePlaceholders( string $translation, mixed $placeholders = null ): string;
```

Replaces placeholders by the values passed

<h1 id="Translate_Adapter_AdapterInterface">Interface Phalcon\Translate\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/adapterinterface.zep)

| Namespace | Phalcon\Translate\Adapter |

Phalcon\Translate\AdapterInterface

Interface for Phalcon\Translate adapters

## Methods

```php
public function exists( string $index ): bool;
```

Check whether is defined a translation key in the internal array

```php
public function query( string $translateKey, mixed $placeholders = null ): string;
```

Returns the translation related to the given key

@param array placeholders

```php
public function t( string $translateKey, mixed $placeholders = null ): string;
```

Returns the translation string of the given key

@param array placeholders

<h1 id="Translate_Adapter_Csv">Class Phalcon\Translate\Adapter\Csv</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/csv.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | Phalcon\Translate\Exception, Phalcon\Translate\Adapter\AbstractAdapter, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | \ArrayAccess |

Phalcon\Translate\Adapter\Csv

Allows to define translation lists using CSV file

## Properties

```php
/**
 * @var array
 */
protected translate;

```

## Methods

```php
public function __construct( mixed $interpolator, array $options ): void;
```

Phalcon\Translate\Adapter\Csv constructor

```php
public function exists( string $index ): bool;
```

Check whether is defined a translation key in the internal array

```php
public function query( string $index, mixed $placeholders = null ): string;
```

Returns the translation related to the given key

<h1 id="Translate_Adapter_Gettext">Class Phalcon\Translate\Adapter\Gettext</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/gettext.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | Phalcon\Translate\Exception, Phalcon\Translate\Adapter\AbstractAdapter, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | \ArrayAccess |

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

## Methods

```php
public function __construct( mixed $interpolator, array $options ): void;
```

Phalcon\Translate\Adapter\Gettext constructor

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
public function nquery( string $msgid1, string $msgid2, int $count, mixed $placeholders = null, string $domain = null ): string;
```

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.

```php
public function query( string $index, mixed $placeholders = null ): string;
```

Returns the translation related to the given key.

```php
$translator->query("你好 %name%！", ["name" => "Phalcon"]);
```

@param array placeholders

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

@param string|array directory The directory path or an array of directories and domains

```php
public function setDomain( mixed $domain ): string;
```

Changes the current domain (i.e. the translation file)

```php
public function setLocale( int $category, string $locale ): string | bool;
```

Sets locale information

```php
// Set locale to Dutch
$gettext->setLocale(LC_ALL, "nl_NL");

// Try different possible locale names for german
$gettext->setLocale(LC_ALL, "de_DE@euro", "de_DE", "de", "ge");
```

```php
protected function getOptionsDefault(): array;
```

Gets default options

```php
protected function prepareOptions( array $options ): void;
```

Validator for constructor

<h1 id="Translate_Adapter_NativeArray">Class Phalcon\Translate\Adapter\NativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/nativearray.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | Phalcon\Translate\Exception, Phalcon\Translate\Adapter\AbstractAdapter, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | \ArrayAccess |

Phalcon\Translate\Adapter\NativeArray

Allows to define translation lists using PHP arrays

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

## Methods

```php
public function __construct( mixed $interpolator, array $options ): void;
```

Phalcon\Translate\Adapter\NativeArray constructor

```php
public function exists( string $index ): bool;
```

Check whether is defined a translation key in the internal array

```php
public function notFound( string $index ): string;
```

Whenever a key is not found this medhod will be called

```php
public function query( string $index, mixed $placeholders = null ): string;
```

Returns the translation related to the given key

<h1 id="Translate_Exception">Class Phalcon\Translate\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/exception.zep)

| Namespace | Phalcon\Translate | | Extends | \Phalcon\Exception |

Phalcon\Translate\Exception

Class for exceptions thrown by Phalcon\Translate

<h1 id="Translate_Interpolator_AssociativeArray">Class Phalcon\Translate\Interpolator\AssociativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/interpolator/associativearray.zep)

| Namespace | Phalcon\Translate\Interpolator | | Uses | Phalcon\Translate\Interpolator\InterpolatorInterface | | Implements | InterpolatorInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;](&#109;&#x61;&#105;&#x6c;&#116;&#x6f;&#58;&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Replaces placeholders by the values passed

<h1 id="Translate_Interpolator_IndexedArray">Class Phalcon\Translate\Interpolator\IndexedArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/interpolator/indexedarray.zep)

| Namespace | Phalcon\Translate\Interpolator | | Uses | Phalcon\Translate\Interpolator\InterpolatorInterface | | Implements | InterpolatorInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;](&#109;&#x61;&#105;&#x6c;&#116;&#x6f;&#58;&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Replaces placeholders by the values passed

<h1 id="Translate_Interpolator_InterpolatorInterface">Interface Phalcon\Translate\Interpolator\InterpolatorInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/interpolator/interpolatorinterface.zep)

| Namespace | Phalcon\Translate\Interpolator |

Phalcon\Translate\InterpolatorInterface

Interface for Phalcon\Translate interpolators

## Methods

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Replaces placeholders by the values passed

<h1 id="Translate_InterpolatorFactory">Class Phalcon\Translate\InterpolatorFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/interpolatorfactory.zep)

| Namespace | Phalcon\Translate | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Translate\Adapter\AdapterInterface | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;](&#109;&#x61;&#105;&#x6c;&#116;&#x6f;&#58;&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Properties

```php
/**
 * @var array
 */
private mapper;

/**
 * @var array
 */
private services;

```

## Methods

```php
public function __construct( array $services = [] );
```

AdapterFactory constructor.

```php
public function newInstance( string $name ): AdapterInterface;
```

Create a new instance of the adapter

```php
protected function getAdapters(): array;
```

//

<h1 id="Translate_TranslateFactory">Class Phalcon\Translate\TranslateFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/translatefactory.zep)

| Namespace | Phalcon\Translate | | Uses | Phalcon\Config\Config, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;](&#109;&#x61;&#105;&#x6c;&#116;&#x6f;&#58;&#x74;e&#97;&#x6d;&#64;&#x70;&#104;&#x61;&#108;&#x63;&#111;&#110;&#x70;&#104;&#x70;&#46;&#x63;&#111;&#x6d;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Properties

```php
/**
 * @var InterpolatorFactory
 */
private interpolator;

```

## Methods

```php
public function __construct( mixed $interpolator, array $services = [] );
```

AdapterFactory constructor.

```php
public function load( mixed $config ): mixed;
```

Factory to create an instace from a Config object

```php
public function newInstance( string $name, array $options = [] ): AbstractAdapter;
```

Create a new instance of the adapter

```php
protected function getAdapters(): array;
```

//