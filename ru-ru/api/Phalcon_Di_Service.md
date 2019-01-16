* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Di\Service'

* * *

# Class **Phalcon\Di\Service**

*implements* [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/di/service.zep" class="btn btn-default btn-sm">Исходный код на GitHub</a>

Represents individually a service in the services container

```php
<?php

$service = new \Phalcon\Di\Service(
    "request",
    "Phalcon\Http\Request"
);

$request = service->resolve();
```

## Methods

final public **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])

public **getName** ()

Returns the service's name

public **setShared** (*mixed* $shared)

Sets if the service is shared or not

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