---
layout: default
language: 'es-es'
version: '5.0'
title: 'Versión'
upgrade: '#version'
keywords: 'registro'
---

# Version Component
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Support\Version][version] is a small but handy class, that returns the current version of Phalcon installed in your system.


## Constantes

| Nombre                   | Valor | Descripción                            |
| ------------------------ |:-----:| -------------------------------------- |
| `VERSION_MAJOR`          |   0   | The major version                      |
| `VERSION_MEDIUM`         |   1   | The medium version                     |
| `VERSION_MINOR`          |   2   | The minor version                      |
| `VERSION_SPECIAL`        |   3   | The special version (alpha, beta etc.) |
| `VERSION_SPECIAL_NUMBER` |   4   | The special version number             |

## Métodos

```php
protected function getVersion(): array
```
Return an array with each version part as an element.

```php
<?php

use Phalcon\Support\Version;

$version = new Version();

var_dump($version->getVersion);
// 5.0.0RC4
// [5, 0, 0, 3, 4] 
```

```php
protected function get(): string
```
Return the version

```php
<?php

use Phalcon\Support\Version;

$version = new Version();

echo $version->get();
// 5.0.0RC4
```

```php
protected function getId(): string
```
Return the version as a number string

```php
<?php

use Phalcon\Support\Version;

$version = new Version();

echo $version->getId();
// 5000034
```

[version]: api/phalcon_support#support-version
