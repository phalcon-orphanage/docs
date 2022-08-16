---
layout: default
language: 'el-gr'
version: '5.0'
title: 'Phalcon\Factory'
---

* [Phalcon\Factory\AbstractConfigFactory](#factory-abstractconfigfactory)
* [Phalcon\Factory\AbstractFactory](#factory-abstractfactory)
* [Phalcon\Factory\Exception](#factory-exception)

<h1 id="factory-abstractconfigfactory">Abstract Class Phalcon\Factory\AbstractConfigFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Factory/AbstractConfigFactory.zep)

| Namespace  | Phalcon\Factory | | Uses       | Phalcon\Config\ConfigInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Methods

```php
protected function checkConfig( mixed $config ): array;
```
Checks the config if it is a valid object


```php
protected function checkConfigElement( array $config, string $element ): array;
```
Checks if the config has "adapter"


```php
protected function getException( string $message ): \Exception;
```
Returns the exception object for the child class


```php
protected function getExceptionClass(): string;
```





<h1 id="factory-abstractfactory">Abstract Class Phalcon\Factory\AbstractFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Factory/AbstractFactory.zep)

| Namespace  | Phalcon\Factory | | Uses       | Phalcon\Config\ConfigInterface | | Extends    | AbstractConfigFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Properties
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

## Methods

```php
protected function getService( string $name ): mixed;
```
Checks if a service exists and throws an exception


```php
abstract protected function getServices(): array;
```
Returns the adapters for the factory


```php
protected function init( array $services = [] ): void;
```
Initialize services/add new services




<h1 id="factory-exception">Class Phalcon\Factory\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Factory/Exception.zep)

| Namespace  | Phalcon\Factory | | Extends    | \Exception |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.
