---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Di\Service'
---
# Class **Phalcon\Di\Service**

*implements* [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service.zep)

Mewakili individual layanan dalam wadah Layanan

```php
<?php

$service = new \Phalcon\Di\Service(
    "request",
    "Phalcon\Http\Request"
);

$request = service->resolve();
```

## Metode

final public **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])

publik **getNama** ()

Mengembalikan nama layanan

public **setShared** (*mixed* $shared)

Menyetel jika layanan dibagikan atau tidak

public **isShared** ()

Periksa apakah layanan dibagikan atau tidak

public **setSharedInstance** (*mixed* $sharedInstance)

Sets/Resets the shared instance related to the service

public **setDefinition** (*mixed* $definition)

Set the service definition

public *mixed* **getDefinition** ()

Mengembalikan definisi layanan

public *mixed* **resolve** ([*array* $parameters], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Menyelesaikan layanan

public **setParameter** (*mixed* $position, *array* $parameter)

Mengubah parameter dalam definisi tanpa menyelesaikan layanan

public *array* **getParameter** (*int* $position)

Mengembalikan parameter pada posisi tertentu

public **isResolved** ()

Kembali benar jika layanan teratasi

public static **__set_state** (*array* $attributes)

Kembalikan keadaan internal layanan