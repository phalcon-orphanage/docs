---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

Yönlendiriciye eklenen her yolu bu sınıf temsil eder

## Sabitler

*string* **DEFAULT_DELIMITER**

## Metodlar

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

Geçeri bir PCRE düzenli ifadesi dönen kalıptaki yer tutucuları değiştirir

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Parametreleri bir dizeden ayıklama yapar

public **reConfigure** (*string* $pattern, [*array* $paths])

Yeni bir kalıp ve bir dizi yol ekleyerek rotayı yeniden yapılandırır

herkese açık ** isim al** ()

Rotanın ismini döndürür

public **setName** (*mixed* $name)

Rota adını ayarlar

```php
<?php

$router->add(
    "/about",
    [
        "controller" => "about",
    ]
)->setName("about");

```

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **beforeMatch** (*callback* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public *mixed* **getBeforeMatch** ()

Eğer var ise 'maç öncesi' geri çağırmayı döndürür

public **getRouteId** ()

Returns the route's id

public **getPattern** ()

Rotanın desenini geri döndürür

public **getCompiledPattern** ()

Rotanın düzenlenmiş desenin geri döndürür

public **getPaths** ()

Yolları döndürür

public **getReversedPaths** ()

Pozisyonları anahtar ve isimleri değerler olarak kullanarak yolları geri döndürür

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

Belirli bir parametre veya dönüşüm yapmak için dönüştürücü ekler

public **getConverters** ()

Yönlendirici dönüştürücüsünü döndürür

public static **reset** ()

Dahili yol kimliği jenaratörünü sıfırlar

public static **delimiter** ([*mixed* $delimiter])

Yönlendirme sınırlayıcısı ayarlama

public static **getDelimiter** ()

Yönlendirme Sınırlayıcısını Getir