---
layout: article
language: 'en'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filter Component
<hr/>

- [Filtering and Sanitizing](filter-overview)
- [Built-in Sanitizers](filter-sanitizers)
- [Sanitizing data](filter-sanitizing)
- [Sanitizing from Controllers](filter-sanitizing-from-controllers)
- [Sanitizing Action Parameters](filter-sanitizing-action-parameters)
- [Filtering data](filter-sanitizing-data)
- [Combining Sanitizers](filter-combining-sanitizers)
- [Complex Sanitizing and Filtering](filter-complex-sanitization-filtering)
- [Implementing your own Sanitizer](filter-custom)

<hr/>

## Filtering and Sanitizing
Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![](/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327)

Sanitizing content can be achieved using the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) and [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory) classes.

## FilterLocatorFactory
This component creates a new locator with predefined filters attached to it. Each filter is lazy loaded for maximum performance. To instantiate the factory and retrieve the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) with the preset sanitizers you need to call `newInstance()`

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();
```

You can now use the locator wherever you need and sanitize content as per the needs of your application. 

## FilterLocator
The filter locator can also be used as a stand alone component, without initializing the built-in filters. 

```php
<?php

use MyApp\Sanitizers\HelloSanitizer;
use Phalcon\Filter\FilterLocator;

$services = [
    'hello' => HelloSanitizer::class,
];
$locator = new FilterLocator($services);
$text    = $locator->hello('World');
```

> The `Phalcon\Di` container already has a `Phalcon\Filter\FilterLocator` object loaded with the predefined sanitizers. The component can be accessed using the `filter` name.
{: .alert .alert-info }
