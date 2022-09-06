---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Phalcon\Kernel'
---

* [Phalcon\Kernel](#kernel)

<h1 id="kernel">Class Phalcon\Kernel</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ pageVersion }}.0/phalcon/kernel.zep)

| Namespace | Phalcon |

This class allows to change the internal behavior of the framework in runtime

## Methods

```php
public static function preComputeHashKey( string $key );
```

Produces a pre-computed hash key based on a string. This function produces different numbers in 32bit/64bit processors

@return string
