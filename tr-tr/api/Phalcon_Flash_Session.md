---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Flash\Session'
---
# Class **Phalcon\Flash\Session**

*extends* abstract class [Phalcon\Flash](Phalcon_Flash)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\FlashInterface](Phalcon_FlashInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/flash/session.zep)

İletileri oturumda geçici olarak tutar, daha sonra iletiler bir sonraki talepte yazdırılabilir

## Metodlar

protected **_getSessionMessages** (*mixed* $remove, [*mixed* $type])

Oturuma kaydedilen mesajları döner

protected **_setSessionMessages** (*array* $messages)

Mesajları oturumda saklar

public **message** (*mixed* $type, *mixed* $message)

Oturuma yeni mesaj ekler

public **has** ([*mixed* $type])

Mesaj olup olmadığını kontrol eder

public **getMessages** ([*mixed* $type], [*mixed* $remove])

Oturumda kaydedilmiş mesajları döner

public **output** ([*mixed* $remove])

Oturumda kaydedilmiş mesajları basar

public **clear** ()

Oturumdaki mesajları siler

public **__construct** ([*mixed* $cssClasses]) inherited from [Phalcon\Flash](Phalcon_Flash)

Phalcon\Flash constructor

public **getAutoescape** () inherited from [Phalcon\Flash](Phalcon_Flash)

Oluşturulan html'de autoescape modunu döndürür

public **setAutoescape** (*mixed* $autoescape) inherited from [Phalcon\Flash](Phalcon_Flash)

Autoescape modunu oluşturulan html'de ayarlayın

public **getEscaperService** () inherited from [Phalcon\Flash](Phalcon_Flash)

The Escaper Service'i döndürür

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService) inherited from [Phalcon\Flash](Phalcon_Flash)

The Escaper Service'i kurar

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Flash](Phalcon_Flash)

Bağımlılık enjektörünü ayarlar

public **getDI** () inherited from [Phalcon\Flash](Phalcon_Flash)

Returns the internal dependency injector

public **setImplicitFlush** (*mixed* $implicitFlush) inherited from [Phalcon\Flash](Phalcon_Flash)

Çıktının çıktıya kapalı olarak silineceğini veya dizgi olarak döndürüleceğini ayarlayın

public **setAutomaticHtml** (*mixed* $automaticHtml) inherited from [Phalcon\Flash](Phalcon_Flash)

Çıktının HTML ile örtük olarak biçimlendirilmesi gerekiyorsa ayarlayın

public **setCssClasses** (*array* $cssClasses) inherited from [Phalcon\Flash](Phalcon_Flash)

İletileri biçimlendirmek için CSS sınıflarıyla bir dizi ayarlayın

public **error** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Bir HTML hata mesajı gösterir

```php
<?php

$flash->error("This is an error");

```

public **notice** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

HTML bildirimini / bilgi mesajını gösterir

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Bir HTML başarı mesajı gösterir

```php
<?php

$flash->success("The process was finished successfully");

```

public **warning** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Bir HTML uyarı mesajı gösterir

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

HTML ile biçimlendirilmiş bir mesaj çıktısı verir

```php
<?php

$flash->outputMessage("error", $message);

```