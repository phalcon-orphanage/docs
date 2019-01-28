---
layout: article
language: 'it-it'
version: '4.0'
---
# Upgrading to v4

So you have decided to upgrade to v4! **Congratulations**!!

Phalcon v4 contains a lot of changes to components, including changing of interfaces, strict types, removal of components and additions of new ones. This document is an effort to help make the upgrade process as smooth as possible.

* * *

<a name='filter'></a>

## Filter

> Status: **changes required**
> 
> Usage: [Filter Documentation](filter) {: .alert .alert-info }

The `Filter` component has been rewritten, utilizing a service locator. Each sanitizer is now enclosed on its own class and lazy loaded to provide maximum performance and the lowest resource usage as possible.

<a name='filter-overview'></a>

### Overview

The `Phalcon\Filter` object has been removed from the framework. In its place we have two components that can help with sanitizing input.

The equivalent of the v3 `Phalcon\Filter` is now the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) object. This object allows you to sanitize input as before using the `sanitize()` method.

The values sanitized are automatically cast to the relevant types. This is the default behavior for the `int`, `bool` and `float` filters.

When instantiating the locator object, it does not know about any sanitizers. You have two options:

#### Load all the default sanitizers

You can load all the Phalcon supplied sanitizers by utilizing the [Phalcon\Filter\FilterLocatorFactory](Phalcon_Filter_FilterLocatorFactory) component.

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();
```

Calling`newInstance()` will return a [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) object with all the sanitizers registered. The sanitizers are lazy loaded so they are instantiated only when called from the locator.

#### Load only sanitizers you want

You can instantiate the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) component and either use the `set()` method to set all the sanitizers you need, or pass an array in the contructor with the sanitizers you want to register.

<a name='filter-di-factorydefault'></a>

### Using the `FactoryDefault`

If you use the [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) container, then the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) is automatically loaded in the container. You can then continue to use the service in your controllers or components as you did before. The name of the service in the Di is `filter`, just as before.

Also components that utilize the filter service, such as the [Request](api/Phalcon_Http_Request) object, transparently use the new filter locator. No additional changes required for those components.

<a name='filter-di-custom'></a>

### Using a custom `Di`

If you have set up all the services in the [Phalcon\Di](api/Phalcon_Di) yourself and need the filter service, you will need to change its registration as follows:

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterLocatorFactory;

$container = new Di();

$container->set(
    'filter',
    function () {
        $factory = new FilterLocatorFactory();
        return $factory->newInstance();
    }
);
```

> Note that even if you register the filter service manually, the **name** of the service must be **filter** so that other components can use it {: .alert .alert-warning }

<a name='filter-constants'></a>

### Constants

The constants that the v3 `Phalcon\Filter` have somewhat changed. They are now located in the [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) class.

#### Removed

* `FILTER_INT_CAST` (`int!`)
* `FILTER_FLOAT_CAST` (`float!`) 

By default the service sanitizers cast the value to the appropriate type so these are obsolete

* `FILTER_APHANUM` has been removed - replaced by `FILTER_ALNUM`

#### Changed

* `FILTER_SPECIAL_CHARS` has changed been removed - replaced by `FILTER_SPECIAL`

#### Added

* `FILTER_ALNUM` - replaced `FILTER_ALPHANUM`
* `FILTER_ALPHA` - sanitize only alpha characters
* `FILTER_BOOL` - sanitize boolean including "yes", "no", etc.
* `FILTER_LOWERFIRST` - sanitze using `lcfirst`
* `FILTER_REGEX` - sanitize based on a pattern (`preg_replace`)
* `FILTER_REMOVE` - sanitize by removing characters (`str_replace`)
* `FILTER_REPLACE` - sanitize by replacing characters (`str_replace`)
* `FILTER_SPECIAL` - replaced `FILTER_SPECIAL_CHARS`
* `FILTER_SPECIALFULL` - sanitize special chars (`filter_var`)
* `FILTER_UPPERFIRST` - sanitize using `ucfirst`
* `FILTER_UPPERWORDS` - sanitize using `ucwords`

* * *