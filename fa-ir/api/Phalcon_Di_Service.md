---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Di\Service'
---
# Class **Phalcon\Di\Service**

*implements* [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service.zep)

Represents individually a service in the services container

```php
<?php

$service = new \Phalcon\Di\Service(
    "request",
    "Phalcon\Http\Request"
);

$request = service->resolve();
```

## روش ها

final public **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])

public **getName** ()

نام سرویس را برمی گرداند

عمومی **دریافت روش** (*مخلوط* $shared)

به اشتراک گذاشته شدن سرویس را تنظیم می کند

public **isShared** ()

Check whether the service is shared or not

public **setSharedInstance** (*mixed* $sharedInstance)

Sets/Resets the shared instance related to the service

public **setDefinition** (*mixed* $definition)

Set the service definition

public *mixed* **getDefinition** ()

Returns the service definition

public *mixed* **resolve** ([*array* $parameters], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Resolves the service

public **setParameter** (*mixed* $position, *array* $parameter)

Changes a parameter in the definition without resolve the service

public *array* **getParameter** (*int* $position)

Returns a parameter in a specific position

public **isResolved** ()

Returns true if the service was resolved

public static **__set_state** (*array* $attributes)

Restore the internal state of a service