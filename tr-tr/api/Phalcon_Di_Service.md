---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Di\Service'
---
# Class **Phalcon\Di\Service**

*implements* [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service.zep)

Servis konteynırının içindeki tek bir hizmeti ifade eder

```php
<?php

$service = new \Phalcon\Di\Service(
    "request",
    "Phalcon\Http\Request"
);

$request = service->resolve();
```

## Metodlar

final public **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])

herkese açık ** isim al** ()

Hizmetin ismini döndürür

public **setShared** (*mixed* $shared)

Hizmetin paylaşılıp paylaşılmadığını ayarlar

public **isShared** ()

Hizmetin paylaşılıp paylaşılmadığını kontrol eder

public **setSharedInstance** (*mixed* $sharedInstance)

Hizmet ile ilgili paylaşılan örneği ayarlar/sıfırlar

public **setDefinition** (*mixed* $definition)

Hizmet tanımını ayarlar

public *mixed* **getDefinition** ()

Hizmet tanımını döndürür

public *mixed* **resolve** ([*array* $parameters], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Hizmeti Yeniden Başlat

public **setParameter** (*mixed* $position, *array* $parameter)

Hizmeti çözmeden tanımdaki bir parametreyi değiştirir

public *array* **getParameter** (*int* $position)

Belirli bir konumdaki parametreyi döndürür

public **isResolved** ()

Returns true if the service was resolved

public static **__set_state** (*array* $attributes)

İç servis durumunu geri yükleyin