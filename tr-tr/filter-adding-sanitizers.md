---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filter Component

* * *

## Adding sanitizers

You can add your own sanitizers to [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator). The sanitizer can be an anonymous function when initializing the locator:

```php
<?php

use Phalcon\Filter\FilterLocator;

$services = [
    'md5' => function ($input) {
        return md5($input);
    },
];

$locator   = new FilterLocator($services);
$sanitized = $locator->sanitize($value, 'md5');
```

If you already have an instantiated filter locator object (for instance if you have used the [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory) and `newInstance()`), then you can simply add the custom filter:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();

$locator->set(
    'md5',
    function ($input) {
        return md5($input);
    }
);

$sanitized = $locator->sanitize($value, 'md5');
```

Or, if you prefer, you can implement the filter in a class:

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

class IPv4
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();

$locator->set(
    'ipv4',
    function () {
        return new Ipv4();
    }
);

// Sanitize with the 'ipv4' filter
$filteredIp = $locator->sanitize('127.0.0.1', 'ipv4');
```