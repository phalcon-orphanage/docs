---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Factory'
---

* [Phalcon\Factory\AbstractFactory](#factory-abstractfactory)
* [Phalcon\Factory\Exception](#factory-exception)

<h1 id="factory-abstractfactory">Abstract Class Phalcon\Factory\AbstractFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/factory/abstractfactory.zep)

| Namespace | Phalcon\Factory | | Uses | Phalcon\Config |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Propiedades

```php
/**
 * @var array
 */
protected mapper;

/**
 * @var array
 */
protected services;

```

## Métodos

```php
protected function checkConfig( mixed $config ): array;
```

Checks the config if it is a valid object

```php
protected function checkService( string $name ): void;
```

Checks if a service exists and throws an exception

```php
abstract protected function getAdapters(): array;
```

Returns the adapters for the factory

```php
protected function init( array $services = [] ): void;
```

AdapterFactory constructor.

<h1 id="factory-exception">Class Phalcon\Factory\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/factory/exception.zep)

| Namespace | Phalcon\Factory | | Extends | \Phalcon\Exception |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.