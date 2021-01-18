---
layout: default
language: 'en'
version: '4.0'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Implements | AdapterInterface |

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
public function __construct( InterpolatorFactory $interpolator, array $options );
```

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Translate\Adapter |

Phalcon\Translate\Adapter\AdapterInterface

Interface for Phalcon\Translate adapters

## Methods

```php
public function exists( string $index ): bool;
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Adapter/Csv.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | ArrayAccess |

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
public function __construct( InterpolatorFactory $interpolator, array $options );
```

Phalcon\Translate\Adapter\Csv constructor

```php
public function exists( string $index ): bool;
```

Check whether is defined a translation key in the internal array

```php
public function query( string $index, array $placeholders = [] ): string;
```

Returns the translation related to the given key

<h1 id="translate-adapter-gettext">Class Phalcon\Translate\Adapter\Gettext</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Adapter/Gettext.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | ArrayAccess |

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
public function __construct( InterpolatorFactory $interpolator, array $options );
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
public function nquery( string $msgid1, string $msgid2, int $count, array $placeholders = [], string $domain = null ): string;
```

The plural version of gettext(). Some languages have more than one form for plural messages dependent on the count.

```php
public function query( string $index, array $placeholders = [] ): string;
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

// Try different possible locale names for German
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

<h1 id="translate-adapter-nativearray">Class Phalcon\Translate\Adapter\NativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Adapter/NativeArray.zep)

| Namespace | Phalcon\Translate\Adapter | | Uses | ArrayAccess, Phalcon\Translate\Exception, Phalcon\Translate\InterpolatorFactory | | Extends | AbstractAdapter | | Implements | ArrayAccess |

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
public function __construct( InterpolatorFactory $interpolator, array $options );
```

Phalcon\Translate\Adapter\NativeArray constructor

```php
public function exists( string $index ): bool;
```

Check whether is defined a translation key in the internal array

```php
public function notFound( string $index ): string;
```

Whenever a key is not found this method will be called

```php
public function query( string $index, array $placeholders = [] ): string;
```

Returns the translation related to the given key

<h1 id="translate-exception">Class Phalcon\Translate\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Exception.zep)

| Namespace | Phalcon\Translate | | Extends | \Phalcon\Exception |

Phalcon\Translate\Exception

Class for exceptions thrown by Phalcon\Translate

<h1 id="translate-interpolator-associativearray">Class Phalcon\Translate\Interpolator\AssociativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Interpolator/AssociativeArray.zep)

| Namespace | Phalcon\Translate\Interpolator | | Implements | InterpolatorInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Replaces placeholders by the values passed

<h1 id="translate-interpolator-indexedarray">Class Phalcon\Translate\Interpolator\IndexedArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Interpolator/IndexedArray.zep)

| Namespace | Phalcon\Translate\Interpolator | | Implements | InterpolatorInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Replaces placeholders by the values passed

<h1 id="translate-interpolator-interpolatorinterface">Interface Phalcon\Translate\Interpolator\InterpolatorInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/Interpolator/InterpolatorInterface.zep)

| Namespace | Phalcon\Translate\Interpolator |

Phalcon\Translate\InterpolatorInterface

Interface for Phalcon\Translate interpolators

## Methods

```php
public function replacePlaceholders( string $translation, array $placeholders = [] ): string;
```

Replaces placeholders by the values passed

<h1 id="translate-interpolatorfactory">Class Phalcon\Translate\InterpolatorFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/InterpolatorFactory.zep)

| Namespace | Phalcon\Translate | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Translate\Adapter\AdapterInterface | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

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

<h1 id="translate-translatefactory">Class Phalcon\Translate\TranslateFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Translate/TranslateFactory.zep)

| Namespace | Phalcon\Translate | | Uses | Phalcon\Config, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr, Phalcon\Translate\Adapter\AdapterInterface | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

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
public function __construct( InterpolatorFactory $interpolator, array $services = [] );
```

AdapterFactory constructor.

```php
public function load( mixed $config ): mixed;
```

Factory to create an instance from a Config object

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Create a new instance of the adapter

```php
protected function getAdapters(): array;
```