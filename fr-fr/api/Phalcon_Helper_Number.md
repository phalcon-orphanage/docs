---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Helper\Number'
---

# Class **Phalcon\Helper\Number**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/number.zep)

This class exposes static methods that offer quick access to common functionality when working with numbers.

## Methods

```php
final public static function between(int $value, int $from, int $to): bool
```

Checks if the passed value is between the range specified in `from` and `to`

### Parameters

| `int` | `$value` | The value to check | | `int` | `$from` | The minimum range value | | `int` | `$to` | The maximum range value |

### Returns

`bool` `true` if the value is between the range, `false` otherwise.

* * *