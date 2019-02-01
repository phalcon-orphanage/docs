---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filteronderdeel

* * *

## Filtering data

The [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) both filters and sanitizes data, depending on the sanitizers used. For instance the `trim` sanitizer will remove all leading and trailing whitespace, leaving the remaining input unchanged. The description of each sanitizer (mentioned above) can help you understand and use the sanitizers according to your needs.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();

// 'Hello'
$locator->sanitize('<h1>Hello</h1>', 'striptags');

// 'Hello'
$locator->sanitize('  Hello   ', 'trim');
```