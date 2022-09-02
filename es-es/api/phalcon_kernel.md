---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Kernel'
---

* [Phalcon\Kernel](#kernel)

<h1 id="kernel">Class Phalcon\Kernel</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Kernel.zep)

| Namespace | Phalcon |

Esta clase permite cambiar el comportamiento interno del framework en tiempo de ejecución

## Métodos

```php
public static function preComputeHashKey( string $key );
```

Produce una clave hash precalculada basada en una cadena. Esta función produce diferentes números en procesadores de 32bit/64bit
