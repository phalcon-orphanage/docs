---
layout: default
language: 'th-th'
version: '4.0'
title: 'Phalcon\Helper\Arr'
---

# Class **Phalcon\Helper\Arr**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/arr.zep)

This class exposes static methods that offer quick access to common functionality when working with arrays.

## Methods

```php
final public static function get( array $collection, mixed $index, mixed $defaultValue ): mixed
```

Retrieves an element from an array. If the element exists its value is returned. If not, the `defaultValue` is returned.

### Parameters

| `array` | `$collection` | The array to check | | `mixed` | `$index` | The index we need to retrieve | | `mixed` | `$defaultValue` | Default value returned if the index does not exist. |

### Returns

`mixed` The value stored in the array, or the `defaultValue` if the `index` does not exist.

* * *

```php
final public static function has( array $collection, mixed $index ): bool
```

Checks if an element exists in an array. Returns `true` if found, `false` otherwise.

### Parameters

| `array` | `$collection` | The array to check | | `mixed` | `$index` | The index we need to retrieve |

### Returns

`bool` `true` if the element exists, `false` otherwise

* * *

```php
final public static function set( array $collection, mixed $value [, $index = null] ): array
```

Sets a value in an array element.

### Parameters

| `array` | `$collection` | The array to check | | `mixed` | `$value` | The value of the element | | `mixed` | `$index` | (optional) The index to store the element under |

### Returns

`bool` `true` if the element exists, `false` otherwise

* * *