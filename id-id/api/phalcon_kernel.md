---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Kernel'
---

* [Phalcon\Kernel](#kernel)

<h1 id="kernel">Class Phalcon\Kernel</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Kernel.zep)

| Namespace | Phalcon |

This class allows to change the internal behavior of the framework in runtime

## Methods

Produces a pre-computed hash key based on a string. This function produces different numbers in 32bit/64bit processors

```php
public static function preComputeHashKey( string $key );
```